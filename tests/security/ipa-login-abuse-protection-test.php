<?php
/** Run: php tests/security/ipa-login-abuse-protection-test.php */
define('ABSPATH', __DIR__);
define('DAY_IN_SECONDS',86400);
define('HOUR_IN_SECONDS',3600);
define('MINUTE_IN_SECONDS',60);
$GLOBALS['data']=[]; $GLOBALS['nonce_ok']=true; $GLOBALS['can_list']=false;
$GLOBALS['filters'] = []; $GLOBALS['removed'] = [];
function add_filter($hook, $callback, ...$rest) { $GLOBALS['filters'][$hook][] = $callback; }
function add_action($hook, $callback, ...$rest) {}
function remove_action($hook, $callback) { $GLOBALS['removed'][] = [$hook, $callback]; }
function wp_nonce_field($a,$b){echo '<input name="'.$b.'">';}
function wp_verify_nonce($nonce,$action){return $GLOBALS['nonce_ok'] && $nonce==='valid';}
function wp_unslash($s){return $s;} function sanitize_text_field($s){return trim($s);}
function wp_salt($s){return 'local-test-secret';}
function get_transient($k){return $GLOBALS['data'][$k]??false;}
function set_transient($k,$v,$e){$GLOBALS['data'][$k]=$v;return true;}
function current_user_can($c){return $GLOBALS['can_list'];}
function is_user_logged_in(){return false;}
function status_header($code){} function nocache_headers(){}
function wp_die($m,$t,$a){throw new Exception((string)$a['response']);}
class WP_Error {
 private $errors=[];
 function __construct($c='',$m='',$d=null){if($c)$this->add($c,$m);}
 function add($c,$m){$this->errors[$c]=$m;}
 function has_errors(){return count($this->errors)>0;}
 function get_error_code(){return array_key_first($this->errors);}
}
class WP_User {
 public $ID; public $user_login; public $user_email;
 function __construct($id, $login='member', $email='member@example.test') {
  $this->ID=$id; $this->user_login=$login; $this->user_email=$email;
 }
}
class WP_REST_Request {
 private $method;private $route;
 function __construct($m,$r){$this->method=$m;$this->route=$r;}
 function get_method(){return $this->method;}
 function get_route(){return $this->route;}
}
require dirname(__DIR__,2).'/wp-content/mu-plugins/ipa-login-abuse-protection.php';
require dirname(__DIR__,2).'/wp-content/mu-plugins/ipa-password-reset-hardening.php';
require dirname(__DIR__,2).'/wp-content/mu-plugins/ipa-disable-xmlrpc.php';
function check($ok,$desc){if(!$ok)throw new Exception('FAIL: '.$desc);echo 'PASS: '.$desc."\n";}
$_SERVER['SCRIPT_NAME']='/wp-login.php';$_SERVER['REQUEST_METHOD']='POST';$_SERVER['REMOTE_ADDR']='192.0.2.1';$_POST=[];
$user=new WP_User(10);
check(ipaenglish_security_limit_password_reset(new WP_Error(),$user)->get_error_code()==='ipa_reset_invalid_request','direct POST rejected');
$_POST['ipaenglish_password_reset_nonce']='valid';$GLOBALS['nonce_ok']=false;
check(ipaenglish_security_limit_password_reset(new WP_Error(),$user)->get_error_code()==='ipa_reset_invalid_request','invalid nonce rejected');
$GLOBALS['nonce_ok']=true;
check(!ipaenglish_security_limit_password_reset(new WP_Error(),$user)->has_errors(),'first valid reset accepted');
check(ipaenglish_security_limit_password_reset(new WP_Error(),$user)->get_error_code()==='ipa_reset_rate_limited','cooldown enforced');
$userKey=ipaenglish_security_reset_bucket_key('user','10');unset($GLOBALS['data'][$userKey.'_cool']);$GLOBALS['data'][$userKey.'_day']=4;
check(ipaenglish_security_limit_password_reset(new WP_Error(),$user)->get_error_code()==='ipa_reset_rate_limited','daily account cap enforced');
unset($GLOBALS['data'][$userKey.'_day']);
$ipKey=ipaenglish_security_reset_bucket_key('ip','192.0.2.1');$GLOBALS['data'][$ipKey]=6;
check(ipaenglish_security_limit_password_reset(new WP_Error(),$user)->get_error_code()==='ipa_reset_rate_limited','hourly IP cap enforced');
check(ipaenglish_security_protect_rest_users(null,null,new WP_REST_Request('GET','/wp/v2/users')) instanceof WP_Error,'anonymous user listing blocked');
check(ipaenglish_security_protect_rest_users(null,null,new WP_REST_Request('GET','/wp/v2/users/4')) instanceof WP_Error,'anonymous user detail blocked');
check(ipaenglish_security_protect_rest_users(null,null,new WP_REST_Request('GET','/wp/v2/posts'))===null,'posts REST API unaffected');
$GLOBALS['can_list']=true;
check(ipaenglish_security_protect_rest_users(null,null,new WP_REST_Request('GET','/wp/v2/users'))===null,'admin REST user access allowed');
$_GET['author']='4';
try{ipaenglish_security_block_numeric_author_enumeration();throw new Exception('unblocked');}
catch(Exception $e){check($e->getMessage()==='404','numeric author enumeration blocked');}
// PR #28: legacy account reset emails are intentionally suppressed.
$legacy = new WP_User(4, 'Translate', 'legacy@example.test');
check(ipa_should_block_public_password_reset($legacy), 'Translate account reset is blocked');
check(false === ipa_block_public_password_reset_email(true, 'Translate', $legacy), 'Translate reset email is suppressed');
check(true === ipa_block_public_password_reset_email(true, 'member', $user), 'Normal user reset remains available');
check(false === ipa_block_public_password_reset_email(false, 'member', $user), 'Earlier email suppression is preserved');
check(in_array('ipa_block_public_password_reset_email', $GLOBALS['filters']['send_retrieve_password_email'] ?? [], true), 'Legacy reset email hook is registered');

// PR #28: all XML-RPC methods are disabled; unrelated headers stay intact.
check(in_array('__return_false', $GLOBALS['filters']['xmlrpc_enabled'] ?? [], true), 'XML-RPC authenticated methods disabled');
check(in_array('__return_empty_array', $GLOBALS['filters']['xmlrpc_methods'] ?? [], true), 'XML-RPC pingbacks and methods disabled');
$headers = ipa_disable_xmlrpc_remove_pingback_header(['X-Pingback' => 'https://example.test/xmlrpc.php', 'X-Robots-Tag' => 'noindex']);
check(!isset($headers['X-Pingback']) && 'noindex' === $headers['X-Robots-Tag'], 'Pingback header removed without affecting SEO headers');
check(in_array(['wp_head','rsd_link'], $GLOBALS['removed'], true), 'XML-RPC RSD discovery removed');
echo "ALL SECURITY TESTS PASSED\n";

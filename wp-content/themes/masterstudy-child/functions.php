<?php 
	add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
	function theme_enqueue_styles() {

		wp_enqueue_style( 'theme-style', get_stylesheet_uri(), null, STM_THEME_VERSION, 'all' );

		
	}

	add_action( 'wp_footer', 'ipaenglish_render_zalo_floating_button' );
	function ipaenglish_render_zalo_floating_button() {
		$zalo_phone   = apply_filters( 'ipaenglish_zalo_phone', '0862660368' );
		$zalo_web_url = apply_filters( 'ipaenglish_zalo_web_url', 'https://zalo.me/0862660368' );
		$zalo_app_url = $zalo_phone ? 'zalo://conversation?phone=' . rawurlencode( $zalo_phone ) : '';
		$facebook_chat_url = apply_filters( 'ipaenglish_facebook_chat_url', 'https://m.me/IPAEnglish.Ecopark' );

		if ( empty( $zalo_web_url ) && empty( $zalo_app_url ) && empty( $facebook_chat_url ) ) {
			return;
		}
		?>
		<?php if ( ! empty( $facebook_chat_url ) ) : ?>
			<a
				class="ipa-floating-chat-button ipa-facebook-floating-button"
				href="<?php echo esc_url( $facebook_chat_url ); ?>"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="Chat with IPA English on Facebook Messenger"
				style="position:fixed;right:22px;bottom:96px;z-index:9999;display:flex;align-items:center;justify-content:center;width:62px;height:62px;border-radius:50%;background:#0084ff;color:#fff;text-decoration:none;box-shadow:0 10px 28px rgba(20,32,48,.24);transition:transform .2s ease,box-shadow .2s ease,background-color .2s ease;"
				onmouseover="this.style.backgroundColor='#006fd6';this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 34px rgba(20,32,48,.32)';"
				onmouseout="this.style.backgroundColor='#0084ff';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 28px rgba(20,32,48,.24)';"
				onfocus="this.style.backgroundColor='#006fd6';this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 34px rgba(20,32,48,.32)';"
				onblur="this.style.backgroundColor='#0084ff';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 28px rgba(20,32,48,.24)';"
			>
				<span class="ipa-floating-chat-button__icon" aria-hidden="true" style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;line-height:1;color:#fff;">
					<svg class="ipa-floating-chat-button__svg" viewBox="0 0 24 24" width="34" height="34" focusable="false" aria-hidden="true" style="display:block;width:34px;height:34px;max-width:34px;max-height:34px;fill:#fff;">
						<path fill="#fff" d="M12 2C6.48 2 2 6.15 2 11.27c0 2.92 1.45 5.52 3.73 7.22V22l3.4-1.87c.91.25 1.87.39 2.87.39 5.52 0 10-4.15 10-9.25C22 6.15 17.52 2 12 2Zm1 12.5-2.55-2.72-4.97 2.72 5.46-5.8 2.61 2.72 4.91-2.72L13 14.5Z" />
					</svg>
				</span>
			</a>
		<?php endif; ?>
		<?php if ( ! empty( $zalo_web_url ) || ! empty( $zalo_app_url ) ) : ?>
			<a
				class="ipa-floating-chat-button ipa-zalo-floating-button"
				href="<?php echo esc_url( $zalo_app_url ?: $zalo_web_url, array( 'zalo', 'https', 'http' ) ); ?>"
				data-zalo-app-url="<?php echo esc_attr( $zalo_app_url ); ?>"
				data-zalo-web-url="<?php echo esc_url( $zalo_web_url ); ?>"
				rel="noopener noreferrer"
				aria-label="Chat with IPA English on Zalo"
				style="position:fixed;right:22px;bottom:24px;z-index:9999;display:flex;align-items:center;justify-content:center;width:62px;height:62px;border-radius:50%;background:#0068ff;color:#fff;text-decoration:none;box-shadow:0 10px 28px rgba(20,32,48,.24);transition:transform .2s ease,box-shadow .2s ease,background-color .2s ease;"
				onmouseover="this.style.backgroundColor='#0056d6';this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 34px rgba(20,32,48,.32)';"
				onmouseout="this.style.backgroundColor='#0068ff';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 28px rgba(20,32,48,.24)';"
				onfocus="this.style.backgroundColor='#0056d6';this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 34px rgba(20,32,48,.32)';"
				onblur="this.style.backgroundColor='#0068ff';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 28px rgba(20,32,48,.24)';"
			>
				<span class="ipa-floating-chat-button__icon" aria-hidden="true" style="display:flex;align-items:center;justify-content:center;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:700;line-height:1;letter-spacing:0;color:#fff;">Zalo</span>
			</a>
		<?php endif; ?>
		<script>
			(function () {
				var zaloButton = document.querySelector('.ipa-zalo-floating-button');

				if (!zaloButton || !zaloButton.dataset.zaloAppUrl) {
					return;
				}

				zaloButton.addEventListener('click', function (event) {
					var appUrl = zaloButton.dataset.zaloAppUrl;

					event.preventDefault();
					window.location.href = appUrl;
				});
			})();
		</script>
		<?php
	}

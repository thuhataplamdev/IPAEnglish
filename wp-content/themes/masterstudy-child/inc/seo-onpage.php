<?php
/**
 * IPA English on-page SEO integration.
 *
 * Keeps page-level title/description, heading hierarchy and informative image
 * alternative text in one small child-theme integration. Canonical/hreflang
 * ownership remains with WordPress/TranslatePress.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'ipaenglish_enable_page_excerpt_support' );
function ipaenglish_enable_page_excerpt_support() {
	add_post_type_support( 'page', 'excerpt' );
}

/**
 * Resolve request path and language without depending on TranslatePress internals.
 *
 * @return array{path:string,language:string}
 */
function ipaenglish_onpage_request_context() {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$path        = wp_parse_url( $request_uri, PHP_URL_PATH );
	$path        = is_string( $path ) ? trim( rawurldecode( $path ), '/' ) : '';
	$path        = '' === $path ? '/' : '/' . $path . '/';
	$is_vi       = 0 === strpos( $path, '/vi/' );

	if ( $is_vi ) {
		$path = preg_replace( '#^/vi(?=/|$)#', '', $path );
		$path = is_string( $path ) && '' !== $path ? $path : '/';
	}

	return array(
		'path'     => $path,
		'language' => $is_vi ? 'vi' : 'en',
	);
}

/**
 * Approved page-level SEO copy for the 11 search-facing landing pages.
 *
 * @return array<string,array<string,array<string,string>>>
 */
function ipaenglish_onpage_seo_map() {
	return array(
		'/' => array(
			'en' => array(
				'title' => 'English Center in Ecopark | IPA English',
				'description' => 'IPA English is an English center in Ecopark for students aged 11-18, focusing on communication, Cambridge-aligned academic English, and small classes.',
			),
			'vi' => array(
				'title' => 'Trung tâm tiếng Anh Ecopark | IPA English',
				'description' => 'IPA English là trung tâm tiếng Anh tại Ecopark uy tín, giúp học sinh phát triển giao tiếp, học thuật và tự tin sử dụng tiếng Anh trong môi trường quốc tế.',
			),
		),
		'/book-a-test/' => array(
			'en' => array(
				'title' => 'Free English Placement Test | IPA English',
				'description' => 'Book a free English placement test at IPA English to assess current proficiency and receive guidance on a suitable learning pathway.',
			),
			'vi' => array(
				'title' => 'Kiểm tra trình độ tiếng Anh miễn phí | IPA English',
				'description' => 'Đăng ký kiểm tra trình độ tiếng Anh miễn phí tại IPA English để đánh giá năng lực hiện tại và nhận tư vấn lộ trình học phù hợp cho học sinh.',
			),
		),
		'/communicative-english-for-adults/' => array(
			'en' => array(
				'title' => 'Communicative English for Adults | IPA English',
				'description' => 'Explore Communicative English for Adults at IPA English, designed to build practical speaking, listening and confidence for real-world English communication.',
			),
			'vi' => array(
				'title' => 'Tiếng Anh giao tiếp cho người lớn | IPA English',
				'description' => 'Khóa tiếng Anh giao tiếp cho người lớn tại IPA English giúp phát triển kỹ năng nghe, nói và sự tự tin khi sử dụng tiếng Anh trong tình huống thực tế.',
			),
		),
		'/contact-us/' => array(
			'en' => array(
				'title' => 'Contact Our English Center in Ecopark | IPA English',
				'description' => 'Contact IPA English in Ecopark for information about courses, placement tests and learning pathways. Find our address, phone number and contact details.',
			),
			'vi' => array(
				'title' => 'Liên hệ trung tâm tiếng Anh Ecopark | IPA English',
				'description' => 'Liên hệ IPA English tại Ecopark để tìm hiểu khóa học, kiểm tra trình độ và lộ trình phù hợp. Xem địa chỉ, số điện thoại và thông tin liên hệ.',
			),
		),
		'/core-values/' => array(
			'en' => array(
				'title' => 'Core Values & Learning Philosophy | IPA English',
				'description' => 'Discover the core values that guide IPA English: integrity, excellence in education, holistic development, growth mindset and commitment to community.',
			),
			'vi' => array(
				'title' => 'Giá trị cốt lõi & triết lý giáo dục | IPA English',
				'description' => 'Khám phá các giá trị cốt lõi của IPA English: chính trực, chất lượng giáo dục, phát triển toàn diện, tư duy phát triển và cam kết với cộng đồng.',
			),
		),
		'/courses/' => array(
			'en' => array(
				'title' => 'English Courses & Learning Programs | IPA English',
				'description' => 'Explore English courses at IPA English for learners with different goals, including communication, academic skills and structured learning pathways.',
			),
			'vi' => array(
				'title' => 'Khóa học tiếng Anh tại Ecopark | IPA English',
				'description' => 'Khám phá các khóa học tiếng Anh tại IPA English với lộ trình phù hợp, tập trung vào giao tiếp, kỹ năng học thuật và phát triển năng lực tiếng Anh.',
			),
		),
		'/faq/' => array(
			'en' => array(
				'title' => 'International School English FAQ | IPA English',
				'description' => 'Find answers to common questions about English for international school students, learning pathways, academic skills, and IPA English programs.',
			),
			'vi' => array(
				'title' => 'Tiếng Anh trường quốc tế: Giải đáp thường gặp | IPA English',
				'description' => 'Giải đáp các câu hỏi thường gặp về tiếng Anh trường quốc tế, môi trường học quốc tế, lộ trình học và chương trình tiếng Anh tại IPA English.',
			),
		),
		'/founders/' => array(
			'en' => array(
				'title' => 'Meet the Founders | IPA English Ecopark',
				'description' => 'Meet the founders of IPA English, Kristin Thảo Lê-Evans and Tony Evans, and learn about their experience, roles and approach to English education.',
			),
			'vi' => array(
				'title' => 'Nhà sáng lập IPA English tại Ecopark',
				'description' => 'Tìm hiểu về hai nhà sáng lập IPA English, Kristin Thảo Lê-Evans và Tony Evans, cùng kinh nghiệm, vai trò và định hướng giáo dục tiếng Anh của họ.',
			),
		),
		'/global-english-for-teen-achievers/' => array(
			'en' => array(
				'title' => 'English Communication for Teenagers | IPA English',
				'description' => 'English communication course for students aged 11-18 with international teachers, small classes, and a focus on confidence and academic skills.',
			),
			'vi' => array(
				'title' => 'Tiếng Anh giao tiếp cho học sinh | IPA English',
				'description' => 'Khóa học tiếng Anh giao tiếp cho học sinh 11-18 tuổi với giáo viên nước ngoài, lớp học nhỏ, giúp học sinh tự tin giao tiếp và phát triển kỹ năng tiếng Anh.',
			),
		),
		'/learning-system/' => array(
			'en' => array(
				'title' => 'Academic English Learning System | IPA English',
				'description' => 'Explore IPA English’s academic English learning system, combining Cambridge-aligned study methods, presentation skills, and critical thinking development.',
			),
			'vi' => array(
				'title' => 'Tiếng Anh học thuật & phương pháp học | IPA English',
				'description' => 'Khám phá hệ thống tiếng Anh học thuật chuẩn Cambridge tại IPA English với phương pháp học hiệu quả, phát triển tư duy và kỹ năng thuyết trình tiếng Anh.',
			),
		),
		'/testimonials/' => array(
			'en' => array(
				'title' => 'Student Testimonials & Reviews | IPA English',
				'description' => 'Read student testimonials about learning with IPA English and teacher Tony, including experiences from students developing their English skills and confidence.',
			),
			'vi' => array(
				'title' => 'Đánh giá của học viên | IPA English',
				'description' => 'Đọc đánh giá của học viên về quá trình học tại IPA English và cùng thầy Tony, với những chia sẻ về kỹ năng tiếng Anh và sự tự tin khi sử dụng tiếng Anh.',
			),
		),
	);
}

/**
 * Get SEO data for the current public request.
 *
 * @return array<string,string>|null
 */
function ipaenglish_get_custom_seo_data() {
	$context = ipaenglish_onpage_request_context();
	$pages   = ipaenglish_onpage_seo_map();

	if ( ! isset( $pages[ $context['path'] ][ $context['language'] ] ) ) {
		return null;
	}

	return $pages[ $context['path'] ][ $context['language'] ];
}

add_filter( 'pre_get_document_title', 'ipaenglish_custom_seo_title' );
function ipaenglish_custom_seo_title( $title ) {
	if ( is_admin() || is_feed() ) {
		return $title;
	}

	$seo = ipaenglish_get_custom_seo_data();

	return ! empty( $seo['title'] ) ? $seo['title'] : $title;
}

add_action( 'wp_head', 'ipaenglish_render_custom_meta_description', 1 );
function ipaenglish_render_custom_meta_description() {
	if ( is_admin() || is_feed() || ! is_singular( 'page' ) ) {
		return;
	}

	$seo = ipaenglish_get_custom_seo_data();

	if ( empty( $seo['description'] ) ) {
		return;
	}

	echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $seo['description'] ) ) . '">' . "\n";
}

/**
 * Return the canonical public URL for the current request without allowing
 * TranslatePress to apply the active language a second time.
 *
 * @return string
 */
function ipaenglish_onpage_current_url() {
	$base        = untrailingslashit( (string) get_option( 'home' ) );
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$path        = wp_parse_url( $request_uri, PHP_URL_PATH );
	$path        = is_string( $path ) && '' !== $path ? '/' . ltrim( $path, '/' ) : '/';

	return esc_url_raw( $base . $path );
}

/**
 * Add share metadata and conservative WebPage structured data using only facts
 * already present in the approved title/description map.
 */
add_action( 'wp_head', 'ipaenglish_render_social_and_structured_metadata', 2 );
function ipaenglish_render_social_and_structured_metadata() {
	if ( is_admin() || is_feed() || ! is_singular( 'page' ) ) {
		return;
	}

	$seo = ipaenglish_get_custom_seo_data();

	if ( empty( $seo['title'] ) || empty( $seo['description'] ) ) {
		return;
	}

	$context   = ipaenglish_onpage_request_context();
	$url       = ipaenglish_onpage_current_url();
	$site_url  = trailingslashit( (string) get_option( 'home' ) );
	$image_url = wp_get_attachment_image_url( 12804, 'full' );
	$locale    = 'vi' === $context['language'] ? 'vi_VN' : 'en_US';
	$language  = 'vi' === $context['language'] ? 'vi-VN' : 'en-US';

	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:site_name" content="IPA English">' . "\n";
	echo '<meta property="og:locale" content="' . esc_attr( $locale ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $seo['title'] ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $seo['description'] ) . '">' . "\n";

	if ( is_string( $image_url ) && '' !== $image_url ) {
		echo '<meta property="og:image" content="' . esc_url( $image_url ) . '">' . "\n";
		echo '<meta property="og:image:alt" content="IPA English Academy">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $image_url ) . '">' . "\n";
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'WebPage',
		'@id'         => $url . '#webpage',
		'url'         => $url,
		'name'        => $seo['title'],
		'description' => $seo['description'],
		'inLanguage'  => $language,
		'isPartOf'     => array(
			'@type' => 'WebSite',
			'@id'   => $site_url . '#website',
			'url'   => $site_url,
			'name'  => 'IPA English',
		),
	);

	if ( is_string( $image_url ) && '' !== $image_url ) {
		$schema['primaryImageOfPage'] = array(
			'@type' => 'ImageObject',
			'url'   => $image_url,
		);
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * Upgrade existing visible headings to a single page H1 without rewriting page copy.
 * Elementor output reaches this filter after widget rendering on these pages.
 *
 * @param string $content Rendered page content.
 * @return string
 */
add_filter( 'the_content', 'ipaenglish_fix_landing_page_heading_hierarchy', 100 );
function ipaenglish_fix_landing_page_heading_hierarchy( $content ) {
	if ( is_admin() || ! is_singular( 'page' ) || ! is_string( $content ) || '' === $content ) {
		return $content;
	}

	$context = ipaenglish_onpage_request_context();
	$path    = $context['path'];

	$promotions = array(
		'/contact-us/'   => array( 'tag' => 'h3', 'text' => 'Contact' ),
		'/core-values/'  => array( 'tag' => 'h2', 'text' => 'Core(?:&nbsp;|\x{00A0}|\s)+Values' ),
		'/faq/'          => array( 'tag' => 'h2', 'text' => 'FAQ' ),
		'/testimonials/' => array( 'tag' => 'h2', 'text' => 'Testimonials for teacher Tony' ),
	);

	if ( isset( $promotions[ $path ] ) ) {
		$heading     = $promotions[ $path ];
		$pattern     = '#<' . $heading['tag'] . '([^>]*)>(\s*' . $heading['text'] . '\s*)</' . $heading['tag'] . '>#iu';
		$replacement = '<h1$1>$2</h1>';

		if ( 'vi' === $context['language'] && '/core-values/' === $path ) {
			$replacement = '<h1$1>Giá trị cốt lõi</h1>';
		}

		$content = preg_replace( $pattern, $replacement, $content, 1 );
	}

	if ( '/communicative-english-for-adults/' === $path && false === stripos( $content, '<h1' ) ) {
		$heading = 'vi' === $context['language'] ? 'Tiếng Anh giao tiếp cho người lớn' : 'Communicative English for Adults';
		$content = '<div class="ipaenglish-seo-page-heading"><div class="container"><h1>' . esc_html( $heading ) . '</h1></div></div>' . $content;
	}

	if ( '/founders/' === $path ) {
		$content = preg_replace( '#<h1([^>]*)>#i', '<h2$1>', $content );
		$content = preg_replace( '#</h1>#i', '</h2>', $content );
		$content = preg_replace(
			'#<h2([^>]*)>\s*(Founders|Người(?:&nbsp;|\x{00A0}|\s)+Sáng(?:&nbsp;|\x{00A0}|\s)+Lập)\s*</h2>#iu',
			'<p$1>$2</p>',
			$content,
			1
		);
		$heading = 'vi' === $context['language'] ? 'Nhà sáng lập IPA English' : 'Founders of IPA English';
		$content = '<div class="ipaenglish-seo-page-heading"><div class="container"><h1>' . esc_html( $heading ) . '</h1></div></div>' . $content;
	}

	return $content;
}

/**
 * Localize the MasterStudy LMS courses archive H1 at its translation source.
 *
 * TranslatePress/W3TC can wrap the final HTML in their own output buffers, so
 * rewriting this LMS-owned heading after rendering is not reliable. The LMS
 * template emits the label through esc_html_e(), making gettext the narrowest
 * server-rendered hook for this exact string and text domain.
 *
 * @param string $translation Translated text.
 * @param string $text        Original text.
 * @param string $domain      Text domain.
 * @return string
 */
add_filter( 'gettext', 'ipaenglish_localize_lms_courses_heading', 999, 3 );
function ipaenglish_localize_lms_courses_heading( $translation, $text, $domain ) {
	if ( is_admin() || 'Courses' !== $text || 'masterstudy-lms-learning-management-system' !== $domain ) {
		return $translation;
	}

	$context = ipaenglish_onpage_request_context();

	if ( 'vi' !== $context['language'] || '/courses/' !== $context['path'] ) {
		return $translation;
	}

	return 'Khóa học tiếng Anh';
}

/**
 * Supporting copy for the ten EN/VI landing-page variants that Screaming Frog
 * still measured below 300 rendered words after structural remediation.
 * Copy is intentionally limited to claims already present in the page,
 * approved metadata or linked IPA English course pages.
 *
 * @return array<string,array<string,array{heading:string,paragraphs:array<int,string>}>>
 */
function ipaenglish_onpage_supporting_copy_map() {
	return array(
		'/book-a-test/' => array(
			'en' => array(
				'heading'    => 'Using the placement test to plan the next step',
				'paragraphs' => array(
					'The free placement test helps IPA English understand a learner’s current English level before guidance is given on a suitable learning pathway. Complete the form with the learner’s grade, school and any known English level, and the IPA English team will contact you to arrange the test.',
					'The placement test is most useful when it is treated as one part of a wider conversation about the learner. Families can use the result to ask what skills need attention, which learning goals should come first and which available IPA English program is relevant to those goals. If a learner has previous study experience, school information or an existing English level, including that context in the form can make the follow-up discussion more specific. For current scheduling and course availability, the IPA English team can confirm the details directly after receiving the request.',
				),
			),
			'vi' => array(
				'heading'    => 'Dùng bài kiểm tra đầu vào để xác định bước tiếp theo',
				'paragraphs' => array(
					'Bài kiểm tra trình độ miễn phí giúp IPA English có thêm cơ sở để hiểu mức tiếng Anh hiện tại của người học trước khi trao đổi về lộ trình phù hợp. Trong biểu mẫu, gia đình có thể cung cấp các thông tin như khối lớp, trường đang học và trình độ tiếng Anh đã biết nếu có. Những dữ liệu này tạo thêm bối cảnh để kết quả kiểm tra được xem cùng với tình hình học tập thực tế của người học.',
					'Sau khi gửi yêu cầu, gia đình có thể dùng kết quả kiểm tra để hỏi rõ kỹ năng nào cần ưu tiên, mục tiêu học tập nào nên đặt trước và chương trình nào đang phù hợp với nhu cầu đó. Bài kiểm tra không phải là lời hứa về một kết quả học tập cụ thể; đây là bước đầu để xác định điểm xuất phát rõ hơn. Lịch kiểm tra, tình trạng lớp và thông tin đăng ký hiện tại có thể được IPA English xác nhận trực tiếp khi liên hệ lại.',
				),
			),
		),
		'/communicative-english-for-adults/' => array(
			'en' => array(
				'heading'    => 'What this communication course is designed to support',
				'paragraphs' => array(
					'Communicative English for Adults is coming soon at IPA English. The program is being developed around practical speaking and listening for real-world communication, with a focus on building confidence when using English. Contact IPA English for current information about the course and guidance on available learning options while the program is being prepared. Because the course is not yet open, this page does not promise dates or enrollment availability; the team can confirm the latest status directly.',
					'Because this program is still presented as coming soon, the most useful next step is to review the focus described on this page and contact IPA English for the latest status. Prospective learners can ask how speaking and listening practice will be approached, what communication goals the course is intended to support, and how the program may fit their current level. This keeps expectations tied to the published course information while giving adults a clear way to decide whether to wait for this program or discuss another currently available learning option with the team.',
				),
			),
			'vi' => array(
				'heading'    => 'Khóa học giao tiếp này hướng đến điều gì',
				'paragraphs' => array(
					'Khóa Tiếng Anh giao tiếp cho người lớn hiện được IPA English giới thiệu ở trạng thái sắp ra mắt. Nội dung công bố tập trung vào giao tiếp thực tế, đặc biệt là kỹ năng nghe, nói và sự tự tin khi sử dụng tiếng Anh trong những tình huống đời sống. Vì chương trình chưa được công bố là đã mở đăng ký, trang này không đưa ra ngày khai giảng hay cam kết về lịch học; người quan tâm nên xem đây là phần giới thiệu định hướng của khóa học.',
					'Nếu đang cân nhắc chương trình, học viên có thể dùng các mục tiêu trên trang để chuẩn bị câu hỏi cụ thể trước khi liên hệ IPA English: mình muốn cải thiện tình huống giao tiếp nào, kỹ năng nghe hay nói đang là ưu tiên, và trình độ hiện tại cần được xác định ra sao. IPA English có thể xác nhận tình trạng mới nhất của khóa học và trao đổi về lựa chọn học tập đang có. Cách này giúp người học so sánh nhu cầu thực tế của mình với nội dung đã công bố thay vì dựa vào kỳ vọng chưa được xác nhận.',
				),
			),
		),
		'/contact-us/' => array(
			'en' => array(
				'heading'    => 'Preparing before you contact IPA English',
				'paragraphs' => array(
					'Contact IPA English for information about courses, placement tests and learning pathways. You can reach the team by phone or email, or visit the Ecopark location shown on this page. The contact details above are the direct way to ask about current programs and the next suitable step for a learner. This makes it easier to confirm current availability before visiting the academy.',
					'Use the contact page to prepare the practical details you want to confirm before choosing a program: the learner’s current needs, age or school stage, the type of English support being considered, and whether a placement test is the appropriate next step. IPA English already publishes its phone, email and Ecopark location here, so families can use the channel that is most convenient for them. Asking these questions before a visit also helps keep the conversation focused on the learner’s situation rather than relying on a generic course recommendation.',
				),
			),
			'vi' => array(
				'heading'    => 'Chuẩn bị gì trước khi liên hệ IPA English',
				'paragraphs' => array(
					'Trang liên hệ là nơi phù hợp để gia đình kiểm tra các thông tin thực tế trước khi lựa chọn chương trình học. Khi liên hệ IPA English, phụ huynh có thể chuẩn bị trước nhu cầu hiện tại của người học, độ tuổi hoặc khối lớp, mục tiêu cần hỗ trợ và câu hỏi về việc có nên thực hiện bài kiểm tra trình độ hay không. Trang này đã cung cấp số điện thoại, email và địa điểm tại Ecopark để gia đình chọn cách liên hệ thuận tiện.',
					'Việc trao đổi trước giúp cuộc tư vấn tập trung vào tình huống cụ thể của người học thay vì chỉ hỏi chung về một khóa học. Gia đình có thể dùng phần liên hệ để xác nhận chương trình đang có, cách đăng ký kiểm tra đầu vào và bước tiếp theo phù hợp với nhu cầu hiện tại. Nếu cần đến trực tiếp, thông tin trên trang cũng giúp kiểm tra địa điểm trước khi di chuyển và chủ động hơn khi sắp xếp thời gian trao đổi với IPA English.',
				),
			),
		),
		'/core-values/' => array(
			'en' => array(
				'heading'    => 'How the core values shape the learning approach',
				'paragraphs' => array(
					'IPA English presents its core values as the principles behind how the academy approaches education and its wider community. Integrity provides a basis for clear and responsible relationships, while excellence in education keeps attention on the quality of the learning experience. Holistic development recognises that progress is broader than a single score or language task.',
					'The same page also highlights a growth mindset and commitment to community. Together, these ideas describe an environment where learners can keep developing their skills, respond constructively to challenge and take part in a learning community. These values are useful context for families comparing IPA English with other learning options because they explain the principles the academy says should guide its decisions and educational approach.',
				),
			),
		),
		'/courses/' => array(
			'en' => array(
				'heading'    => 'Choosing the right learning pathway',
				'paragraphs' => array(
					'Explore English learning options at IPA English for different goals, including communication and academic development. The Global English for Teen Achievers page provides program information for teenage learners, while Communicative English for Adults is marked as coming soon. Use the course pages for current program details or contact IPA English for guidance on a suitable learning pathway.',
					'A useful way to compare the programs is to begin with the learner’s current goal rather than choosing only by course name. Some learners may be looking for stronger everyday communication, while others may need more structured academic English development. The individual course pages explain the audience and focus of the programs that IPA English currently presents online. Families can review those details first, then use the contact or placement-test pages when they need help matching a learner’s current level and priorities with the most relevant available pathway.',
				),
			),
			'vi' => array(
				'heading'    => 'Cách chọn lộ trình học phù hợp',
				'paragraphs' => array(
					'Trang khóa học giúp người học và gia đình nhìn tổng quan các lựa chọn tiếng Anh mà IPA English đang giới thiệu. Thay vì chọn chỉ theo tên khóa học, nên bắt đầu từ mục tiêu hiện tại: cần cải thiện giao tiếp, phát triển tiếng Anh học thuật hay tìm một lộ trình có cấu trúc phù hợp với giai đoạn học tập. Các trang chương trình riêng cung cấp thêm thông tin về nhóm người học và trọng tâm của từng lựa chọn.',
					'Sau khi xem nội dung từng chương trình, gia đình có thể đối chiếu với trình độ hiện tại và ưu tiên của người học. Nếu chưa rõ nên bắt đầu từ đâu, trang kiểm tra trình độ và trang liên hệ là hai bước tiếp theo để có thêm thông tin trước khi quyết định. Với những chương trình được ghi là sắp ra mắt, IPA English có thể xác nhận tình trạng hiện tại trực tiếp. Cách tiếp cận này giúp việc chọn khóa học dựa trên nhu cầu và thông tin đang được công bố trên website.',
				),
			),
		),
		'/testimonials/' => array(
			'en' => array(
				'heading'    => 'How to use student testimonials when deciding',
				'paragraphs' => array(
					'The testimonials on this page are individual accounts of learning with IPA English and teacher Tony. They give prospective learners and families another type of context alongside course descriptions and academic information: what previous students chose to highlight about their own experience, the skills they worked on and the confidence they developed while using English.',
					'Testimonials should be read as personal experiences rather than a promise that every learner will have the same outcome. A useful next step is to compare the themes in these reviews with the learner’s own goals, then review the relevant course or learning-system page for more structured information. Families who still have questions can contact IPA English or use the placement-test page to discuss the learner’s current level and possible next steps.',
				),
			),
		),
	);
}

/**
 * Language-aware ALT text for informative WordPress media used across public pages.
 * Decorative language flags intentionally retain alt="" and role="presentation".
 *
 * @return array<int,array<string,string>>
 */
function ipaenglish_onpage_image_alt_map() {
	return array(
		12232 => array( 'en' => 'Student presenting in front of a projector during an English lesson', 'vi' => 'Học sinh thuyết trình trước máy chiếu trong giờ học tiếng Anh' ),
		12252 => array( 'en' => 'Students working together during an English study session', 'vi' => 'Học sinh cùng học và thực hành tiếng Anh' ),
		12297 => array( 'en' => 'IPA English founders Kristin Thảo Lê-Evans and Tony Evans', 'vi' => 'Hai nhà sáng lập IPA English Kristin Thảo Lê-Evans và Tony Evans' ),
		12299 => array( 'en' => 'IPA English teacher training session', 'vi' => 'Buổi đào tạo giáo viên tại IPA English' ),
		12350 => array( 'en' => 'Tony Evans, founder and Director of Studies at IPA English', 'vi' => 'Tony Evans, nhà sáng lập và Giám đốc Học thuật IPA English' ),
		12410 => array( 'en' => 'Students practicing English together in class', 'vi' => 'Học sinh cùng thực hành tiếng Anh trong lớp' ),
		12525 => array( 'en' => 'Kristin Thảo Lê-Evans, co-founder and Director of Operations at IPA English', 'vi' => 'Kristin Thảo Lê-Evans, đồng sáng lập và Giám đốc Vận hành IPA English' ),
		12804 => array( 'en' => 'IPA English Academy', 'vi' => 'Học viện Anh ngữ IPA' ),
		13062 => array( 'en' => 'Tony Evans, founder and Director of Studies at IPA English', 'vi' => 'Tony Evans, nhà sáng lập và Giám đốc Học thuật IPA English' ),
		13221 => array( 'en' => 'English course options at IPA English', 'vi' => 'Các lựa chọn khóa học tiếng Anh tại IPA English' ),
		13482 => array( 'en' => 'English learning pathway at IPA English from input to practical tasks', 'vi' => 'Lộ trình học tiếng Anh tại IPA English từ đầu vào đến nhiệm vụ thực hành' ),
	);
}

/**
 * Apply ALT text when WordPress renders an attachment through its media helpers.
 *
 * @param array<string,string> $attr       Image attributes.
 * @param WP_Post              $attachment Attachment object.
 * @return array<string,string>
 */
add_filter( 'wp_get_attachment_image_attributes', 'ipaenglish_onpage_attachment_alt', 20, 2 );
function ipaenglish_onpage_attachment_alt( $attr, $attachment ) {
	$context = ipaenglish_onpage_request_context();
	$alts    = ipaenglish_onpage_image_alt_map();
	$id      = isset( $attachment->ID ) ? (int) $attachment->ID : 0;

	if ( isset( $alts[ $id ][ $context['language'] ] ) ) {
		$attr['alt'] = $alts[ $id ][ $context['language'] ];
	}

	return $attr;
}

/**
 * Make the existing Core Values homepage heading a crawlable internal link.
 *
 * The current theme footer does not render through the registered secondary
 * menu location, so the older menu-item fallback is not present in final HTML.
 * Reusing the visible Elementor heading keeps the link contextual and avoids
 * adding a second navigation element only for SEO.
 *
 * @param string                     $html    Full rendered HTML.
 * @param array{path:string,language:string} $context Normalized request context.
 * @return string
 */
function ipaenglish_link_home_core_values_heading( $html, $context ) {
	if ( '/' !== $context['path'] ) {
		return $html;
	}

	$is_vi       = 'vi' === $context['language'];
	$base        = untrailingslashit( (string) get_option( 'home' ) );
	$target      = $base . ( $is_vi ? '/vi/core-values/' : '/core-values/' );
	$pattern     = '#<h2([^>]*)>\\s*(Core Values|Giá trị cốt lõi)\\s*</h2>#u';
	$replacement = '<h2$1><a class="ipaenglish-seo-core-values-link" href="' . esc_url( $target ) . '">$2</a></h2>';

	return preg_replace( $pattern, $replacement, $html, 1 );
}

/**
 * Elementor and footer templates can emit raw <img> tags instead of calling
 * wp_get_attachment_image(). Buffer public frontend responses and fill ALT text
 * for known informative wp-image-* IDs. Non-HTML responses are returned intact.
 */
add_action( 'template_redirect', 'ipaenglish_start_onpage_html_buffer', 99 );
function ipaenglish_start_onpage_html_buffer() {
	if ( is_admin() || is_feed() || wp_doing_ajax() ) {
		return;
	}

	ob_start( 'ipaenglish_filter_rendered_onpage_html' );
}

/**
 * Complete rendered-page ALT coverage and append scoped supporting copy.
 *
 * @param string $html Full rendered HTML.
 * @return string
 */
function ipaenglish_filter_rendered_onpage_html( $html ) {
	if (
		! is_string( $html ) ||
		'' === $html ||
		false === stripos( $html, '<html' ) ||
		! class_exists( 'WP_HTML_Tag_Processor' )
	) {
		return $html;
	}

	$context   = ipaenglish_onpage_request_context();
	$alts      = ipaenglish_onpage_image_alt_map();
	$processor = new WP_HTML_Tag_Processor( $html );

	while ( $processor->next_tag( 'IMG' ) ) {
		$class = (string) $processor->get_attribute( 'class' );
		$src   = (string) $processor->get_attribute( 'src' );
		$alt   = (string) $processor->get_attribute( 'alt' );
		$title = (string) $processor->get_attribute( 'title' );

		if ( preg_match( '/(?:^|\s)wp-image-(\d+)(?:\s|$)/', $class, $matches ) ) {
			$id = (int) $matches[1];

			if ( isset( $alts[ $id ][ $context['language'] ] ) ) {
				$processor->set_attribute( 'alt', $alts[ $id ][ $context['language'] ] );
				continue;
			}
		}

		if (
			'' === trim( $alt ) &&
			false !== strpos( $class, 'rev-slidebg' ) &&
			false !== strpos( $src, '/revslider/sr6/assets/assets/dummy.png' ) &&
			'' !== trim( $title )
		) {
			$processor->set_attribute( 'alt', $title );
		}
	}

	$html = $processor->get_updated_html();
	$html = ipaenglish_link_home_core_values_heading( $html, $context );

	$supporting_copy = ipaenglish_onpage_supporting_copy_map();

	if ( isset( $supporting_copy[ $context['path'] ][ $context['language'] ] ) ) {
		$copy       = $supporting_copy[ $context['path'] ][ $context['language'] ];
		$paragraphs = '';

		foreach ( $copy['paragraphs'] as $paragraph ) {
			$paragraphs .= '<p>' . esc_html( $paragraph ) . '</p>';
		}

		$section = '<section class="ipaenglish-seo-supporting-copy"><div class="container"><h2>' . esc_html( $copy['heading'] ) . '</h2>' . $paragraphs . '</div></section>';

		if ( false !== stripos( $html, '<footer' ) ) {
			$html = preg_replace( '#<footer\b#i', $section . '<footer', $html, 1 );
		} elseif ( false !== stripos( $html, '</body>' ) ) {
			$html = preg_replace( '#</body>#i', $section . '</body>', $html, 1 );
		}
	}

	return $html;
}

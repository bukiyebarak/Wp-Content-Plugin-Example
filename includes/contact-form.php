<?php

//kanca sayesinde kısa kod ile kullanıcı arayüzüne ekleme yapılıyor.
add_shortcode( 'contact-form', 'show_contact_form' );
add_action( 'rest_api_init', 'create_rest_endpoint' ); //ajax işlemleri için kullanıldı
add_action( 'init', 'create_submissions_page' ); //veritabanı bağlanır

function create_submissions_page(): void {
	$args = [
		'public'      => true,
		'has_archive' => true,
		'labels'      => [
			'name'          => 'Submissions',
			'singular_name' => 'Submission'
		],
	];
	register_post_type( 'submission', $args );
}

function show_contact_form() {
	ob_start(); // Başlatma tamponunu açar. Sayfa da çağrılan yerde yazılır.
	include MY_PLUGIN_PATH . '/includes/templates/contact-form.php';

	return ob_get_clean(); // Tamponu içeriği alır ve temizler.
}

function create_rest_endpoint() {
	register_rest_route( 'v1/contact-form', 'submit', array(
		'methods'  => 'POST',
		'callback' => 'handle_enquiry',
	) );
}

function handle_enquiry( $data ) {
	$params = $data->get_params();
	if ( ! wp_verify_nonce( $params['_wpnonce'], 'wp_rest' ) ) {
		return new WP_REST_Response( 'Message not sent', 422 );
	}
	unset( $params['_wpnonce'] );
	unset( $params['_wp_http_referer'] );
//	return $params;
	$admin_email = get_bloginfo( 'admin_email' );
	$admin_name  = get_bloginfo( 'name' );
	$headers     = [];
	$headers[]   = "From: {$admin_name} {$admin_email}";
	$headers[]   = "Reply-to: {$params['name']} <{$params['email']}> ";
	$subject     = "New enquiry from {$params['name']}";
	$message     = '';
	$message     .= "Message has been sent from {$params['name']}";

	foreach ( $params as $label => $value ) {
		$message .= ucfirst( $label ) . ':' . $value;
	}
	wp_mail( $admin_email, $subject, $message, $headers );

	return new WP_REST_Response( 'The message was sent successfully', 200 );
}

//------------------------ Eklentiyi template olarak ekleme----------------------------------

function my_template_array() {
	$temps                     = [];
	$temps['contact-form.php'] = 'My Special Tempt';
	return $temps;
}

function my_template_register( $page_templates, $theme, $post ) {
	$templates = my_template_array();
	foreach ( $templates as $tk => $tv ) // $tk:template key, $tv:template value
	{
		$page_templates[ $tk ] = $tv;
	}
	return $page_templates;
}

add_filter( 'theme_page_templates', 'my_template_register', 10, 3 ); //sayfalara template yani şablon ekledi.Filter bölümüne

function my_template_select( $template ) {
	global $post, $wp_query, $wpdb;
	if ( isset( $post->ID ) ) {
		$page_temp_slug = get_page_template_slug( $post->ID );
		$templates      = my_template_array();
//	if ($page_temp_slug=='contact-form.php') {
		if ( isset( $templates[ $page_temp_slug ] ) ) {
//		echo '<pre>Preformatted:';
//		print_r( $page_temp_slug );
//		echo '</pre>';
			$template = plugin_dir_path( __FILE__ ) . 'templates/temps/' . $page_temp_slug;
		}
	}

	return $template;
}

add_filter( 'template_include', 'my_template_select', 99 );
function remove_admin_bar_by_post_type() {
	global $post, $current_user, $wp_query, $wpdb;
//	echo '<pre>Preformatted:'; print_r($post);  print_r($current_user); echo '</pre>';
//	echo '<pre>Preformatted:'; print_r($wp_query->query['name']);   echo '</pre>';
	$page_temp_slug = get_page_template_slug( $post->ID );
//	echo '<pre>Preformatted:'; print_r($page_temp_slug);   echo '</pre>';

//	show_admin_bar(false);
//	is_admin();
}

add_action( 'wp_head', 'remove_admin_bar_by_post_type' );

function sectionb_menu_register(){
	register_nav_menus(array(
		'section_b'=>__('Section B Menu')
	));
}
add_action('init','sectionb_menu_register');
//------------------------ Eklentiyi template olarak ekleme----------------------------------

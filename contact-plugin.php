<?php
//die('you can  t here');
/*
 *
 * Plugin Name: Contact Plugin
 * Description: This is my test plugin
 * Version: 1.0.0
 * Text Domain: options-plugin
 *
 */

//siteye doğrudan etkileşim engellendi.

if ( ! defined( 'ABSPATH' ) ) {
//	die("You can be here");
}

//bu sınıfa etkileşim yoksa yükleyecek
if ( ! class_exists( 'ContactPlugin' ) ) {
// Kapsülleme işlemi
	class ContactPlugin {
		/*require_once işlevi kullanılarak belirli bir dosya dahil edilmektedir. plugin_dir_path() işlevi, WordPress eklentisi içindeki bir dosyanın tam yolunu döndürür. __FILE__ özel bir sabittir ve mevcut dosyanın tam yolunu içerir.Bu kod parçası, belirtilen dosyanın tam yolunu hesaplar ve vendor/autoload.php dosyasını dahil eder.*/
		public function __construct() {
			define('MY_PLUGIN_PATH',plugin_dir_path( __FILE__ ));
			require_once( MY_PLUGIN_PATH . '/vendor/autoload.php' );
		}
//		tüm mantığın dahil olacağı yer
		public function initialize(){
			// yardımcı programlar dahil edildi.
			include_once MY_PLUGIN_PATH . 'includes/utilities.php';
			include_once MY_PLUGIN_PATH . 'includes/options-page.php';
			include_once MY_PLUGIN_PATH. 'includes/contact-form.php';
		}
	}

//etkileşim oluşturur
	$contactPlugin= new ContactPlugin;
	$contactPlugin->initialize();

}
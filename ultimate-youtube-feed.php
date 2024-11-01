<?php
/**
 * Plugin Name: Ultimate YouTube Feed
 * Description: Youtube feed for Elementor.
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Plugin URI: https://wpmet.com/plugin/gutenkit/
 * Author: Wpmet
 * Version: 1.0.0
 * Author URI: https://wpmet.com/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: ultimate-youtube-feed
 * Domain Path: /languages
 *
 * @package UltimateYoutubeFeed
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class file.
 */
final class UltimateYoutubeFeed {
	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @return string The plugin version.
	 */
	public static function version() {
		return '1.0.0';
	}

	/**
	 * Minimum elementor version
	 *
	 * @since 1.0.0
	 * @return string Minimum elementor version required to run the plugin.
	 */
	public static function min_el_version() {
		return '3.0.0';
	}

	/**
	 * Minimum PHP version
	 *
	 * @since 1.0.0
	 * @return string Minimum PHP version required to run the plugin.
	 */
	public static function min_php_version() {
		return '7.4';
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		// plugins helper constants.
		define( 'ULTIMATE_YOUTUBE_FEED_PLUGIN_VERSION', self::version() );
		define( 'ULTIMATE_YOUTUBE_FEED_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'ULTIMATE_YOUTUBE_FEED_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'ULTIMATE_YOUTUBE_FEED_BLOKS_INC_DIR', ULTIMATE_YOUTUBE_FEED_PLUGIN_DIR . 'includes/' );

		// load after plugin activation.
		register_activation_hook( __FILE__, array( $this, 'activated_plugin' ) );

		// load autoloader.
		require_once ULTIMATE_YOUTUBE_FEED_PLUGIN_DIR . 'scoped/vendor/scoper-autoload.php';

		// Load translation.
		add_action( 'init', array( $this, 'i18n' ) );

		// Check if elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_head', array( $this, 'missing_elementor' ) );
			\UltimateYoutubeFeedScoped\Wpmet\UtilityPackage\Notice\Notice::init();
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::min_php_version(), '<' ) ) {
			add_action( 'admin_head', array( $this, 'failed_php_version' ) );
			\UltimateYoutubeFeedScoped\Wpmet\UtilityPackage\Notice\Notice::init();
			return;
		}

		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
	}

	/**
	 * Plugin activate.
	 */
	public function activated_plugin() {}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 */
	public function i18n() {
		load_plugin_textdomain( 'ultimate-youtube-feed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have elementor installed or activated.
	 *
	 * @since 1.0.0
	 */
	public function missing_elementor() {
		$btn = array(
			'default_class' => 'button',
			'class'         => 'button-primary ', // button-primary button-secondary button-small button-large button-link.
		);

		if ( function_exists( 'get_plugins' ) && array_key_exists( 'elementor/elementor.php', get_plugins() ) ) {
			$btn['text'] = esc_html__( 'Activate Elementor', 'ultimate-youtube-feed' );
			$btn['url']  = wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php' );
		} else {
			$btn['text'] = esc_html__( 'Install Elementor', 'ultimate-youtube-feed' );
			$btn['url']  = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		}

		\UltimateYoutubeFeedScoped\Wpmet\UtilityPackage\Notice\Notice::instance( 'ultimate-youtube-feed', 'unsupported-elementor-version' )
		->set_type( 'error' )
		->set_message( sprintf( /* translators: 1: %1$s min elementor version */ esc_html__( 'Ultimate YouTube Feed requires Elementor version %1$s+, which is currently NOT RUNNING.', 'ultimate-youtube-feed' ), self::min_el_version() ) )
		->set_button( $btn )
		->call();
	}

	/**
	 * Admin notice.
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 */
	public function failed_php_version() {
		\UltimateYoutubeFeedScoped\Wpmet\UtilityPackage\Notice\Notice::instance( 'ultimate-youtube-feed', 'unsupported-php-version' )
		->set_type( 'error' )
		->set_message( sprintf( /* translators: 1: %1$s min php version */ esc_html__( 'Ultimate YouTube Feed requires PHP version %1$s+, which is currently NOT RUNNING on this server.', 'ultimate-youtube-feed' ), self::min_php_version() ) )
		->call();
	}

	/**
	 * Initialize the widgets.
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @param $widgets_manager The widgets manager.
	*/
	function register_widgets( $widgets_manager ) {
		require_once ULTIMATE_YOUTUBE_FEED_PLUGIN_DIR . 'widgets/youtube-feed.php';
		$widgets_manager->register( new \Ultimate_Youtube_Feed_Widget() );
	}
}

/**
 * Kickoff the plugin
 *
 * @since 1.0.0
 */
new UltimateYoutubeFeed();

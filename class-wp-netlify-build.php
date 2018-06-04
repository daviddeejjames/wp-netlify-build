<?php
/**
 * WP Netlify Build Class
 *
 * @package   WP_Netlify_Build
 * @author    David James <dave@dfjames.com>
 * @license   GPL-2.0+
 * @link 			TBA
 */

/**
 * @package WP_Netlify_Build
 * @author  David James <dave@dfjames.com>
 */
class WP_Netlify_Build {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	const VERSION = '0.0.1';

	/**
	 * Unique identifier for plugin.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $plugin_slug = 'wp-netlify-build';

	/**
	 * Instance of this class.
	 *
	 * @since 0.0.1
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Stores Netlify Site API key
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $netlify_site_api_key = '';

	/**
	 * Initialize the plugin by loading public scripts and styles or admin page
	 *
	 * @since 0.0.1
	 */
	public function __construct() {


		// Define Variations
		$this->netlify_site_api_key 	= get_option( 'dfj_netlify_site_api_key' );

		// If there is no API Key set, send a warning
		if($this->netlify_site_api_key == '') {
			// add_action('admin_notices', array($this, 'no_api_key_admin_notice'));
		}

		// Load Admin Functions
		if ( is_admin() ) {
			// Add the settings page and menu item.
			add_action( 'admin_menu', array( $this, 'plugin_admin_menu' ) );

		}

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register the settings menu for this plugin into the WordPress Settings menu.
	 *
	 * @since 0.0.1
	 */
	public function plugin_admin_menu() {
		add_submenu_page( 'options-general.php', __( 'WP Netlify Build Settings', 'wp-netlify-build' ), __( 'WP Netlify Build', 'wp-netlify-build' ), 'manage_options', $this->plugin_slug, array( $this, 'wp_netlify_build_options' ) );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 0.0.1
	 */
	public function wp_netlify_build_options() {
		if ( ! current_user_can( 'edit_posts' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if ( ! empty( $_POST ) && check_admin_referer( 'wp_netlify_build', 'save_wp_netlify_build' ) ) {
			//add or update netlify_site_api_key
			if ( $this->netlify_site_api_key !== false ) {
				update_option( 'netlify_site_api_key', $_POST['netlify_site_api_key'] );
			} else {
				add_option( 'netlify_site_api_key', $_POST['netlify_site_api_key'], null, 'no' );
			}

			wp_redirect( admin_url( 'admin.php?page='.$_GET['page'].'&updated=1' ) );

		}

		$show_full_form = false;
		if($this->netlify_site_api_key != '') {
			$show_full_form = true;
		}

		?>
		<div class="wrap">
			<h2><?php _e( 'WP Netlify Build Settings', 'wp-netlify-build' );?></h2>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page='.$_GET['page'].'&noheader=true' ) ); ?>" enctype="multipart/form-data">
				<?php wp_nonce_field( 'wp_netlify_build', 'save_wp_netlify_build' ); ?>
				<div class="dfj_netlify_site_form">
					<table class="form-table" width="100%">
						<tr>
							<th scope="row"><label for="wp_netlify_build_api_key"><?php _e( 'Netlify Site API Key', 'wp-netlify-build' );?></label></th>
							<td><input type="text" name="dfj_netlify_site_api_key" id="dfj_netlify_site_api_key" maxlength="255" size="75" value="<?php echo $this->dfj_netlify_site_api_key; ?>"></td>
						</tr>

						<?php if($show_full_form) : ?>

						<tr>
							<th scope="row"><label for="dfj_netlify_site_form">Showing A Full Form.</th>
							<td>
							</td>
						</tr>

						<?php endif; ?>

					</table>
					<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ) ?>" />
					</p>
				</div>
			</form>
			<?php
			$plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) );
			?>
		</div>
		<?php
	}
}

// TODO: Save Method and Call Netlify API!
<?php
/**
 * WP Netlify Build plugin
 *
 * @package     WP_Netlify_Build
 * @author      David James <dave@dfjames.com>
 * @license     GPL-2.0+
 * @link        TBA
 *
 * @wordpress-plugin
 * Plugin Name: WP Netlify Build
 * Plugin URI:  https://github.com:daviddeejjames/wp-netlify-build
 * Description: Will trigger a given Netlify Build via the Netlify API site key.
 * Version:     0.0.1
 * Author:      David James
 * Author URI:  https://dfjames.com
 * Text Domain: wp-netlify-build
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * WP Netlify Build is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WP Netlify Build is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WP Netlify Build. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'class-wp-netlify-build.php';

add_action( 'plugins_loaded', array( 'WP_Netlify_Build', 'get_instance' ), 99999999 );

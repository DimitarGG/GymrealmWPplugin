<?php // ѣ
/**
 * Plugin Name: GymRealm
 * Description: GymRealm for WordPress.
 * Version: 0.0.1
 * Author: pavelsof
 * Author URI: http://gymrealm.com/
 * License: GPL2
 */

/*  Copyright 2014  Pavel Sofroniev  (email : pavelsof@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * The plugin's entry point.
 * 
 * Code style note:
 * Everything in the global namespace is prefixed with
 * GymRealm_ in case it is a class, or with
 * gymrealm_ otherwise.
 * 
 * @author Pavel
 * @package GymRealm
 * @since 0.0.1
 */

if(!is_admin()) {
	require_once('lib/Plugin.class.php');
	$gymrealm_plugin = new GymRealm_Plugin();
} else {
	require_once('lib/AdminPlugin.class.php');
	$gymrealm_plugin = new GymRealm_AdminPlugin();
}

?>

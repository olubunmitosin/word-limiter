<?php
/**
 * Plugin Name: Word Limiter
 * Plugin URI: https://www.github.com/olubunmitosin/word-restricter
 * Description: A WordPress plugin that helps restrict words input for frontend post submission applications in supported editors.
 * Version: 1.0.0
 * Author: Olubunmi Tosin
 * Author URI: http://www.derizotech.com/victor
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl.html
 * Donate link: http://ravefwd.com/#donate
 *
 *
 * Copyright 2018
 * Olubunmi Tosin
 * (email : olubunmivictor6@gmail.com)
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
 * USA
 */

defined( 'ABSPATH' ) or die('No script kiddies please');

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


/**
 * Load all plugin resources and fire off functionality
 * as soon as they are loaded. This is the entry point of
 * the plugin, and we'll make it concise as cool as possible.
 *
 * Class WordLimiter
 */
class WordLimiter {

	/**
	 * protected property
	 * @var
	 */
	protected $plugin_dir;

	public static function init()
	{
		//reference this current class
		$class = __CLASS__;
		//instantiate this class
		new $class;
	}

	public function __construct() {
		//set plugin base directory
		$this->plugin_dir = dirname( __FILE__ );
		//we want to load all files as soon as this class is instantiated.
		$this->loadFiles();
	}

	public function loadFiles()
	{
		//load required files needed for smooth functionality.
		require_once $this->plugin_dir . '/admin/core-functions.php';
		require_once $this->plugin_dir . '/admin/style-loader.php';
		require_once $this->plugin_dir . '/admin/admin-menu.php';
		require_once $this->plugin_dir . '/admin/settings-page.php';
		require_once $this->plugin_dir . '/admin/settings-register.php';
		require_once $this->plugin_dir . '/admin/settings-validate.php';
		require_once $this->plugin_dir . '/admin/settings-callbacks.php';
	}

}

//Fire up entire plugin
add_action( 'plugins_loaded', array( 'WordLimiter', 'init' ) );



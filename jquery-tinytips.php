<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * Plugin Name: jQuery Tinytips
 * Plugin URI: http://www.techotronic.de/plugins/jquery-tinytips/
 * Description: Adds tinytips tooltips to links on your site. Comes with different themes.
 * Version: 1.2
 * Author: Arne Franken
 * Author URI: http://www.techotronic.de/
 * License: GPL
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
?>
<?php
//define constants
define('JQUERYTINYTIPS_VERSION', '1.2');
define('TINYTIPSLIBRARY_VERSION', '1.2');

if (!defined('JQUERYTINYTIPS_PLUGIN_BASENAME')) {
  //jquery-tinytips/jquery-tinytips.php
  define('JQUERYTINYTIPS_PLUGIN_BASENAME', plugin_basename(__FILE__));
}
if (!defined('JQUERYTINYTIPS_PLUGIN_NAME')) {
  //jquery-tinytips
  define('JQUERYTINYTIPS_PLUGIN_NAME', trim(dirname(JQUERYTINYTIPS_PLUGIN_BASENAME), '/'));
}
if (!defined('JQUERYTINYTIPS_NAME')) {
  define('JQUERYTINYTIPS_NAME', 'jQuery TinyTips');
}
if (!defined('JQUERYTINYTIPS_TEXTDOMAIN')) {
  define('JQUERYTINYTIPS_TEXTDOMAIN', 'jquery-tinytips');
}
if (!defined('JQUERYTINYTIPS_PLUGIN_DIR')) {
  // /path/to/wordpress/wp-content/plugins/jquery-tinytips
  define('JQUERYTINYTIPS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . JQUERYTINYTIPS_PLUGIN_NAME);
}
if (!defined('JQUERYTINYTIPS_PLUGIN_URL')) {
  // http://www.domain.com/wordpress/wp-content/plugins/jquery-tinytips
  define('JQUERYTINYTIPS_PLUGIN_URL', WP_PLUGIN_URL . '/' . JQUERYTINYTIPS_PLUGIN_NAME);
}
if (!defined('JQUERYTINYTIPS_SETTINGSNAME')) {
  define('JQUERYTINYTIPS_SETTINGSNAME', 'jquery-tinytips_settings');
}
if (!defined('JQUERYTINYTIPS_USERAGENT')) {
  define('JQUERYTINYTIPS_USERAGENT', 'jQuery Tinytips V' . JQUERYTINYTIPS_VERSION . '; (' . get_bloginfo('url') . ')');
}


/**
 * Main plugin class
 *
 * @since 1.0
 * @author Arne Franken
 */
class JQueryTinytips {

  /**
   * Constructor
   * Plugin initialization
   *
   * @since 1.0
   * @access public
   * @access static
   * @author Arne Franken
   */
  //public static function jQueryTinytips() {
  function JQueryTinytips() {
    if (!function_exists('plugins_url')) {
      return;
    }

    load_plugin_textdomain(JQUERYTINYTIPS_TEXTDOMAIN, false, '/jquery-tinytips/localization/');

    //register method for uninstall
    if (function_exists('register_uninstall_hook')) {
      register_uninstall_hook(__FILE__, array('jQueryTinytips', 'uninstallJqueryTinytips'));
    }

    // Create the settings array by merging the user's settings and the defaults
    $usersettings = (array)get_option(JQUERYTINYTIPS_SETTINGSNAME);
    $defaultArray = $this->jQueryTinytipsDefaultSettings();
    $this->tinytipsSettings = wp_parse_args($usersettings, $defaultArray);

    // Create list of themes and their human readable names
    $this->tinytipsThemes = array(
      'light' => __('Light Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'yellow' => __('Yellow Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'orange' => __('Orange Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'red' => __('Red Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'green' => __('Green Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'blue' => __('Blue Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'purple' => __('Purple Theme', JQUERYTINYTIPS_TEXTDOMAIN),
      'dark' => __('Dark Theme', JQUERYTINYTIPS_TEXTDOMAIN)
    );

    if (is_admin()) {
      require_once 'includes/jquery-tinytips-backend.php';
      new JQueryTinytipsBackend($this->tinytipsSettings, $this->tinytipsThemes, $this->jQueryTinytipsDefaultSettings());
    } else if (!is_admin()) {
      require_once 'includes/jquery-tinytips-frontend.php';
      new JQueryTinytipsFrontend($this->tinytipsSettings);
    }
  }

  // jQueryTinytips()

  /**
   * Default array of jQuery Tinytips settings
   *
   * @since 1.0
   * @access private
   * @static
   * @author Arne Franken
   *
   * @return array of default settings
   */
  //private static function jQueryTinytipsDefaultSettings() {
  function jQueryTinytipsDefaultSettings() {

    // Create and return array of default settings
    return array(
      'jQueryTinytipsVersion' => JQUERYTINYTIPS_VERSION,
      'autoTinytips' => false,
      'tinytipsTheme' => 'light',
      'tinytipsWarningOff' => false,
      'tinytipsMetaLinkOff' => false,
      'javascriptInFooter' => false,
      'debugMode' => false,
      'removeLinkFromMetaBox' => false
    );
  }

  // jQueryTinytipsDefaultSettings()

  /**
   * Delete jQuery Tinytips settings
   *
   * handles deletion from WordPress database
   *
   * @since 1.3
   * @access private
   * @author Arne Franken
   */
  //private function uninstallJqueryTinytips() {
  function uninstallJqueryTinytips() {
    delete_option(JQUERYTINYTIPS_SETTINGSNAME);
  }

  // uninstallJqueryTinytips()

  /**
   * executed during activation.
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function activateJqueryTinytips() {
  function activateJqueryTinytips() {
    //do nothing at the moment
  }

  // activateJqueryTinytips()

}

// class JQueryTinytips()
?><?php
/**
 * Workaround for PHP4
 * initialize plugin, call constructor
 *
 * @since 1.0
 * @access public
 * @author Arne Franken
 */
function initJQueryTinytips() {
  new JQueryTinytips();
}

// initJQueryTinytips()

// add JQueryTinytips() to WordPress initialization
add_action('init', 'initJQueryTinytips', 7);

//static call to constructor is only possible if constructor is 'public static', therefore not PHP4 compatible:
//add_action('init', array('JQueryTinytips','JQueryTinytips'), 7);

// register method for activation
register_activation_hook(__FILE__, array('JQueryTinytips', 'activateJqueryTinytips'));
?>
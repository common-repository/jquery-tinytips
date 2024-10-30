<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Object that handles all actions in the WordPress backend
 */
class JQueryTinytipsBackend {

  /**
   * Constructor
   *
   * @since 1.3
   * @access public
   * @access static
   * @author Arne Franken
   *
   * @param array $tinytipsSettings user settings
   * @param array $tinytipsThemes plugin themes
   * @param array $tinytipsDefaultSettings default settings
   */
  //public static function JQueryTinytipsBackend($tinytipsSettings) {
  function JQueryTinytipsBackend($tinytipsSettings, $tinytipsThemes, $tinytipsDefaultSettings) {

    $this->tinytipsSettings = $tinytipsSettings;
    $this->tinytipsThemes = $tinytipsThemes;
    $this->tinytipsDefaultSettings = $tinytipsDefaultSettings;


    add_action('admin_post_jQueryTinytipsDeleteSettings', array(& $this, 'jQueryTinytipsDeleteSettings'));
    add_action('admin_post_jQueryTinytipsUpdateSettings', array(& $this, 'jQueryTinytipsUpdateSettings'));
    // add options page
    add_action('admin_menu', array(& $this, 'registerAdminMenu'));
    add_action('admin_notices', array(& $this, 'registerAdminWarning'));

    //add style selector dropdown to TinyMCE
    add_filter('mce_buttons_2', array(& $this, 'addStyleSelectorBox'), 100);
    //add Tinytips CSS class to TinyMCE dropdown box
    add_filter('tiny_mce_before_init', array(& $this, 'addTinytipsLinkClass'), 100);

    require_once 'donationloader.php';
    $donationLoader = new JQueryTinytipsDonationLoader();

    //only load JavaScript if we are on this plugin's settingspage
    if (isset($_GET['page']) && $_GET['page'] == JQUERYTINYTIPS_PLUGIN_BASENAME) {
      add_action('admin_print_scripts', array(& $donationLoader, 'registerDonationJavaScript'));
    }
  }

  // JQueryTinytipsBackend()

  /**
   * Render Settings page
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function renderSettingsPage() {
  function renderSettingsPage() {
    require_once 'settings-page.php';
  }

  //renderSettingsPage()

  /**
   * Registers the Settings Page in the Admin Menu
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function registerAdminMenu() {
  function registerAdminMenu() {
    $return_message = '';

    if (function_exists('add_management_page') && current_user_can('manage_options')) {
      // update, uninstall message
      if (strpos($_SERVER['REQUEST_URI'], 'jquery-tinytips.php') && isset($_GET['jQueryTinytipsUpdateSettings'])) {
        $return_message = sprintf(__('Successfully updated %1$s settings.', JQUERYTINYTIPS_TEXTDOMAIN), JQUERYTINYTIPS_NAME);
      } elseif (strpos($_SERVER['REQUEST_URI'], 'jquery-tinytips.php') && isset($_GET['jQueryTinytipsDeleteSettings'])) {
        $return_message = sprintf(__('%1$s settings were successfully deleted.', JQUERYTINYTIPS_TEXTDOMAIN), JQUERYTINYTIPS_NAME);
      }
    }
    $this->registerAdminNotice($return_message);

    $this->registerSettingsPage();
  }

  // registerAdminMenu()

  /**
   * Registers Admin Notices
   *
   * @since 1.0
   * @access private
   * @author Arne Franken
   *
   * @param string $notice to register notice with.
   */
  //private function registerAdminNotice($notice) {
  function registerAdminNotice($notice) {
    if ($notice != '') {
      $message = '<div class="updated fade"><p>' . $notice . '</p></div>';
      add_action('admin_notices', create_function('', "echo '$message';"));
    }
  }

  // registerAdminNotice()

  /**
   * Registers the warning for admins
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function registerAdminWarning() {
  function registerAdminWarning() {
    if ($this->tinytipsSettings['tinytipsWarningOff'] || $this->tinytipsSettings['autoTinytips']) {
      return;
    }
    ?>

  <div class="updated" style="background-color:#f66;">
    <p>
      <a href="options-general.php?page=<?php echo JQUERYTINYTIPS_PLUGIN_BASENAME ?>"><?php echo JQUERYTINYTIPS_NAME ?></a> <?php _e('needs attention: the plugin is not activated to work automatically for all links.', JQUERYTINYTIPS_TEXTDOMAIN)?>
    </p>
  </div>
  <?php

  }

  // registerAdminWarning()

  /**
   * Register the settings page in wordpress
   *
   * @since 1.0
   * @access private
   * @author Arne Franken
   */
  //private function registerSettingsPage() {
  function registerSettingsPage() {
    if (current_user_can('manage_options')) {
      add_filter('plugin_action_links_' . JQUERYTINYTIPS_PLUGIN_BASENAME, array(& $this, 'addPluginActionLinks'));
      add_options_page(JQUERYTINYTIPS_NAME, JQUERYTINYTIPS_NAME, 'manage_options', JQUERYTINYTIPS_PLUGIN_BASENAME, array(& $this, 'renderSettingsPage'));
    }
  }

  //registerSettingsPage()

  /**
   * Add settings link to plugin management page
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   *
   * @param  array $action_links original links
   * @return array $action_links with link to settings page
   */
  //public function addPluginActionLinks($action_links) {
  function addPluginActionLinks($action_links) {
    $settings_link = '<a href="options-general.php?page=' . JQUERYTINYTIPS_PLUGIN_BASENAME . '">' . __('Settings', JQUERYTINYTIPS_TEXTDOMAIN) . '</a>';
    array_unshift($action_links, $settings_link);

    return $action_links;
  }

  //addPluginActionLinks()

  /**
   * Adds style selector option to TinyMCE
   *
   * @since 1.2
   * @access public
   * @author Arne Franken
   *
   * @param array $array
   * @return array modified array
   */
  //public function addStyleSelectorBox($array) {
  function addStyleSelectorBox($array) {
    if (!in_array('styleselect', $array)) {
      array_push($array, 'styleselect');
    }
    return $array;
  }

  // addStyleSelectorBox()

  /**
   * Update plugin settings wrapper
   *
   * handles checks and redirect
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function jQueryTinytipsUpdateSettings() {
  function jQueryTinytipsUpdateSettings() {

    if (!current_user_can('manage_options'))
      wp_die(__('Did not update settings, you do not have the necessary rights.', JQUERYTINYTIPS_TEXTDOMAIN));

    //cross check the given referer for nonce set in settings form
    check_admin_referer('jquery-tinytips-settings-form');
    //get settings from plugins admin page
    $this->tinytipsSettings = $_POST[JQUERYTINYTIPS_SETTINGSNAME];
    //have to add jQueryColorboxVersion here because it is not included in the HTML form
    $this->tinytipsSettings['jQueryTinytipsVersion'] = JQUERYTINYTIPS_VERSION;
    $this->updateSettingsInDatabase();
    $referrer = str_replace(array('&jQueryTinytipsUpdateSettings', '&jQueryTinytipsDeleteSettings'), '', $_POST['_wp_http_referer']);
    wp_redirect($referrer . '&jQueryTinytipsUpdateSettings');
  }

  // jQueryTinytipsUpdateSettings()

  /**
   * Update plugin settings
   *
   * handles updating settings in the WordPress database
   *
   * @since 1.0
   * @access private
   * @author Arne Franken
   */
  //private function updateSettingsInDatabase() {
  function updateSettingsInDatabase() {
    update_option(JQUERYTINYTIPS_SETTINGSNAME, $this->tinytipsSettings);
  }

  //updateSettings()

  /**
   * Delete plugin settings wrapper
   *
   * handles checks and redirect
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function jQueryTinytipsDeleteSettings() {
  function jQueryTinytipsDeleteSettings() {

    if (current_user_can('manage_options') && isset($_POST['delete_settings-true'])) {
      //cross check the given referer for nonce set in delete settings form
      check_admin_referer('jquery-delete_settings-form');
      $this->deleteSettingsFromDatabase();
    } else {
      wp_die(sprintf(__('Did not delete %1$s settings. Either you dont have the nececssary rights or you didnt check the checkbox.', JQUERYTINYTIPS_TEXTDOMAIN), JQUERYTINYTIPS_NAME));
    }
    //clean up referrer
    $referrer = str_replace(array('&jQueryTinytipsUpdateSettings', '&jQueryTinytipsDeleteSettings'), '', $_POST['_wp_http_referer']);
    wp_redirect($referrer . '&jQueryTinytipsDeleteSettings');
  }

  // jQueryTinytipsDeleteSettings()

  /**
   * Delete plugin settings
   *
   * handles deletion from WordPress database
   *
   * @since 1.0
   * @access private
   * @author Arne Franken
   */
  //private function deleteSettingsFromDatabase() {
  function deleteSettingsFromDatabase() {
    delete_option(JQUERYTINYTIPS_SETTINGSNAME);
  }

  // deleteSettings()

  /**
   * Read HTML from a remote url
   *
   * @since 1.0
   * @access private
   * @author Arne Franken
   *
   * @param string $url
   * @return the response
   */
  //private function getRemoteContent($url) {
  function getRemoteContent($url) {
    if (function_exists('wp_remote_request')) {

      $options = array();
      $options['headers'] = array(
        'User-Agent' => JQUERYTINYTIPS_USERAGENT
      );

      $response = wp_remote_request($url, $options);

      if (is_wp_error($response))
        return false;

      if (200 != wp_remote_retrieve_response_code($response))
        return false;

      return wp_remote_retrieve_body($response);
    }

    return false;
  }

  // getRemoteContent()

  /**
   * gets current URL to return to after donating
   *
   * @since 1.0
   * @access private
   * @author Arne Franken
   */
  //private function getReturnLocation(){
  function getReturnLocation() {
    $currentLocation = "http";
    $currentLocation .= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "s" : "") . "://";
    $currentLocation .= $_SERVER['SERVER_NAME'];
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
      if ($_SERVER['SERVER_PORT'] != '443') {
        $currentLocation .= ":" . $_SERVER['SERVER_PORT'];
      }
    }
    else {
      if ($_SERVER['SERVER_PORT'] != '80') {
        $currentLocation .= ":" . $_SERVER['SERVER_PORT'];
      }
    }
    $currentLocation .= $_SERVER['REQUEST_URI'];
    echo $currentLocation;
  }

  // getReturnLocation()

  /**
   * adds Tinytips CSS class to TinyMCE style selector dropdown box
   *
   * @since 1.2
   * @access public
   * @author Arne Franken
   *
   * @param  $init_array
   * @return modified array
   */
  //public function addColorboxLinkClass($defaultCss) {
  function addTinytipsLinkClass($init_array) {

    $init_array['theme_advanced_styles'] .= ';tinytips=tinytips;';
    //strip first and last character if it matches ";"
    $init_array['theme_advanced_styles'] = trim($init_array['theme_advanced_styles'], ';');
    return $init_array;
  }

  // addTinytipsLinkClass()

}

// JQueryTinytipsBackend()
?>

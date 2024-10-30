<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Object that handles all actions in the WordPress frontend
 */
class JQueryTinytipsFrontend {

  /**
   * Constructor
   *
   * @since 1.3
   * @access public
   * @access static
   * @author Arne Franken
   *
   * @param array $tinytipsSettings user settings
   */
  //public static function JQueryTinytipsFrontend($tinytipsSettings) {
  function JQueryTinytipsFrontend($tinytipsSettings) {

    $this->tinytipsSettings = $tinytipsSettings;

    // Add meta tag with version number to the header
    add_action('wp_head', array(& $this, 'renderMetaTag'));

    //only add link to meta box
    if (isset($this->tinytipsSettings['removeLinkFromMetaBox']) && !$this->tinytipsSettings['removeLinkFromMetaBox']) {
      add_action('wp_meta', array(& $this, 'renderMetaLink'));
    }

    if (isset($this->tinytipsSettings['autoTinytips']) && $this->tinytipsSettings['autoTinytips']) {
      //write "tinytips-CSS-class" to "a"-tags class attribute.
      //Priority = 100, hopefully the preg_replace is then executed after other plugins messed with the_content
      add_filter('the_content', array(& $this, 'addTinytipsCssClassToImages'), 100);
      add_filter('the_excerpt', array(& $this, 'addTinytipsCssClassToImages'), 100);
    }

    // enqueue JavaScript and CSS files in wordpress
    wp_enqueue_script('jquery');
    wp_register_style('tinytips-css', JQUERYTINYTIPS_PLUGIN_URL . '/css/tinyTips.css', array(), JQUERYTINYTIPS_VERSION, 'screen');
    wp_enqueue_style('tinytips-css');

    $this->addTinytipsJS();
    $this->addTinytipsWrapperJS();
    $this->addTinytipsProperties();
  }

  // JQueryTinytipsBackend()

  /**
   * Insert JavaScript into WP Header
   *
   * @since 1.3
   * @access public
   * @author Arne Franken
   */
  //public function addTinytipsJS() {
  function addTinytipsJS() {
    if ($this->tinytipsSettings['debugMode']) {
      $jqueryTinytipsJavaScriptPath = "js/jquery.tinyTips.js";
    }
    else {
      $jqueryTinytipsJavaScriptPath = "js/jquery.tinyTips-min.js";
    }
    wp_enqueue_script('tinyTips', JQUERYTINYTIPS_PLUGIN_URL . '/' . $jqueryTinytipsJavaScriptPath, array('jquery'), TINYTIPSLIBRARY_VERSION, $this->tinytipsSettings['javascriptInFooter']);
  }

  // addTinytipsJS()

  /**
   * Insert JavaScript with properties for Colorbox into WP Header
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function addTinytipsProperties() {
  function addTinytipsProperties() {
    /**
     * declare variables that are used in more than one function
     */
    $tinytipsPropertyArray = array(
      'tinytipsTheme' => $this->tinytipsSettings['tinytipsTheme']
    );
    wp_localize_script('tinyTips', 'Tinytips', $tinytipsPropertyArray);
  }

  // addTinytipsProperties()

  /**
   * Insert JavaScript into WP Header
   *
   * @since 4.1
   * @access public
   * @author Arne Franken
   */
  //public function addTinytipsWrapperJS() {
  function addTinytipsWrapperJS() {
    if ($this->tinytipsSettings['debugMode']) {
      $jqueryTinytipsWrapperJavaScriptPath = "js/jquery-tinytips-wrapper.js";
    }
    else {
      $jqueryTinytipsWrapperJavaScriptPath = "js/jquery-tinytips-wrapper-min.js";
    }
    wp_enqueue_script('tinyTips-wrapper', JQUERYTINYTIPS_PLUGIN_URL . '/' . $jqueryTinytipsWrapperJavaScriptPath, array('colorbox'), TINYTIPSLIBRARY_VERSION, $this->tinytipsSettings['javascriptInFooter']);
  }

  // addTinytipsWrapperJS()

  /**
   * Renders plugin Meta tag
   *
   * @since 1.3
   * @access public
   * @author Arne Franken
   */
  //public function renderMetaTag() {
  function renderMetaTag() {
    ?>

  <meta name="<?php echo JQUERYTINYTIPS_NAME ?>" content="<?php echo JQUERYTINYTIPS_VERSION ?>"/>
  <?php
  }

  // renderMetaTag()

  /**
   * Renders plugin link in Meta widget
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   */
  //public function renderMetaLink() {
  function renderMetaLink() {
    ?>
  <li id="tinytipsLink"><?php _e('Using', JQUERYTINYTIPS_TEXTDOMAIN);?>
    <a href="http://www.techotronic.de/plugins/jquery-tinytips/" target="_blank" title="<?php echo JQUERYTINYTIPS_NAME ?>"><?php echo JQUERYTINYTIPS_NAME ?></a>
  </li>
  <?php
  }

  // renderMetaLink()

  /**
   * Add Tinytips-CSS-Class to links.
   * function is called for every page or post rendering.
   *
   * ugly way to make the links Tinytips-ready by adding the necessary CSS class.
   * unfortunately, Wordpress does not offer a convenient way to get certain elements from the_content,
   * so I had to do this by regexp replacement...
   *
   * @since 1.0
   * @access public
   * @author Arne Franken
   *
   * @param  $content
   * @return replaced content or excerpt
   */
  //public function addTinytipsCssClassToImages($content) {
  function addTinytipsCssClassToImages($content) {
    // match all img tags with this pattern
    $linkPattern = "/<a([^\>]*?)>/i";
    if (preg_match_all($linkPattern, $content, $linkTags)) {
      foreach ($linkTags[0] as $linkTag) {
        // only work on imgTags that do not already contain the String "colorbox-"
        if (!preg_match('/tinytips/i', $linkTag)) {
          if (!preg_match('/class/i', $linkTag)) {
            // imgTag does not contain class-attribute
            $pattern = $linkPattern;
            $replacement = '<a class="tinytips" $1>';
          }
          else {
            // imgTag already contains class-attribute
            $pattern = "/<a(.*?)class=('|\")([A-Za-z0-9 \/_\.\~\:-]*?)('|\")([^\>]*?)>/i";
            $replacement = '<a$1class=$2$3 tinytips$4$5>';
          }
          $replacedLinkTag = preg_replace($pattern, $replacement, $linkTag);
          $content = str_replace($linkTag, $replacedLinkTag, $content);
        }
      }
    }
    return $content;
  }

  // addTinytipsGroupIdToImages()

}

// JQueryTinytipsFrontend()
?>
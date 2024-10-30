<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Plugin Settings for settings page
 */
?>
<div id="jquery-tinytips-settings" class="postbox">
  <!--h3 id="tinytips-settings"><?php __('Settings', JQUERYTINYTIPS_TEXTDOMAIN); ?></h3-->
  <h3 id="plugin-settings"><?php _e('Plugin settings', JQUERYTINYTIPS_TEXTDOMAIN); ?></h3>

  <div class="inside">

    <table class="form-table">
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-autoTinytips"><?php printf(__('Automate %1$s for all links in pages, posts and galleries', JQUERYTINYTIPS_TEXTDOMAIN), JQUERYTINYTIPS_NAME); ?>:</label>
        </th>
        <td>
          <input type="checkbox" name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]" id="jquery-tinytips-autoTinytips" value="true" <?php echo ($this->tinytipsSettings['autoTinytips'])
                  ? 'checked="checked"' : '';?>/>
          <br/><?php _e('Automatically add tinytips-class to links in posts and pages. Also adds tinytips-class to links to images in galleries.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-autoTinytipsGalleries"><?php printf(__('Automate %1$s for links to images in WordPress galleries', JQUERYTINYTIPS_TEXTDOMAIN), JQUERYTINYTIPS_NAME); __('Automate %1$s for images in WordPress galleries only', JQUERYTINYTIPS_TEXTDOMAIN) ?>:</label>
        </th>
        <td>
          <input type="checkbox" name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytipsGalleries]" id="jquery-tinytips-autoTinytipsGalleries" value="true" <?php echo ($this->tinytipsSettings['autoTinytipsGalleries'])
                  ? 'checked="checked"' : '';?>/>
          <br/><?php _e('Automatically add tinytips-class to links to images in WordPress galleries, but nowhere else.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-javascriptInFooter"><?php _e('Add JavaScript to footer', JQUERYTINYTIPS_TEXTDOMAIN); ?>:</label>
        </th>
        <td>
          <input type="checkbox" name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[javascriptInFooter]" id="jquery-tinytips-javascriptInFooter" value="true" <?php echo ($this->tinytipsSettings['javascriptInFooter'])
                  ? 'checked="checked"' : '';?>/>
          <br/><?php _e('Add JavaScript to footer instead of the header.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-removeLinkFromMetaBox"><?php _e('Remove link from Meta-box', JQUERYTINYTIPS_TEXTDOMAIN); ?>:</label>
        </th>
        <td>
          <input type="checkbox" name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[removeLinkFromMetaBox]" id="jquery-tinytips-removeLinkFromMetaBox" value="true" <?php echo ($this->tinytipsSettings['removeLinkFromMetaBox'])
                  ? 'checked="checked"' : '';?>/>
          <br/><?php _e('Remove the link to the developers site from the WordPress meta-box.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-debugMode"><?php _e('Activate debug mode', JQUERYTINYTIPS_TEXTDOMAIN); ?>:</label>
        </th>
        <td>
          <input type="checkbox" name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[debugMode]" id="jquery-tinytips-debugMode" value="true" <?php echo ($this->tinytipsSettings['debugMode'])
                  ? 'checked="checked"' : '';?>/>
          <br/><?php _e('Adds debug information and non-minified JavaScript to the page. Useful for troubleshooting.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-tinytipsWarningOff"><?php printf(__('Disable warning', JQUERYTINYTIPS_TEXTDOMAIN), JQUERYTINYTIPS_NAME); ?>:</label>
        </th>
        <td>
          <input type="checkbox" name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[tinytipsWarningOff]" id="jquery-tinytips-tinytipsWarningOff" value="true" <?php echo ($this->tinytipsSettings['tinytipsWarningOff'])
                  ? 'checked="checked"' : '';?>/>
          <br/><?php _e('Disables the warning that is displayed if the plugin is activated but the auto-tinytips feature for all links is turned off.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
    </table>
    <p class="submit">
      <input type="hidden" name="action" value="jQueryTinytipsUpdateSettings"/>
      <input type="submit" name="jQueryTinytipsUpdateSettings" class="button-primary" value="<?php _e('Save Changes') ?>"/>
    </p>
  </div>
</div>
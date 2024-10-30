<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Tinytips Settings for settings page
 */
?>
<div id="jquery-tinytips-plugin-settings" class="postbox">
  <h3 id="tinytips-settings"><?php _e('Tinytips settings', JQUERYTINYTIPS_TEXTDOMAIN); ?></h3>

  <div class="inside">

    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="jquery-tinytips-theme"><?php _e('Theme', JQUERYTINYTIPS_TEXTDOMAIN); ?></label>
        </th>
        <td>
          <select name="<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[tinytipsTheme]" id="jquery-tinytips-theme" class="postform" style="margin:0">
<?php
          foreach ($this->tinytipsThemes as $theme => $name) {
            echo '<option value="' . esc_attr($theme) . '"';
            selected($this->tinytipsSettings['tinytipsTheme'], $theme);
            echo '>' . htmlspecialchars($name) . "</option>\n";
          }
  ?>
          </select>
          <br/><?php _e('Select the theme you want to use on your blog.', JQUERYTINYTIPS_TEXTDOMAIN); ?>
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="jquery-tinytips-theme_screenshot_image"><?php _e('Theme screenshot', JQUERYTINYTIPS_TEXTDOMAIN); ?>:</label>
        </th>
        <td height="185px">
          <div id="jquery-tinytips-theme_screenshot_image">
            <img src="<?php echo JQUERYTINYTIPS_PLUGIN_URL; echo '/screenshot-' . $this->tinytipsSettings['tinytipsTheme']; ?>.jpg"/>
          </div>
        </td>
      </tr>
    </table>
    <p class="submit">
      <input type="hidden" name="action" value="jQueryTinytipsUpdateSettings"/>
      <input type="submit" name="jQueryTinytipsUpdateSettings" class="button-primary" value="<?php _e('Save Changes') ?>"/>
    </p>

  </div>
</div>
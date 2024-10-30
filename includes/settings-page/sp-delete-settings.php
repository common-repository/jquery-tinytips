<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Delete Settings for settings page
 */
?>
<div id="poststuff">
  <div id="jquery-tinytips-delete_settings" class="postbox">
    <h3 id="delete_options"><?php _e('Delete Settings', JQUERYTINYTIPS_TEXTDOMAIN) ?></h3>

    <div class="inside">
      <p><?php _e('Check the box and click this button to delete settings of this plugin.', JQUERYTINYTIPS_TEXTDOMAIN); ?></p>

      <form name="delete_settings" method="post" action="admin-post.php">
        <?php if (function_exists('wp_nonce_field') === true) wp_nonce_field('jquery-delete_settings-form'); ?>
        <p id="submitbutton">
          <input type="hidden" name="action" value="jQueryTinytipsDeleteSettings"/>
          <input type="submit" name="jQueryTinytipsDeleteSettings" value="<?php _e('Delete Settings', JQUERYTINYTIPS_TEXTDOMAIN); ?> &raquo;" class="button-secondary"/>
          <input type="checkbox" name="delete_settings-true"/>
        </p>
      </form>
    </div>
  </div>
</div>
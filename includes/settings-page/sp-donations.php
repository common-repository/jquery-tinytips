<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Donations for settings page
 */
?>
<div id="poststuff">
    <div id="jquery-tinytips-topdonations" class="postbox">
        <h3><?php _e('Top donations', JQUERYTINYTIPS_TEXTDOMAIN) ?></h3>

        <div class="inside">
      <div id="topdonations">
        <div id="toploader" align="center"><img src="<?php echo JQUERYTINYTIPS_PLUGIN_URL ?>/images/ajax-loader.gif" alt="loading"/></div>
        <div id="topdonationslist" style="display: none;"></div>
        <div id="toperror" style="display: none;"><p><?php _e('Thank you for your donation.', JQUERYTINYTIPS_TEXTDOMAIN) ?></p></div>
        </div>
    </div>
</div>
</div>
<div id="poststuff">
    <div id="jquery-tinytips-latestdonations" class="postbox">
        <h3><?php _e('Latest donations', JQUERYTINYTIPS_TEXTDOMAIN) ?></h3>

        <div class="inside">
      <div id="latestdonations">
        <div id="latestloader" align="center"><img src="<?php echo JQUERYTINYTIPS_PLUGIN_URL ?>/images/ajax-loader.gif" alt="loading"/></div>
        <div id="latestdonationslist" style="display: none;"></div>
        <div id="latesterror" style="display: none;"><p><?php _e('Thank you for your donation.', JQUERYTINYTIPS_TEXTDOMAIN) ?></p></div>
        </div>
    </div>
</div></div>
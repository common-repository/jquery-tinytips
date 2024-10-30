<?php
/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * JavaScript for settings page
 */
?>
<script type="text/javascript">
  //<![CDATA[
  jQuery(document).ready(function($) {
    //only one of the checkboxes is allowed to be selected.
    $("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]']").click(function() {
      if ($("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]']").is(':checked')) {
        $("#jquery-tinytips-autoTinytipsGalleries").attr("checked", false);
      }
    });
    $("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytipsGalleries]']").click(function() {
      if ($("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytipsGalleries]']").is(':checked')) {
        $("#jquery-tinytips-autoTinytips").attr("checked", false);
      }
    });

    //deactivate warning if auto Colorbox is activated
    $("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]']").click(function() {
      if ($("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]']").is(':checked')) {
        $("#jquery-tinytips-tinytipsWarningOff").attr("checked", true);
      }
    });

    //activate warning if auto Colorbox is deactivated
    $("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]']").click(function() {
      if (!$("input[name='<?php echo JQUERYTINYTIPS_SETTINGSNAME ?>[autoTinytips]']").is(':checked')) {
        $("#jquery-tinytips-tinytipsWarningOff").attr("checked", false);
      }
    });

    //change screenshot if new theme is selected
    $("#jquery-tinytips-theme").change(function() {
      var src = $("option:selected", this).val();
      if (src != "") {
        var $imgTag = "<img src=\"" + "<?php echo JQUERYTINYTIPS_PLUGIN_URL; echo '/screenshot-'; ?>" + src + ".jpg\" />";
        $("#jquery-tinytips-theme_screenshot_image").empty().html($imgTag).fadeIn();
      }
    });
  });
  //]]>
</script>
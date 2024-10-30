/**
 * @package Techotronic
 * @subpackage jQuery Tinytips
 *
 * @since 1.3
 * @author Arne Franken
 *
 * Tinytips Javascript
 */

/**
 * call Tinytips selector function.
 */
jQuery(document).ready(function(jQuery) {
  jQuery("a.tinytips").each(function(index, obj) {
    if (jQuery(obj).attr('title')) {
      jQuery(obj).tinyTips(Tinytips.tinytipsTheme, 'title');
    }
  });
});

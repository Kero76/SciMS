/**
 * This script initialize TinyMCE from the article
 * about the biography textarea.
 *
 * @author Kero76
 * @since SciMS 0.2.1
 * @version 1.0
 */
$(document).ready(function(){
    init_tinyMCE('#content', 350);
    init_tinyMCE('#authors', 150);
});
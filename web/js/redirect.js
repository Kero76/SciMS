/**
 * Script use to redirect user on other page.
 *
 * @author Kero76
 * @since SciMS 0.2
 * @version 1.0
 */

/**
 * Redirect user after the DOM element were correctly loaded.
 *
 * -> V1.1
 *  - Change time before redirection.
 *
 * @since SciMS 0.2
 * @version 1.1
 */
$(document).ready(function () {
    setTimeout(function () {
        window.location.href = window.location.origin + '/' + window.location.pathname;
    }, 10000);
});
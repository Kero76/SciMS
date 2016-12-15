/**
 * Add anchor on all main and subtitle available on article content.
 *
 * @param main_title_lvl
 *  Main level of title at display on summary
 * @param subtitle_lvl
 *  Sub level of title at display on summary
 * @since SciMS 0.4
 * @version 1.0
 */
function addAnchor(main_title_lvl, subtitle_lvl) {
    // Add anchor on main_title of the article.
    var anchor_main_title = 0;
    $('#scims-body-page ' + main_title_lvl).each(function() {
        $(this).prop('id', 'anchor-' + anchor_main_title);
        ++anchor_main_title;
    }); // h1 each
    
    // Add anchor on subtitle present on each main title sections.
    var j =0;
    for (var i = 0; i < anchor_main_title; ++i) {
        j = 0;
        var children = $('#anchor-' + i).nextUntil(main_title_lvl);
        children.each(function() {
            if ($(this).is(subtitle_lvl)) {
                $(this).prop('id', 'anchor-' + i + '-' + j);
                ++j;
            }
        });
    }
}

/**
 * Generate main title available on summary.
 *
 * @param main_title_lvl
 *  Main level of title at display on summary
 * @param subtitle_lvl
 *  Sub level of title at display on summary
 * @since SciMS 0.4
 * @version 1.0
 */
function generateMainTitle(main_title_lvl, subtitle_lvl) {
    var ul      = document.getElementById('list-summary');
    var li      = null;
    var a       = null;
    var text    = '';
    var title   = '';
    var anchor_index = 0;
    
    $('#scims-body-page ' + main_title_lvl).each(function() {
        title = $(this).text();
        li = document.createElement('li');
        li.setAttribute('id', 'anchor-link-' + anchor_index);
        a  = document.createElement('a');
        a.href += '#anchor-' + anchor_index;
        text = document.createTextNode(title);
        a.appendChild(text);
        li.appendChild(a);
        ul.appendChild(li);
        ++anchor_index;
    }); // #article h1 each.
    
    _generateSubtitle(anchor_index, main_title_lvl, subtitle_lvl);
}

/**
 * Generate subtitle available on summary.
 *
 * @access private
 * @param max_main_anchor
 *  The number of max hX main title.
 * @param main_title_lvl
 *  Main level of title at display on summary
 * @param subtitle_lvl
 *  The level of the subtitle.
 * @since SciMS 0.4
 * @version 1.0
 */
function _generateSubtitle(max_main_anchor, main_title_lvl, subtitle_lvl) {
    var ul = li = a = null;
    var text = title = '';
    
    var j = 0;
    for (var i = 0; i < max_main_anchor; ++i) {
        j  = 0;
        ul = document.createElement('ul');
        var brother  = $('#anchor-' + i).nextUntil(main_title_lvl);
        
        brother.each(function() {
            if ($(this).is(subtitle_lvl)) {
                title   = $(this).text();
                li      = document.createElement('li');
                a       = document.createElement('a');
                a.href += '#anchor-' + i + '-' + j;
                text    = document.createTextNode(title);
                a.append(text);
                li.append(a);
                ul.append(li);
                ++j;
            }
        }); // children.each
        
        $('#anchor-link-' + i).append(ul);
    }
}

/**
 * This function is fired when the page is totally loaded.
 * It display potentially the summary on the webpage.
 *
 * @since SciMS 0.4
 * @version 1.0
 */
$(document).ready(function() {
    addAnchor('h2', 'h3');
    generateMainTitle('h2', 'h3');
});

/**
 * This script initialize TinyMCE when the page is completely upload
 * by the browser to avoid a possible blank page during some seconds
 * use to call TinyMCE code.
 *
 * @author Kero76
 * @since SciMS 0.2
 * @version 1.0
 */
function init_tinyMCE(selector, height) {
    tinymce.init({
        selector: selector,
        height: height,
        plugins: 'visualblocks',
        style_formats: [
            { title: 'Headers', items: [
                { title: 'h1', block: 'h1' },
                { title: 'h2', block: 'h2' },
                { title: 'h3', block: 'h3' },
                { title: 'h4', block: 'h4' },
                { title: 'h5', block: 'h5' },
                { title: 'h6', block: 'h6' }
            ]},
            { title: 'Blocks', items: [
                { title: 'p',   block: 'p' },
                { title: 'div', block: 'div' },
                { title: 'pre', block: 'pre' }
            ]},
            { title: 'Containers', items: [
                { title: 'section',     block: 'section',    wrapper: true, merge_siblings: false },
                { title: 'article',     block: 'article',    wrapper: true, merge_siblings: false },
                { title: 'blockquote',  block: 'blockquote', wrapper: true },
                { title: 'hgroup',      block: 'hgroup',     wrapper: true },
                { title: 'aside',       block: 'aside',      wrapper: true },
                { title: 'figure',      block: 'figure',     wrapper: true }
            ]}
        ],
        visualblocks_default_state: true,
        end_container_on_empty_block: true,
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],
    });
}
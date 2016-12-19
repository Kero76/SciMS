<?php
    namespace SciMS\Controller\Handler;

    /**
     * Class RedirectHandler.
     *
     * This class redirect the user on the right page after on interaction with the website.
     *
     * @author Kero76
     * @package SciMS\Controller\Handler
     * @since SciMS 0.5
     * @version 1.0
     */
    class RedirectHandler {
    
        /**
         * @var array
         *  An array with all possible redirect choice.
         * @since SciMS 0.5
         */
        private $_redirection_url;
    
        /**
         * RedirectHandler constructor.
         *
         * @construct
         * @since SciMS 0.5
         * @version 1.0
         */
        public function __construct() {
            $this->_redirection_url = array(
                'home'           => '#\/web\/index\.php(\?user=[0-9]+)?$#',
                'article'        => '#\/web\/index\.php\?action=consult_article&id=[0-9]+(&user=[0-9]+)?$#',
                'administration' => '#\/web\/index\.php\?action=administration&user=[0-9]+$#',
            );
        }
    
        /**
         * Redirect the user on the right page after on interaction with the website.
         *
         * @param $url
         *  The url of the page to redirect user after on interaction with the website.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function redirect($url) {
            if ($this->match($url) === true) {
                header('Location: ' . $url);
            }
        }
        
        /**
         * Match if the URL passed on parameter is present on routes.
         *
         * @access private
         * @param $url
         *  Url who match the route pattern present on routes.
         * @return bool
         *  True if the url was match, otherwise return false.
         * @since SciMS 0.1
         * @version 1.0
         */
        private function match($url) {
            $view = null;
            foreach ($this->_redirection_url as $key => $value) {
                // Generate REGEX to recognize right url form.
                if (preg_match($value, $url) != 0) {
                    return true;
                }
            }
            return false;
        }
    }

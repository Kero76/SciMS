<?php
    namespace SciMS\Controller;
    
    /**
     * Class Router.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.1
     * @version 1.0
     */
    class Router {
        
        /**
         * An instance of the Renderer object use for render the view.
         *
         * @var \SciMS\Controller\Renderer
         * @since SciMS 0.1
         */
        private $_renderer;
        
        /**
         * An array with all routes present on website.
         *
         * @var array
         *  This array contains all routes present on website.
         */
        private $_routes;
    
        /**
         * An array with all templates present on Website.
         *
         * @var array
         *  This array contains all templates with the same key as $_routes.
         */
        private $_templates;
        
        /**
         * Router constructor.
         *
         * This constructor initialize the object render use for generate the view in function of the route
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct() {
            $this->_renderer = new Renderer();
            $this->_routes   = array(
                'index' => '/web/index.php',
            );
            
            $this->_templates = array(
                'index' => 'index.html.twig',
            );
        }
        
        public function parse($url) {
            foreach ($this->_routes AS $key => $value) {
                if (preg_match($value, $url)) {
                    return $this->_renderer->renderer($this->_templates[$key], array());
                }
            }
        }
    }
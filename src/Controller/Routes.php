<?php
    namespace SciMS\Controller;
    
    /**
     * Class Routes.
     *
     * This class routes
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.1
     * @version 1.0
     */
    class Routes {
    
        /**
         * An instance of the Renderer object use for render the view.
         *
         * @var \SciMS\Controller\Renderer
         * @since SciMS 0.1
         */
        private $_renderer;
    
        /**
         * Routes constructor.
         *
         * This constructor initialize the object render use for generate the view in function of the route
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct() {
            $this->_renderer = new Renderer();
        }
    }
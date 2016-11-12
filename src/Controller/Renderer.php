<?php
    namespace SciMS\Controller;

    /**
     * Class Renderer.
     *
     * This class renderer the view in function of the template and the object.
     * This is a part of the controller app because it can render the good view in function
     * of the routes define in other classes present on package SciMS\Controller.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.1
     * @version 1.0
     */
    class Renderer {
    
        /**
         * An instance of Twig use for generate template view in function of the route.
         *
         * @var \Twig_Environment
         * @since SciMS 0.1
         */
        private $_twig;
    
        /**
         * Contains the path of the templates directory.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_template_dir;
    
        /**
         * Renderer constructor.
         *
         * This constructor build the differents services present on website use for interact with Database.
         * All services are contains on an array and call *.dao with * equals the DAo corresponding at the Domain object.
         * This constructor create an instance of Twig and this instance use for render the good view
         * in function of the corresponding template.
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct() {
            $path = realpath('../');
            $path .= '/views';
            $this->_template_dir = $path;
            $loader      = new \Twig_Loader_Filesystem($this->_template_dir);
            $this->_twig = new \Twig_Environment($loader, array(
                'debug' => true,
                'cache' => false,
            ));
        }
    
        /**
         * This method render the template in function of the corresponding view.
         *
         * @param       $template
         *  Template used to render the view.
         * @param array $domains
         *  All domains objects use to render the view.
         * @return string
         */
        public function renderer($template, array $domains) {
            return $this->_twig->render($template, $domains);
        }
    }
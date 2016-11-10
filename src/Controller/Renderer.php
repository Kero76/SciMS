<?php
    namespace SciMS\Controller;
    
    use SciMS\DAO\ArticleDAO;
    use SciMS\DAO\CategoryDAO;
    use SciMS\DAO\UserDAO;

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
         * An array with all DAO Services present on Website.
         * It contains all DAO service use for generate Twig render in functon of
         * the Domain object present on Website.
         *
         * @var array
         * @since SciMS 0.1
         */
        private $_services;
    
        /**
         * An instance of Twig use for generate template view in function of the route.
         *
         * @var \Twig_Environment
         * @since SciMS 0.1
         */
        private $_twig;
    
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
            $path        = dirname(__DIR__) . '/views/';
            $loader      = new \Twig_Loader_Filesystem($path);
            $this->_twig = new \Twig_Environment($loader);
        
            $this->_services = array(
                'user.dao'      => new UserDAO(),
                'article.dao'   => new ArticleDAO(),
                'category.dao'  => new CategoryDAO(),
            );
        }
    
        /**
         * This method render the template in function of the corresponding view.
         *
         * @param       $template
         *  Template used to render the view.
         * @param array $domains
         *  All domains object used to render the view.
         * @return string
         */
        public function renderer($template, array $domains) {
            return $this->_twig->render($template, $domains);
        }
    }
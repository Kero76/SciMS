<?php
    namespace SciMS\Controller;
    
    use \SciMS\DAO\ArticleDAO;
    use \SciMS\DAO\CategoryDAO;
    use \SciMS\DAO\UserDAO;
    
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
         * These routes are describe by their regex pattern use for reconize them.
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
         * An array with all DAO Services present on Website.
         * It contains all DAO service use for generate Twig render in functon of
         * the Domain object present on Website.
         *
         * @var array
         * @since SciMS 0.1
         */
        private $_services;
    
        
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
            $this->_renderer    = new Renderer();
            
            $this->_routes = array(
                'home'          => '#\/web\/index\.php$#',
                'connection'    => '#\/web\/index\.php\?action=connection$#',
                'inscription'   => '#\/web\/index\.php\?action=inscription$#',
                'article'       => '#\/web\/index\.php\?action=article&id=[0-9]+(&user=[0-9]+)?$#',
                'user'          => '#\/web\/index\.php\?action=user&id=[0-9]+$#',
            );
            
            $this->_templates = array(
                'home'          => 'home.html.twig',
                'connection'    => 'connection.html.twig',
                'inscription'   => 'inscription.html.twig',
                'article'       => 'article.html.twig',
                'user'          => 'user.html.twig',
                '404'           => '404.html.twig',
            );
    
            $this->_services = array(
                'user.dao'      => new UserDAO(),
                'article.dao'   => new ArticleDAO(),
                'category.dao'  => new CategoryDAO(),
            );
        }
    
        /**
         * Render the corresponding view in function of the URL.
         *
         * @param $url
         *  URL requested by user.
         * @return null|string
         *  Return HTML content of the page.
         */
        public function render($url) {
            $view = null;
            $view = $this->_match($url);
            return $view;
        }
    
        /**
         * Match if the URL passed on parameter is present on routes.
         *
         * @access private
         * @param $url
         *  Url who match the route pattern present on routes.
         * @return string
         *  Return the HTML page content.
         * @since SciMS 0.1
         * @version 1.0
         */
        private function _match($url) {
            $view = null;
            foreach ($this->_routes AS $key => $value) {
                // Generate REGEX to recognize good url form.
                if (preg_match($value, $url) != 0) {
                    $view = $this->_parseUrl($key);
                }
            }
            if ($view === null) {
                $view = $this->_parseUrl('404');
            }
            return $view;
        }
    
        /**
         * Method use to parse URL and generate corresponding view in function of the user request.
         *
         * @access private
         * @param $key
         *  Use for retrieve good template from templates array.
         * @return string
         *  The HTML view corresponding to the good template.
         */
        private function _parseUrl($key) {
            $domains = null;
            
            // Switch on $key
            switch ($key) {
                // Home template generate with good domains object.
                case 'home' :
                    $domains = array(
                        'articles' => $this->_services['article.dao']->findLastArticle(10),
                    );
                    break;
                
                // Connection template generate with good domains object.
                case 'connection' :
                    $domains = array(
                        
                    );
                    break;
    
                // Inscription template generate with good domains object.
                case 'inscription' :
                    $domains = array(
                        
                    );
                    break;
    
                // Article template generate with good domains object.
                case 'article' :
                    $domains = array(
                        'article' => $this->_services['article.dao']->findById($_GET['id']),
                    );
                    break;
    
                // User template generate with good domains object.
                case 'user' :
                    $domains = array(
                        'user' => $this->_services['user.dao']->findById($_GET['id']),
                    );
                    break;
    
                // 404 template generate with nothing domains object.
                default :
                    $domains = array();
                    break;
            }
            
            return $this->_renderer->renderer($this->_templates[$key], $domains);
        }
    }
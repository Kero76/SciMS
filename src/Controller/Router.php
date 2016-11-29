<?php
    namespace SciMS\Controller;
    
    use \SciMS\Controller\BuildDomain\Build404;
    use \SciMS\Controller\BuildDomain\BuildAccount;
    use \SciMS\Controller\BuildDomain\BuildArticle;
    use \SciMS\Controller\BuildDomain\BuildCategory;
    use \SciMS\Controller\BuildDomain\BuildConnection;
    use \SciMS\Controller\BuildDomain\BuildDisconnection;
    use \SciMS\Controller\BuildDomain\BuildEdit;
    use \SciMS\Controller\BuildDomain\BuildHome;
    use \SciMS\Controller\BuildDomain\BuildInscription;
    use \SciMS\Controller\BuildDomain\BuildVerification;
    use \SciMS\Controller\BuildDomain\BuildWrite;
    use \SciMS\Controller\RequestHandler\GetHandler;
    use \SciMS\Controller\RequestHandler\PostHandler;
    use \SciMS\Controller\RequestHandler\SessionHandler;
    use \SciMS\DAO\ArticleDAO;
    use \SciMS\DAO\CategoryDAO;
    use \SciMS\DAO\UserDAO;
    use \SciMS\Error\MessageHandler;
    use \SciMS\Form\FormBuilder;

    /**
     * Class Router.
     *
     * This class is the main and the only Controller of the website.
     * In fact, this role consist in match in the url a precise pattern to
     * redirect the user on the right view.
     * After matching the url, it parse the URL to return the good Domain object
     * at display on the view.
     * This class is a composition of lots of private methods use to render the right view
     * in function of the URL match and parse.
     *
     * -> V1.1
     *  - Added new routes, templates and form.builder service.
     *  - Moved $_renderer attribute into $_services array.
     *
     * -> V1.2
     *  - Added url.checker into $_services array.
     *  - Change view 404 message.
     *  - Added RequestHandler classes on services.
     *  - Replaced template array by BuildDomain classes.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.1
     * @version 1.2
     */
    class Router {
        /**
         * An array with all routes present on website.
         * These routes are describe by their regex pattern use for reconize them.
         *
         * @var array
         *  This array contains all routes present on website.
         * @since SciMS 0.1
         */
        private $_routes;
    
        /**
         * An array with DomainBuilder services.
         * This array contains all DomainBuilder using to render the view with
         * all objects from the Domains.
         *
         * @var array
         *  This array contains all templates with the same key as $_routes.
         * @since SciMS 0.3
         */
        private $_domains;
    
        /**
         * An array with all DAO Services present on Website.
         * It contain all DAO service use for generate Twig render in function of
         * the Domain object present on Website.
         * It contain too FormBuilder object use to build form in view.
         * So it contain finally the Renderer object to render the view.
         *
         * @var array
         * @since SciMS 0.1
         */
        private $_services;
    
        
        /**
         * Router constructor.
         *
         * This constructor initialize the object render use for generate the view in function of the route.
         *
         * -> V1.1 :
         *  - Add new routes.
         *  - Add new templates.
         *  - Add form.builder service.
         *  - Add message.handler service.
         *
         * -> V1.2 :
         *  - Add url.checker service.
         *  - Add RequestHandler classes on services.
         *  - Replace $_template by BuildDomain classes.
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.2
         */
        public function __construct() {
            $this->_routes = array(
                'home'          => '#\/web\/index\.php(\?user=[0-9]+)?$#',
                'connection'    => '#\/web\/index\.php\?action=connection$#',
                'disconnection' => '#\/web\/index\.php\?action=disconnection&user=([0-9]+)+$#',
                'inscription'   => '#\/web\/index\.php\?action=inscription$#',
                'verification'  => '#\/web\/index\.php\?action=verification&form=(connection|inscription|disconnection|update|write|edit|category)+$#', // Change it when you add new Form.
                'article'       => '#\/web\/index\.php\?action=article&id=[0-9]+(&user=[0-9]+)?$#',
                'account'       => '#\/web\/index\.php\?action=account&user=[0-9]+$#',
                'write'         => '#\/web\/index\.php\?action=write&user=[0-9]+$#',
                'category'      => '#\/web\/index\.php\?action=category&user=[0-9]+$#',
                'edit'          => '#\/web\/index\.php\?action=edit&user=[0-9]+&article=[0-9]+$#',
            );
            
            $this->_domains = array(
                'home'          => new BuildHome('home.html.twig'),
                'connection'    => new BuildConnection('connection.html.twig'),
                'disconnection' => new BuildDisconnection('disconnection.html.twig'),
                'inscription'   => new BuildInscription('inscription.html.twig'),
                'verification'  => new BuildVerification('verification.html.twig'),
                'article'       => new BuildArticle('article.html.twig'),
                'account'       => new BuildAccount('admin/account.html.twig'),
                'write'         => new BuildWrite('admin/article.html.twig'),
                'edit'          => new BuildEdit('admin/article.html.twig'),
                'category'      => new BuildCategory('admin/category.html.twig'),
                '404'           => new Build404('404.html.twig'),
            );
    
            $this->_services = array(
                'dao.user'          => new UserDAO(),
                'dao.article'       => new ArticleDAO(),
                'dao.category'      => new CategoryDAO(),
                'form.builder'      => new FormBuilder(),
                'form.checker'      => new FormChecker(),
                'file.checker'      => new FileChecker(),
                'url.checker'       => new URLChecker(),
                'get.handler'       => new GetHandler(),
                'post.handler'      => new PostHandler(),
                'session.handler'   => new SessionHandler(),
                'message.handler'   => new MessageHandler(),
                'renderer'          => new Renderer(),
            );
        }
    
        /**
         * Render the corresponding view in function of the URL.
         *
         * @param $url
         *  URL requested by user.
         * @return null|string
         *  Return HTML content of the page.
         * @since SciMS 0.1
         * @version 1.0
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
         * -> V1.1 :
         *  - Add new routes.
         *
         * -> V1.2 :
         *  - Add private method to build domains on each switch case.
         *
         * -> V1.3 :
         *  - Add URL checker before generating domains.
         *  - Refactor method.
         *
         * @access private
         * @param $key
         *  Use for retrieve good template from templates array.
         * @return string
         *  The HTML view corresponding to the good template.
         * @since SciMS 0.1
         * @version 1.3
         */
        private function _parseUrl($key) {
            $domains = null;
            $this->_services['session.handler']->setRequest($_SESSION); // Retrieve $_SESSION
            
            // Article id.
            if ($this->_services['get.handler']->requestFieldExist('id')) {
                $max_id = $this->_services['dao.article']->findLastId();
                if (!$this->_services['url.checker']->checkArticleId($this->_services['get.handler']->getRequestField('id'), $max_id)) {
                    $key = '404';
                }
            }
            
            // User id.
            if (isset($_GET['user'])) {
                $max_id = $this->_services['dao.user']->findLastId();
                if (!$this->_services['url.checker']->checkUserId($this->_services['get.handler']->getRequestField('id'), $max_id)) {
                    $key = '404';
                }
            }
            
            $domains = $this->_domains[$key]->buildDomain($this->_services);
            return $this->_services['renderer']->renderer($this->_domains[$key]->getTemplateName(), $domains);
        }
    }

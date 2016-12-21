<?php
    namespace SciMS\Controller;
    
    use SciMS\Controller\BuildDomain\Administration\BuildArticles;
    use SciMS\Controller\BuildDomain\Administration\BuildCategories;
    use SciMS\Controller\BuildDomain\Administration\BuildInstallation;
    use SciMS\Controller\BuildDomain\Administration\BuildUsers;
    use \SciMS\Controller\BuildDomain\Build404;
    use \SciMS\Controller\BuildDomain\BuildConnection;
    use \SciMS\Controller\BuildDomain\BuildConsultArticle;
    use SciMS\Controller\BuildDomain\BuildConsultArticleCategory;
    use \SciMS\Controller\BuildDomain\BuildConsultProfile;
    use \SciMS\Controller\BuildDomain\BuildHome;
    use \SciMS\Controller\BuildDomain\BuildInscription;
    use \SciMS\Controller\BuildDomain\BuildSearchResultDomain;
    use \SciMS\Controller\BuildDomain\BuildVerification;
    use \SciMS\Controller\BuildDomain\Administration\BuildAdministrationHome;
    use \SciMS\Controller\BuildDomain\Administration\BuildAddCategory;
    use \SciMS\Controller\BuildDomain\Administration\BuildEditArticle;
    use \SciMS\Controller\BuildDomain\Administration\BuildEditCategory;
    use \SciMS\Controller\BuildDomain\Administration\BuildEditProfile;
    use \SciMS\Controller\BuildDomain\Administration\BuildWriteArticle;
    use \SciMS\Controller\Builder\FormBuilder;
    use SciMS\Controller\Checker\FileChecker;
    use \SciMS\Controller\Checker\Form\ArticleChecker;
    use \SciMS\Controller\Checker\Form\CategoryChecker;
    use \SciMS\Controller\Checker\Form\ConnectionChecker;
    use \SciMS\Controller\Checker\Form\UserChecker;
    use \SciMS\Controller\Checker\MailChecker;
    use \SciMS\Controller\Checker\PasswordChecker;
    use \SciMS\Controller\Checker\URLChecker;
    use \SciMS\Controller\Handler\MessageHandler;
    use SciMS\Controller\Handler\RedirectHandler;
    use \SciMS\Controller\Handler\RequestHandler\CookieHandler;
    use \SciMS\Controller\Handler\RequestHandler\FileHandler;
    use \SciMS\Controller\Handler\RequestHandler\GetHandler;
    use \SciMS\Controller\Handler\RequestHandler\PostHandler;
    use \SciMS\Controller\Handler\RequestHandler\SessionHandler;
    use \SciMS\DAO\ArticleDAO;
    use \SciMS\DAO\CategoryDAO;
    use \SciMS\DAO\ThemeDAO;
    use \SciMS\DAO\UserDAO;
    use \SciMS\DAO\WebsiteDAO;
    use \SciMS\File\FileAvatar;
    use SciMS\File\YamlFile;
    use \SciMS\Message\Error;
    use \SciMS\Message\Success;

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
     * -> V1.3
     *  - Added some new services.
     *  - Added private method to initialize messages.
     *  - Check url parameter thanks to Checker classes.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.1
     * @version 1.3
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
         * -> V1.3 :
         *  - Add administration backend.
         *  - Add auto-installation.
         *  - Add RedirectHandler on services.
         *  - Add FileChecker on services.
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.3
         */
        public function __construct() {
            $this->_routes = array(
                // Installation part
                'installation' => '#\/web\/index\.php\?action=installation$#',
                
                // Website part
                'home'                     => '#\/web\/index\.php(\?user=[0-9]+)?$#',
                'connection'               => '#\/web\/index\.php\?action=connection$#',
                'disconnection'            => '#\/web\/index\.php\?action=disconnection&user=([0-9]+)+$#',
                'inscription'              => '#\/web\/index\.php\?action=inscription$#',
                'consult_article'          => '#\/web\/index\.php\?action=consult_article&id=[0-9]+(&user=[0-9]+)?$#',
                'consult_article_category' => '#\/web\/index\.php\?action=consult_article_category&id=[0-9]+(&user=[0-9]+)?$#',
                'consult_profile'          => '#\/web\/index\.php\?action=consult_profile&id=[0-9]+(&user=[0-9]+)?$#',
                'search'                   => '#\/web\/index\.php\?action=search(&user=[0-9]+)?$#',
                'verification'             => '#\/web\/index\.php\?action=verification&form=(installation|connection|inscription|disconnection|edit_profile(&user_update=[0-9]+)?|write_article|edit_article|delete_article|add_category|edit_category|delete_category|delete_user)+(&user=[0-9]+&(article|category|user_delete)=[0-9]+)?$#',
                
                // Administration part
                'administration' => '#\/web\/index\.php\?action=administration&user=[0-9]+$#',
                'admin_article'  => '#\/web\/index\.php\?action=admin_article&user=[0-9]+$#',
                'admin_category' => '#\/web\/index\.php\?action=admin_category&user=[0-9]+$#',
                'admin_user'     => '#\/web\/index\.php\?action=admin_user&user=[0-9]+$#',
                'write_article'  => '#\/web\/index\.php\?action=write_article&user=[0-9]+$#',
                'edit_article'   => '#\/web\/index\.php\?action=edit_article&user=[0-9]+&article=[0-9]+$#',
                'edit_profile'   => '#\/web\/index\.php\?action=edit_profile&user=[0-9]+(&user_update=[0-9]+)?$#',
                'add_category'   => '#\/web\/index\.php\?action=edit_category&user=[0-9]+$#',
                'edit_category'  => '#\/web\/index\.php\?action=edit_category&user=[0-9]+&category=[0-9]+$#',
            );
            
            $this->_domains = array(
                // Installation
                'installation' => new BuildInstallation('admin/installation.html.twig'),
                
                // Website
                'home'                     => new BuildHome('home.html.twig'),
                'connection'               => new BuildConnection('connection.html.twig'),
                'inscription'              => new BuildInscription('inscription.html.twig'),
                'consult_article'          => new BuildConsultArticle('consult_article.html.twig'),
                'consult_article_category' => new BuildConsultArticleCategory('consult_article_category.html.twig'),
                'consult_profile'          => new BuildConsultProfile('consult_profile.html.twig'),
                'search'                   => new BuildSearchResultDomain('search_results.html.twig'),
                'verification'             => new BuildVerification('verification.html.twig'),
                
                // Administration part
                'administration' => new BuildAdministrationHome('admin/home.html.twig'),
                'admin_article'  => new BuildArticles('admin/article.html.twig'),
                'admin_category' => new BuildCategories('admin/category.html.twig'),
                'admin_user'     => new BuildUsers('admin/user.html.twig'),
                
                'write_article'  => new BuildWriteArticle('admin/edit_article.html.twig'),
                'edit_article'   => new BuildEditArticle('admin/edit_article.html.twig'),
                'edit_profile'   => new BuildEditProfile('admin/edit_profile.html.twig'),
                'add_category'   => new BuildAddCategory('admin/edit_category.html.twig'),
                'edit_category'  => new BuildEditCategory('admin/edit_category.html.twig'),
                
                // 404 Page not found !
                '404' => new Build404('404.html.twig'),
            );
    
            $this->_services = array(
                // Dao section.
                'dao.article'  => new ArticleDAO(),
                'dao.category' => new CategoryDAO(),
                'dao.theme'    => new ThemeDAO(),
                'dao.user'     => new UserDAO(),
                'dao.website'  => new WebsiteDAO(),
                
                // Builder section.
                'form.builder' => new FormBuilder(),
                
                // checker section.
                'article.checker'    => new ArticleChecker(),
                'category.checker'   => new CategoryChecker(),
                'connection.checker' => new ConnectionChecker(),
                'file.checker'       => new FileChecker(),
                'mail.checker'       => new MailChecker(),
                'password.checker'   => new PasswordChecker(),
                'user.checker'       => new UserChecker(),
                'url.checker'        => new URLChecker(),
                
                // Handler section.
                'cookie.handler'    => new CookieHandler(),
                'file.handler'      => new FileHandler(),
                'get.handler'       => new GetHandler(),
                'message.handler'   => new MessageHandler(),
                'post.handler'      => new PostHandler(),
                'redirect.handler'  => new RedirectHandler(),
                'session.handler'   => new SessionHandler(),
                
                // File section.
                'avatar.upload' => new FileAvatar(),
                'yaml.file'     => new YamlFile(),
                
                // Renderer section.
                'renderer' => new Renderer(),
            );
    
            $this->initializeMessageHandler();
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
            $view = $this->match($url);
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
        private function match($url) {
            $view = null;
            foreach ($this->_routes as $key => $value) {
                // Generate REGEX to recognize right url form.
                if (preg_match($value, $url) != 0) {
                    $view = $this->parseUrl($key);
                }
            }
            if ($view === null) {
                $view = $this->parseUrl('404');
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
        private function parseUrl($key) {
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
                if (!$this->_services['url.checker']->checkId($this->_services['get.handler']->getRequestField('id'), $max_id)) {
                    $key = '404';
                }
            }
            
            $domains = $this->_domains[$key]->buildDomain($this->_services);
            return $this->_services['renderer']->renderer($this->_domains[$key]->getTemplateName(), $domains);
        }
    
        /**
         * Private method use for initialize MessageHandler on constructor with message return in differents process.
         *
         * @access private
         * @since SciMS 0.3
         * @version 1.0
         */
        private function initializeMessageHandler() {
            // Success messages.
            $this->_services['message.handler']->pushMessage('inscription',     new Success('Inscription success'));
            $this->_services['message.handler']->pushMessage('connection',      new Success('Connection success'));
            $this->_services['message.handler']->pushMessage('update',          new Success('User profile update'));
            $this->_services['message.handler']->pushMessage('write_article',   new Success('Write article was a success'));
            $this->_services['message.handler']->pushMessage('update_article',  new Success('Update article was a success'));
            $this->_services['message.handler']->pushMessage('category_create', new Success('Create category was a success'));
            $this->_services['message.handler']->pushMessage('disconnection',   new Success('Disconnection success'));
            
            // Error messages
            $this->_services['message.handler']->pushMessage('email_invalid',       new Error('Email invalid'));
            $this->_services['message.handler']->pushMessage('email_present_on_db', new Error('Email already present on Website'));
            $this->_services['message.handler']->pushMessage('connection_fail',     new Error('Connection fail'));
            $this->_services['message.handler']->pushMessage('inscription_fail',    new Error('Inscription fail'));
            $this->_services['message.handler']->pushMessage('update_failed',       new Error('Update profile fail'));
            $this->_services['message.handler']->pushMessage('write_article_fail',  new Error('Write article fail'));
            $this->_services['message.handler']->pushMessage('update_article_fail', new Error('Update article fail'));
            $this->_services['message.handler']->pushMessage('category_fail',       new Error('Category already present or invalid'));
            $this->_services['message.handler']->pushMessage('research_fail',       new Error('Research not found'));
            $this->_services['message.handler']->pushMessage('article_not_found',   new Error('Article not found'));
            $this->_services['message.handler']->pushMessage('user_not_found',      new Error('User not found'));
            $this->_services['message.handler']->pushMessage('404',                 new Error('Page not found'));
        }
    }

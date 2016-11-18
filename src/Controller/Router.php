<?php
    namespace SciMS\Controller;
    
    use \SciMS\DAO\ArticleDAO;
    use \SciMS\DAO\CategoryDAO;
    use \SciMS\DAO\UserDAO;
    use \SciMS\Error\MessageHandler;
    use \SciMS\Form\FormBuilder;
    use \SciMS\Form\InputEmail;
    use \SciMS\Form\InputPassword;
    use \SciMS\Form\InputSubmit;
    use \SciMS\Form\InputText;

    /**
     * Class Router.
     *
     * -> V1.1
     *  - Added new routes, templates and form.builder service.
     *  - Moved $_renderer attribute into $_services array.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.1
     * @version 1.1
     */
    class Router {
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
         * -> V1.1
         *  - Add new routes.
         *  - Add new templates.
         *  - Add form.builder on services.
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.1
         */
        public function __construct() {
            $this->_routes = array(
                'home'          => '#\/web\/index\.php(&user=[0-9]+)?$#',
                'connection'    => '#\/web\/index\.php\?action=connection$#',
                'disconnection' => '#\/web\/index\.php\?action=disconnection$#',
                'inscription'   => '#\/web\/index\.php\?action=inscription$#',
                'verification'  => '#\/web\/index\.php\?action=verification&form=(connection|inscription)+$#',
                'article'       => '#\/web\/index\.php\?action=article&id=[0-9]+(&user=[0-9]+)?$#',
                'account'       => '#\/web\/index\.php\?action=account&user=[0-9]+$#',
            );
            
            $this->_templates = array(
                'home'          => 'home.html.twig',
                'connection'    => 'connection.html.twig',
                'disconnection' => 'disconnection.html.twig',
                'inscription'   => 'inscription.html.twig',
                'verification'  => 'verification.html.twig',
                'article'       => 'article.html.twig',
                'account'       => 'account.html.twig',
                '404'           => '404.html.twig',
            );
    
            $this->_services = array(
                'dao.user'          => new UserDAO(),
                'dao.article'       => new ArticleDAO(),
                'dao.category'      => new CategoryDAO(),
                'form.builder'      => new FormBuilder(),
                'form.checker'      => new FormChecker(),
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
         * @access private
         * @param $key
         *  Use for retrieve good template from templates array.
         * @return string
         *  The HTML view corresponding to the good template.
         * @since SciMS 0.1
         * @version 1.1
         */
        private function _parseUrl($key) {
            $domains = null;
            
            // Switch on $key
            switch ($key) {
                // Home template generate with good domains object.
                case 'home' :
                    if (!isset($_SESSION['id'])) {
                        $domains = array(
                            'articles' => $this->_services['dao.article']->findLastArticle(10),
                        );
                    } else {
                        $domains = array(
                            'articles' => $this->_services['dao.article']->findLastArticle(10),
                            'user'     => $this->_services['dao.user']->findById($_SESSION['id']),
                        );
                    }
                    break;
    
                // Connection template generate with good domains object.
                case 'connection' :
                    $domains = array(
                        'forms' => $this->_services['form.builder']->add(
                            new InputText(array(
                                'type'          => 'text',
                                'id'            => 'username',
                                'name'          => 'username',
                                'placeholder'   => 'Enter your username ...',
                                'class'         => 'form-control',
                                'required'      => true,
                                'label'         => 'Username',
                            ))
                        )->add(
                            new InputPassword(array(
                                'type'          => 'password',
                                'id'            => 'password',
                                'name'          => 'password',
                                'placeholder'   => 'Enter your password ...',
                                'class'         => 'form-control',
                                'required'      => true,
                                'label'         => 'Password',
                            ))
                        )->add(
                            new InputSubmit(array(
                                'type'          => 'submit',
                                'id'            => 'submit',
                                'name'          => 'submit',
                                'value'         => 'Sign in',
                                'class'         => 'form-control btn btn-primary',
                            ))
                        )->getForms(),
                    );
                    break;
    
                // disonnection template generate with good domains object.
                case 'disconnection' :
                    $domains = array(
                        
                    );
                    break;
    
                // Inscription template generate with good domains object.
                case 'inscription' :
                    $domains = array(
                        'forms' => $this->_services['form.builder']->add(
                            new InputEmail(array(
                                'type'          => 'email',
                                'id'            => 'email',
                                'name'          => 'email',
                                'placeholder'   => 'Enter your email ...',
                                'class'         => 'form-control',
                                'required'      => true,
                                'label'         => 'Email',
                            ))
                        )->add(
                            new InputText(array(
                                'type'          => 'text',
                                'id'            => 'username',
                                'name'          => 'username',
                                'placeholder'   => 'Enter your username ...',
                                'class'         => 'form-control',
                                'required'      => true,
                                'label'         => 'Username',
                            ))
                        )->add( new InputPassword(array(
                                'type'          => 'password',
                                'id'            => 'password',
                                'name'          => 'password',
                                'placeholder'   => 'Enter your password ...',
                                'class'         => 'form-control',
                                'required'      => true,
                                'label'         => 'Password',
                            ))
                        )->add(
                        new InputSubmit(array(
                            'type'          => 'submit',
                            'id'            => 'submit',
                            'name'          => 'submit',
                            'value'         => 'Sign in',
                            'class'         => 'form-control btn btn-primary',
                        ))
                        )->getForms(),
                    );
                    break;
                
                // Form verification template.
                case 'verification' :
                    $entry_form = $_GET['form'];
                    
                    switch ($entry_form) {
                        case 'connection' :
                            $user  = $this->_services['dao.user']->findByUsername($_POST['username']);
                            $check = $this->_services['form.checker']->checkConnection($_POST, $user);
                            if ($check) {
                                $this->_services['dao.user']->saveUser($user);
                                $domains = array(
                                    'message' => $this->_services['message.handler']->getSuccess($entry_form),
                                );
                            } else {
                                $domains = array(
                                    'message' => $this->_services['message.handler']->getError($entry_form . '_username'),
                                );
                            }
                            break;
    
                        case 'inscription' :
                            $user  = array(
                                'email'     => $_POST['email'],
                                'username'  => $_POST['username'],
                                'password'  => $_POST['password'],
                            );
                            $check = $this->_services['form.checker']->checkInscription($_POST, $user);
                            if ($check) {
                                $this->_services['dao.user']->saveUser($user);
                                $domains = array(
                                    'message' => $this->_services['message.handler']->getSuccess($entry_form),
                                );
                            } else {
                                $domains = array(
                                    'message' => $this->_services['message.handler']->getError($entry_form . '_username'),
                                );
                            }
                            break;
                        
                        // Default case : $_GET['form'] not exists or not corresponding with possible choice.
                        default:
                            $domains = array(
                                'message' => $this->_services['message.handler']->getError('404'),
                            );
                            break;
                    }
                    
                    
                    break;
    
                // Article template generate with good domains object.
                case 'article' :
                    if (!isset($_SESSION['id'])) {
                        $domains = array(
                            'article' => $this->_services['dao.article']->findById($_GET['id']),
                        );
                    } else {
                        $domains = array(
                            'article' => $this->_services['dao.article']->findById($_GET['id']),
                            'user'    => $this->_services['dao.user']->findById($_SESSION['id']),
                        );
                    }
                    break;
                
                // User template generate with good domains object.
                case 'account' :
                    $domains = array(
                        'account' => $this->_services['dao.user']->findById($_GET['id']),
                    );
                    break;
    
                // 404 template generate with nothing domains object.
                default :
                    $domains = array();
                    break;
            }
            
            return $this->_services['renderer']->renderer($this->_templates[$key], $domains);
        }
    }

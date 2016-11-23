<?php
    namespace SciMS\Controller;
    
    use \SciMS\DAO\ArticleDAO;
    use \SciMS\DAO\CategoryDAO;
    use \SciMS\DAO\UserDAO;
    use \SciMS\Domain\Article;
    use \SciMS\Domain\User;
    use \SciMS\Error\MessageHandler;
    use \SciMS\Form\FormBuilder;
    use \SciMS\Form\Input\InputDate;
    use \SciMS\Form\Input\InputEmail;
    use \SciMS\Form\Input\InputFile;
    use \SciMS\Form\Input\InputHidden;
    use \SciMS\Form\Input\InputPassword;
    use \SciMS\Form\Input\InputSubmit;
    use \SciMS\Form\Input\InputText;
    use \SciMS\Form\Option;
    use \SciMS\Form\Select;
    use \SciMS\Form\TextArea;

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
                'home'          => '#\/web\/index\.php(\?user=[0-9]+)?$#',
                'connection'    => '#\/web\/index\.php\?action=connection$#',
                'disconnection' => '#\/web\/index\.php\?action=disconnection&user=([0-9]+)+$#',
                'inscription'   => '#\/web\/index\.php\?action=inscription$#',
                'verification'  => '#\/web\/index\.php\?action=verification&form=(connection|inscription|disconnection|update|write)+$#', // Change it when you add new Form.
                'article'       => '#\/web\/index\.php\?action=article&id=[0-9]+(&user=[0-9]+)?$#',
                'account'       => '#\/web\/index\.php\?action=account&user=[0-9]+$#',
                'write'         => '#\/web\/index\.php\?action=write&user=[0-9]+$#',
            );
            
            $this->_templates = array(
                'home'          => 'home.html.twig',
                'connection'    => 'connection.html.twig',
                'disconnection' => 'disconnection.html.twig',
                'inscription'   => 'inscription.html.twig',
                'verification'  => 'verification.html.twig',
                'article'       => 'article.html.twig',
                'account'       => 'admin/account.html.twig',
                'write'         => 'admin/article.html.twig',
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
         * -> V1.2 :
         *  - Add private method to build domains on each switch case.
         *
         * @access private
         * @param $key
         *  Use for retrieve good template from templates array.
         * @return string
         *  The HTML view corresponding to the good template.
         * @since SciMS 0.1
         * @version 1.2
         */
        private function _parseUrl($key) {
            $domains = null;
            
            // Switch on $key
            switch ($key) {
                // Home template generate with good domains object.
                case 'home' :
                    $domains = $this->_buildDomainHome();
                    break;
    
                // Connection template generate with good domains object.
                case 'connection' :
                    $domains = $this->_buildDomainConnection();
                    break;
    
                // disconnection template generate with good domains object.
                case 'disconnection' :
                    $domains = $this->_buildDomainDisconnection();
                    break;
    
                // Inscription template generate with good domains object.
                case 'inscription' :
                    $domains = $this->_buildDomainInscription();
                    break;
                
                // Form verification template.
                case 'verification' :
                    $domains = $this->_buildDomainVerification();
                    break;
    
                // Article template generate with good domains object.
                case 'article' :
                    $domains = $this->_buildDomainArticle();
                    break;
                
                // User template generate with good domains object.
                case 'account' :
                    $domains = $this->_buildDomainAccount();
                    break;
                
                // Write on article.
                case 'write' :
                    $domains = $this->_buildDomainWrite();
                    break;
    
                // 404 template generate with nothing domains object.
                default :
                    $domains = $this->_buildDomain404();
                    break;
            }
            
            return $this->_services['renderer']->renderer($this->_templates[$key], $domains);
        }
    
        /**
         * A private method use for build domains object using in Home render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Home.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainHome() {
            if (!isset($_SESSION['user_id'])) {
                $domains = array(
                    'articles' => $this->_services['dao.article']->findLastArticle(10),
                );
            } else {
                $domains = array(
                    'articles' => $this->_services['dao.article']->findLastArticle(10),
                    'user'     => $this->_services['dao.user']->findById($_SESSION['user_id']),
                    'connect'  => true,
                );
            }
            
            return $domains;
        }
    
        /**
         * A private method use for build domains object using in Connection render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Connection.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainConnection() {
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
            return $domains;
        }
    
        /**
         * A private method use for build domains object using in Disconnection render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Disconnection.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainDisconnection() {
            $domains = array(
                'forms' => $this->_services['form.builder']->add(
                    new InputSubmit(array(
                        'type'          => 'submit',
                        'id'            => 'submit',
                        'name'          => 'submit',
                        'value'         => 'Sign out',
                        'class'         => 'form-control btn btn-primary',
                    ))
                )->getForms(),
            );
            return $domains;
        }
        
        /**
         * A private method use for build domains object using in Inscription render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Inscription.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainInscription() {
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
            return $domains;
        }
    
        /**
         * A private method use for build domains object using in Verification render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Verification.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainVerification() {
            $entry_form = $_GET['form'];
    
            switch ($entry_form) {
                // Connection section.
                case 'connection' :
                    $user = $this->_services['dao.user']->findByEmail($_POST['email']);
                    $message_key = $this->_services['form.checker']->checkUserConnection($_POST, $user);
                    if ((strcmp($message_key, 'connection_success') == 0) || strcmp($message_key, 'inscription_success') == 0)  {
                        $domains = array(
                            'user'    => $user->setConnect(true),
                            'message' => $this->_services['message.handler']->getSuccess($message_key),
                        );
                    } else {
                        $domains = array(
                            'message' => $this->_services['message.handler']->getError($message_key),
                        );
                    }
                    break;
        
                // Inscription section.
                case 'inscription' :
                    $user = new User(array(
                        'email'     => $_POST['email'],
                        'username'  => $_POST['username'],
                        'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'role'      => User::WRITTER,
                        'connect'   => true,
                    ));
                    // Potential user because the username is possible not corresponding to the email type on form.
                    $potential_user = $this->_services['dao.user']->findByEmail($user->getEmail());
                    $message_key = $this->_services['form.checker']->checkUserInscription($_POST, $potential_user);
                    if ((strcmp($message_key, 'connection_success') == 0) || strcmp($message_key, 'inscription_success') == 0)  {
                        $this->_services['dao.user']->saveUser($user);
                        $domains = array(
                            'message' => $this->_services['message.handler']->getSuccess($message_key),
                            'user'    => $this->_services['dao.user']->findByUsername($user->getUsername()),
                        );
                    } else {
                        $domains = array(
                            'message' => $this->_services['message.handler']->getError($message_key),
                        );
                    }
                    break;
        
                case 'disconnection' :
                    session_destroy();
                    $domains = array(
            
                    );
                    break;
        
                // Update user.
                case 'update' :
                    $message_key = $this->_services['form.checker']->checkUserUpdate($_POST);
            
                    $user = $this->_services['dao.user']->findByUsername($_POST['username']);
                    $user->setUsername($_POST['username']);
                    $user->setFname($_POST['fname']);
                    $user->setLname($_POST['lname']);
            
                    if ((strcmp($message_key, 'update_success') == 0))  {
                        $this->_services['dao.user']->updateUser($user);
                        $domains = array(
                            'message' => $this->_services['message.handler']->getSuccess($message_key),
                            'user'    => $this->_services['dao.user']->findByUsername($user->getUsername()),
                        );
                    } else {
                        $domains = array(
                            'message' => $this->_services['message.handler']->getError($message_key),
                            'user'    => $this->_services['dao.user']->findByUsername($user->getUsername()),
                        );
                    }
                    break;
                
                // Write an Article
                case 'write' :
                    $message_key = $this->_services['form.checker']->checkInsertArticle($_POST);
                    $category    = $this->_services['dao.category']->findById($_POST['category']);
                    $user        = $this->_services['dao.user']->findById($_POST['writter']);
                    
                    $article = new Article(array(
                        'title'         => $_POST['title'],
                        'content'       => $_POST['content'],
                        'authors'       => $_POST['authors'],
                        'categories'    => $category->getId(),
                        'tags'          => $_POST['tags'],
                        'status'        => $_POST['status'],
                        'writter'       => $user,
                    ));
                    
                    if (strcmp($message_key, 'insert_success') === 0) {
                        $this->_services['dao.article']->saveArticle($article);
                        $domains = array(
                            'message' => $this->_services['message.handler']->getSuccess($message_key),
                            'user'    => $this->_services['dao.user']->findById($_SESSION['user_id']),
                        );
                    } else {
                        $domains = array(
                            'message' => $this->_services['message.handler']->getError($message_key),
                            'user'    => $this->_services['dao.user']->findById($_SESSION['user_id']),
                        );
                    }
                    break;
        
                // Default case : $_GET['form'] not exists or not corresponding with possible choices.
                default:
                    $domains = array(
                        'message' => $this->_services['message.handler']->getError('404'),
                    );
                    break;
            }
            return $domains;
        }
    
        /**
         * A private method use for build domains object using in Article render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Article.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainArticle() {
            
            if (!isset($_SESSION['user_id'])) {
                $domains = array(
                    'article' => $this->_services['dao.article']->findById($_GET['id']),
                );
            } else {
                $domains = array(
                    'article' => $this->_services['dao.article']->findById($_GET['id']),
                    'user'    => $this->_services['dao.user']->findById($_SESSION['user_id']),
                    'connect'  => true,
                );
            }
            return $domains;
        }
        
        /**
         * A private method use for build domains object using in Article render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page Article.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomainAccount() {
            $user = $this->_services['dao.user']->findById($_SESSION['user_id']);
            $domains = array(
                'forms' => $this->_services['form.builder']->add(
                // Username
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'username',
                        'name'  => 'username',
                        'value' => $user->getUsername(),
                        'class' => 'form-control',
                        'label' => 'Username',
                    ))
                )->add(
                // First name
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'username',
                        'name'  => 'username',
                        'value' => $user->getFname(),
                        'class' => 'form-control',
                        'label' => 'First name',
                    ))
                )->add(
                // Last name
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'username',
                        'name'  => 'username',
                        'value' => $user->getLname(),
                        'class' => 'form-control',
                        'label' => 'Last name',
                    ))
                )->add(
                // Email - readonly.
                    new InputEmail(array(
                        'type'      => 'email',
                        'value'     => $user->getEmail(),
                        'class' => 'form-control',
                        'label' => 'Email',
                        'readonly'  => true,
                    ))
                )->add(
                // Password
                    new InputPassword(array(
                        'type'  => 'password',
                        'id'    => 'password',
                        'name'  => 'password',
                        'class' => 'form-control',
                        'label' => 'New Password',
                    ))
                )->add(
                // Repeat Password
                    new InputPassword(array(
                        'type'  => 'password',
                        'id'    => 'repeat_password',
                        'name'  => 'repeat_password',
                        'class' => 'form-control',
                        'label' => 'Repeat Password',
                    ))
                )->add(
                // Birthday
                    new InputDate(array(
                        'type'  => 'date',
                        'id'    => 'birthday',
                        'name'  => 'birthday',
                        'class' => 'form-control',
                        'label' => 'Birthday',
                        'value' => $user->getBirthday(),
                    ))
                )->add(
                // Biography
                    new TextArea(array(
                        'id'    => 'biography',
                        'name'  => 'biography',
                        'class' => 'form-control',
                        'label' => 'Biography',
                        'value' => $user->getBiography(),
                        'rows'  => '10',
                        'cols'  => '50',
                    ))
                )->add(
                // Avatar
                    new InputFile(array(
                        'type'  => 'file',
                        'id'    => 'avatar',
                        'name'  => 'avatar',
                        'class' => 'form-control',
                        'label' => 'Avatar',
                    ))
                )->add(
                // Max size of file
                    new InputHidden(array(
                        'type'  => 'hidden',
                        'name'  => 'max_size_file',
                        'value' => '',
                    ))
                )->add(
                // Submit button
                    new InputSubmit(array(
                        'type'  => 'submit',
                        'id'    => 'submit',
                        'name'  => 'submit',
                        'value' => 'Submit',
                        'class' => 'form-control btn btn-primary',
                    ))
                )->getForms(),
                'user'     => $user,
                'connect'  => true,
            );
            return $domains;
        }
        
        private function _buildDomainWrite() {
            $user = $this->_services['dao.user']->findById($_SESSION['user_id']);
            
            // Create the object datalist for the category.
            $categories = $this->_services['dao.category']->findAll();
            $select_category = new Select(array(
                'id'    => 'category',
                'name'  => 'category',
                'label' => 'Category',
                'class' => 'form-control',
            ));
    
            // Fill option in Select object.
            foreach ($categories as $category) {
                $select_category->add(new Option(array(
                    'value' => $category->getId(),
                    'label' => $category->getTitle(),
                )));
            }
            $select_category->renderSelect();
            
            // Status
            $select_status = new Select(array(
                'id'    => 'status',
                'label' => 'status',
                'class' => 'form-control',
            ));
    
            // Fill option in Select object0
            $status = array(
                'Release' => Article::RELEASE,
                'Pending' => Article::PENDING,
                'Hidden'  => Article::HIDDEN
            );
            
            foreach ($status as $key => $value) {
                $select_status->add(new Option(array(
                    'value' => $value,
                    'label' => $key,
                )));
            }
            $select_status->renderSelect();
            
            $domains = array(
                'forms'  => $this->_services['form.builder']->add(
                    // Title
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'title',
                        'name'  => 'title',
                        'class' => 'form-control',
                        'label' => 'Title',
                    ))
                )->add(
                    // Content
                    new TextArea(array(
                        'id'    => 'content',
                        'name'  => 'content',
                        'class' => 'form-control',
                        'label' => 'Content',
                        'rows'  => '10',
                        'cols'  => '50',
                    ))
                )->add(
                    // Authors
                    new TextArea(array(
                        'id'    => 'authors',
                        'name'  => 'authors',
                        'class' => 'form-control',
                        'label' => 'Authors',
                        'rows'  => '5',
                        'cols'  => '50',
                    ))
                )->add(
                    // Category
                    $select_category
                )->add(
                    // Tags
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'tags',
                        'name'  => 'tags',
                        'class' => 'form-control',
                        'label' => 'Tags',
                    ))
                )->add(
                    // Status
                    $select_status
                )->add(
                    // Writter id.
                    new InputHidden(array(
                        'type'  => 'hidden',
                        'id'    => 'writter',
                        'name'  => 'writter',
                        'value' => $user->getId(),
                    ))
                )->add(
                    // Submit
                    new InputSubmit(array(
                        'type'  => 'submit',
                        'id'    => 'submit',
                        'name'  => 'submit',
                        'class' => 'form-control btn btn-primary',
                        'value' => 'Submit'
                    ))
                )->getForms(),
                'user'    => $user,
                'connect' => true,
            );
            
            return $domains;
        }
    
        /**
         * A private method use for build domains object using in 404 render.
         *
         * @access private
         * @return array
         *  An array with all domain class loaded for build page 404.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _buildDomain404() {
            if (!isset($_SESSION['user_id'])) {
                $domains = array(
        
                );
            } else {
                $domains = array(
                    'user'    => $this->_services['dao.user']->findById($_SESSION['user_id']),
                    'connect'  => true,
                );
            }
            return $domains;
        }
    }

<?php
    namespace SciMS\Controller\BuildDomain;

    /**
     * Class BuildVerification
     *
     * This class build domain objects present on Verification page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildVerification extends AbstractBuildDomain {
    
        /**
         * BuildCategory constructor.
         *
         * @param $template
         *  Name of the template.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function __construct($template) {
            $this->setTemplateName($template);
        }
    
        /**
         * Method use for create domains array use to render the view.
         *
         * @param array $services
         *  Return services.
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function buildDomain(array $services) {
            $services['post.handler']->setRequest($_POST);          // Retrieve $_POST.
            $services['get.handler']->setRequest($_GET);            // Retrieve $_GET.
            $entry_form = $services['get.handler']->getRequestField('form');
            
            switch ($entry_form) {
                // Connection section.
                case 'connection' :
                    $user = $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'));
                    $message_key = $services['form.checker']->checkUserConnection($services['post.handler']->getRequest(), $user);
                    if ((strcmp($message_key, 'connection_success') == 0) || strcmp($message_key, 'inscription_success') == 0)  {
                        // Create session with session.handler.
                        $services['session.handler']->createSession(array(
                            'user_id'       => $user->getId(),
                            'user_connect'  => true,
                        ));
                        $domains = array(
                            'user'    => $user->setConnect(true),
                            'message' => $services['message.handler']->getSuccess($message_key),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError($message_key),
                        );
                    }
                    break;
        
                // Inscription section.
                case 'inscription' :
                    $user = new User(array(
                        'email'     => $services['post.handler']->getRequestField('email'),
                        'username'  => $services['post.handler']->getRequestField('username'),
                        'password'  => password_hash($services['post.handler']->getRequestField('password'), PASSWORD_DEFAULT),
                        'role'      => User::WRITTER,
                        'connect'   => true,
                    ));
                    // Potential user because the username is possible not corresponding to the email type on form.
                    $potential_user = $services['dao.user']->findByEmail($user->getEmail());
                    $message_key = $services['form.checker']->checkUserInscription($services['post.handler']->getRequest(), $potential_user);
                    if ((strcmp($message_key, 'connection_success') == 0) || strcmp($message_key, 'inscription_success') == 0)  {
                        $services['dao.user']->saveUser($user);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess($message_key),
                            'user'    => $services['dao.user']->findByUsername($user->getUsername()),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError($message_key),
                        );
                    }
                    break;
        
                case 'disconnection' :
                    $services['session.handler']->destroySession();
                    $domains = array();
                    break;
        
                // Update user.
                case 'update' :
                    $services['file.checker']->uploadAvatarFile($_FILES, strtolower($services['post.handler']->getRequestField('username')));
                    $file_extension = $services['file.checker']->splitExtensionFile($_FILES, 'avatar');
                    $message_key = $services['form.checker']->checkUserUpdate($services['post.handler']->getRequest());
            
                    $user = $services['dao.user']->findByUsername($services['post.handler']->getRequestField('username'));
                    $user->setUsername($services['post.handler']->getRequestField('username'));
                    $user->setFname($services['post.handler']->getRequestField('fname'));
                    $user->setLname($services['post.handler']->getRequestField('lname'));
                    $user->setBirthday($services['post.handler']->getRequestField('birthday'));
                    $user->setBiography($services['post.handler']->getRequestField('biography'));
                    $user->setAvatar(strtolower($user->getUsername() . $file_extension));
            
                    if ((strcmp($message_key, 'update_success') == 0))  {
                        $services['dao.user']->updateUser($user);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess($message_key),
                            'user'    => $services['dao.user']->findByUsername($user->getUsername()),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError($message_key),
                            'user'    => $services['dao.user']->findByUsername($user->getUsername()),
                        );
                    }
                    break;
        
                // Write an Article
                case 'write' :
                    $message_key = $services['form.checker']->checkInsertArticle($services['post.handler']->getRequest());
                    $category    = $services['dao.category']->findById($services['post.handler']->getRequestField('category'));
                    $user        = $services['dao.user']->findById($services['post.handler']->getRequestField('writter'));
            
                    $article = new Article(array(
                        'title'         => $services['post.handler']->getRequestField('title'),
                        'content'       => $services['post.handler']->getRequestField('content'),
                        'authors'       => $services['post.handler']->getRequestField('authors'),
                        'categories'    => $category,
                        'tags'          => $services['post.handler']->getRequestField('tags'),
                        'status'        => $services['post.handler']->getRequestField('status'),
                        'writter'       => $user,
                    ));
            
                    if (strcmp($message_key, 'insert_success') === 0) {
                        $services['dao.article']->saveArticle($article);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess($message_key),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError($message_key),
                            'user'    => $services['dao.user']->findById($services['post.handler']->getRequestField('user_id')),
                        );
                    }
                    break;
        
                // Edit an Article.
                case 'edit' :
                    $message_key = $services['form.checker']->checkUpdateArticle($services['post.handler']->getRequest());
                    $category    = $services['dao.category']->findById($services['post.handler']->getRequestField('category'));
                    $user        = $services['dao.user']->findById($services['post.handler']->getRequestField('writter'));
            
                    $date = new DateTime();
                    $article = new Article(array(
                        'id'                => $services['post.handler']->getRequestField('article_id'),
                        'title'             => $services['post.handler']->getRequestField('title'),
                        'content'           => $services['post.handler']->getRequestField('content'),
                        'authors'           => $services['post.handler']->getRequestField('authors'),
                        'categories'        => $category,
                        'tags'              => $services['post.handler']->getRequestField('tags'),
                        'status'            => $services['post.handler']->getRequestField('status'),
                        'date_modified'     => $date->format("Y-m-d H:i:s"),
                        'writter'           => $user,
                    ));
            
                    if (strcmp($message_key, 'update_success') === 0) {
                        $services['dao.article']->updateArticle($article);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess($message_key),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError($message_key),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    }
                    break;
        
                // Create a Category.
                case 'category' :
                    $category_db = $services['dao.category']->findByTitle($services['post.handler']->getRequestField('title'));
                    $message_key = $services['form.checker']->checkInsertCategory($services['post.handler']->getRequest(), $category_db->getTitle());
            
                    $category = new Category(array(
                        'title' => $services['post.handler']->getRequestField('title'),
                    ));
            
                    if (strcmp($message_key, 'insert_success') === 0) {
                        $services['dao.category']->saveCategory($category);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess($message_key),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError($message_key),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    }
                    break;
        
                // Default case : $_GET['form'] not exists or not corresponding with possible choices.
                default:
                    $domains = array(
                        'message' => $services['message.handler']->getError('404'),
                    );
                    break;
            }
    
            return $domains;
        }
    }
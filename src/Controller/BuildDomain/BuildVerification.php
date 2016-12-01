<?php
    namespace SciMS\Controller\BuildDomain;
    
    use \DateTime;
    use SciMS\Domain\Article;
    use SciMS\Domain\Category;
    use SciMS\Domain\User;

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
            $services['post.handler']->setRequest($_POST);  // Retrieve $_POST.
            $services['get.handler']->setRequest($_GET);    // Retrieve $_GET.
            $services['file.handler']->setRequest($_FILES); // Retrieve $_SESSION.
            $entry_form = $services['get.handler']->getRequestField('form');
            
            switch ($entry_form) {
                // Connection section.
                case 'connection' :
                    $user = $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'));
                    $connection = $services['connection.checker']->checkUpdate($services);

                    if ($connection) {
                        // Create session with session.handler.
                        $services['session.handler']->createSession(array(
                            'user_id'       => $user->getId(),
                            'user_connect'  => true,
                        ));
                        $domains = array(
                            'user'    => $user->setConnect(true),
                            'message' => 'Connection',//$services['message.handler']->getSuccess($message_key),
                        );
                    } else {
                        $domains = array(
                            'message' => 'Not connected.',//$services['message.handler']->getError($message_key),
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
                    
                    $inscription = $services['user.checker']->checkInsert($services);
                    if ($inscription === true)  {
                        $services['dao.user']->saveUser($user);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess('Inscription !'),
                            'user'    => $services['dao.user']->findByUsername($user->getUsername()),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError('Inscription failed'),
                        );
                    }
                    break;
        
                // Disconnection
                case 'disconnection' :
                    $disconnection = $services['connection.checker']->checkDelete($services);
                    if ($disconnection === true) {
                        $services['session.handler']->destroySession();
                    }
                    $domains = array();
                    break;
        
                // Update user.
                case 'update' :
                    // File upload.
                    $services['avatar.upload']->moveFile($services, strtolower($services['post.handler']->getRequestField('username')));
                    $file_extension = $services['avatar.upload']->splitExtensionFile($services['file.handler']->getRequest(), 'avatar');
                    
                    // Check user update.
                    $update = $services['user.checker']->checkUpdate($services);
            
                    $user = $services['dao.user']->findByUsername($services['post.handler']->getRequestField('username'));
                    $user->setUsername($services['post.handler']->getRequestField('username'));
                    $user->setFname($services['post.handler']->getRequestField('fname'));
                    $user->setLname($services['post.handler']->getRequestField('lname'));
                    $user->setBirthday($services['post.handler']->getRequestField('birthday'));
                    $user->setBiography($services['post.handler']->getRequestField('biography'));
                    $user->setAvatar(strtolower($user->getUsername() . $file_extension));
                    
                    if ($update === true)  {
                        $services['dao.user']->updateUser($user);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess('Update !'),
                            'user'    => $services['dao.user']->findByUsername($user->getUsername()),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError('Update failed'),
                            'user'    => $services['dao.user']->findByUsername($user->getUsername()),
                        );
                    }
                    break;
        
                // Write an Article
                case 'write' :
                    $write    = $services['article.checker']->checkInsert($services);
                    $category = $services['dao.category']->findById($services['post.handler']->getRequestField('category'));
                    $user     = $services['dao.user']->findById($services['post.handler']->getRequestField('writter'));
            
                    $article = new Article(array(
                        'title'         => $services['post.handler']->getRequestField('title'),
                        'content'       => $services['post.handler']->getRequestField('content'),
                        'authors'       => $services['post.handler']->getRequestField('authors'),
                        'categories'    => $category,
                        'tags'          => $services['post.handler']->getRequestField('tags'),
                        'status'        => $services['post.handler']->getRequestField('status'),
                        'writter'       => $user,
                    ));
            
                    if ($write === true) {
                        $services['dao.article']->saveArticle($article);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess('Write !'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError('Write failed'),
                            'user'    => $services['dao.user']->findById($services['post.handler']->getRequestField('user_id')),
                        );
                    }
                    break;
        
                // Edit an Article.
                case 'edit' :
                    $edit     = $services['article.checker']->checkUpdate($services);
                    $category = $services['dao.category']->findById($services['post.handler']->getRequestField('category'));
                    $user     = $services['dao.user']->findById($services['post.handler']->getRequestField('writter'));
                    
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
                    
            
                    if ($edit === true) {
                        $services['dao.article']->updateArticle($article);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess('Edition'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError('Edition failed'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    }
                    break;
        
                // Create a Category.
                case 'category' :
                    $insertCategory = $services['category.checker']->checkInsert($services);
                    $category = new Category(array(
                        'title' => $services['post.handler']->getRequestField('title'),
                    ));
            
                    if ($insertCategory === true) {
                        $services['dao.category']->saveCategory($category);
                        $domains = array(
                            'message' => $services['message.handler']->getSuccess('Category added'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        );
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getError('Category already present or invalid'),
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
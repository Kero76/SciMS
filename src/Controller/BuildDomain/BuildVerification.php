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
         * BuildVerification constructor.
         *
         * @constructor
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
            $services['file.handler']->setRequest($_FILES); // Retrieve $_FILES.
    
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
    
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
    
            $entry_form = $services['get.handler']->getRequestField('form');
            switch ($entry_form) {
                // Installation section
                case 'installation' :
                    $database = array(
                        'database' => array(
                            'dns'      => $services['post.handler']->getRequestField('db_dns'),
                            'dbname'   => $services['post.handler']->getRequestField('db_dbname'),
                            'user'     => $services['post.handler']->getRequestField('db_user'),
                            'password' => $services['post.handler']->getRequestField('db_password'),
                        ),
                    );
                    $services['yaml.file']->write($database, '../app/database.yml');
                    
                    // Create an user instance.
                    $user = new User(array(
                        'email'    => $services['post.handler']->getRequestField('admin_email'),
                        'username' => $services['post.handler']->getRequestField('admin_username'),
                        'password' => password_hash($services['post.handler']->getRequestField('admin_password'), PASSWORD_DEFAULT),
                        'role'     => User::ADMINISTRATOR,
                        'connect'  => true,
                    ));
    
                    // Save user on Database
                    $services['dao.user']->saveUser($user);
    
                    // Create session with session.handler.
                    $services['session.handler']->createSession(array(
                        'user_id'      => $services['dao.user']->findByEmail($services['post.handler']->getRequestField('admin_email'))->getId(),
                        'user_connect' => true,
                    ));
    
                    // Redirect user with connection.
                    $url = '/web/index.php?user=' . $services['dao.user']->findByEmail($services['post.handler']->getRequestField('admin_email'))->getId();
                    $services['redirect.handler']->redirect($url);
                    
                    break;
                
                // Connection section.
                case 'connection' :
                    $connection = $services['connection.checker']->checkUpdate($services);

                    if ($connection) {
                        $user = $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'));
                        // Create session with session.handler.
                        $services['session.handler']->createSession(array(
                            'user_id'       => $user->getId(),
                            'user_connect'  => true,
                        ));
                        
                        // Redirect connected user.
                        $url = '/web/index.php?user=' . $user->getId();
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('connection_fail'),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
        
                // Inscription section.
                case 'inscription' :
                    $inscription = $services['user.checker']->checkInsert($services);
                    if ($inscription === true) {
                        // Create an user instance.
                        $user = new User(array(
                            'email'    => $services['post.handler']->getRequestField('email'),
                            'username' => $services['post.handler']->getRequestField('username'),
                            'password' => password_hash($services['post.handler']->getRequestField('password'), PASSWORD_DEFAULT),
                            'role'     => User::WRITTER,
                            'connect'  => true,
                        ));
                        
                        // Save user on Database
                        $services['dao.user']->saveUser($user);
                        
                        // Create session with session.handler.
                        $services['session.handler']->createSession(array(
                            'user_id'      => $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'))->getId(),
                            'user_connect' => true,
                        ));
                        
                        // Redirect user with connection.
                        $url = '/web/index.php?user=' . $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'))->getId();
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('inscription_fail'),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
        
                // Disconnection
                case 'disconnection' :
                    $disconnection = $services['connection.checker']->checkDelete($services);
                    if ($disconnection === true) {
                        $services['session.handler']->destroySession();
                    }
                    $url = '/web/index.php';
                    $services['redirect.handler']->redirect($url);
                    break;
        
                // Update my user profile.
                case 'edit_profile' :
                    $update = $services['user.checker']->checkUpdate($services);
                    if ($update === true)  {
                        // File upload.
                        $services['avatar.upload']->moveFile($services, 'avatar', strtolower($services['post.handler']->getRequestField('username')));
                        $file_extension = $services['avatar.upload']->splitExtensionFile($services['file.handler']->getRequest(), 'avatar');
                        
                        // Create a user instance.
                        $user = $services['dao.user']->findByUsername($services['post.handler']->getRequestField('username'));
                        $user->setUsername($services['post.handler']->getRequestField('username'));
                        $user->setFname($services['post.handler']->getRequestField('fname'));
                        $user->setLname($services['post.handler']->getRequestField('lname'));
                        $user->setBirthday($services['post.handler']->getRequestField('birthday'));
                        $user->setBiography($services['post.handler']->getRequestField('biography'));
                        $user->setAvatar(strtolower($user->getUsername() . $file_extension));
                        
                        $services['dao.user']->updateUser($user);
                        
                        if ($services['get.handler']->requestFieldExist('user_update')) {
                            $url = '/web/index.php?action=consult_profile&id=' . $services['get.handler']->getRequestField('user_update') . '&user=' . $services['session.handler']->getRequestField('user_id');
                        } else {
                            $url = '/web/index.php?action=consult_profile&id=' . $services['session.handler']->getRequestField('user_id') . '&user=' . $services['session.handler']->getRequestField('user_id');
                        }
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('update_failed'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
        
                // Write an Article
                case 'write_article' :
                    $write = $services['article.checker']->checkInsert($services);
                    if ($write === true) {
                        $category = $services['dao.category']->findById($services['post.handler']->getRequestField('category'));
                        $user     = $services['dao.user']->findById($services['post.handler']->getRequestField('writter'));
    
                        $article = new Article(array(
                            'title'             => $services['post.handler']->getRequestField('title'),
                            'abstract'          => $services['post.handler']->getRequestField('abstract'),
                            'content'           => $services['post.handler']->getRequestField('content'),
                            'authors'           => $services['post.handler']->getRequestField('authors'),
                            'categories'        => $category,
                            'tags'              => $services['post.handler']->getRequestField('tags'),
                            'status'            => $services['post.handler']->getRequestField('status'),
                            'writter'           => $user,
                            'displayed_summary' => $services['post.handler']->getRequestField('summary'),
                        ));
                        
                        $services['dao.article']->saveArticle($article);
                        $url = '/web/index.php?action=consult_article&id=' . $services['dao.article']->findLastId() . '&user=' . $services['session.handler']->getRequestField('user_id');
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('write_article_fail'),
                            'user'    => $services['dao.user']->findById($services['post.handler']->getRequestField('user_id')),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
        
                // Edit an Article.
                case 'edit_article' :
                    $edit = $services['article.checker']->checkUpdate($services);
                    if ($edit === true) {
                        $category = $services['dao.category']->findById($services['post.handler']->getRequestField('category'));
                        $user     = $services['dao.user']->findById($services['post.handler']->getRequestField('writter'));
    
                        $date = new DateTime();
                        $article = new Article(array(
                            'id'                => $services['post.handler']->getRequestField('article_id'),
                            'title'             => $services['post.handler']->getRequestField('title'),
                            'abstract'          => $services['post.handler']->getRequestField('abstract'),
                            'content'           => $services['post.handler']->getRequestField('content'),
                            'authors'           => $services['post.handler']->getRequestField('authors'),
                            'categories'        => $category,
                            'tags'              => $services['post.handler']->getRequestField('tags'),
                            'status'            => $services['post.handler']->getRequestField('status'),
                            'date_modified'     => $date->format("Y-m-d H:i:s"),
                            'writter'           => $user,
                            'displayed_summary' => $services['post.handler']->getRequestField('summary'),
                        ));
    
                        $services['dao.article']->updateArticle($article);
                        $url = '/web/index.php?action=consult_article&id=' . $article->getId() . '&user=' . $services['session.handler']->getRequestField('user_id');
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('update_article_fail'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
                
                // Delete an Article
                case 'delete_article' :
                    $services['dao.article']->deleteArticle($services['get.handler']->getRequestField('article'));
                    $url = '/web/index.php?action=administration&user=' . $services['session.handler']->getRequestField('user_id');
                    $services['redirect.handler']->redirect($url);
                    break;
    
                // Create a Category.
                case 'add_category' :
                    $insertCategory = $services['category.checker']->checkInsert($services);
                    if ($insertCategory === true) {
                        $category = new Category(array(
                            'title' => $services['post.handler']->getRequestField('title'),
                        ));
                        
                        $services['dao.category']->saveCategory($category);
                        $url = '/web/index.php?action=administration&user=' . $services['session.handler']->getRequestField('user_id');
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('category_fail'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
                
                // Edit a Category
                case 'edit_category' :
                    $edit = $services['category.checker']->checkUpdate($services);
                    if ($edit === true) {
                        $category = new Category(array(
                            'id'    => $services['post.handler']->getRequestField('category_id'),
                            'title' => $services['post.handler']->getRequestField('title'),
                        ));
        
                        $services['dao.category']->updateCategory($category);
                        $url = '/web/index.php?action=administration&user=' . $services['session.handler']->getRequestField('user_id');
                        $services['redirect.handler']->redirect($url);
                    } else {
                        $domains = array(
                            'message' => $services['message.handler']->getMessage('update_article_fail'),
                            'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                            'website' => $website,
                            'theme'   => $theme,
                        );
                    }
                    break;
    
                // Delete a Category
                case 'delete_category' :
                    $services['dao.category']->deleteCategory($services['get.handler']->getRequestField('category'));
                    $url = '/web/index.php?action=administration&user=' . $services['session.handler']->getRequestField('user_id');
                    $services['redirect.handler']->redirect($url);
                    break;
                
                // Delete an User
                case 'delete_user' :
                    $services['dao.user']->deleteUser($services['get.handler']->getRequestField('user_delete'));
                    $url = '/web/index.php?action=administration&user=' . $services['session.handler']->getRequestField('user_id');
                    $services['redirect.handler']->redirect($url);
                    break;
                
                // Default case : $_GET['form'] not exists or not corresponding with possible choices.
                default:
                    $domains = array(
                        'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        'message' => $services['message.handler']->getMessage('404'),
                        'website' => $website,
                        'theme'   => $theme,
                    );
                    break;
            }
    
            return $domains;
        }
    }

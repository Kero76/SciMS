<?php
    namespace SciMS\Controller\BuildDomain;
    
    use \SciMS\Database\DatabaseSetting;
    use \SciMS\Domain\Theme;
    use \SciMS\Domain\Website;

    /**
     * Class BuildHome
     *
     * This class build domain objects present on Home page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildHome extends AbstractBuildDomain  {
    
        /**
         * BuildHome constructor.
         *
         * -> V1.1 :
         *  - Added redirect when the file database.yml not exist because
         * the website is not installed on server and the configurations are
         * required to interact with database and created the admin user.
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
         * -> V1.1 :
         *  - Add redirect when website not configurate.
         *
         * @param array $services
         *  Return services.
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since   SciMS 0.3
         * @version 1.1
         */
        public function buildDomain(array $services) {
            // Check if the database file not exist on server, and if not exist redirect the user on the installation page.
            if (!$services['file.checker']->fileExist(DatabaseSetting::DB_SETTING_PATH)) {
                $url = '/web/index.php?action=installation';
                $services['redirect.handler']->redirect($url);
            }
            
            $website = $services['dao.website']->findSettings(Website::WEBSITE_SETTING_PATH);
            $themes  = $services['dao.theme']->findSettings(Theme::THEMES_SETTING_PATH);
            $theme   = "";
            
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
            
            if ($services['session.handler']->requestFieldExist('user_id')) {
                $domains = array(
                    'last_articles'         => $services['dao.article']->findLastArticle($website->getLastArticle()),
                    'user'                  => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'connect'               => true,
                    'website'               => $website,
                    'theme'                 => $theme,
                    'categories'            => $services['dao.category']->findAll(),
                );
            } else {
                $domains = array(
                    'last_articles'         => $services['dao.article']->findLastArticle($website->getLastArticle()),
                    'website'               => $website,
                    'categories'            => $services['dao.category']->findAll(),
                    'theme'                 => $theme,
                );
            }
    
            return $domains;
        }
    }

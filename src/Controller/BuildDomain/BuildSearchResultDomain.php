<?php
    namespace SciMS\Controller\BuildDomain;

    /**
     * Class BuildSearchResultDomain.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.4
     * @version 1.0
     */
    class BuildSearchResultDomain extends AbstractBuildDomain {
    
        /**
         * SearchResultDomain constructor.
         *
         * @constructor
         * @param $template
         *  Name of the template.
         * @since SciMS 0.4
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
            
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
    
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
    
            // If search-field exists, so search result on Database.
            if ($services['post.handler']->requestFieldExist('search-field') === true && $services['post.handler']->getRequestField('search-field') != '') {
                if ($services['session.handler']->requestFieldExist('user_id')) {
                    $domains = array(
                        'articles' => $services['dao.article']->findByResearch($services['post.handler']->getRequestField('search-field')),
                        'user'     => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        'connect'  => true,
                        'website' => $website,
                        'theme'   => $theme,
                    );
                } else {
                    $domains = array(
                        'articles' => $services['dao.article']->findByResearch($services['post.handler']->getRequestField('search-field')),
                        'website' => $website,
                        'theme'   => $theme,
                    );
                }
            } else {
                if ($services['session.handler']->requestFieldExist('user_id')) {
                    $domains = array(
                        'message' => $services['message.handler']->getMessage('research_fail'),
                        'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                        'connect' => true,
                        'website' => $website,
                        'theme'   => $theme,
                    );
                } else {
                    $domains = array(
                        'message' => $services['message.handler']->getMessage('research_fail'),
                        'website' => $website,
                        'theme'   => $theme,
                    );
                }
            }
            
            return $domains;
        }
    }

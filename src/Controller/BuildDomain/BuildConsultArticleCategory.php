<?php
    namespace SciMS\Controller\BuildDomain;

    /**
     * Class BuildConsultArticleCategory.
     *
     * This class build domain objects present on article by category page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.5
     * @version 1.0
     */
    class BuildConsultArticleCategory extends AbstractBuildDomain {
    
        /**
         * BuildConsultArticleCategory constructor.
         *
         * @constructor
         * @param $template
         *  Name of the template.
         * @since SciMS 0.5
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
         * @since   SciMS 0.5
         * @version 1.0
         */
        public function buildDomain(array $services) {
            $services['get.handler']->setRequest($_GET); // Retrieve $_GET.
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
    
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
    
            $writter = $services['dao.user']->findById($services['get.handler']->getRequestField('id'));
            if ($services['session.handler']->requestFieldExist('user_id')) {
                $domains = array(
                    'writter'    => $writter,
                    'user'       => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'articles'   => $services['dao.article']->findByCategories($services['get.handler']->getRequestField('id')),
                    'category'   => $services['dao.category']->findById($services['get.handler']->getRequestField('id')),
                    'connect'    => true,
                    'categories' => $services['dao.category']->findAll(),
                    'website'    => $website,
                    'theme'      => $theme,
                );
            } else {
                $domains = array(
                    'writter'    => $writter,
                    'articles'   => $services['dao.article']->findByCategories($services['get.handler']->getRequestField('id')),
                    'categories' => $services['dao.category']->findAll(),
                    'website'    => $website,
                    'theme'      => $theme,
                );
            }
            
            return $domains;
        }
    }

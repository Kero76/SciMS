<?php
    /**
     * Created by PhpStorm.
     * User: Kero76
     * Date: 19/12/16
     * Time: 17:06
     */
    
    namespace SciMS\Controller\BuildDomain\Administration;
    
    
    use SciMS\Controller\BuildDomain\AbstractBuildDomain;

    class BuildCategories extends AbstractBuildDomain {
    
        /**
         * BuildDomainArticles constructor.
         *
         * @constructor
         * @param $template
         *  Name of the template.
         * @since   SciMS 0.5
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
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
        
            foreach ($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
        
            if ($services['session.handler']->requestFieldExist('user_id')) {
                $domains = array(
                    'categories' => $services['dao.category']->findAll(),
                    'user'       => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'connect'    => true,
                    'website'    => $website,
                    'theme'      => $theme,
                );
            } else {
                $domains = array(
                    'categories' => $services['dao.category']->findAll(),
                    'website'    => $website,
                    'theme'      => $theme,
                );
            }
        
            return $domains;
        }
    }

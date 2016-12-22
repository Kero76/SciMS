<?php
    namespace SciMS\Controller\BuildDomain;
    
    use \SciMS\Domain\Theme;
    use \SciMS\Domain\Website;

    /**
     * Class Build404.
     *
     * This class build domain objects present on 404 page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class Build404 extends AbstractBuildDomain {
    
        /**
         * Build404 constructor.
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
            $website = $services['dao.website']->findSettings(Website::WEBSITE_SETTING_PATH);
            $themes  = $services['dao.theme']->findSettings(Theme::THEMES_SETTING_PATH);
            $theme   = "";
    
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
    
            if (($services['session.handler']->requestFieldExist('user_id'))) {
                $domains = array(
                    'message'    => $services['message.handler']->getMessage('404'),
                    'user'       => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'connect'    => true,
                    'categories' => $services['dao.category']->findAll(),
                    'website'    => $website,
                    'theme'      => $theme,
                );
            } else {
                $domains = array(
                    'message'    => $services['message.handler']->getMessage('404'),
                    'categories' => $services['dao.category']->findAll(),
                    'website'    => $website,
                    'theme'      => $theme,
                );
            }
            
            return $domains;
        }
    }

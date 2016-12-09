<?php
    namespace SciMS\Controller\BuildDomain;

    /**
     * Class BuildConsultProfile.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.4
     * @version 1.0
     */
    class BuildConsultProfile extends AbstractBuildDomain {
    
        /**
         * BuildConsultProfile constructor.
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
         *
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function buildDomain(array $services) {
            $services['get.handler']->setRequest($_GET); // Retrieve $_GET.
    
            $writter = $services['dao.user']->findById($services['get.handler']->getRequestField('id'));
            if ($services['session.handler']->requestFieldExist('user_id')) {
                $domains = array(
                    'writter'  => $writter,
                    'user'     => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'articles' => $services['dao.article']->findByOwnership($writter->getId()),
                    'connect'  => true,
                    'website'  => $services['dao.website']->findSettings('../app/settings.yml'),
                );
            } else {
                $domains = array(
                    'writter' => $writter,
                    'articles' => $services['dao.article']->findByOwnership($writter->getId()),
                    'website'  => $services['dao.website']->findSettings('../app/settings.yml'),
                );
            }
            return $domains;
        }
    }
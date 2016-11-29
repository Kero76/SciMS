<?php
    namespace SciMS\Controller\BuildDomain;

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
            if (($services['session.handler']->requestFieldExist('user_id'))) {
                $domains = array(
                    'message' => $services['message.handler']->getError('404'),
                    'user'    => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'connect' => true,
                );
            } else {
                $domains = array(
                    'message' => $services['message.handler']->getError('404'),
                );
            }
            return $domains;
        }
    }
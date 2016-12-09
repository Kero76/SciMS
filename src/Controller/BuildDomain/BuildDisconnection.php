<?php
    namespace SciMS\Controller\BuildDomain;

    use \SciMS\Form\Input\InputSubmit;

    /**
     * Class BuildDisconnection
     *
     * This class build domain objects present on Disconnection page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildDisconnection extends AbstractBuildDomain {
    
        /**
         * BuildDisconnection constructor.
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
            $domains = array(
                'forms' => $services['form.builder']->add(
                    new InputSubmit(array(
                        'type'          => 'submit',
                        'id'            => 'submit',
                        'name'          => 'submit',
                        'value'         => 'Sign out',
                        'class'         => 'form-control btn btn-primary',
                    ))
                )->getForms(),
                'website' => $services['dao.website']->findSettings('../app/settings.yml'),
            );
    
            return $domains;
        }
    }
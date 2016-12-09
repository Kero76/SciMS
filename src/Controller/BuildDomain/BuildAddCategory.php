<?php
    namespace SciMS\Controller\BuildDomain;
    
    use \SciMS\Form\Input\InputSubmit;
    use \SciMS\Form\Input\InputText;
    
    /**
     * Class BuildAddCategory.
     *
     * This class build domain objects present on Add Category page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildAddCategory extends AbstractBuildDomain {
    
        /**
         * BuildAddCategory constructor.
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
            $user    = $services['dao.user']->findById($services['session.handler']->getRequestField('user_id'));
            $domains = array(
                'forms' => $services['form.builder']->add(
                // Title
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'title',
                        'name'  => 'title',
                        'class' => 'form-control',
                        'label' => 'Title',
                    ))
                )->add(
                // Submit
                    new InputSubmit(array(
                        'type'  => 'submit',
                        'id'    => 'submit',
                        'name'  => 'submit',
                        'class' => 'form-control btn btn-primary',
                        'value' => 'Submit',
                    ))
                )->getForms(),
                'user'       => $user,
                'connect'    => true,
                'website' => $services['dao.website']->findSettings('../app/settings.yml'),
            );
    
            return $domains;
        }
    }
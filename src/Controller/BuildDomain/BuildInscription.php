<?php
    namespace SciMS\Controller\BuildDomain;

    use \SciMS\Form\Input\InputEmail;
    use \SciMS\Form\Input\InputPassword;
    use \SciMS\Form\Input\InputSubmit;
    use \SciMS\Form\Input\InputText;

    /**
     * Class BuildInscription
     *
     * This class build domain objects present on Inscription page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildInscription extends AbstractBuildDomain {
    
        /**
         * BuildInscription constructor.
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
                    new InputEmail(array(
                        'type'          => 'email',
                        'id'            => 'email',
                        'name'          => 'email',
                        'placeholder'   => 'Enter your email ...',
                        'class'         => 'form-control',
                        'required'      => true,
                        'label'         => 'Email',
                    ))
                )->add(
                    new InputText(array(
                        'type'          => 'text',
                        'id'            => 'username',
                        'name'          => 'username',
                        'placeholder'   => 'Enter your username ...',
                        'class'         => 'form-control',
                        'required'      => true,
                        'label'         => 'Username',
                    ))
                )->add( new InputPassword(array(
                        'type'          => 'password',
                        'id'            => 'password',
                        'name'          => 'password',
                        'placeholder'   => 'Enter your password ...',
                        'class'         => 'form-control',
                        'required'      => true,
                        'label'         => 'Password',
                    ))
                )->add(
                    new InputSubmit(array(
                        'type'          => 'submit',
                        'id'            => 'submit',
                        'name'          => 'submit',
                        'value'         => 'Sign in',
                        'class'         => 'form-control btn btn-primary',
                    ))
                )->getForms(),
                'website' => $services['dao.website']->findSettings('../app/settings.yml'),
            );
            
            return $domains;
        }
    }
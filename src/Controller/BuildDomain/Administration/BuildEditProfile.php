<?php
    namespace SciMS\Controller\BuildDomain\Administration;

    use \SciMS\Controller\BuildDomain\AbstractBuildDomain;
    use \SciMS\Form\Input;
    use \SciMS\Form\TextArea;

    /**
     * Class BuildEditProfile.
     *
     * This class build domain objects present on Account page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildEditProfile extends AbstractBuildDomain {
    
        /**
         * BuildEditProfile constructor.
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
            
            if ($services['get.handler']->requestFieldExist('user_update')) {
                $user = $services['dao.user']->findById($services['get.handler']->getRequestField('user_update'));
            } else {
                $user = $services['dao.user']->findById($services['session.handler']->getRequestField('user_id'));
            }
    
            $domains = array(
                'forms' => $services['form.builder']->add(
                // Username
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'username',
                        'name'     => 'username',
                        'value'    => $user->getUsername(),
                        'class'    => 'form-control',
                        'label'    => 'Username',
                        'readonly' => false,
                    ))
                )->add(
                // First name
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'fname',
                        'name'     => 'fname',
                        'value'    => $user->getFname(),
                        'class'    => 'form-control',
                        'label'    => 'First name',
                        'readonly' => false,
                        'required' => false,
                    ))
                )->add(
                // Last name
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'lname',
                        'name'     => 'lname',
                        'value'    => $user->getLname(),
                        'class'    => 'form-control',
                        'label'    => 'Last name',
                        'readonly' => false,
                        'required' => false,
                    ))
                )->add(
                // Email - readonly.
                    new Input(array(
                        'type'     => 'email',
                        'value'    => $user->getEmail(),
                        'class'    => 'form-control',
                        'label'    => 'Email',
                        'readonly' => true,
                    ))
                )->add(
                // Password
                    new Input(array(
                        'type'     => 'password',
                        'id'       => 'password',
                        'name'     => 'password',
                        'class'    => 'form-control',
                        'label'    => 'New Password',
                        'readonly' => false,
                        'required' => false,
                    ))
                )->add(
                // Repeat Password
                    new Input(array(
                        'type'     => 'password',
                        'id'       => 'repeat_password',
                        'name'     => 'repeat_password',
                        'class'    => 'form-control',
                        'label'    => 'Repeat Password',
                        'readonly' => false,
                        'required' => false,
                    ))
                )->add(
                // Birthday
                    new Input(array(
                        'type'     => 'date',
                        'id'       => 'birthday',
                        'name'     => 'birthday',
                        'class'    => 'form-control',
                        'label'    => 'Birthday',
                        'value'    => $user->getBirthday(),
                        'required' => false,
                        'readonly' => false,
                    ))
                )->add(
                // Biography
                    new TextArea(array(
                        'id'        => 'biography',
                        'name'      => 'biography',
                        'class'     => 'form-control',
                        'label'     => 'Biography',
                        'content'   => $user->getBiography(),
                        'rows'      => '10',
                        'cols'      => '50',
                        'required'  => false,
                    ))
                )->add(
                // Avatar
                    new Input(array(
                        'type'     => 'file',
                        'id'       => 'avatar',
                        'name'     => 'avatar',
                        'label'    => 'Avatar',
                        'required' => false,
                    ))
                )->add(
                // Submit button
                    new Input(array(
                        'type'     => 'submit',
                        'id'       => 'submit',
                        'name'     => 'submit',
                        'value'    => 'Submit',
                        'class'    => 'form-control btn btn-primary',
                        'readonly' => false,
                    ))
                )->getForms(),
                'user'       => $user,
                'user_id'    => $services['session.handler']->getRequestField('user_id'),
                'categories' => $services['dao.category']->findAll(),
                'connect'    => true,
                'website'    => $website,
                'theme'      => $theme,
            );
            
            return $domains;
        }
    }

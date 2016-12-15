<?php
    namespace SciMS\Controller\BuildDomain;
    
    use \SciMS\Form\Input\InputDate;
    use \SciMS\Form\Input\InputEmail;
    use \SciMS\Form\Input\InputFile;
    use \SciMS\Form\Input\InputHidden;
    use \SciMS\Form\Input\InputPassword;
    use \SciMS\Form\Input\InputSubmit;
    use \SciMS\Form\Input\InputText;
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
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
    
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
    
            $user = $services['dao.user']->findById($services['session.handler']->getRequestField('user_id'));
            $domains = array(
                'forms' => $services['form.builder']->add(
                // Username
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'username',
                        'name'  => 'username',
                        'value' => $user->getUsername(),
                        'class' => 'form-control',
                        'label' => 'Username',
                    ))
                )->add(
                // First name
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'fname',
                        'name'  => 'fname',
                        'value' => $user->getFname(),
                        'class' => 'form-control',
                        'label' => 'First name',
                    ))
                )->add(
                // Last name
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'lname',
                        'name'  => 'lname',
                        'value' => $user->getLname(),
                        'class' => 'form-control',
                        'label' => 'Last name',
                    ))
                )->add(
                // Email - readonly.
                    new InputEmail(array(
                        'type'      => 'email',
                        'value'     => $user->getEmail(),
                        'class' => 'form-control',
                        'label' => 'Email',
                        'readonly'  => true,
                    ))
                )->add(
                // Password
                    new InputPassword(array(
                        'type'  => 'password',
                        'id'    => 'password',
                        'name'  => 'password',
                        'class' => 'form-control',
                        'label' => 'New Password',
                    ))
                )->add(
                // Repeat Password
                    new InputPassword(array(
                        'type'  => 'password',
                        'id'    => 'repeat_password',
                        'name'  => 'repeat_password',
                        'class' => 'form-control',
                        'label' => 'Repeat Password',
                    ))
                )->add(
                // Birthday
                    new InputDate(array(
                        'type'  => 'date',
                        'id'    => 'birthday',
                        'name'  => 'birthday',
                        'class' => 'form-control',
                        'label' => 'Birthday',
                        'value' => $user->getBirthday(),
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
                    ))
                )->add(
                // Avatar
                    new InputFile(array(
                        'type'  => 'file',
                        'id'    => 'avatar',
                        'name'  => 'avatar',
                        'label' => 'Avatar',
                    ))
                )->add(
                // Max size of file
                    new InputHidden(array(
                        'type'  => 'hidden',
                        'name'  => 'max_size_file',
                        'value' => '',
                    ))
                )->add(
                // Submit button
                    new InputSubmit(array(
                        'type'  => 'submit',
                        'id'    => 'submit',
                        'name'  => 'submit',
                        'value' => 'Submit',
                        'class' => 'form-control btn btn-primary',
                    ))
                )->getForms(),
                'user'     => $user,
                'connect'  => true,
                'website'  => $website,
                'theme'    => $theme,
            );
            
            return $domains;
        }
    }

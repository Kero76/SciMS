<?php
    namespace SciMS\Controller\BuildDomain\Administration;
    
    use \SciMS\Controller\BuildDomain\AbstractBuildDomain;
    use \SciMS\Domain\Theme;
    use \SciMS\Domain\Website;
    use \SciMS\Form\Input;

    /**
     * Class BuildInstallation.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain\Administration
     * @since SciMS 0.5
     * @version 1.0
     */
    class BuildInstallation extends AbstractBuildDomain {
    
        /**
         * BuildInstallation constructor.
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
         *
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function buildDomain(array $services) {
            $website = $services['dao.website']->findSettings(Website::WEBSITE_SETTING_PATH);
            $themes  = $services['dao.theme']->findSettings(Theme::THEMES_SETTING_PATH);
            $theme   = "";
    
            foreach ($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
    
            $domains = array(
                // Database form
                'db_form' => $services['form.builder']->add(
                // Dns
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'db_dns',
                        'name'     => 'db_dns',
                        'class'    => 'form-control',
                        'label'    => 'DNS',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->add(
                // Database Name
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'db_dbname',
                        'name'     => 'db_dbname',
                        'class'    => 'form-control',
                        'label'    => 'Database name',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->add(
                // User
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'db_user',
                        'name'     => 'db_user',
                        'class'    => 'form-control',
                        'label'    => 'Database User',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->add(
                // Password
                    new Input(array(
                        'type'     => 'password',
                        'id'       => 'db_password',
                        'name'     => 'db_password',
                        'class'    => 'form-control',
                        'label'    => 'Database Password',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->getForms(),

                // Administrator form
                'admin_form' => $services['form.builder']->reset()->add(
                // Admin email
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'admin_email',
                        'name'     => 'admin_email',
                        'class'    => 'form-control',
                        'label'    => 'Admin Email',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->add(
                // Admin username
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'admin_username',
                        'name'     => 'admin_username',
                        'class'    => 'form-control',
                        'label'    => 'Admin username',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->add(
                // Admin password
                    new Input(array(
                        'type'     => 'password',
                        'id'       => 'admin_password',
                        'name'     => 'admin_password',
                        'class'    => 'form-control',
                        'label'    => 'Admin password',
                        'readonly' => false,
                        'required' => true,
                    ))
                )->add(
                // Submit
                    new Input(array(
                        'type'     => 'submit',
                        'id'       => 'admin_submit',
                        'name'     => 'admin_submit',
                        'class'    => 'form-control btn btn-primary',
                        'value'    => 'Submit',
                        'readonly' => false,
                    ))
                )->getForms(),
                'website' => $website,
                'theme'   => $theme,
            );
            
            return $domains;
        }
    }

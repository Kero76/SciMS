<?php
    namespace SciMS\Controller\BuildDomain\Administration;
    
    use SciMS\Controller\BuildDomain\AbstractBuildDomain;
    use \SciMS\Form\Input;

    /**
     * Class BuildEditCategory.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain\Administration
     * @since SciMS 0.5
     * @version 1.0
     */
    class BuildEditCategory extends AbstractBuildDomain {
    
        /**
         * BuildEditCategory constructor.
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
            $services['get.handler']->setRequest($_GET);         // Retrieve $_GET.
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
        
            foreach($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
        
            $category = $services['dao.category']->findById($services['get.handler']->getRequestField('category'));
            $user     = $services['dao.user']->findById($services['session.handler']->getRequestField('user_id'));
            $domains  = array(
                'forms' => $services['form.builder']->add(
                // Title
                    new Input(array(
                        'type'     => 'text',
                        'id'       => 'title',
                        'name'     => 'title',
                        'class'    => 'form-control',
                        'label'    => 'Title',
                        'value'    => $category->getTitle(),
                        'readonly' => false,
                    ))
                )->add(
                // Submit
                    new Input(array(
                        'type'     => 'submit',
                        'id'       => 'submit',
                        'name'     => 'submit',
                        'class'    => 'form-control btn btn-primary',
                        'value'    => 'Submit',
                        'readonly' => false,
                    ))
                )->add(
                    new Input(array(
                        'type'  => 'hidden',
                        'id'    => 'category_id',
                        'name'  => 'category_id',
                        'value' => $services['get.handler']->getRequestField('category'),
                    ))
                )->getForms(),
                'user'        => $user,
                'connect'     => true,
                'category_id' => true,
                'website'     => $website,
                'theme'       => $theme,
            );
        
            return $domains;
        }
    }

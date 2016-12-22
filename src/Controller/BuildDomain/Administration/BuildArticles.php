<?php
    namespace SciMS\Controller\BuildDomain\Administration;
    
    use SciMS\Controller\BuildDomain\AbstractBuildDomain;
    use SciMS\Domain\User;

    /**
     * Class BuildDomainArticles.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain\Administration
     * @since SciMS 0.5
     * @version 1.0
     */
    class BuildArticles extends AbstractBuildDomain {
    
        /**
         * BuildDomainArticles constructor.
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
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since   SciMS 0.5
         * @version 1.0
         */
        public function buildDomain(array $services) {
            $website = $services['dao.website']->findSettings('../app/settings.yml');
            $themes  = $services['dao.theme']->findSettings('../app/themes.yml');
            $theme   = "";
        
            foreach ($themes as $t) {
                if (strtolower($t->getName()) === strtolower($website->getTheme())) {
                    $theme = $t;
                    break;
                }
            }
            
            $user = $services['dao.user']->findById($services['session.handler']->getRequestField('user_id'));
            if ($services['session.handler']->requestFieldExist('user_id')) {
                // If user is an administrator, so it retrieve all articles.
                if ($user->getRole() == User::ADMINISTRATOR) {
                    $articles = $services['dao.article']->findAll();
                } else {
                    $articles = $services['dao.article']->findByOwnership($user->getId());
                }
                
                $domains = array(
                    'articles'   => $articles,
                    'categories' => $services['dao.category']->findAll(),
                    'user'       => $services['dao.user']->findById($services['session.handler']->getRequestField('user_id')),
                    'connect'    => true,
                    'website'    => $website,
                    'theme'      => $theme,
                );
            } else {
                $domains = array(
                    'articles'   => $services['dao.article']->findAll(),
                    'categories' => $services['dao.category']->findAll(),
                    'website'    => $website,
                    'theme'      => $theme,
                );
            }
        
            return $domains;
        }
    }


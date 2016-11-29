<?php
    namespace SciMS\Controller\BuildDomain;

    /**
     * Interface BuildDomain.
     *
     * This interface at implements when you would add a new view at the website.
     * This interface implements 2 methods use to return the template name and the domains
     * build in function of the view.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    interface BuildDomain {
    
        /**
         * Method use for create domains array use to render the view.
         *
         * @param array $services
         *  Return services.
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function buildDomain(array $services);
    
        /**
         * Return the name of the template.
         *
         * @return string
         *  The name of the template.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getTemplateName();
    
    
        /**
         * Set the name of the template.
         *
         * @param $template
         *  The name of the template.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setTemplateName($template);
    }
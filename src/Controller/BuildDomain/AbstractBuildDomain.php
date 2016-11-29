<?php
    namespace SciMS\Controller\BuildDomain;

    /**
     * Class AbstractBuildDomain.
     *
     * This abstract class implements BuildDomain.
     * This class must extends if you would add new template on the website.
     * In fact, it write the methods getTemplateName and setTemplateName for all child of this class.
     * So, when you extends this class, only the method BuildDomain is at override.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    abstract class AbstractBuildDomain implements BuildDomain {
    
        /**
         * The name of the Template.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_template;
        
        /**
         * Return the name of the template.
         *
         * @return string
         *  The name of the template.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getTemplateName() {
            return $this->_template;
        }
    
        /**
         * Set the name of the template.
         *
         * @param $template
         *  The name of the template.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setTemplateName($template) {
            $this->_template = $template;
        }
    }
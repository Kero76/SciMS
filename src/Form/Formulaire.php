<?php
    namespace SciMS\Form;

    /**
     * Class Formulaire.
     *
     * This class is a root of form element.
     * It's a represent of the <form>
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.1
     * @version 1.0
     */
    class Formulaire extends Form {
    
        /**
         * The attribute action.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_action;
    
        /**
         * The attribute method.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_method;
    
        /**
         * The attribute enctype.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_enctype;
        
        /**
         * Formulaire constructor.
         *
         * @constructor
         * @param array $data
         *  An array with all data using to hydrate Formulaire object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
        
        /**
         * Return the value of the attribute action.
         *
         * @return string
         *  The content of the attribute action.
         */
        public function getAction() {
            return $this->_action;
        }
    
        /**
         * Set the value of the attribute action.
         *
         * @param string $action
         *  The value of the action attribute.
         */
        public function setAction($action) {
            $this->_action = $action;
        }
    
        /**
         * Return the content of the attribute method.
         *
         * @return string
         *  The content of the attributes method.
         */
        public function getMethod() {
            return $this->_method;
        }
    
        /**
         * Set the value of the attributes method.
         *
         * @param string $method
         *  The value of the attributes method.
         */
        public function setMethod($method) {
            $this->_method = $method;
        }
    
        /**
         * Return the enctype of the object.
         *
         * @return string
         *  The value of the attribute enctype.
         */
        public function getEnctype() {
            return $this->_enctype;
        }
    
        /**
         * Set the enctype of the Formulaire.
         *
         * @param string $enctype
         *  The value of attributes enctype.
         */
        public function setEnctype($enctype) {
            $this->_enctype = $enctype;
        }
        
        /**
         * Return the HTML representation of the object Form.
         *
         * @return string
         *  Return the HTML string represent of the object Form.
         * @since   SciMS 0.1
         * @version 1.0
         */
        public function initialTag() {
            return "<form id=\"" . $this->getId() . " class=\"" . $this->getClass() . " action=\"" . $this->_action . "\" method=\"" . $this->_method . "\" enctype=\"" . $this->_enctype . "\">";
        }
        
        /**
         * Return the last HTML tag of the object Form.
         *
         * @return string
         *  Return the HTML string representation of the end HTML tag of the object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function lastTag() {
            return "</form>";
        }
    }
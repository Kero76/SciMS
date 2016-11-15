<?php

    namespace SciMS\Form;

    /**
     * Class AbstractForm.
     *
     * Abstract class which represent all Form element use in form.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.1
     * @version 1.0
     */
    abstract class AbstractForm {
    
        /**
         * Id use to qualify Form object.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_id;
    
        /**
         * Name use to qualify Form object.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_name;
    
        /**
         * All classes use to qualify Form object.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_class;
    
        /**
         * A boolean to check if the form element is necessary before sending informations.
         *
         * @var boolean
         * @since SciMS 0.1
         */
        private $_required;
    
        /**
         * Value of placeholder tags.
         *
         * @var boolean
         * @since SciMS 0.1
         */
        private $_placeholder;
    
        /**
         * Return the id of the object Form.
         *
         * @return string
         *  The id of the object Form.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getId() {
            return $this->_id;
        }
    
        /**
         * Set the id of the Form object.
         *
         * @param string $id
         *  The id of the object Form.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setId($id) {
            $this->_id = $id;
        }
    
        /**
         * Return the name of the Form object.
         *
         * @return string
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getName() {
            return $this->_name;
        }
    
        /**
         * Set the name of the Form object.
         *
         * @param string $name
         *  Set the name of the Form object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setName($name) {
            $this->_name = $name;
        }
    
        /**
         * Return the classes apply to the object Form.
         *
         * @return string
         *  Return the class apply to the Form object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getClass() {
            return $this->_class;
        }
    
        /**
         * Set the classes apply to the object Form.
         *
         * @param string $class
         *  Class apply to the Form object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setClass($class) {
            $this->_class = $class;
        }
    
        /**
         * Return the value of required tags.
         *
         * @return boolean
         *  Return the value of required tags.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getRequired() {
            return $this->_required;
        }
    
        /**
         * Set the value of required tags.
         *
         * @param boolean $required
         *  Set the value of required tags.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setRequired($required) {
            $this->_required = $required;
        }
    
        /**
         * Return the value of placeholder.
         *
         * @return string
         *  Return the value of placeholder.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getPlaceholder() {
            return $this->_placeholder;
        }
    
        /**
         * Set the value of placeholder tag.
         *
         * @param string $placeholder
         *  Set the value of placeholder tag.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setPlaceholder($placeholder) {
            $this->_placeholder = $placeholder;
        }
        
        /**
         * Method use for hydrate object directly thanks the data from an array.
         *
         * @access protected
         * @param array $data
         *  An array with all data from the Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        protected function _hydrate(array $data) {
            foreach($data as $key => $value) {
                $method = 'set';
                $keySplit = explode("_", $key); // split key name if contains XXX_XXX_XXX
                for ($i = 0; $i < count($keySplit); $i++ ) {
                    $method .= ucfirst($keySplit[$i]); // Replace first characters of each word in uppercase form.
                }
                // Execute method if exists on is object.
                if(method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }
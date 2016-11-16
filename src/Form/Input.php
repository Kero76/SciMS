<?php
    
    namespace SciMS\Form;

    /**
     * Class Input.
     *
     * Abstract class which represent all input element use in form.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.2
     * @version 1.0
     */
    abstract class Input extends AbstractForm {
    
        /**
         * Type of Input Form.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_type;
    
        /**
         * Value of Input Form.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_value;
    
        /**
         * Return the type attribute of Input Form.
         *
         * @return string
         *  Return the type of the input.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getType() {
            return $this->_type;
        }
    
        /**
         * Set the value of attribute type.
         *
         * @param string $type
         *  The value of type attribute.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function setType($type) {
            $this->_type = $type;
        }
    
        /**
         * Return the value of attribute value.
         *
         * @return string
         *  Return the value of attribute value.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getValue() {
            return $this->_value;
        }
    
        /**
         * Set the attribute value.
         *
         * @param string $value
         *  Set the attribute value.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function setValue($value) {
            $this->_value = $value;
        }
        
        
    }
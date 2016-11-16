<?php
    
    namespace SciMS\Form;

    /**
     * Class Input.
     *
     * Abstract class which represent all input element use in form.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.1
     * @version 1.0
     */
    abstract class Input extends AbstractForm {
        
        /**
         * Type of Input Form.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_type;
    
        /**
         * Return the type attribute of Input Form.
         *
         * @return string
         *  Return the type of the input.
         * @since SciMS 0.1
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
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setType($type) {
            $this->_type = $type;
        }
    }
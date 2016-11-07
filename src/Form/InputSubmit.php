<?php
    namespace SciMS\Form;
    
    /**
     * Class Input.
     *
     * This class is a representation of the tag <input>.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.1
     * @version 1.0
     */
    class InputSubmit extends Input {
    
        /**
         * Content of the attributes value.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_value;
        
        /**
         * InputReset constructor.
         *
         * @constructor
         * @param array $data
         *  Data use to hydrate object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
        
        /**
         * Return the content of the value attribute.
         *
         * @return string
         *  Return the content of thevalue attribute.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getValue() {
            return $this->_value;
        }
        
        /**
         * Set the content of the value attribute.
         *
         * @param string $value
         *  Set the value of the attribute value.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setValue($value) {
            $this->_value = $value;
        }
        
        /**
         * Return the start HTML representation of the object Form.
         *
         * @return string
         *  Return the HTML string representation of the start html tag of the object Form.
         * @since   SciMS 0.1
         * @version 1.0
         */
        function initialTag() {
            return "<input type=\"reset\" id=\"" . $this->getClass() . "\" class=\"" . $this->getId() . "\" name=\"" . $this->getName() . "\" value=\"" . $this->_value . "\" >";
        }
    }
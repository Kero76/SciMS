<?php
    namespace SciMS\Form;
    
    abstract class Input extends Form {
    
        /**
         * The name of the tag.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_name;
    
        /**
         * Return the name of the HTML tag.
         *
         * @return string
         *  Return the name of the HTML tag.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getName() {
            return $this->_name;
        }
    
        /**
         * Set the name of the tag HTML.
         *
         * @param string $name
         *  Set the name of the input tag.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setName($name) {
            $this->_name = $name;
        }
        
        /**
         * Return the start HTML representation of the object Form.
         *
         * @return string
         *  Return the HTML string representation of the start html tag of the object Form.
         * @since   SciMS 0.1
         * @version 1.0
         */
        public function initialTag() {}
    }
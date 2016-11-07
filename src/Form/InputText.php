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
    class InputText extends Input {
    
        /**
         * InputText constructor.
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
         * Return the start HTML representation of the object Form.
         *
         * @return string
         *  Return the HTML string representation of the start html tag of the object Form.
         * @since   SciMS 0.1
         * @version 1.0
         */
        function initialTag() {
            return "<input type=\"text\" id=\"" . $this->getClass() . "\" class=\"" . $this->getId() . "\" name=\"" . $this->getName() . "\" >";
        }
    }
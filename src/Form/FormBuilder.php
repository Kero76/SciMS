<?php
    
    namespace SciMS\Form;
    
    /**
     * Class FormBuilder.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.2
     * @version 1.0
     */
    class FormBuilder {
        
        /**
         * An array with all form element use to generate a form.
         *
         * @var array
         * @since SciMS 0.2
         */
        private $_forms = array();
    
        /**
         * Return form elements present on array.
         *
         * @return array
         *  An array with all form element.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getForms() {
            return $this->_forms;
        }
    
        /**
         * Add an object AbstractForm to the end of array.
         *
         * @param \SciMS\Form\AbstractForm $form
         *  An AbstractForm object to add at the end of the array.
         * @return FormBuilder
         *  Return the instance of FormBuilder to chain calling add function.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function add(AbstractForm $form) {
            array_push($this->_forms, $form);
            return $this;
        }
    }
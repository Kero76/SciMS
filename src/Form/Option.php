<?php
    namespace SciMS\Form;

    /**
     * Class Option.
     *
     * An option is an element content on select tag.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.2
     * @version 1.0
     */
    class Option extends AbstractForm {
    
        /**
         * Content of the attribute value.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_value;
    
        /**
         * Content of the attribute label.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_label;
    
        /**
         * Indicate if the option was selected by default or not.
         *
         * @var bool
         * @since SciMS 0.2
         */
        private $_selected;
    
        /**
         * Option constructor.
         *
         * @param array $attributes
         *  An array with all attributes.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct(array $attributes) {
            $this->_hydrate($attributes);
            $render  = '<option';
            $render .= ($this->getValue() == ''    ) ? '' : ' value="' . $this->getValue() . '"';
            $render .= ($this->getValue() == false ) ? '' : ' selected"';
            $render .= '>' . ucfirst($this->getLabel()) . '</option>';
            $this->setRender($render);
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
    
        /**
         * Return the value of the label.
         *
         * @return string
         *  Value of the label.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getLabel() {
            return $this->_label;
        }
    
        /**
         * Set the value of the label.
         *
         * @param string
         *  Value of label.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function setLabel($label) {
            $this->_label = $label;
        }
    
        /**
         * Return the value of the selected.
         *
         * @return string
         *  Value of the selected.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getSelected() {
            return $this->_selected;
        }
    
        /**
         * Set the value of the selected.
         *
         * @param string
         *  Value of the attribute selected.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function setSelected($selected) {
            $this->_selected = $selected;
        }
    
    
    }
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
            $render .= ($this->getValue() == '' ) ? '' : ' value="' . $this->getValue() . '"';
            $render .= '>' . ucfirst($this->getValue()) . '</option>';
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
    }
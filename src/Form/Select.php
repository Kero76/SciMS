<?php
    namespace SciMS\Form;

    /**
     * Class Select
     *
     * This is a representation of the HTML tag Select present on HTML.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.2
     * @version 1.0
     */
    class Select extends AbstractForm {
    
        /**
         * @var array
         *  An array with all options who composed the select options.
         * @since SciMS 0.2
         * @version 1.0
         */
        private $_options;
    
        /**
         * Select constructor.
         *
         * @constructor
         * @param array $attributes
         *  All attributes present on select attributes.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct(array $attributes) {
            $this->hydrate($attributes);
            $this->_options = array();
        }
    
        /**
         * Add a new instance of Option in array.
         *
         * @param \SciMS\Form\Option $option
         *  A new option to add on the select list.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function add(Option $option) {
            array_push($this->_options, $option);
        }
            
        /**
         * Generate render attribute.
         *
         * @since SciMS 0.2
         * @version 1.0
         */
        public function renderSelect() {
            $render  = '<select';
            $render .= ($this->getName() == '' ) ? '' : ' name="' . $this->getName() . '"';
            $render .= ($this->getId()   == '' ) ? '' : ' id="'   . $this->getId()   . '"';
            $render .= '>';
    
            // Loop on all options stored on array.
            foreach ($this->_options as $option) {
                $render .= $option->getRender();
            }
            $render .= '</select>';
            $this->setRender($render);
        }
    }

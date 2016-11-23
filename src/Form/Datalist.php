<?php
    namespace SciMS\Form;

    /**
     * Class DataList.
     *
     * @author Kero76
     * @package SciMS\Form\Input
     * @since SciMS 0.2
     * @version 1.0
     */
    class Datalist extends AbstractForm {
    
        /**
         * @var array
         *  An array with all options who composed the select options.
         * @since SciMS 0.2
         * @version 1.0
         */
        private $_options;
    
        /**
         * @var \SciMS\Form\Input\InputList
         *  Tored an instance of InputList to generate HTML.
         * @since SciMS 0.2
         */
        private $_input;
    
        /**
         * Datalist constructor.
         *
         * @param array $attributes
         *  All attributes present on select attributes.
         * @param \SciMS\Form\Input\InputList
         *  An instance of InputList.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct(array $attributes, $input) {
            $this->_hydrate($attributes);
            $this->_options = array();
            $this->_input = $input;
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
        public function renderDatalist() {
            $render  = $this->_input->getRender();
            $render .= '<datalist';
            $render .= ($this->getId()   == '' ) ? '' : ' id="'   . $this->getId()   . '"';
            $render .= '>';
        
            // Loop on all options stored on array.
            foreach ($this->_options as $option) {
                $render .= $option->getRender();
            }
            $render .= '</datalist>';
            $this->setRender($render);
        }
    }
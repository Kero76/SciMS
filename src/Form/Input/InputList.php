<?php
    namespace SciMS\Form\Input;
    
    /**
     * Class InputList.
     *
     * This is a representation of the HTML tag input type="list" present on HTML.
     *
     * @author Kero76
     * @package SciMS\Form\Input
     * @since SciMS 0.2
     * @version 1.0
     */
    class InputList extends Input {
        
        /**
         * Stored list attributes in object InputList.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_list;
        
        /**
         * InputList constructor.
         *
         * @constructor
         * @param array $attributes
         *  An array with all attributes use for create InputList object.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct(array $attributes) {
            $this->hydrate($attributes);
            $render  = '<input ';
            $render .= ($this->getList() == '') ? '' : ' list="' . $this->getList() . '"';
            $render .= '>';
            $this->setRender($render);
        }
        
        /**
         * Return the value of attribute list.
         *
         * @return string
         *  Value of attribute list.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getList() {
            return $this->_list;
        }
        
        /**
         * Set the value of the attribute list.
         *
         * @param string $list
         *  Value of the attribute.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function setList($list) {
            $this->_list = $list;
        }
    }

<?php
    namespace SciMS\Form;

    /**
     * Class Input.
     *
     * This is a representation of the HTML tag input present on HTML.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.5
     * @version 1.0
     */
    class Input extends AbstractForm {
    
        /**
         * Type of Input Form.
         *
         * @var string
         * @since SciMS 0.5
         */
        private $_type;
    
        /**
         * Value of Input Form.
         *
         * @var string
         * @since SciMS 0.5
         */
        private $_value;
        
        /**
         * Stored list attributes in object InputList.
         *
         * @var string
         * @since SciMS 0.5
         */
        private $_list;
        
        /**
         * InputText constructor.
         *
         * @constructor
         * @param array $attributes
         *  An array with all attributes use for create InputText object.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function __construct(array $attributes) {
            $this->hydrate($attributes);
            $render  = '<input ';
            $render .= ($this->getType()         == ''   ) ? '' : ' type="'        . $this->getType()        . '"';
            $render .= ($this->getClass()        == ''   ) ? '' : ' class="'       . $this->getClass()       . '"';
            $render .= ($this->getId()           == ''   ) ? '' : ' id="'          . $this->getId()          . '"';
            $render .= ($this->getName()         == ''   ) ? '' : ' name="'        . $this->getName()        . '"';
            $render .= ($this->getPlaceholder()  == ''   ) ? '' : ' placeholder="' . $this->getPlaceholder() . '"';
            $render .= ($this->getValue()        == ''   ) ? '' : ' value="'       . $this->getValue()       . '"';
            $render .= ($this->getList()         == ''   ) ? '' : ' list="' . $this->getList()               . '"';
            $render .= ($this->getReadonly()    === false) ? '' : ' readonly';
            $render .= ($this->getRequired()    === false) ? '' : ' required';
            $render .= '>';
            $this->setRender($render);
        }
    
        /**
         * Return the type attribute of Input Form.
         *
         * @return string
         *  Return the type of the input.
         * @since SciMS 0.5
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
         * @since SciMS 0.5
         * @version 1.0
         */
        public function setType($type) {
            $this->_type = $type;
        }
    
        /**
         * Return the value of attribute value.
         *
         * @return string
         *  Return the value of attribute value.
         * @since SciMS 0.5
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
         * @since SciMS 0.5
         * @version 1.0
         */
        public function setValue($value) {
            $this->_value = $value;
        }
    
        /**
         * Return the value of attribute list.
         *
         * @return string
         *  Value of attribute list.
         * @since SciMS 0.5
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
         * @since SciMS 0.5
         * @version 1.0
         */
        public function setList($list) {
            $this->_list = $list;
        }
    }

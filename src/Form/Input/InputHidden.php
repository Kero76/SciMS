<?php
    
    namespace SciMS\Form\Input;
    
    /**
     * Class InputHidden.
     *
     * This is a representation of the HTML tag input type="hidden" present on HTML.
     *
     * @author Kero76
     * @package SciMS\Form\Input
     * @since SciMS 0.2
     * @version 1.0
     */
    class InputHidden extends Input {
        
        /**
         * InputHidden constructor.
         *
         * @constructor
         * @param array $attributes
         *  An array with all attributes use for create InputFile object.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct(array $attributes) {
            $this->_hydrate($attributes);
            $render  = '<input ';
            $render .= ($this->getType()         == ''   ) ? '' : ' type="'           . $this->getType()          . '"';
            $render .= ($this->getId()           == ''   ) ? '' : ' id="'             . $this->getId()            . '"';
            $render .= ($this->getName()         == ''   ) ? '' : ' name="'           . $this->getName()          . '"';
            $render .= ($this->getValue()        == ''   ) ? '' : ' value="'          . $this->getValue()         . '"';
            $render .= '>';
            $this->setRender($render);
        }
    }

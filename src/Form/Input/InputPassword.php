<?php
    
    namespace SciMS\Form\Input;
    
    /**
     * Class InputPassword.
     *
     * This is a representation of the HTML tag input type="password" present on HTML.
     *
     * @author Kero76, TeeGreg
     * @package SciMS\Form\Input
     * @since SciMS 0.2
     * @version 1.0
     */
    class InputPassword extends Input {
        
        /**
         * InputPassword constructor.
         *
         * @constructor
         * @param array $attributes
         *  An array with all attributes use for create InputPassword object.
         * @since SciMS 0.2
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
            $render .= ($this->getRequired()    === false) ? '' : ' required';
            $render .= '>';
            $this->setRender($render);
        }
    }

<?php
    
    namespace SciMS\Form;

    /**
     * Class InputText.
     *
     * Abstract class which represent input text in form.
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
         * @param array $attributes
         *  An array with all attributes use for create InputText object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct(array $attributes) {
            $this->_hydrate($attributes);
            $render  = '<input ';
            $render .= $this->getType()     == ''    ? '' : 'type=\"'   . $this->getType()  . '\"';
            $render .= $this->getClass()    == ''    ? '' : 'class=\"'  . $this->getClass() . '\"';
            $render .= $this->getId()       == ''    ? '' : 'id=\"'     . $this->getId()    . '\"';
            $render .= $this->getName()     == ''    ? '' : 'name=\"'   . $this->getName()  . '\"';
            $render .= $this->getRequired() == false ? '' : 'required>';
            $this->setRender($render);
        }
    }
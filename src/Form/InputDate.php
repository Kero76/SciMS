<?php
    
    namespace SciMS\Form;
    
    /**
     * Class InputDate.
     *
     * Abstract class which represent input submit in form.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.1
     * @version 1.0
     */
    class InputDate extends Input {
        
        /**
         * InputDate constructor.
         *
         * @constructor
         * @param array $attributes
         *  An array with all attributes use for create InputDate object.
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
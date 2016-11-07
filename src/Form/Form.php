<?php
    namespace SciMS\Form;

    /**
     * Class Form
     *
     * This is a main class using to extends property to child form element.
     * This class contains an id and class attributes.
     *
     * @author Kero76
     * @package SciMS\Form
     * @since SciMS 0.1
     * @version 1.0
     */
    abstract class Form {
    
        /**
         * The id of the object Form.
         *
         * @var integer
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_id;
    
        /**
         * The classes of the object Form.
         *
         * @var integer
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_class;
    
        /**
         * Return the id of the object Form.
         *
         * @return integer
         *  The id of the object Form.
         */
        public function getId() {
            return $this->_id;
        }
    
        /**
         * Set the id of the object form.
         *
         * @param integer $id
         *  The id of the form object.
         */
        public function setId($id) {
            $this->_id = $id;
        }
    
        /**
         * Return the class of the object.
         *
         * @return string
         *  Return the class of the object form.
         */
        public function getClass() {
            return $this->_class;
        }
    
        /**
         * Set the class of the object Form.
         *
         * @param string $class
         *  The html class attribute at the object Form.
         */
        public function setClass($class) {
            $this->_class = $class;
        }
        
        /**
         * Method use for hydrate an instance of Category.
         *
         * This method is calling in the constructor of a Category instance to
         * fill all attributes with the good value from the Database.
         *
         * @access protected
         * @param array $data
         *  An array with all Data for hydrate the current instance of Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        protected function _hydrate(array $data) {
            foreach($data as $key => $value) {
                $method = 'set';
                $keySplit = explode("_", $key);
                for ($i = 0; $i < count($keySplit); $i++ ) {
                    $method .= ucfirst($keySplit[$i]);
                }
                if(method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    
        /**
         * Return the start HTML representation of the object Form.
         *
         * @return string
         *  Return the HTML string representation of the start html tag of the object Form.
         * @since SciMS 0.1
         * @version 1.0
         */
        abstract function initialTag();
    }
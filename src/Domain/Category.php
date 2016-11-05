<?php
    namespace SciMS\Domain;
    
    /**
     * Created by PhpStorm.
     * User: Kero76
     * Date: 04/11/16
     * Time: 15:24
     */
    class Category {
        private $_id;
        private $_name;
    
        /**
         * Category constructor.
         *
         * @constructor
         * @param array $data
         *  An array with all data used for hydrate object.
         * @see _hydrate(array $data).
         */
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
    
        /**
         * Return the id of the Category.
         *
         * @return integer
         *  The id of the Category.
         */
        public function getId() {
            return $this->_id;
        }
    
        /**
         * Set the id of the Category.
         *
         * @param integer $id
         *  The id of the Category.
         */
        public function setId($id) {
            $this->_id = $id;
        }
    
        /**
         * Return the name of the Category.
         *
         * @return string
         *  The name of the Category.
         */
        public function getName() {
            return $this->_name;
        }
    
        /**
         * Set the name of the Category.
         *
         * @param string $name
         *  The name of the Category.
         */
        public function setName($name) {
            $this->_name = $name;
        }
        
        /**
         * Method use for hydrate an instance of Category.
         *
         * This method is calling in the constructor of a Category instance to
         * fill all attributes with the good value from the Database.
         *
         * @access private
         * @param array $data
         *  An array with all Data for hydrate the current instance of Category.
         */
        private function _hydrate(array $data) {
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
    }
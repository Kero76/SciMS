<?php
    namespace SciMS\Domain;

    /**
     * Class User
     *
     * The class is a representation of an category on Website.
     *
     * -> V1.1 :
     *  Added attributes connect + corresponding Getter and Setter.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.1
     * @version 1.1
     */
    class Category {
    
        /**
         * Id of the Category.
         *
         * @var integer
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_id;
    
        /**
         * Name of the Category
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_title;
    
        /**
         * Category constructor.
         *
         * @constructor
         * @param array $data
         *  An array with all data used for hydrate object.
         * @see _hydrate(array $data).
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
    
        /**
         * Return the id of the Category.
         *
         * @return integer
         *  The id of the Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getId() {
            return $this->_id;
        }
    
        /**
         * Set the id of the Category.
         *
         * @param integer $id
         *  The id of the Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setId($id) {
            $this->_id = $id;
        }
    
        /**
         * Return the name of the Category.
         *
         * @return string
         *  The name of the Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getTitle() {
            return $this->_title;
        }
    
        /**
         * Set the name of the Category.
         *
         * @param string $title
         *  The name of the Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setTitle($title) {
            $this->_title = $title;
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
         * @since SciMS 0.1
         * @version 1.0
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
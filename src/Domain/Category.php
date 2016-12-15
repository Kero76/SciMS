<?php
    namespace SciMS\Domain;

    /**
     * Class User
     *
     * The class is a representation of an Category on Website.
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.1
     * @version 1.0
     */
    class Category extends AbstractDomain {
    
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
            $this->hydrate($data);
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
    }

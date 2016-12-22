<?php
    namespace SciMS\DAO;

    use \SciMS\Database\Database;

    /**
     * Class DAO.
     *
     * This class is a representation of the DAO object.
     * In fact, it have an access at the Database for each children generate,
     * and it have an abstract method defined on each child.
     *
     * @author Kero76
     * @package \SciMS\DAO
     * @since SciMS 0.1
     * @version 1.0
     */
    abstract class DAO {
    
        /**
         * Stored the unique instance of Database.
         *
         * @var \SciMS\Database\Database
         * @since SciMS 0.1
         */
        private $_db;
    
        /**
         * DAO constructor.
         *
         * @constructor
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct() {
            $this->_db = Database::getInstance();
        }
    
        /**
         * Return the instance of the Database access.
         *
         * @access protected.
         * @return \SciMS\Database\Database
         *  The unique instance of Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        protected function getDatabase() {
            return $this->_db;
        }
    
        /**
         * Method use for build a Domain object.
         *
         * @abstract
         * @access protected.
         * @param array $row
         *  The data use for build Domain.
         * @return mixed
         *  The corresponding instance of Domain object.
         * @since SciMS 0.1
         * @version 1.0
         */
        protected abstract function buildDomain(array $row);
    }

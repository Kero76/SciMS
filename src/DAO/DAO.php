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
         * Return the instance of the Database access.
         *
         * @access protected.
         * @return \SciMS\Database\Database
         *  The unique instance of Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        protected function getDatabase() {
            return Database::getInstance();
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

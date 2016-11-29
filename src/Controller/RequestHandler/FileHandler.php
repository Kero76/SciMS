<?php
    namespace SciMS\Controller\RequestHandler;

    /**
     * Class FileHandler.
     *
     * This class manage the $_FILES array.
     *
     * @author Kero76
     * @package SciMS\Controller\RequestHandler
     * @since SciMS 0.3
     * @version 1.0
     */
    class FileHandler implements RequestHandler {
    
        /**
         * An array which contains $_FILES content.
         *
         * @var array
         * @since SciMS 0.3
         */
        private $_files;
    
        /**
         * FileHandler constructor.
         *
         * @constructor
         * @since SciMS 0.3
         * @version 1.0
         */
        public function __construct() {
            $this->_files = array();
        }
    
        /**
         * This method return the array request who contains $_GET / $_POST / $_SESSION / ...
         *
         * @return array
         *  Return the array who contains $_GET / $_POST / $_SESSION / ...
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function getRequest() {
            return $this->_files;
        }
    
        /**
         * Set the array who contains $_GET / $_POST / $_SESSION / ...
         *
         * @param array $request
         *  Set the array who contains $_GET / $_POST / $_SESSION / ...
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function setRequest(array $request) {
            $this->_files = $request;
        }
    
        /**
         * Return the associate value of the key.
         *
         * @param $key
         *  The key who search on array.
         * @return mixed
         *  Return the value corresponding of the key pass on parameter.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function getRequestField($key) {
            return $this->_files[$key];
        }
    
        /**
         * Set the speficic value from thanks to the key.
         *
         * @param $key
         *  The key using on request array
         * @param $value
         *  Value of the row selected on request array.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function setRequestField($key, $value) {
            $this->_files[$key] = $value;
        }
    
        /**
         * Verify if the field in array exists or not.
         *
         * @param $field
         *  The field at check if exists on request array or not.
         * @return bool
         *  True or false if the field exists or not.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function requestFieldExist($field) {
            if (isset($this->_files[$field])) {
                return true;
            }
            return false;
        }
    }
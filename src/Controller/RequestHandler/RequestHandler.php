<?php
    namespace SciMS\Controller\RequestHandler;
 
    /**
     * Interface RequestHandler.
     *
     * An interface use to create a Handler about the global variable like
     * $_POSt, $_GET, ...
     * This interface must implements if you would manage another global variable.
     *
     * @author Kero76
     * @package SciMS\Controller\RequestHandler
     * @since SciMS 0.3
     * @version 1.0
     */
    interface RequestHandler {
        
        /**
         * This method return the array request who contains $_GET / $_POST / $_SESSION / ...
         *
         * @return array
         *  Return the array who contains $_GET / $_POST / $_SESSION / ...
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getRequest();
    
        /**
         * Set the array who contains $_GET / $_POST / $_SESSION / ...
         *
         * @param array $request
         *  Set the array who contains $_GET / $_POST / $_SESSION / ...
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setRequest(array $request);
    
        /**
         * Return the associate value of the key.
         *
         * @param $key
         *  The key who search on array.
         * @return mixed
         *  Return the value corresponding of the key pass on parameter.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getRequestField($key);
    
        /**
         * Set the speficic value from thanks to the key.
         *
         * @param $key
         *  The key using on request array
         * @param $value
         *  Value of the row selected on request array.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setRequestField($key, $value);
    
        /**
         * Verify if the field in array exists or not.
         *
         * @param $field
         *  The field at check if exists on request array or not.
         * @return bool
         *  True or false if the field exists or not.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function requestFieldExist($field);
    }
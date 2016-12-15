<?php
    namespace SciMS\Controller\Handler\RequestHandler;

    /**
     * Class SessionHandler.
     *
     * This class manage the $_SESSION array.
     *
     * @author Kero76
     * @package SciMS\Controller\RequestHandler
     * @since SciMS 0.3
     * @version 1.0
     */
    class SessionHandler implements RequestHandlerInterface {
    
        /**
         * An array which contains $_SESSION content.
         *
         * @var array
         * @since SciMS 0.3
         */
        private $_session;
    
        /**
         * SessionHandler constructor.
         *
         * @constructor
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function __construct() {
            $this->_session = array();
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
            return $this->_session;
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
            $this->_session = $request;
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
            return $this->_session[$key];
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
            $this->_session[$key] = $value;
        }
    
        /**
         * Create a new Session on website.
         *
         * @param array $session
         *  The session created.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function createSession(array $session) {
            foreach ($session as $key => $value) {
                $_SESSION[$key] = $value;
            }
            $this->setRequest($session);
        }
    
        /**
         * Destroy the current $_SESSION
         *
         * @since SciMS 0.3
         * @version 1.0
         */
        public function destroySession() {
            session_destroy();
            $this->setRequest(array());
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
            if (isset($this->_session[$field])) {
                return true;
            }
            return false;
        }
    }

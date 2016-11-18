<?php
    namespace SciMS\Error;

    /**
     * Class MessageHandler.
     *
     * @author Kero76
     * @package SciMS\Error
     * @since SciMS 0.2
     * @version 1.0
     */
    class MessageHandler {
    
        /**
         * An array with all successes messages.
         *
         * @var array
         * @since SciMS 0.2
         */
        private $_successes;
    
        /**
         * An array with all errors messages.
         *
         * @var array
         * @since SciMS 0.2
         */
        private $_errors;
    
        /**
         * MessageHandler constructor.
         *
         * @constructor
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct() {
            $this->_errors = array(
                'connection_username'   => 'Username fail',
                'connection_password'   => 'Password fail',
                'inscription_username'  => 'Username fail',
                'inscription_password'  => 'Password fail',
                'inscription_email'     => 'Email fail',
            );
            
            $this->_successes = array(
                'connection'    => 'Connection !',
                'inscription'   => 'Inscription !',
            );
        }
    
        /**
         * Return the success message in function of the key.
         *
         * @param $key
         *  Return the message in function of the key.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getSuccess($key) {
            $this->_successes[$key];
        }
    
        /**
         * Return the error message in function of the key.
         *
         * @param $key
         *  Return the message in function of the key.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getError($key) {
            $this->_errors[$key];
        }
    }
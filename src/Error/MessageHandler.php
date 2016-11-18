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
                'connection_username'   => new Error('Username fail'),
                'connection_password'   => new Error('Password fail'),
                'inscription_username'  => new Error('Username fail'),
                'inscription_password'  => new Error('Password fail'),
                'inscription_email'     => new Error('Email fail'),
                '404'                   => new Error('Page not found'),
            );
            
            $this->_successes = array(
                'connection'    => new Success('Connection !'),
                'inscription'   => new Success('Inscription !'),
            );
        }
    
        /**
         * Return the success message in function of the key.
         *
         * @param $key
         *  Return the message in function of the key.
         * @return string
         *  A message.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getSuccess($key) {
            return $this->_successes[$key];
        }
    
        /**
         * Return the error message in function of the key.
         *
         * @param $key
         *  Return the message in function of the key.
         * @return string
         *  A message.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getError($key) {
            return $this->_errors[$key];
        }
    }
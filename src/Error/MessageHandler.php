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
                'field_empty_email'     => new Error('The field email is empty.'),
                'field_empty_username'  => new Error('The field username is empty.'),
                'field_empty_password'  => new Error('The field password is empty.'),
                'email_not_valid'       => new Error('Email is not valid.'),
                'not_same_password'     => new Error('The password type and the password are not the same.'),
                'not_same_username'     => new Error('The username type and the username are not the same.'),
                'email_not_found'       => new Error('Email not found in website.'),
                'user_not_found'        => new Error('Username not found in website.'),
                'email_already_found'   => new Error('Email already use in website.'),
                'avatar_not_upload'     => new Error('Avatar not upload'),
                'avatar_not_valid'      => new Error('Avatar invalid'),
                '404'                   => new Error('Page not found'),
            );
            
            $this->_successes = array(
                'connection_success'         => new Success('Connection !'),
                'inscription_success'        => new Success('Inscription !'),
                'update_success'             => new Success('Update !'),
                'avatar_upload_with_success' => new Success('Avatar upload with success !'),
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
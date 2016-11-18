<?php
    namespace SciMS\Controller;

    /**
     * Class FormChecker.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.2
     * @version 1.0
     */
    class FormChecker {
    
        /**
         * A regex use for match if a string is an email address.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_regex_email;
    
        /**
         * FormChecker constructor.
         *
         * Build the Regular Expression use to check if an email is valid.
         *
         * @constructor
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct() {
            $this->_regex_email = '#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#';
        }
    
        /**
         * Check if the value passed with the inscription form are good or not.
         *
         * @param array $post
         *  $_POST[] array.
         * @return bool
         *  True or false in function of the inscription form is valid or not.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkInscription(array $post) {
            // Check if string is empty.
            foreach ($post as $p) {
                if (!$this->_checkEmptyString($p)) {
                    return false;
                }
            }
            // Check if email is valid.
            if (!$this->_checkEmail($post['email'])) {
                return false;
            }
            return true;
        }
    
        /**
         * Check some information before connected user on Website.
         *
         * @param array $post
         *  $_POST[] array.
         * @param \SciMS\Domain\User $user
         *  An instance of user retrieve by the username to check if the password is the same as the password stored on Database.
         * @return bool
         *  True or false in function of the inscription form is valid or not.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkConnection(array $post, $user) {
            // Check if string is empty.
            foreach ($post as $p) {
                if (!$this->_checkEmptyString($p)) {
                    return false;
                }
            }
            // Check if password is the same as the password store on database.
            if (!$this->_checkSamePassword($post['password'], $user->getPassword())) {
                return false;
            }
            return true;
        }
    
        /**
         * Return the encrypt password with salt include on it to avoid
         * to stored separately salt and password on Database.
         *
         * @param $password
         *  The password at encrypt.
         * @return string
         *  The password encrypt with salt include on it.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function encryptPassword($password) {
            return password_hash($password, PASSWORD_DEFAULT);
        }
    
        /**
         * Check if an email is validate or not.
         *
         * @access private
         * @param $email
         *  Email at check.
         * @return bool
         *  True if the email is check. Otherwise, return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkEmail($email) {
            if (preg_match($this->_regex_email, $email) !=0) {
                return true;
            }
            return false;
        }
    
        /**
         * Check if a string is empty or not.
         *
         * @access private
         * @param $str
         *  String at check.
         * @return bool
         *  True if the string is not empty. Otherwise, return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkEmptyString($str) {
            if (!empty($str)) {
                return true;
            }
            return false;
        }
    
        /**
         * Check if the password type on form is equal to the password retrieve from the Database.
         *
         * @param $user_password
         *  The password type by user on form.
         * @param $hash_password
         *  The password encrypt by the function password_hash().
         * @return bool
         *  True or false in function of the result of the function.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkSamePassword($user_password, $hash_password) {
            return password_verify($user_password, $hash_password);
        }
    }
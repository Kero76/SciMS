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
         * @param \SciMS\Domain\User $potential_user
         *  An instance of user retrieve by the username to check if the password is already present on Database.
         * @return string
         *  The key use to generate message in view.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkUserInscription(array $post, $potential_user) {
            // Check if string is empty.
            foreach ($post as $p) {
                if (!$this->_checkEmptyString($p)) {
                    return 'field_empty_' . $p;
                }
            }
            
            // Check if email is valid.
            if (!$this->_checkConformEmail($post['email'])) {
                return 'email_not_valid';
            }
    
            // Check if the email is the same as the email store on Database.
            if (!$this->_checkEmailPresentOnDatabase($post['email'], $potential_user->getEmail())) {
                return 'email_already_found';
            }
            
            return 'inscription_success';
        }
    
        /**
         * Check some information before connected user on Website.
         *
         * @param array $post
         *  $_POST[] array.
         * @param \SciMS\Domain\User $user
         *  An instance of user retrieve by the username to check if the password is the same as the password stored on Database.
         * @return string
         *  The key use to generate message in view.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkUserConnection(array $post, $user) {
            // Check if string is empty.
            foreach ($post as $p) {
                if (!$this->_checkEmptyString($p)) {
                    return 'field_empty_' . $p;
                }
            }
        
            // Check if email is valid.
            if (!$this->_checkConformEmail($post['email'])) {
                return 'email_not_valid';
            }
        
            // Check if the email is the same as the email store on Database.
            if ($this->_checkEmailPresentOnDatabase($post['email'], $user->getEmail())) {
                return 'email_not_found';
            }
        
            // Check if password is the same as the password store on database.
            if (!$this->_checkSamePassword($post['password'], $user->getPassword())) {
                return 'not_same_password';
            }
            return 'connection_success';
        }
    
        /**
         * Control form input before update user.
         *
         * @param array $post
         *  $_POST[] array.
         * @return string
         *  The key use to generate message in view.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkUserUpdate(array $post) {
            // Check if string is empty.
            foreach ($post as $p) {
                if (!$this->_checkEmptyString($p)) {
                    return 'field_empty_' . $p;
                }
            }
            return 'update_success';
        }
        
        /**
         * Control form input before add article.
         *
         * @param array $post
         *  $_POST[] array.
         * @return string
         *  The key use to generate message in view.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkAddArticle(array $post) {
            if (!$this->_checkEmptyString($post['title']) && !$this->_checkEmptyString($post['content'])) {
                return '';
            }
            return 'insert_success';
        }
    
        /**
         * Control form input before update article.
         *
         * @param array $post
         *  $_POST[] array.
         * @return string
         *  The key use to generate message in view.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkUpdateArticle(array $post) {
            if (!$this->_checkEmptyString($post['title']) && !$this->_checkEmptyString($post['content'])) {
                return '';
            }
            return 'update_success';
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
        private function _checkConformEmail($email) {
            return (preg_match($this->_regex_email, $email) !==0) ? true : false;
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
            return (!empty($str) ? true : false);
        }
    
        /**
         * Check if the password type on form is equal to the password retrieve from the Database.
         *
         * @access private
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
    
        /**
         * Check if the email post on form and email store on database are the same.
         *
         * @param $email_post
         *  Email type on form.
         * @param $email_db
         *  Email retrieve from Database.
         * @return bool
         *  True if the emails are the same. Otherwise, return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkEmailPresentOnDatabase($email_post, $email_db) {
            return (strcmp($email_post, $email_db) === 0) ? false : true;
        }
    }
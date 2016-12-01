<?php
    namespace SciMS\Controller\Checker;

    /**
     * Class MailChecker.
     *
     * This class extends AbstractChecker.
     * His role consist in check email from the form.
     * It compare with email regular expression and is already present on Database or not.
     *
     * @author Kero76
     * @package SciMS\Controller\Checker
     * @since SciMS 0.3
     * @version 1.0
     */
    class MailChecker extends AbstractChecker  {
    
        /**
         * Regex use to check email address.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_mail_regex;
    
        /**
         * MailChecker constructor.
         *
         * @constructor
         * @since SciMS 0.3
         * @version 1.0
         */
        public function __construct() {
            $this->_mail_regex = '#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#';
        }
    
        /**
         * Method use to check the conformity of the email address.
         *
         * @param $mail
         *  Email address at check.
         * @return bool
         *  True if the email is valid, else return false.
         */
        public function checkConformity($mail) {
            if (preg_match($this->_mail_regex, $mail) === 0) {
               return true;
           }
           return false;
        }
    
        /**
         * Method use to check if the mail pass from form is already present on database or not.
         *
         * @param $mail
         *  Mail at compare with mail present on database.
         * @param $db_mail
         *  Mail present on Database.
         * @return bool
         *  True if the mail and the mail present on database are the same, else it return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkDatabasePresence($mail, $db_mail) {
            if (strcmp($mail, $db_mail) === 0) {
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
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkSamePassword($user_password, $hash_password) {
            return password_verify($user_password, $hash_password);
        }
    }
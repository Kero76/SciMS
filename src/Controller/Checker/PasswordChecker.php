<?php
    namespace SciMS\Controller\Checker;

    /**
     * Class PasswordChecker.
     *
     * This class check the password from the form.
     * It check the size of the password and if the password are the same as the password retrieve from the database.
     *
     * @author Kero76
     * @package SciMS\Controller\Checker
     * @since SciMS 0.3
     * @version 1.0
     */
    class PasswordChecker extends AbstractChecker {
        
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
        public function checkEmailPresentOnDatabase($email_post, $email_db) {
            if (strcmp($email_post, $email_db) === 0){
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
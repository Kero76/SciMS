<?php
    namespace SciMS\Controller\Checker\Form;
    
    use SciMS\Controller\Checker\AbstractChecker;

    /**
     * Class ConnectionChecker.
     *
     *
     * @author Kero76
     * @package SciMS\Controller\Checker\Form
     * @since SciMS 0.3
     * @version 1.0
     */
    class ConnectionChecker extends AbstractChecker implements FormChecker {
    
        /**
         * Method use to check insertion the differents forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the insertion are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkInsert(array $services) {
            $user = $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'));
    
            // Check if string is empty.
            foreach ($services['post.handler']->getRequest() as $p) {
                if ($services['mail.checker']->emptyString($p)) {
                    return false;
                }
            }
    
            // Check if email is valid.
            if ($services['mail.checker']->checkConformity($services['post.handler']->getRequestField('email'))) {
                return false;
            }
    
            // Check if the email is the same as the email store on Database.
            if (!$services['mail.checker']->checkDatabasePresence($services['post.handler']->getRequestField('email'), $user->getEmail())) {
                return false;
            }
    
            return true;
        }
    
        /**
         * Method use to check update the differents forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the update are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkUpdate(array $services) {
            $user = $services['dao.user']->findByEmail($services['post.handler']->getRequestField('email'));
            // Check if string is empty.
            foreach ($services['post.handler']->getRequest() as $p) {
                if ($services['mail.checker']->emptyString($p)) {
                    return false;
                }
            }
            
            // Check if email is valid.
            if ($services['mail.checker']->checkConformity($services['post.handler']->getRequestField('email'))) {
                return false;
            }
    
            // Check if the email is the same as the email store on Database.
            if (!$services['mail.checker']->checkDatabasePresence($services['post.handler']->getRequestField('email'), $user->getEmail())) {
                return false;
            }
    
            // Check if password is the same as the password store on database.
            if (!$services['mail.checker']->checkSamePassword($services['post.handler']->getRequestField('password'), $user->getPassword())) {
                return false;
            }
            
            return true;
        }
    
        /**
         * Method use to check delete the differents forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the delete are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkDelete(array $services) {
            return $services['session.handler']->requestFieldExist('user_id');
        }
    }
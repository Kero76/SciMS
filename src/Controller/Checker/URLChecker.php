<?php
    namespace SciMS\Controller\Checker;

    /**
     * Class URLChecker.
     *
     * This class check the URL.
     * In fact, if a user change directly the parameter on URL, it can be arrived on a 404 page,
     * because the article id ou user not valid on Database.
     * So thanks to this class, it can check before redirect user on page if the parameter on url are right or not,
     * and redirect the user to the corresponding view.
     *
     * @author Kero76
     * @package SciMS\Controller\Checker
     * @since SciMS 0.3
     * @version 1.0
     */
    class URLChecker extends AbstractChecker {
    
        /**
         * Method use to check the id retrieve from form is smaller than the max id from the database.
         *
         * @param $get_id
         *  The id retrieve from form.
         * @param $max_id
         *  The max id from the database.
         * @return bool
         *  True if the id retrieve from form is smaller than the max id retrieve from the Database.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkId($get_id, $max_id) {
            if ($max_id > $get_id) {
                return true;
            }
            return false;
        }
    }
<?php
    namespace SciMS\Controller;

    /**
     * Class URLChecker.
     *
     * This class check if the URL is valid.
     * In fact, if an user change the URL on his web browser, it can arrive on a unvalid URL.
     * For example, if the user add an article's id not present on the Database, the user arrive on a page 404.
     * But, thanks to the URLChecker, it redirect directly on the invalid page.
     *
     * @author Kero76
     * @package SciMS\Controller
     * @since SciMS 0.3
     * @version 1.0
     */
    class URLChecker {
    
        /**
         * This method check if the article id present on URL is present on Database
         * and if the id is superior to 0.
         *
         * @param $get_id
         *  The id retrieve from URL.
         * @param $max_article_id
         *  The max id present on Database.
         * @return bool
         *  True if the id from the url is good, otherwise, return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkArticleId($get_id, $max_article_id) {
            if ($get_id > $max_article_id || $get_id < 0) {
                return false;
            }
            
            return true;
        }
    
        /**
         * This method check if the article id present on URL is present on Database
         * and if the id is superior to 0.
         *
         * @param $get_id
         *  The id retrieve from URL.
         * @param $max_user_id
         *  The max id present on Database.
         * @return bool
         *  True if the id from the url is good, otherwise, return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkUserId($get_id, $max_user_id) {
            if ($get_id > $max_user_id || $get_id < 0) {
                return false;
            }
    
            return true;
        }
    }
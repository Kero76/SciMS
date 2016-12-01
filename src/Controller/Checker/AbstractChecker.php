<?php
    namespace SciMS\Controller\Checker;

    /**
     * Class AbstractChecker.
     *
     * This is an abstract class use for inehrit method emptyString on a child classes.
     * It must extends for all subclasses create to check element on website.
     *
     * @author Kero76
     * @package SciMS\Controller\Checker
     * @since SciMS 0.3
     * @version 1.0
     */
    abstract class AbstractChecker {
    
        /**
         * Check if a String is empty or not.
         *
         * @param $str
         *  String to check if is empty.
         * @return bool
         *  True if the string is empty, otherwise return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function emptyString($str) {
            return empty($str);
        }
    
        /**
         * Check if the two strings are the same or not.
         *
         * @param $str1
         *  First string at compare.
         * @param $str2
         *  Second string at compare.
         * @return bool
         *  True if the strings are the same. Otherwise, return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function compareString($str1, $str2) {
            if (strcmp($str1, $str2) === 0) {
                return true;
            }
            return false;
        }
    }
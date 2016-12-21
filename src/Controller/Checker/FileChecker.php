<?php
    namespace SciMS\Controller\Checker;

    /**
     * Class FileChecker.
     *
     * @author Kero76
     * @package SciMS\Controller\Checker
     * @since SciMS 0.5
     * @version 1.0
     */
    class FileChecker extends AbstractChecker {
    
        /**
         * Check if a spefici file exists on server.
         *
         * @param $file_name
         *  The complete path of the file at search on server.
         * @return bool
         *  Return true when the specific file is present on website. In other case, it return false.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function fileExist($file_name) {
            return file_exists($file_name);
        }
    }

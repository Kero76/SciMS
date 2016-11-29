<?php
    namespace SciMS\File;

    /**
     * Interface FileUpload.
     *
     * @author Kero76
     * @package SciMS\File
     * @since SciMS 0.3
     * @version 1.0
     */
    interface FileUpload {
    
        /**
         * Check if the file is correct before upload it on server.
         *
         * @return bool
         *  True if the file respect the upload convention, else return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkFile();
    
        /**
         * Move the file after check.
         *
         * @return bool
         *  True if the file was correctly move. Otherwise, return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function moveFile();
    }
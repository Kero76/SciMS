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
         * @param array $services
         *  The services array.
         * @param       $form_image_name
         *  The name of the input file present on form page.
         * @return bool
         *  True if the file respect the upload convention, else return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkFile(array $services, $form_image_name);
    
        /**
         * Move the file after check.
         *
         * @param array $services
         *  The services array.
         * @param       $form_image_name
         *  The name of the input file present on form page.
         * @param       $image_name
         *  The last name of the image after uploaded and moved on server.
         * @return bool
         *  True if the file was correctly move. Otherwise, return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function moveFile(array $services, $form_image_name, $image_name);
    
        /**
         * Split the extension of the file passed on parameter.
         *
         * @param array $file
         *  The file retrieve from parameter.
         * @param       $form_id
         *  The file name id retrieve from form.
         * @return string
         *  The extension of the file passed on parameter.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function splitExtensionFile(array $file, $form_id);
    }
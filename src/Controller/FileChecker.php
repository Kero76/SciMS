<?php
    namespace SciMS\Controller;

     /**
      * Class FileChecker.
      *
      * This class check if the files uploads thank to the different form present on website respect the normes.
      * In fact, it check the size, the extension and if the file is not upload before authorize interact with the Database.
      *
      * @author Kero76
      * @package SciMS\Controller
      * @since SciMS 0.2
      * @version 1.0
      */
    class FileChecker {
    
        /**
         * All right use for create directory if not exists on server.
         *
         * @var int
         * @since SciMS 0.2
         */
        static $ALL_RIGHT = 0777;
    
        /**
         * Right apply at the folder to authorize php and server to browse directory and files.
         *
         * @var int
         * @since SciMS 0.2
         */
        static $CHMOD_RIGHT = 0745;
    
        /**
         * A list of all image extension file available on website.
         *
         * @var array
         * @since SciMS 0.2
         */
        private $_image_extension_available;
    
        /**
         * The maximum size possible to upload on website.
         * This size is compute in bytes, so the current value (8388608) represent approximatively 8Mo.
         *
         * @var int
         * @since SciMS 0.2
         */
        private $_image_max_size;
    
        /**
         * The path of the upload directory.
         *
         * @var string
         * @since SciMS 0.2
         */
        private $_upload_dir;
    
        /**
         * FileChecker constructor.
         *
         * @constructor
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct() {
            $this->_image_extension_available = array(
                'png', 'jpg', 'jpeg',
            );
            $this->_image_max_size = 8388608;
            $this->_upload_dir     = '../web/uploads/';
        }
    
        /**
         * Upload the file on the website server.
         *
         * Before upload the file, it check if the file is correct and respect some conditions.
         * Then, if it ok, it check if the folder _upload_dir exists, and if exists, move the file into this directory.
         * Otherwise, it create before the folder and moved file into this directory after.
         *
         * @param array $file
         *  An array with all files informations.
         * @param string $file_name
         *  The name of the file stored on server.
         * @return string
         *  The error code during process.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function uploadAvatarFile(array $file, $file_name) {
            if ($this->checkFile($file)) {
                // Check if the folder uploads doesn't exists.
                if (!file_exists($this->_upload_dir) && !file_exists($this->_upload_dir . 'avatar/')) {
                    mkdir($this->_upload_dir, FileChecker::$ALL_RIGHT);
                    chmod($this->_upload_dir, FileChecker::$CHMOD_RIGHT);
                    mkdir($this->_upload_dir . 'avatar/', FileChecker::$ALL_RIGHT);
                    chmod($this->_upload_dir . 'avatar/', FileChecker::$CHMOD_RIGHT);
                }
                // Moved image on this directory.
                if (move_uploaded_file($file['avatar']['tmp_name'], $this->_upload_dir . 'avatar/' . $file_name . $this->splitExtensionFile($file, 'avatar'))) {
                    return 'avatar_upload_with_success';
                } else {
                    return 'avatar_not_upload';
                }
            } else {
                return 'avatar_not_valid';
            }
        }
    
        /**
         * Split the extension of the file passed on parameter.
         *
         * @param array $file
         *  The file retrieve from parameter.
         * @param       $form_id
         *  The file name id retrieve from form.
         * @return string
         *  The extension of the file passed on parameter.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function splitExtensionFile(array $file, $form_id) {
            return strrchr($file[$form_id]['name'], '.');
        }
    
        /**
         * Check if the file is correct before upload it on the server.
         *
         * @param array $file
         *  The array which contains all informations about the file send by the form.
         * @return bool
         *  If the file is correct, it return true. Otherwise, it return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function checkFile(array $file) {
            return (
                $this->_checkUnuploadFile($file['avatar']['error']) &&
                $this->_checkFileExtension($file['avatar']['name']) &&
                $this->_checkFileSize($file['avatar']['size'])
            );
        }
    
        /**
         * Check the file send by the form before upload it on website.
         *
         * @access private
         * @param $file_error
         *  The error code of the file upload.
         * @return bool
         *  If the error code equals 0, it return true. Otherwise, it return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkUnuploadFile($file_error) {
            if ($file_error > 0) {
                return false;
            }
            return true;
        }
    
        /**
         * Check the file size before upload it on website because if the size is huge, the image doesn't upload on website.
         *
         * @access private
         * @param $file_size
         *  The size of the file.
         * @return bool
         *  If the file size is between maximum size authorized and 0, it return true. Otherwise, it return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkFileSize($file_size) {
            if ($file_size > $this->_image_max_size) {
                return false;
            }
            return true;
        }
    
        /**
         * Check the file extension before upload it on website. The server accept only the image with
         * 'png, 'jpg' and 'jpeg' extension to avoid to add potential hack script.
         *
         * @access private
         * @param $file_extension
         *  The file extension.
         * @return bool
         *  If the extension file is correct, it return true. Otherwise, it return false.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _checkFileExtension($file_extension) {
            // strrchr return the extension with '.'.
            // substr return the substring without the first character ('.').
            // strtolower return the extension in lower case.
            $extension_upload = strtolower(substr(strrchr($file_extension, '.'), 1));
            if (in_array($extension_upload, $this->_image_extension_available)) {
                return true;
            };
            return false;
        }
    }
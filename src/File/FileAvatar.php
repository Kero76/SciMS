<?php
    namespace SciMS\File;

    /**
     * Class FileAvatar.
     *
     * @author Kero76
     * @package SciMS\File
     * @since SciMS 0.3
     * @version 1.0
     */
    class FileAvatar implements FileUpload {
    
        /**
         * All right use for create directory if not exists on server.
         *
         * @var integer
         * @since SciMS 0.3
         */
        static $ALL_RIGHT = 0777;
    
        /**
         * Right apply at the folder to authorize php and server to browse directory and files.
         *
         * @var integer
         * @since SciMS 0.3
         */
        static $CHMOD_RIGHT = 0745;
    
        /**
         * A list of all image extension file available on website.
         *
         * @var array
         * @since SciMS 0.3
         */
        private $_image_extension_available;
    
        /**
         * The maximum size possible to upload on website.
         * This size is compute in bytes, so the current value (8388608) represent approximatively 8Mo.
         *
         * @var integer
         * @since SciMS 0.3
         */
        private $_image_max_size;
    
        /**
         * The path of the upload directory.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_upload_dir;
    
        /**
         * FileAvatar constructor.
         *
         * @constructor
         * @since SciMS 0.3
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
         * Check if the file is correct before upload it on server.
         *
         * @param array $services
         *  The services array.
         * @param       $form_image_name
         *  The name of the input file present on form page.
         * @return bool
         *  True if the file respect the upload convention, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkFile(array $services, $form_image_name) {
            return (
                $this->_checkUnuploadFile($services['file.handler']->getRequestField($form_image_name)['error']) &&
                $this->_checkFileExtension($services['file.handler']->getRequestField($form_image_name)['name']) &&
                $this->_checkFileSize($services['file.handler']->getRequestField($form_image_name)['size'])
            );
        }
    
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
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function moveFile(array $services, $form_image_name, $image_name) {
            if ($this->checkFile($services, $form_image_name)) {
                // Check if the folder uploads doesn't exists.
                if (!file_exists($this->_upload_dir) && !file_exists($this->_upload_dir . 'avatar/')) {
                    mkdir($this->_upload_dir, FileAvatar::$ALL_RIGHT);
                    chmod($this->_upload_dir, FileAvatar::$CHMOD_RIGHT);
                    mkdir($this->_upload_dir . 'avatar/', FileAvatar::$ALL_RIGHT);
                    chmod($this->_upload_dir . 'avatar/', FileAvatar::$CHMOD_RIGHT);
                }
                // Moved image on this directory.
                if (move_uploaded_file($services['file.handler']->getRequestField($form_image_name)['tmp_name'], $this->_upload_dir . 'avatar/' . $image_name . $this->splitExtensionFile($services['file.handler']->getRequestField($form_image_name), $form_image_name))) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
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
         * @since SciMS 0.3
         * @version 1.0
         */
        public function splitExtensionFile(array $file, $form_id) {
            return strrchr($file[$form_id]['name'], '.');
        }
        
        /**
         * Check the file send by the form before upload it on website.
         *
         * @access private
         * @param $file_error
         *  The error code of the file upload.
         * @return bool
         *  If the error code equals 0, it return true. Otherwise, it return false.
         * @since SciMS 0.3
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
         * @since SciMS 0.3
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
         * @since SciMS 0.3
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
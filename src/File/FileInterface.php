<?php
    namespace SciMS\File;

    /**
     * Interface FileInterface.
     *
     * This interface must implement by a class when you would interact with a file on the server.
     * For example, you can create a class YamlWrite who can write, read, create or delete a .yml file.
     *
     * @author Kero76
     * @package SciMS\File
     * @since SciMS 0.5
     * @version 1.0
     */
    interface FileInterface {
    
        /**
         * Create a file on server with the specific name.
         *
         * @param $file_name
         *  The complete path and the name of the file with this extension.
         * @return bool
         *  Return true if the file is create, otherwise it return false.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function create($file_name);
        
        /**
         * Delete a file on server with the specific name.
         *
         * @param $file_name
         *  The complete path and the name of the file with this extension.
         * @return bool
         *  Return true if the file is delete, otherwise it return false.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function delete($file_name);
    
        /**
         * Write data on the specific file.
         *
         * @param array $data
         *  All data at write on file.
         * @param $file_name
         *  The complete path and the name of the file with this extension where the data are write.
         * @return bool
         *  Return true if the file is create, otherwise it return false.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function write(array $data, $file_name);
    
        /**
         * Read data from the specific file.
         *
         * @param $file_name
         *  The complete path and the name of the file with this extension where the data are read.
         * @return mixed
         *  Return the result under on array or a string, in function of the implementation method.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function read($file_name);
    }

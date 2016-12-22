<?php
    namespace SciMS\File;
    
    use Symfony\Component\Yaml\Yaml;
    
    /**
     * Class YamlFile.
     *
     * @author Kero76
     * @package SciMS\File
     * @since SciMS 0.5
     * @version 1.0
     */
    class YamlFile implements FileInterface {
        
        /**
         * The size of the inline use for write a Yaml file.
         *
         * @const
         * @since SciMS 0.5
         */
        const INLINE = 2;
    
        /**
         * The size of the indentation use for write a Yaml file.
         *
         * @const
         * @since SciMS 0.5
         */
        const INDENTATION = 2;
        
        /**
         * Create a file on server with the specific name.
         *
         * @param $file_name
         *  The complete path and the name of the file with this extension.
         * @return bool
         *  Return true if the file is create, otherwise it return false.
         * @since   SciMS 0.5
         * @version 1.0
         */
        public function create($file_name) {
            
        }
    
        /**
         * Delete a file on server with the specific name.
         *
         * @param $file_name
         *  The complete path and the name of the file with this extension.
         * @return bool
         *  Return true if the file is delete, otherwise it return false.
         * @since   SciMS 0.5
         * @version 1.0
         */
        public function delete($file_name) {
            
        }
    
        /**
         * Write data on the specific file.
         *
         * @param array $data
         *  All data at write on file.
         * @param       $file_name
         *  The complete path and the name of the file with this extension where the data are write.
         * @return bool
         *  Return true if the file is create, otherwise it return false.
         * @since   SciMS 0.5
         * @version 1.0
         */
        public function write(array $data, $file_name) {
            $yaml = Yaml::dump($data, YamlFile::INLINE, YamlFile::INDENTATION);
            $result = file_put_contents($file_name, $yaml);
            
            if (is_int($result)) {
                return true;
            }
            return false;
        }
    
        /**
         * Read data from the specific file.
         *
         * @param $file_name
         *  The complete path and the name of the file with this extension where the data are read.
         * @return mixed
         *  Return the result under on array or a string, in function of the implementation method.
         * @since   SciMS 0.5
         * @version 1.0
         */
        public function read($file_name) {
            return Yaml::parse(file_get_contents($file_name));
        }
    }

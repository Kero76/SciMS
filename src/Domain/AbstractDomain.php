<?php
    namespace SciMS\Domain;
    
    /**
     * Class AbstractDomain.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.4.1
     * @version 1.0
     */
    abstract class AbstractDomain {
        
        /**
         * Method use for hydrate object directly thanks the data from the Database.
         *
         * @access protected
         * @param array $data
         *  An array with all data from the Database.
         * @since SciMS 0.3
         * @version 1.0
         */
        protected function hydrate(array $data) {
            foreach($data as $key => $value) {
                $method = 'set';
                $keySplit = explode("_", $key); // split key name if contains XXX_XXX_XXX
                $count = count($keySplit);
                for ($i = 0; $i < $count; $i++ ) {
                    $method .= ucfirst($keySplit[$i]); // Replace first characters of each word in uppercase form.
                }
                // Execute method if exists on is object.
                if(method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }

<?php
    namespace SciMS\Controller\Checker\Form;

    /**
     * Interface FormChecker.
     *
     * This interface can implements to check all forms presents on website.
     *
     * @author Kero76
     * @package SciMS\Controller\Checker\Form
     * @since SciMS 0.3
     * @version 1.0
     */
    interface FormCheckerInterface {
     
        /**
         * Method use to check insertion the different forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the insertion are correct, else return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkInsert(array $services);
    
        /**
         * Method use to check update the different forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the update are correct, else return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkUpdate(array $services);
    
        /**
         * Method use to check delete the different forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the delete are correct, else return false.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function checkDelete(array $services);
    }

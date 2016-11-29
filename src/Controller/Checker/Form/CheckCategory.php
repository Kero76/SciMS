<?php
    /**
     * Created by PhpStorm.
     * User: Kero76
     * Date: 29/11/16
     * Time: 16:55
     */
    
    namespace SciMS\Controller\Checker\Form;

    /**
     * Class CheckCategory.
     *
     *
     * @author Kero76
     * @package SciMS\Controller\Checker\Form
     * @since SciMS 0.3
     * @version 1.0
     */
    class CheckCategory implements FormChecker {
    
        /**
         * Method use to check insertion the differents forms present on website.
         *
         * @param array $post
         *  The array $_POST.
         * @return bool
         *  True if the insertion are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkInsert(array $post) {
            // TODO: Implement checkInsert() method.
        }
    
        /**
         * Method use to check update the differents forms present on website.
         *
         * @param array $post
         *  The array $_POST.
         * @return bool
         *  True if the update are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkUpdate(array $post) {
            // TODO: Implement checkUpdate() method.
        }
    
        /**
         * Method use to check delete the differents forms present on website.
         *
         * @param array $post
         *  The array $_POST.
         * @return bool
         *  True if the delete are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkDelete(array $post) {
            // TODO: Implement checkDelete() method.
        }
    }
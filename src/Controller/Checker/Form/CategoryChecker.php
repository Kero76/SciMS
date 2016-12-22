<?php
    namespace SciMS\Controller\Checker\Form;
    
    use \SciMS\Controller\Checker\AbstractChecker;

    /**
     * Class CategoryChecker.
     *
     *
     * @author Kero76
     * @package SciMS\Controller\Checker\Form
     * @since SciMS 0.3
     * @version 1.0
     */
    class CategoryChecker extends AbstractChecker implements FormCheckerInterface {
    
        /**
         * Method use to check insertion the different forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the insertion are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkInsert(array $services) {
            $title = $services['post.handler']->getRequestField('title');
            if ($this->emptyString($title) && $this->compareString($title, $services['dao.category']->findByTitle($title))) {
                return false;
            }
            return true;
        }
    
        /**
         * Method use to check update the different forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the update are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkUpdate(array $services) {
            if ($this->emptyString($services['post.handler']->getRequestField('title'))) {
                return false;
            }
            return true;
        }
    
        /**
         * Method use to check delete the differents forms present on website.
         *
         * @param array $services
         *  The array with all services available on website.
         * @return bool
         *  True if the delete are correct, else return false.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function checkDelete(array $services) {
            
        }
    }

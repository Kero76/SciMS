<?php
    namespace SciMS\DAO;
    
    use SciMS\Domain\Category;


    /**
     * Class CategoryDAO.
     *
     * This class represent the interaction between Database and Domain object.
     * In fact, with it, we can interact with the Table Category on Database.
     *
     * @author Kero76
     * @package SciMS\DAO
     * @since SciMS 0.1
     * @version 1.0
     */
    class CategoryDAO extends DAO {
    
        /**
         * Method use for research 1 category thanks to the id.
         *
         * @param $id
         *  The id of the category research on Database.
         * @return \SciMS\Domain\Category
         *  Return an instance of the Category, if it found.
         * @throws \Exception
         * Throw an exception if the user with "id" not found on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findById($id) {
            $sql = "SELECT * FROM `category` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
        
            if ($row) {
                return $this->buildDomain($row);
            } else {
                throw new \Exception("No category with this id is present on Website.");
            }
        }
        
        /**
         * Method use for build a Domain object.
         *
         * @param $row
         *  The data use for build Domain.
         * @return \SciMS\Domain\Category
         *  The corresponding instance of Domain object.
         */
        public function buildDomain($row) {
            $category = new Category($row);
            return $category;
        }
    }
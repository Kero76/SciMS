<?php
    namespace SciMS\DAO;

    use \PDO;
    use \SciMS\Domain\Category;
    
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
         * Return all Categories stored on Database.
         *
         * @return array
         *  Return an array with all categories present on Database.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function findAll() {
            $sql = "SELECT * FROM `category`";
            $result = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
    
            $categories = array();
            foreach ($result as $row) {
                $id = $row['id'];
                $categories[$id] = $this->buildDomain($row);
            }
    
            return $categories;
        }
        
        /**
         * Method use for research 1 category thanks to the id.
         *
         * @param $id
         *  The id of the category research on Database.
         * @return \SciMS\Domain\Category
         *  Return an instance of the Category, if it found.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findById($id) {
            $sql = "SELECT * FROM `category` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
        
            if ($row) {
                return $this->buildDomain($row);
            } else {
                return $this->buildDomain(array());
            }
        }
        
        /**
         * Method use for build a Domain object.
         *
         * @param array $row
         *  The data use for build Domain.
         * @return \SciMS\Domain\Category
         *  The corresponding instance of Domain object.
         */
        public function buildDomain(array $row) {
            $category = new Category($row);
            return $category;
        }
    }
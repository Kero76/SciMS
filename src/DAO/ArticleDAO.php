<?php
    namespace SciMS\DAO;
    
    use \PDO;
    use SciMS\Domain\Article;
    
    /**
     * Class ArticleDAO.
     *
     * This class represent the interaction between Database and Domain object.
     * In fact, with it, we can interact with the Table articles on Database.
     *
     * @author Kero76, TeeGreg
     * @package SciMS\DAO
     * @since SciMS 0.1
     * @version 1.0
     */
    class ArticleDAO extends DAO {
        
        /**
         * Method use for retrieve all articles present on Database.
         *
         * @return array
         *  An array with all Articles present on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findAll() {
            $sql = "SELECT * FROM `articles`";
            $result = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
    
            $articles = array();
            foreach ($result as $row) {
                $id = $row['id'];
                $articles[$id] = $this->buildDomain($row);
            }
                 
            return $articles;
        }
    
        /**
         * Method use for retrieve last $last_nb articles present on Database.
         *
         * @param integer $last_nb
         *  Parameter use for return X last Article present on Website.
         * @return array
         *  An array with all Articles present on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findLastArticle($last_nb) {
            $sql = "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT 0," . $last_nb;
            $result = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
    
            $articles = array();
            foreach ($result as $row) {
                $id = $row['id'];
                $articles[$id] = $this->buildDomain($row);
            }
    
            return $articles;
        }
    
        /**
         * Method use for research 1 article thanks to the id.
         *
         * @param $id
         *  The id of the article research on Database.
         * @return \SciMS\Domain\Article
         *  Return an instance of the Article, if it found.
         * @throws \Exception
         * Throw an exception if the article with "id" not found on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findById($id) {
            $sql = "SELECT * FROM `articles` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
        
            if ($row) {
                return $this->buildDomain($row);
            } else {
                throw new \Exception("No article with this id is present on Website.");
            }
        }
    
        /**
         * Method use for build a Domain object.
         *
         * @param array $row
         *  The data use for build Domain.
         *
         * @return mixed
         *  The corresponding instance of Domain object.
         */
        protected function buildDomain(array $row) {
            $article = new Article($row);
            return $article;
        }
    }

<?php
    namespace SciMS\DAO;
    
    use \PDO;
    use \SciMS\Domain\Article;
    
    /**
     * Class ArticleDAO.
     *
     * This class represent the interaction between Database and Domain object.
     * In fact, with it, it can interact with the Table articles present on Database.
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
         * -> V1.1 :
         *  - Added an instance of User and Category on the loop to respect the setX Attribute.
         *
         * @return array
         *  An array with all Articles present on Database.
         * @since SciMS 0.1
         * @version 1.1
         */
        public function findAll() {
            $user_dao     = new UserDAO();
            $category_dao = new CategoryDAO();
            $sql          = "SELECT * FROM `articles`";
            $result       = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
    
            $articles = array();
            foreach ($result as $row) {
                $id                 = $row['id'];
                $user               = $user_dao->findById($row['writter']);
                $category           = $category_dao->findById($row['category']);
                $row['writter']     = $user;
                $row['categories']  = $category;
                $articles[$id]      = $this->buildDomain($row);
            }
    
            return $articles;
        }
    
        /**
         * Method use for retrieve last $last_nb articles present on Database.
         *
         * -> V1.1 :
         *  - Added an instance of User and Category on the loop to respect the setX Attribute.
         *
         * @param integer $last_nb
         *  Parameter use for return X last Article present on Website.
         * @return array
         *  An array with all Articles present on Database.
         * @since SciMS 0.1
         * @version 1.1
         */
        public function findLastArticle($last_nb) {
            $user_dao     = new UserDAO();
            $category_dao = new CategoryDAO();
            $sql          = "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT 0," . $last_nb;
            $result       = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
    
            $articles = array();
            foreach ($result as $row) {
                $id                 = $row['id'];
                $user               = $user_dao->findById($row['writter']);
                $category           = $category_dao->findById($row['categories']);
                $row['writter']     = $user;
                $row['categories']  = $category;
                $articles[$id]  = $this->buildDomain($row);
            }
    
            return $articles;
        }
    
        /**
         * Method use for research 1 article thanks to the id.
         *
         * -> V1.1 :
         *  - Added an instance of User and Category to respect the setX Attribute.
         *
         * @param $id
         *  The id of the article research on Database.
         * @return \SciMS\Domain\Article
         *  Return an instance of the Article, if it found.
         * @since SciMS 0.1
         * @version 1.1
         */
        public function findById($id) {
            // Retrieve writter id from the database.
            $writter_id = $this->_findWritterById($id);
            
            // Create the user from the database.
            $user_dao = new UserDAO();
            $user     = $user_dao->findById($writter_id);
            
            // Retrieve Category id from the Database.
            $category_id = $this->_findCategoryById($id);
            
            // Create the Category from the Database.
            $category_dao = new CategoryDAO();
            $category     = $category_dao->findById($category_id);
            
            // Select article from database.
            $sql = "SELECT * FROM `articles` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
        
            // Build domain object.
            if ($row) {
                $row['categories'] = $category;
                $row['writter']    = $user;
                return $this->buildDomain($row);
            }
        }
        
        /**
         * Method use for research a list of articles using tag.
         *
         * @param $tags
         *  A list of tag to search in the Database.
         * @return \SciMS\Domain\Article
         *  Return a collection of Article, as found.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function findByTag(array $tags) {
            $rows = array();
            foreach ($tags as $tag) {
                $sql = "SELECT * FROM `articles` WHERE tags like %$tag%";
                $rows.push($this->getDatabase()->query($sql, PDO::FETCH_ASSOC));
            }
            $rows = array_unique($rows);
            $articles = array();
            foreach ($rows as $row) {
                $id = $row['id'];
                $articles[$id] = $this->buildDomain($row);
            }
            return $articles;
        }
    
        /**
         * Method use for research 1 article thanks to the category.
         *
         * @param $category
         *  The id of the article research on Database.
         * @return array
         *  Return an collection of Article, as found.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function findByCategories($category) {
            $user_dao     = new UserDAO();
            $category_dao = new CategoryDAO();
            
            $sql = "SELECT * FROM `articles` WHERE categories = $category";
            $rows = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
            
            $articles = array();
            foreach ($rows as $row) {
                $id                 = $row['id'];
                $user               = $user_dao->findById($row['writter']);
                $category           = $category_dao->findById($row['categories']);
                $row['writter']     = $user;
                $row['categories']  = $category;
                $articles[$id]  = $this->buildDomain($row);
            }
    
            return $articles;
        }
        
        /**
         * Method use to get all the articles own by a use.
         *
         * @param $userid
         *  The id of the writter research on Database.
         * @return array
         *  Return an collection of Article, as found.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function findByOwnership($userid) {
            $user_dao     = new UserDAO();
            $category_dao = new CategoryDAO();
            $sql          = "SELECT * FROM `articles` WHERE writter = $userid";
            $rows         = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
    
            $articles = array();
            foreach ($rows as $row) {
                $id                 = $row['id'];
                $user               = $user_dao->findById($row['writter']);
                $category           = $category_dao->findById($row['categories']);
                $row['writter']     = $user;
                $row['categories']  = $category;
                $articles[$id]  = $this->buildDomain($row);
            }
    
            return $articles;
        }
        
        /**
         * Method use for return last id present on Database.
         *
         * @return integer
         *  Return the last id present on Database.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function findLastId() {
            $sql = "SELECT MAX(id) AS max FROM `articles`";
            $row = $this->getDatabase()->execute($sql, array(), PDO::FETCH_ASSOC);
        
            return $row['max'];
        }
        
        /**
         * Method use for register an article.
         *
         * ->V1.1 :
         *  - Added abstract attribute on request and article instance creation.
         *
         * @param \SciMS\Domain\Article $article
         *  The article to add on Database.
         * @since SciMS 0.2
         * @version 1.1
         */
        public function saveArticle(Article $article) {
            // Stored article informations into on associative array.
            $infoUser = array(
                'title'             => $article->getTitle(),
                'abstract'          => $article->getAbstract(),
                'content'           => $article->getContent(),
                'authors'           => $article->getAuthors(),
                'categories'        => $article->getCategories()->getId(),
                'tags'              => $article->getTags(),
                'status'            => $article->getStatus(),
                'writter'           => $article->getWritter()->getId(),
                'displayed_summary' => $article->getDisplayedSummary(),
            );
        
            $sql = "INSERT INTO `articles` (title, abstract, content, authors, categories, tags, status, writter, displayed_summary) VALUES (:title, :abstract, :content, :authors, :categories, :tags, :status, :writter, :displayed_summary)";
            $this->getDatabase()->update($sql, $infoUser);
        }
    
        /**
         * Method use for update an user.
         *
         * ->V1.1 :
         *  - Added abstract attribute on request and article instance creation.
         *
         * @param \SciMS\Domain\Article $article
         *  The user at update on Database.
         * @since SciMS 0.2
         * @version 1.1
         */
        public function updateArticle(Article $article) {
            // Stored users informations into on associative array.
            $infoArticle = array(
                'title'             => $article->getTitle(),
                'abstract'          => $article->getAbstract(),
                'content'           => $article->getContent(),
                'authors'           => $article->getAuthors(),
                'categories'        => $article->getCategories()->getId(),
                'tags'              => $article->getTags(),
                'status'            => $article->getStatus(),
                'date_modified'     => $article->getDateModified(),
                'writter'           => $article->getWritter()->getId(),
                'displayed_summary' => $article->getDisplayedSummary(),
                'id'                => $article->getId(),
            );
            
            $sql = "UPDATE `articles` SET title = :title, abstract = :abstract, content = :content, authors = :authors, categories = :categories, tags = :tags, status = :status, date_modified = :date_modified, writter = :writter, displayed_summary = :displayed_summary WHERE id = :id";
            $this->getDatabase()->update($sql, $infoArticle);
        }
    
    
        /**
         * Method use for search a writter thanks to the article id.
         *
         * @access private
         * @param $id
         *  The id of the article.
         * @return integer
         *  Id of the writter.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _findWritterById($id) {
            $sql = "SELECT writter FROM `articles` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
            return $row['writter'];
        }
    
        /**
         * Method use for search a category thanks to the article id.
         *
         * @access private
         * @param $id
         *  The id of the article.
         * @return integer
         *  Id of the category.
         * @since SciMS 0.2
         * @version 1.0
         */
        private function _findCategoryById($id) {
            $sql = "SELECT categories FROM `articles` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
            return $row['categories'];
        }
    
        /**
         * Method use for build a Domain object.
         *
         * @param array $row
         *  The data use for build Domain.
         * @return mixed
         *  The corresponding instance of Domain object.
         * @since SciMS 0.1
         * @version 1.0
         */
        protected function buildDomain(array $row) {
            $article = new Article($row);
            return $article;
        }
    }

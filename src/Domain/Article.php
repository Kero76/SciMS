<?php
    namespace SciMS\Domain;

    /**
     * Class Article.
     *
     * This class is a representation of the Article.
     * He have 4 role on website :
     *  - RELEASE : Visible on the Website.
     *  - PENDING : Can invisible except for Administrator and Moderator.
     *  - HIDDEN  : Totally hidden.
     *
     * -> V1.1 :
     *  Added constantes attributes representing status.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.1
     * @version 1.1
     */
    class Article {
    
        /**
         * Release status of the Article.
         *
         * @const
         * @var integer
         * @since SciMS 0.1
         */
        const RELEASE = 0;
    
        /**
         * Pending status of the Article.
         * @const
         * @var integer
         * @since SciMS 0.1
         */
        const PENDING = 1;
    
        /**
         * Hidden status of the Article.
         *
         * @const
         * @var integer
         * @since SciMS 0.1
         */
        const HIDDEN  = 2;
    
        /**
         * Id of the Article.
         *
         * @var integer
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_id;
    
        /**
         * Title of the Article.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_title;
    
        /**
         * Content of the Article.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_content;
    
        /**
         * Author of the Article.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_authors;
    
        /**
         * Category of the Article.
         *
         * @var \SciMS\Domain\Category
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_categories;
    
        /**
         * Tags of the Article.
         *
         * @var string
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_tags;
    
        /**
         * Status of the Article.
         *
         * @var integer
         * @since SciMS 0.1
         * @version 1.0
         */
        private $_status;
    
        /**
         * Creation date of the Article.
         *
         * @var timestamp
         * @since SciMS 0.1
         * @version 1.0
         */
        private $date_creation;
    
        /**
         * Modification date of the Article.
         *
         * @var timestamp
         * @since SciMS 0.1
         * @version 1.0
         */
        private $date_modified;
    
        /**
         * Writer of the Article.
         *
         * @var \SciMS\Domain\User
         * @since SciMS 0.1
         * @version 1.0
         */
        private $writer;
    
        /**
         * Article constructor.
         *
         * @constructor
         * @param array $data
         *  An array with all data used for hydrate object.
         * @see _hydrate(array $data)
         * @since SciMS 0.1
         * @version 1.0
         */
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
    
        /**
         * Return the id of the Article.
         *
         * @return integer
         *  Return the id of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getId() {
            return $this->_id;
        }
    
        /**
         * Set the id of the Article.
         *
         * @param integer $id
         *  Id of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setId($id) {
            $this->_id = $id;
        }
    
        /**
         * Return the title of the Article.
         *
         * @return string
         *  Return the title of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getTitle() {
            return $this->_title;
        }
    
        /**
         * Set the title of the Article.
         *
         * @param string $title
         *  The title of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setTitle($title) {
            $this->_title = $title;
        }
    
        /**
         * Return the content of the Article.
         *
         * @return string
         *  The content of the Article
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getContent() {
            return $this->_content;
        }
    
        /**
         * Set the content of the Article.
         *
         * @param string $content
         *  The content of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setContent($content) {
            $this->_content = $content;
        }
    
        /**
         * Return the authors of the Article.
         *
         * @return string
         *  The authors of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getAuthors() {
            return $this->_authors;
        }
    
        /**
         * Set the authors of the authors.
         *
         * @param string $authors
         *  The authors of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setAuthors($authors) {
            $this->_authors = $authors;
        }
    
        /**
         * Return an instance of Category.
         *
         * @return \SciMS\Domain\Category
         *  An instance of Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getCategories() {
            return $this->_categories;
        }
    
        /**
         * Set the category of the Article.
         *
         * @param \SciMS\Domain\Category $categories
         *  An instance of Category.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setCategories($categories) {
            $this->_categories = $categories;
        }
    
        /**
         * Return the all tags apply at the article.
         *
         * @return string
         *  A string with all tags.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getTags() {
            return $this->_tags;
        }
    
        /**
         * Set the Tags of the article.
         *
         * @param string $tags
         *  The list of all tags separate with comma.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setTags($tags) {
            $tags_explode = explode(',', $tags);
            $this->_tags = $tags_explode;
        }
    
        /**
         * Return the status of the Article.
         *
         * @return integer
         *  Return the status of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getStatus() {
            return $this->_status;
        }
    
        /**
         * Set the status of the Article.
         *
         * @param integer $status
         *  Return the status of the Article.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setStatus($status) {
            switch ($status) {
                case self::RELEASE :
                    $this->_status = self::RELEASE;
                    break;
    
                case self::PENDING :
                    $this->_status = self::PENDING;
                    break;
    
                case self::HIDDEN :
                    $this->_status = self::HIDDEN;
                    break;
            }
        }
        
        /**
         * Return the date of the article creation.
         *
         * @return mixed
         *  The creation date at format timestamp.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getDateCreation() {
            return $this->date_creation;
        }
    
        /**
         * Set the date of the article creation.
         *
         * @param mixed $date_creation
         *  A timestamp date format.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setDateCreation($date_creation) {
            $this->date_creation = $date_creation;
        }
    
        /**
         * Return the date of the last modification of the Article.
         *
         * @return mixed
         *  The last date at format timestamp.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getDateModified() {
            return $this->date_modified;
        }
    
        /**
         * Set the date of the last modification of the Article.
         *
         * @param mixed $date_modified
         *  The date of the last modification on Timestamp format.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setDateModified($date_modified) {
            $this->date_modified = $date_modified;
        }
    
        /**
         * Return the Writer.
         *
         * @return \SciMS\Domain\User
         *  An instance of User.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getWriter() {
            return $this->writer;
        }
    
        /**
         * Set the writer.
         *
         * @param \SciMS\Domain\User $writer
         *  The value of the Writer.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setWriter($writer) {
            $this->writer = $writer;
        }
        
        /**
         * Method use for hydrate object directly thanks the data from the Database.
         *
         * @access private
         * @param array $data
         *  An array with all data from the Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        private function _hydrate(array $data) {
            foreach($data as $key => $value) {
                $method = 'set';
                $keySplit = explode("_", $key); // split key name if contains XXX_XXX_XXX
                for ($i = 0; $i < count($keySplit); $i++ ) {
                    $method .= ucfirst($keySplit[$i]); // Replace first characters of each word in uppercase form.
                }
                // Execute method if exists on is object.
                if(method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }
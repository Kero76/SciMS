<?php
    namespace SciMS\Domain;
    
    /**
     * Created by PhpStorm.
     * User: Kero76
     * Date: 04/11/16
     * Time: 14:01
     */
    class Article {
    
        /**
         * @var integer
         */
        private $_id;
    
        /**
         * @var string
         */
        private $_title;
    
        /**
         * @var string
         */
        private $_content;
    
        /**
         * @var string
         */
        private $_authors;
    
        /**
         * @var \SciMS\Domain\Category
         */
        private $_categories;
    
        /**
         * @var string
         */
        private $_tags;
    
        /**
         * @var integer
         */
        private $_status;
    
        /**
         * @var timestamp
         */
        private $date_creation;
    
        /**
         * @var timestamp
         */
        private $date_modified;
    
        /**
         * @var \SciMS\Domain\User
         */
        private $writer;
        
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
    
        /**
         * @return mixed
         */
        public function getId() {
            return $this->_id;
        }
    
        /**
         * @param mixed $id
         */
        public function setId($id) {
            $this->_id = $id;
        }
    
        /**
         * @return mixed
         */
        public function getTitle() {
            return $this->_title;
        }
    
        /**
         * @param mixed $title
         */
        public function setTitle($title) {
            $this->_title = $title;
        }
    
        /**
         * @return mixed
         */
        public function getContent() {
            return $this->_content;
        }
    
        /**
         * @param mixed $content
         */
        public function setContent($content) {
            $this->_content = $content;
        }
    
        /**
         * @return mixed
         */
        public function getAuthors() {
            return $this->_authors;
        }
    
        /**
         * @param mixed $authors
         */
        public function setAuthors($authors) {
            $this->_authors = $authors;
        }
    
        /**
         * @return mixed
         */
        public function getCategories() {
            return $this->_categories;
        }
    
        /**
         *
         * @param \SciMS\$categories
         *  An instance of Category.
         */
        public function setCategories($categories) {
            $this->_categories = $categories;
        }
    
        /**
         * Return the all tags apply at the article.
         *
         * @return string
         *  A string with all tags.
         */
        public function getTags() {
            return $this->_tags;
        }
    
        /**
         * Set the Tags of the article.
         *
         * @param string $tags
         *  The list of all tags separate with comma.
         */
        public function setTags($tags) {
            $this->_tags = $tags;
        }
    
        /**
         * @return mixed
         */
        public function getStatus() {
            return $this->_status;
        }
    
        /**
         * @param mixed $status
         */
        public function setStatus($status) {
            $this->_status = $status;
        }
        
        /**
         * Return the date of the article creation.
         *
         * @return mixed
         *  The creation date at format timestamp.
         */
        public function getDateCreation() {
            return $this->date_creation;
        }
    
        /**
         * Set the date of the article creation.
         *
         * @param mixed $date_creation
         *  A timestamp date format.
         */
        public function setDateCreation($date_creation) {
            $this->date_creation = $date_creation;
        }
    
        /**
         * Return the date of the last modification of the Article.
         *
         * @return mixed
         *  The last date at format timestamp.
         */
        public function getDateModified() {
            return $this->date_modified;
        }
    
        /**
         * Set the date of the last modification of the Article.
         *
         * @param mixed $date_modified
         *  The date of the last modification on Timestamp format.
         */
        public function setDateModified($date_modified) {
            $this->date_modified = $date_modified;
        }
    
        /**
         * Return the Writer.
         *
         * @return \SciMS\Domain\User
         *  An instance of User.
         */
        public function getWriter() {
            return $this->writer;
        }
    
        /**
         * Set the writer.
         *
         * @param \SciMS\Domain\User $writer
         *  The value of the Writer.
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
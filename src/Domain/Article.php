<?php
    namespace SciMS\Domain;

    /**
     * Class Article.
     *
     * This class is a representation of the Article.
     * An article have one of these three possible status :
     *  - RELEASE : Visible on the Website.
     *  - PENDING : Can invisible except for Administrator and Moderator.
     *  - HIDDEN  : Totally hidden.
     *
     * -> V1.1 :
     *  Added constants attributes representing status.
     * -> V1.2 :
     *  Added abstract attributes on Article.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.1
     * @version 1.1
     */
    class Article extends AbstractDomain {
    
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
         */
        private $_id;
    
        /**
         * Title of the Article.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_title;
    
        /**
         * Abstract of the Article.
         *
         * @var string
         * @since SciMS 0.4
         */
        private $_abstract;
    
        /**
         * Content of the Article.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_content;
    
        /**
         * Author of the Article.
         *
         * @var string
         * @since SciMS 0.1
         */
        private $_authors;
    
        /**
         * Category of the Article.
         *
         * @var \SciMS\Domain\Category
         * @since SciMS 0.1
         */
        private $_categories;
    
        /**
         * Tags of the Article.
         *
         * @var array
         * @since SciMS 0.1
         */
        private $_tags;
    
        /**
         * Status of the Article.
         *
         * @var integer
         * @since SciMS 0.1
         */
        private $_status;
    
        /**
         * Creation date of the Article.
         *
         * @var timestamp
         * @since SciMS 0.1
         */
        private $_date_creation;
    
        /**
         * Modification date of the Article.
         *
         * @var timestamp
         * @since SciMS 0.1
         */
        private $_date_modified;
    
        /**
         * Writter of the Article.
         *
         * @var \SciMS\Domain\User
         * @since SciMS 0.1
         */
        private $_writter;
    
        /**
         * Indicate if the summary is display or not.
         * @var bool
         * @since SciMS 0.4
         */
        private $_displayed_summary;
    
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
            $this->hydrate($data);
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
         * Return the Abstract of the Article.
         * @return string
         *  The abstract of the article.
         * @since SciMS 0.4
         * @version 1.0
         */
        public function getAbstract() {
            return $this->_abstract;
        }
    
        /**
         * Set the abstract of the article.
         *
         * @param string $abstract
         *  The abstract of the article.
         * @since SciMS 0.4
         * @version 1.0
         */
        public function setAbstract($abstract) {
            $this->_abstract = $abstract;
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
        public function setCategories(Category $categories) {
            $this->_categories = $categories;
        }
    
        /**
         * Return the all tags apply at the article.
         *
         * @return array
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
            $this->_tags = $tags;
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
            return $this->_date_creation;
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
            $this->_date_creation = $date_creation;
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
            return $this->_date_modified;
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
            $this->_date_modified = $date_modified;
        }
    
        /**
         * Return the Writer.
         *
         * @return \SciMS\Domain\User
         *  An instance of User.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function getWritter() {
            return $this->_writter;
        }
    
        /**
         * Set the writer.
         *
         * @param \SciMS\Domain\User $writter
         *  The value of the Writter.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function setWritter(User $writter) {
            $this->_writter = $writter;
        }
    
        /**
         * Return if the summary can display or not.
         *
         * @return boolean
         *  A boolean who indicate if the article is displayed or not.
         * @since SciMS 0.4
         * @version 1.0
         */
        public function getDisplayedSummary() {
            return $this->_displayed_summary;
        }
    
        /**
         * Set if the summary is display or not.
         *
         * @param boolean $displayed_summary
         *  A boolean who indicate if the article is displayed or not.
         * @since SciMS 0.4
         * @version 1.0
         */
        public function setDisplayedSummary($displayed_summary) {
            $this->_displayed_summary = $displayed_summary;
        }
    }

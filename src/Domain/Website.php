<?php
    namespace SciMS\Domain;

    /**
     * Class Website.
     *
     * This class contains all settings about the website.
     * It contains :
     *  - Title of the website.
     *  - Number of article at display on home.
     *  - Status of articles available when user create an Article.
     *  - Role of user can receive on website.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.3
     * @version 1.0
     */
    class Website {
    
        /**
         * Title of the website.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_title;
    
        /**
         * Subtitle of the website.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_subtitle;
    
        /**
         * Copyright of the website
         *
         * @var string
         * @since 0.3
         */
        private $_copyright;
    
        /**
         * Number of article at display on website.
         *
         * @var integer
         * @since SciMS 0.3
         */
        private $_last_article;
    
        /**
         * Status of article.
         *
         * @var array
         * @since SciMS 0.3
         */
        private $_article_status;
    
        /**
         * Role of the user.
         *
         * @var array
         * @since SciMS 0.3
         */
        private $_user_role;
    
        /**
         * Website constructor.
         *
         * @constructor
         * @param array $data
         *  An array with all data use to build website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function __construct(array $data) {
            $this->_hydrate($data);
        }
    
        /**
         * Return the title of the website.
         *
         * @return string
         *  The title of the website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getTitle() {
            return $this->_title;
        }
    
        /**
         * Set the title of the website.
         *
         * @param string $title
         *  The title of the website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setTitle($title) {
            $this->_title = $title;
        }
    
        /**
         * Return the subtitle of the website.
         *
         * @return string
         *  The subtitle of the website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getSubtitle() {
            return $this->_subtitle;
        }
    
        /**
         * Set the subtitle of the website.
         *
         * @param string $subtitle
         *  The subtitle of the website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setSubtitle($subtitle) {
            $this->_subtitle = $subtitle;
        }
    
        /**
         * Return the copyright of the website.
         *
         * @return string
         *  The copyright of the website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getCopyright() {
            return $this->_copyright;
        }
    
        /**
         * Set the copyright of the website.
         *
         * @param string $copyright
         *  The copyright of the website.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setCopyright($copyright) {
            $this->_copyright = $copyright;
        }
    
        /**
         * Return the number of the article display on home page of the website.
         *
         * @return integer
         *  The number of article display on website
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getLastArticle() {
            return $this->_last_article;
        }
    
        /**
         * Set the number of article display on website.
         *
         * @param integer $number_of_article
         *  Set the number of the last article.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setLastArticle($number_of_article) {
            $this->_last_article = $number_of_article;
        }
    
        /**
         * Return the article status.
         *
         * @return array
         *  The array with all article status.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getArticleStatus() {
            return $this->_article_status;
        }
    
        /**
         * Set the article status.
         *
         * @param array $article_status
         *  The article status.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setArticleStatus(array $article_status) {
            $this->_article_status = $article_status;
        }
    
        /**
         * Return the role of the user.
         *
         * @return array
         *  The role of the user.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getUserRole() {
            return $this->_user_role;
        }
    
        /**
         * Set the role of the user.
         *
         * @param array $user_role
         *  The role of the user.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setUserRole(array $user_role) {
            $this->_user_role = $user_role;
        }
    
        /**
         * Method use for hydrate object directly thanks the data from the Database.
         *
         * @access private
         * @param array $data
         *  An array with all data from the Database.
         * @since SciMS 0.3
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
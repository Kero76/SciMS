<?php
    namespace SciMS\Domain;
    
    /**
     * Class Theme.
     *
     * This class contains informations about the Bootstrap theme apply on website.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.4.1
     * @version 1.0
     */
    class Theme extends AbstractDomain {
    
        /**
         * Path of the themes present on themes.yml.
         *
         * @var string
         * @since SciMS 0.5
         */
        const THEMES_SETTING_PATH = '../app/themes.yml';
    
        /**
         * Name of the theme.
         * @var string
         * @since SciMS 0.4.1
         */
        private $_name;
    
        /**
         * Link of the theme.
         *
         * @var string
         * @since SciMS 0.4.1
         */
        private $_link;
    
        /**
         * Integrity value of the theme.
         *
         * @var string
         * @since SciMS 0.4.1
         */
        private $_integrity;
        
        /**
         * Theme constructor.
         *
         * @constructor
         * @param array $data
         *  An array with all data use to build website.
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function __construct(array $data) {
            $this->hydrate($data);
        }
    
        /**
         * Return the name of the theme.
         *
         * @return string
         *  The name of the theme.
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function getName() {
            return $this->_name;
        }
    
        /**
         * Set the name of the theme.
         *
         * @param string $name
         *  the name of the theme.
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function setName($name) {
            $this->_name = $name;
        }
    
        /**
         * Return the theme link.
         *
         * @return string
         *  The link of the theme.
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function getLink() {
            return $this->_link;
        }
    
        /**
         * Set the link of the theme.
         *
         * @param string $link
         *  The link of the theme.
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function setLink($link) {
            $this->_link = $link;
        }
    
        /**
         * Return the integrity value of the theme.
         *
         * @return string
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function getIntegrity() {
            return $this->_integrity;
        }
    
        /**
         * Set the integrity value.
         *
         * @param string $integrity
         *  The integrity value.
         * @since SciMS 0.4.1
         * @version 1.0
         */
        public function setIntegrity($integrity) {
            $this->_integrity = $integrity;
        }
    }

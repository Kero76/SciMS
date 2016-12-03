<?php
    namespace SciMS\Domain;
    
    use \Symfony\Component\Yaml\Yaml;

    /**
     * Class DatabaseSetting.
     *
     * This class contains all settings about the website.
     * It contains :
     *  - The DNS of the Database connection.
     *  - The user of the Database connection.
     *  - The password of the Database connection.
     *
     * @author Kero76
     * @package SciMS\Domain
     * @since SciMS 0.3
     * @version 1.0
     */
    class DatabaseSetting {
    
        /**
         * The dns of the database access.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_dns;
    
        /**
         * The database name of the database access.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_dbname;
    
        /**
         * The user of the database access.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $_user;
    
        /**
         * The password of the database access.
         *
         * @var string
         * @since SciMS 0.3
         */
        private $password;
    
        /**
         * Unique instance of DatabaseSetting.
         *
         * @var \SciMS\Domain\DatabaseSetting $instance
         * @since SciMS 0.3
         */
        private static $_instance = NULL;
    
        /**
         * Relative path of the database setting file at the Yaml format.
         *
         * @const
         * @var string
         * @since SciMS 0.3
         */
        const DB_SETTING_PATH = '../app/database.yml';
    
        /**
         * DatabaseSetting constructor.
         *
         * @access private
         * @constructor
         * @since SciMS 0.3
         * @version 1.0
         */
        private function __construct() {
            $database_setting = Yaml::parse(file_get_contents(self::DB_SETTING_PATH))['database'];
            $this->_hydrate($database_setting);
        }
        
        /**
         * Method use too call the unique instance of the Database connector.*
         *
         * It create the instance of the Database if the attributes $_instance is at NULL.
         * Otherwise, it return only the instance of this class.
         *
         * @return \SciMS\Domain\DatabaseSetting
         *  The unique instance of Database object on the project.
         * @static
         * @since SciMS 0.3
         * @version 1.0
         */
        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new DatabaseSetting();
            }
            return self::$_instance;
        }
    
        /**
         * Return the Dns of the database connection.
         *
         * @return string
         *  The dns of the Database connection.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getDns() {
            return $this->_dns;
        }
    
        /**
         * Set the dns of the Database connection.
         *
         * @param string $dns
         *  The dns of the Database connection.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setDns($dns) {
            $this->_dns = $dns;
        }
    
        /**
         * Return the dbname of the database connection.
         *
         * @return string
         *  The dns of the Database connection.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getDbname() {
            return $this->_dbname;
        }
    
        /**
         * Set the dbname of the Database connection.
         *
         * @param string $dbname
         *  The dbname of the Database connection.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setDbname($dbname) {
            $this->_dbname = $dbname;
        }
    
        /**
         * Return the user of the Database connection.
         *
         * @return string
         *  The user of the Database connection.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getUser() {
            return $this->_user;
        }
    
        /**
         * Set the user of the Database connection.
         *
         * @param string $user
         *  The user of the Database.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setUser($user) {
            $this->_user = $user;
        }
    
        /**
         * Return the password of the Database connection.
         *
         * @return string
         *  The password of the Database.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getPassword() {
            return $this->password;
        }
    
        /**
         * Set the Database password.
         *
         * @param string $password
         *  The Database password.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function setPassword($password) {
            $this->password = $password;
        }
    
        /**
         * Method unimplements because it can be possible to clone the Singleton.
         *
         * @access private
         * @since SciMS 0.3
         * @version 1.0
         */
        private function __clone() { }
        
        /**
         * Method use for hydrate object directly thanks the data from the setting file.
         *
         * @access private
         * @param array $data
         *  An array with all data from the setting file.
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
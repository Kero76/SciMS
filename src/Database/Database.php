<?php
    namespace SciMS\Database;
    
    use \PDO;
    use \Exception;
    use \SciMS\Controller\Checker\FileChecker;

    /**
     * Class Database.
     *
     * This class respect the singleton pattern.
     * In fact, in the project, it only necessary to have one access at the Database.
     * So, it use the Singleton pattern to respect this condition and dialogue with the Database.
     * The connexion with the Database is automatically closed when the script is finished.
     * So, it's not necessary to develop a "close" method, but it can be possible to use it, then, it develop it.
     *
     * -> v1.1 :
     *  - Add method update($sql, array $statement) to update table on database.
     *
     * -> v1.2 :
     *  - Add Singleton DatabaseSetting to configure database connection on app/database.yml files.
     *  - Remove const defines to configure Database access.
     *
     * -> v1.3 :
     *  - Add method exec.
     *
     * @author Kero76
     * @package \SciMS\Database
     * @since SciMS 0.1
     * @version 1.3
     */
    class Database {
        
        /**
         * Stored the only one instance of Database on is project.
         *
         * @static
         * @var \SciMS\Database\Database
         *  Attribute use for stored the only one instance of Database in is project.
         * @since SciMS 0.1
         */
        private static $_instance = NULL;
    
        /**
         * PDO Instance for communicate with the Database.
         *
         * @var \PDO
         * @since SciMS 0.1
         */
        private $_pdo;
    
        /**
         * Database constructor.
         *
         * -> v1.1 :
         *  - Added Singleton DatabaseSetting to configure database connection on app/database.yml files.
         *
         * @access private
         * @constructor
         * @since SciMS 0.1
         * @version 1.1
         */
        private function __construct() {
            $fileChecker = new FileChecker();
            if ($fileChecker->fileExist(DatabaseSetting::DB_SETTING_PATH)) {
                try {
                    $this->_pdo = new PDO(DatabaseSetting::getInstance()->getDns() . DatabaseSetting::getInstance()->getDbname(),
                        DatabaseSetting::getInstance()->getUser(), DatabaseSetting::getInstance()->getPassword());
                    $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $e) {
                    echo 'Erreur : ' . $e->getMessage().'<br />';
                    echo 'N° : '.$e->getCode();
                }
            }
        }
    
        /**
         * Method unimplements because it can be possible to clone the Singleton.
         *
         * @access private
         * @since SciMS 0.1
         * @version 1.0
         */
        private function __clone() { }
    
        /**
         * Method use too call the unique instance of the Database connector.*
         *
         * It create the instance of the Database if the attributes $_instance is at NULL.
         * Otherwise, it return only the instance of this class.
         *
         * @return \SciMS\Database\Database
         *  The unique instance of Database object on the project.
         * @static
         * @since SciMS 0.1
         * @version 1.0
         */
        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new Database();
            }
            return self::$_instance;
        }
    
        /**
         * Method use for execute a SQL request with statement.
         *
         * @param       $sql
         *  The SQL request to execute.
         * @param array $statement
         *  The statement present on prepare request.
         * @param       $fetch_style
         *  Method use to fetch data retrieve from PDO.
         * @return mixed
         *  Return the data with format speficic on fetchMethod attributes.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function execute($sql, array $statement, $fetch_style = NULL) {
            $request = $this->_pdo->prepare($sql);
            $request->execute($statement);
            
            if ($fetch_style === NULL) {
                return $request->fetch();
            }
            return $request->fetch($fetch_style);
        }
    
        /**
         * Method use for execute SQL request without parameters on it.
         *
         * @param $sql
         *  The SQL request to use for query the Database.
         * @param $fetch_style
         *  Select the fetch mode using in query function.
         * @param $class
         *  Return the corresponding classes required.
         * @return array
         *  An array with all row present on database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function query($sql, $fetch_style = PDO::ATTR_DEFAULT_FETCH_MODE, $class = '') {
            if (strlen($class) > 0) {
                return $this->_pdo->query($sql)->fetchAll($fetch_style, '\\SciMS\\Domain\\' . $class);
            } else {
                return $this->_pdo->query($sql)->fetchAll($fetch_style);
            }
        }
    
        /**
         * Method use to execute SQL request.
         *
         * @param $sql
         *  SQL request to execute on Database.
         * @return integer
         *  Return the number of rows update by SQL request.
         * @since SciMS 0.5
         * @version 1.0
         */
        public function exec($sql) {
            return $this->_pdo->exec($sql);
        }
        
        /**
         * Method use for execute a SQL request with statement to update table present on Database.
         *
         * @param       $sql
         *  The SQL request to execute.
         * @param array $statement
         *  The statement present on prepare request.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function update($sql, array $statement) {
            $request = $this->_pdo->prepare($sql);
            $request->execute($statement);
        }
    }

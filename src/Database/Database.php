<?php
    namespace SciMS\Database;

    use \PDO;
    
    /**
     * Class Database.
     *
     * This class respect the singleton pattern.
     * In fact, in the project, it only necessary to have one access at the Database.
     * So, it use the Singleton pattern to respect this condition and dialogue with the Database.
     * The connexion with the Database is automatically closed when the script is finished.
     * So, it's not necessary to develop a "close" method, but it can be possible to use it, then, it develop it.
     *
     * @author Kero76
     * @package \SciMS\Database
     * @since SciMS 0.1
     * @version 1.0
     */
    class Database {
    
        const HOST      = "db655171027.db.1and1.com";
        const DBNAME    ="db655171027";
        const USER      = "dbo655171027";
        const PASSWORD  = "uh92ZJ7i8TWg";
    
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
         * @access private
         * @constructor
         * @since SciMS 0.1
         * @version 1.0
         */
        private function __construct() {
            try {
                $this->_pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DBNAME, self::USER, self::PASSWORD);
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage().'<br />';
                echo 'N° : '.$e->getCode();
                die();
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
         *  The SQL requet to execute.
         * @param array $statement
         *  The statement present on prepare request.
         * @param       $fetchMethod
         *  Method use to fetch data retrieve from PDO.
         * @return mixed
         *  Return the data with format speficic on fetchMethod attributes.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function execute($sql, array $statement, $fetchMethod) {
            $request = $this->_pdo->prepare($sql);
            $request->execute($statement);
            return $request->fetch($fetchMethod);
        }
    
        /**
         * Method use for execute SQL request without parameters on it.
         *
         * @param $sql
         *  The SQL request to use for query the Database.
         * @return \PDOStatement
         *  Return a PDOStatement who representing the data from the Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function query($sql) {
            return $this->_pdo->query($sql);
        }
    }
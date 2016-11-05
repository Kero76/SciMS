<?php
    namespace SciMS\Domain;
    
    /**
     * Created by PhpStorm.
     * User: Kero76
     * Date: 04/11/16
     * Time: 14:01
     */
    class User {
        private $_id;
        private $_fname;
        private $_lname;
        private $_username;
        private $_email;
        private $_password;
        private $_salt;
        private $_avatar;
        private $_role;
    
        /**
         * User constructor.
         * @constructor
         * @param array $data
         *  An array with all data from Database.
         */
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
        public function getFname() {
            return $this->_fname;
        }
    
        /**
         * @param mixed $fname
         */
        public function setFname($fname) {
            $this->_fname = $fname;
        }
    
        /**
         * @return mixed
         */
        public function getLname() {
            return $this->_lname;
        }
    
        /**
         * @param mixed $lname
         */
        public function setLname($lname) {
            $this->_lname = $lname;
        }
    
        /**
         * @return mixed
         */
        public function getUsername() {
            return $this->_username;
        }
    
        /**
         * @param mixed $username
         */
        public function setUsername($username) {
            $this->_username = $username;
        }
        
        /**
         * @return mixed
         */
        public function getEmail() {
            return $this->_email;
        }
    
        /**
         * @param mixed $email
         */
        public function setEmail($email) {
            $this->_email = $email;
        }
    
        /**
         * @return mixed
         */
        public function getPassword() {
            return $this->_password;
        }
    
        /**
         * @param mixed $password
         */
        public function setPassword($password) {
            $this->_password = $password;
        }
    
        /**
         * @return mixed
         */
        public function getSalt() {
            return $this->_salt;
        }
    
        /**
         * @param mixed $salt
         */
        public function setSalt($salt) {
            $this->_salt = $salt;
        }
    
        /**
         * @return mixed
         */
        public function getAvatar() {
            return $this->_avatar;
        }
    
        /**
         * @param mixed $avatar
         */
        public function setAvatar($avatar) {
            $this->_avatar = $avatar;
        }
    
        /**
         * @return mixed
         */
        public function getRole() {
            return $this->_role;
        }
    
        /**
         * @param mixed $role
         */
        public function setRole($role) {
            $this->_role = $role;
        }
        
        /**
         * @access private
         * @param array $data
         */
        private function _hydrate(array $data) {
            foreach($data as $key => $value) {
                $method = 'set';
                $keySplit = explode("_", $key);
                for ($i = 0; $i < count($keySplit); $i++ ) {
                    $method .= ucfirst($keySplit[$i]);
                }
                if(method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
    }
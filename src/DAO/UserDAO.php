<?php
    namespace SciMS\DAO;

    use \PDO;
    use SciMS\Domain\User;

    /**
     * Class UserDAO.
     *
     * This class represent the interaction between Database and Domain object.
     * In fact, with it, we can interact with the Table users on Database.
     *
     * @author Kero76
     * @package SciMS\DAO
     * @since SciMS 0.1
     * @version 1.0
     */
    class UserDAO extends DAO {
    
    
        /**
         * Method use for retrieve all users present on Database.
         *
         * @return array
         *  An array with all Users present on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findAll() {
            $sql = "SELECT * FROM `users`";
            $result = $this->getDatabase()->query($sql, PDO::FETCH_ASSOC);
            
            $users = array();
            foreach ($result as $row) {
                $id = $row['id'];
                $users[$id] = $this->buildDomain($row[$id]);
            }
            
            return $users;
        }
    
        /**
         * Method use for research 1 user thanks to the id.
         *
         * @param $id
         *  The id of the user research on Database.
         * @return \SciMS\Domain\User
         *  Return an instance of the User, if it found.
         * @throws \Exception
         * Throw an exception if the user with "id" not found on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findById($id) {
            $sql = "SELECT * FROM `users` WHERE id = ?";
            $row = $this->getDatabase()->execute($sql, array($id), PDO::FETCH_ASSOC);
            
            if ($row) {
                return $this->buildDomain($row);
            } else {
                throw new \Exception("No user with this id is present on Website.");
            }
        }
    
        /**
         * Method use for research 1 user thanks to the username.
         * @param $username
         *  The username research on Database.
         * @return \SciMS\Domain\User
         *  Return an instance of the User, if it found.
         * @throws \Exception
         *  Throw an exception if the user with "username" not found in Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function findByUsername($username) {
            $sql = "SELECT * FROM `users` WHERE login = ?";
            $row = $this->getDatabase()->execute($sql, array($username), PDO::FETCH_ASSOC);
    
            if ($row) {
                return $this->buildDomain($row);
            } else {
                throw new \Exception("No user with this username is present on Website.");
            }
        }
    
        /**
         * Method use for register or update an user.
         *
         * @param \SciMS\Domain\User $user
         *  The user at add or update on Database.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function saveUser(User $user) {
            // Stored users informations into on associative array.
            $infoUser = array(
                'fname'     => $user->getFname(),
                'lname'     => $user->getLname(),
                'username'  => $user->getUsername(),
                'email'     => $user->getEmail(),
                'password'  => $user->getPassword(),
                'salt'      => $user->getSalt(),
                'avatar'    => $user->getAvatar(),
                'role'      => $user->getRole(),
            );
            
            // If id not empty, so update user, else insert user.
            if ($user->getId()) {
                $sql = "UPDATE `users` SET  fname = ?, lname = ?, username = ?, email = ?, password = ?, salt = ?, avatar = ?, role = ? WHERE id = ?";
                $this->getDatabase()->execute($sql, $infoUser);
            } else {
                $sql = "INSERT INTO `users` (fname, lname, username, email, password, salt, avatar, role) VALUES ?, ?, ?, ?, ?, ?, ?, ?";
                $this->getDatabase()->execute($sql, $infoUser);
            }
        }
    
        /**
         * Method use for delete user from Database.
         *
         * @param $id
         *  The id of the user at remove.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function deleteUser($id) {
            $sql = "DELETE FROM `users` WHERE id = ?";
            $this->getDatabase()->execute($sql, array($id));
        }
    
        /**
         * Method use for build a Domain object.
         *
         * @param array $row
         *  The data use for build Domain.
         * @return \SciMS\Domain\User
         *  The corresponding instance of Domain object.
         * @since SciMS 0.1
         * @version 1.0
         */
        public function buildDomain(array $row) {
            $user = new User($row);
            return $user;
        }
    }
<?php
    namespace SciMS\Controller\Handler;
    
    use \SciMS\Message\MessageInterface;

    /**
     * Class MessageHandler.
     *
     * This class manage all messages presents on website.
     * It can return a success message if an action is correctly trigger,
     * or a failure message if the action not working correctly.
     * These messages are contains on two arrays : one for success and the other for error messages.
     * It return the corresponding message in function of a key pass on parameter of the method displaying message.
     *
     * @author Kero76
     * @package SciMS\Error
     * @since SciMS 0.2
     * @version 1.0
     */
    class MessageHandler {
    
        /**
         * An array with all successes messages.
         *
         * @var array
         * @since SciMS 0.2
         */
        private $_messages;
        
        /**
         * MessageHandler constructor.
         *
         * @constructor
         * @since SciMS 0.2
         * @version 1.0
         */
        public function __construct() {
            $this->_messages = array();
        }
    
        /**
         * Return the message in function of the key.
         *
         * @param $key
         *  Return the message in function of the key.
         * @return string
         *  A message.
         * @since SciMS 0.2
         * @version 1.0
         */
        public function getMessage($key) {
            return $this->_messages[$key];
        }
    
        /**
         * Add a message on MessageHandler.
         *
         * @param                  $key
         *  The key of the message.
         * @param MessageInterface $message
         *  The message at add.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function pushMessage($key, MessageInterface $message) {
            $this->_messages[$key] = $message;
        }
    }

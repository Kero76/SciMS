<?php
    namespace SciMS\Message;

    /**
     * Interface Message.
     *
     * This interface represent the possible message at display on website.
     * In fact, when an error occured during a process, the server can send
     * an error message, or when the process is a success, the server can send a
     * successful message at display on a page.
     * So this interface group all possible message model.
     *
     * @author Kero76
     * @package SciMS\Message
     * @since SciMS 0.3
     * @version 1.0
     */
    interface Message {
    
        /**
         * Return the message.
         *
         * @return string
         *  The message at display.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function getMessage();
    }
<?php
    /**
     * Role config rules.
     *
     * This files defines some globals variables using with User object.
     * It stored all roles present in website and it can be possible to adding new roles on this file.
     *
     * @author Kero76
     * @since SciMS 0.1
     * @version 1.0
     */
    
    /**
     * Admin role :
     *  - Add / Remove / Update all articles present on website.
     *  - Consult all articles presents on website,
     *  - Changes users rights.
     *  - Backend Access.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("ADMIN", 1);
    
    /**
     * Moderator role :
     *  - Add / Remove / Update all articles present on Website.
     *  - Consult all articles presents on website.
     *  - Backend Access.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("MODERATOR", 2);
    
    /**
     * Writter role :
     *  - Add / Remove / Update these articles present on Website.
     *  - Consult all article visible on website.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("WRITTER", 3);
    
    /**
     * Guest role :
     *  - Consult all visible articles on website.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("GUEST", 4);
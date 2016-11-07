<?php
    /**
     * State config rules.
     *
     * This files defines some globals variables using with Article object.
     * It stored all states using on Article visibility.
     *
     * @author Kero76
     * @since SciMS 0.1
     * @version 1.0
     */
    
    /**
     * Release status of the Article.
     * The article is currently release on website and can access by all users.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("RELEASE", 1);
    
    /**
     * Pending status of the article.
     * The article is currently on pending brefore last checking.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("PENDING", 2);
    
    /**
     * Hidden status of the article.
     * The article is hidden for all users except admin and moderator users.
     *
     * @global
     * @var integer
     * @since SciMS 0.1
     */
    define ("HIDDEN", 3);
    
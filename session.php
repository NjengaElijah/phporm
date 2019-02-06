<?php
    class Session{

        function __construct()
        {
            if (!isset($_SESSION)) {session_start();}
        }
        /**
         * Receives a json string and stores to the session
         * @param JSON
         */
        public static function SetAuthenticatedUser($json_user){
            if (!isset($_SESSION)) {session_start();}
            $_SESSION['user'] = $json_user;
        }
        /**
         * Retreive the stored json string and cast it to an object
         * @return OBJECT
         */
        public static function GetAuthenticatedUser($class){
            if (!isset($_SESSION)) {session_start();}
          return DBObject::instantiate_m($class,json_decode($_SESSION['user'],true));
        }
        /**
         * Clears the session to implement a logout
         */
        public static function LogOut(){
            if (!isset($_SESSION)) {session_start();}
            if (session_destroy()) {
                //force the cookie to expire by setting its expiry time to a time in the past
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time() - 86400, '/');
                }
            }
        }
        /**
         * Checks if there is a logged in user
         * @return boolean
         */
        public static function isLoggedIn(){
            if (!isset($_SESSION)) {session_start();}
            
            return isset($_SESSION['user']);
        }

    }
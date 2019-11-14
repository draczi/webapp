<?php

  define('DEBUG', true);

  define('DB_NAME', 'live'); // database name
  define('DB_USER', 'root'); // database user
  define('DB_PASSWORD', ''); // database password
  define('DB_HOST', '127.0.0.1'); // database elerhetősége

  define('DEFAULT_CONTROLLER', 'Home'); // default controller if there isn't one defined in the URL
  define('DEFAULT_LAYOUT', 'default'); // if no layout is set int the controller use this $_layout

  define('PROOT', '/webapp/'); // set this to '/' for a live server
  define('SITE_TITLE', 'Mezőgazdasági Aukciós Portál'); // This will be used if no site title is set
  define('MENU_BRAND', 'Mezőgazdasági és Őstermelői Aukciós Portál');

  define('CURRENT_USER_SESSION_NAME', 'ln53huvGqXwvvLHV'); // session name for logged in user
  define('REMEMBER_ME_COOKIE_NAME', 'NZAMr4KVJbOyFazP'); // cookie name for logged in user remember me
  define('REMEMBER_ME_COOKIE_EXPIRY', 2592000); // time in seconds for remember me cookie to live (30days)

  define('ACCESS_RESTRICTED', 'Restricted'); // controller name for the restricted redirect

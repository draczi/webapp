<?php

  define('DEBUG', true);

  //adatbázis kapcsolat adatai
  define('DB_NAME', 'auction'); // adatbázis neve
  define('DB_USER', 'root'); // adatbázis felhasználói név
  define('DB_PASSWORD', ''); // adatbázis jelszó
  define('DB_HOST', '127.0.0.1'); // adatbázis elerhetősége

  define('DEFAULT_CONTROLLER', 'Home'); // alapértelmezett vezérlő ha az URL címben nincs megadva
  define('DEFAULT_LAYOUT', 'default'); // alapértelmezett stíluslap beállítás

  define('PROOT', '/webapp/'); // a gyökérkönyvtár meghatározása, webszerveren csak '/'
  define('SITE_TITLE', 'Mezőgazdasági Aukciós Portál'); // Az weboldal alapértelemezett fejléce
  define('MENU_BRAND', 'Mezőgazdasági és Őstermelői Aukciós Portál'); // Navigációnál megjelenő logó vagy cím

  define('CURRENT_USER_SESSION_NAME', 'ln53huvGqXwvvLHV'); // munkamenet neve a bejelentkezett felhasználó számára.
  define('REMEMBER_ME_COOKIE_NAME', 'NZAMr4KVJbOyFazP'); // cookie név a bejelentkezett felhasználó száméra
  define('REMEMBER_ME_COOKIE_EXPIRY', 2592000); // time in seconds for remember me cookie to live (30days)

  define('ACCESS_RESTRICTED', 'Restricted'); // nem megfelelő oldalcím vagy jogosultság hiánya esetén erre az oldalra küldje tovább

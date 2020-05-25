<?php

  //adatbázis kapcsolat adatai
  define('DB_NAME', 'auction'); // adatbázis neve
  define('DB_USER', 'root'); // adatbázis felhasználói név
  define('DB_PASSWORD', ''); // adatbázis jelszó
  define('DB_HOST', '127.0.0.1'); // adatbázis elerhetősége

  define('DEFAULT_CONTROLLER', 'Home'); // alapértelmezett vezérlő ha az URL címben nincs megadva
  define('ACCESS_RESTRICTED', 'Restricted'); // nem megfelelő oldalcím vagy jogosultság hiánya esetén erre az oldalra küldje tovább
  define('DEFAULT_LAYOUT', 'default'); // alapértelmezett stíluslap beállítás

  define('PROOT', '/webapp/'); // a gyökérkönyvtár meghatározása, webszerveren csak '/'
  define('SITE_TITLE', 'Mezőgazdasági Aukciós Portál'); // Az weboldal alapértelemezett fejléce
  define('MENU_BRAND', 'Mezőgazdasági és Őstermelői Aukciós Portál'); // Navigációnál megjelenő logó vagy cím

  define('CURRENT_USER_SESSION_NAME', 'ln53huvGqXwvvLHV'); // a munkamenet neve a bejelentkezett felhasználó számára

  //email adatok
  define('EMAIL_PORT', 465);
  define('EMAIL_HOST', 'draczi.hu');
  define('EMAIL_USERNAME', 'aukciosportal@draczi.hu');
  define('EMAIL_PASSWORD', '58]iTX~(umfH');
  define('EMAIL_SENDER', 'aukciosportal@draczi.hu');
  define('SENDER_NAME', 'Mezőgazdasági Aukciós Portál');

<?php
   define('DB_SERVER', null);
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'administrador');
   define('DB_DATABASE', 'dbmanantialdeoriente');
   define('DBPORT', null);
   define('DBSOCKET','/cloudsql/metal-voyager-246520:us-central1:dbmanantialdeoriente');
   $db = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_DATABASE, DBPORT, DBSOCKET);
?>
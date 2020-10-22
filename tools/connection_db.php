<?php

//Traitement du fichier qui contient le mot de passe de la base de données pour qu'il puisse être utilisé
$dir = '/var/database_file';
$myfile = fopen($dir, "r");
$database_file = fread($myfile,filesize($dir));
$database_file2 = preg_replace('/\s/', '', $database_file);

//Permet de faire se connecter à la base de données pour faire les requêtes
$db_name="vpi_startup";
$servername = "mysql-scx.epfl.ch";
$username = "vpi_startup_mgmt";
$port = 33001;




//Si la connexion n'est pas réussie, alors il affiche un message de connection failed
try 
{
  $db = new PDO("mysql:host=$servername;port=$port;dbname=$db_name;charset=utf8", $username, $database_file2);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}

?>
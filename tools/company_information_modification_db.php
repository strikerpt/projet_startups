<?php

//Ouvrir la connexion à la base de données pour ajouter la nouvelle startup
require 'connection_db.php';

//Fonction pour empêcher les attaques XSS et injections SQL
function security_text($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*
Requête pour changer le contenu des messages de warning.
name_field = Nom du champ qui a été changé
changed_field = Contenu qui a été saisi par l'utilisateur
*/

$get = security_text($_POST['get']);
$name_field = security_text($_POST['name_field']);
$changed_field = security_text($_POST['changed_field']);


if($name_field == "status")
{  
    $status_startups = $db ->query('SELECT id_status FROM status WHERE status ="'.$changed_field.'"');
    $status_startup = $status_startups -> fetch(); 

    $change_messages_limits = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$status_startup['id_status'].'" WHERE company ="'.$get.'" ');
    $change_messages_limits -> execute();
}
elseif ($name_field == "sectors")
{
    $sectors_startups = $db ->query('SELECT id_sectors FROM sectors WHERE sectors ="'.$changed_field.'"');
    $sectors_startup = $sectors_startups -> fetch(); 

    $change_messages_limits = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$sectors_startup['id_sectors'].'" WHERE company ="'.$get.'" ');
    $change_messages_limits -> execute();
}
elseif ($name_field == "type")
{
    $type_startups = $db ->query('SELECT id_type FROM type WHERE type ="'.$changed_field.'"');
    $type_startup = $type_startups -> fetch(); 

    $change_messages_limits = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$type_startup['id_type'].'" WHERE company ="'.$get.'" ');
    $change_messages_limits -> execute();
}
else
{
    $change_messages_limits = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$changed_field.'" WHERE company ="'.$get.'" ');
    $change_messages_limits -> execute();
}


?>
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
$delete_startup = security_text($_POST['delete_startup']);
$year_date = security_text($_POST['year_date']);
$change_company = security_text($_POST['change_company']);

if($change_company == "true")
{
    if($name_field == "status")
    {  
        $name_field = "fk_status";
        $status_startups = $db ->query('SELECT id_status FROM status WHERE status ="'.$changed_field.'"');
        $status_startup = $status_startups -> fetch(); 

        echo $status_startup['id_status'];
        $update_changes = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$status_startup['id_status'].'" WHERE company ="'.$get.'" ');
        $update_changes -> execute();
    }
    elseif ($name_field == "sector")
    {
        $name_field = "fk_sectors";
        $sectors_startups = $db ->query('SELECT id_sectors FROM sectors WHERE sectors ="'.$changed_field.'"');
        $sectors_startup = $sectors_startups -> fetch(); 

        $update_changes = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$sectors_startup['id_sectors'].'" WHERE company ="'.$get.'" ');
        $update_changes -> execute();
    }
    elseif ($name_field == "type")
    {
        $name_field = "fk_type";
        $type_startups = $db ->query('SELECT id_type FROM type WHERE type ="'.$changed_field.'"');
        $type_startup = $type_startups -> fetch(); 

        $update_changes = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$type_startup['id_type'].'" WHERE company ="'.$get.'" ');
        $update_changes -> execute();
    }
    else
    {
        $update_changes = $db -> prepare('UPDATE startup SET '.$name_field.' = "'.$changed_field.'" WHERE company ="'.$get.'" ');
        $update_changes -> execute();
    }
}
else
{
    if($delete_startup == "true")
    {
        $delete_startup = $db -> prepare('UPDATE startup SET exit_year = "'.$year_date.'" WHERE company ="'.$get.'" ');
        $delete_startup -> execute();
    }
}
?>
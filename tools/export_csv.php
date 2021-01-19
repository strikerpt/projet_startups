<?php


require 'connection_db.php';

//Mettre la date d'aujourd'hui dans le nom du fichier csv
$today = date("d-m-Y");

//Ouvrir un fichier pour mettre les données de la base de données
$file = fopen("../csv_imported/csv_".$today.".csv", "w+");

//Donner le nom du fichier avec la date courante et le nom du chemin où se trouve le fichier
$filename = "csv_".$today.".csv";
$filepath = "../csv_imported/csv_".$today.".csv";

//Prendre les données de startup de la base de données 
$startup = $db->prepare("SELECT * FROM startup");
$startup->execute();

//Supprimer le code HTML du fichier csv
ob_end_clean();

//Mettre l'en-tête dans le fichier csv
$header_csv = array("company", "founding_year","web","rc","status","exit_year","time_to_exit","type","capital","investor_platform","epfl_grant","prix_hors_epfl","impact","sectors","key_words","ba_ma_phd_epfl","founders_origin","founders_country","name","firstname","function","email1","email2","name2","firstname2","function2","prof_as_founder","gender_female_ratio","gender_female_number","fac_dpt","laboratory","prof","investment_2020","investor_2020","description","comments");
fputcsv($file, $header_csv);

//Mettre les données dans le fichier csv
while ($row = $startup->fetch(PDO::FETCH_NAMED)) 
{
    //Remplacer les chiffres des foreign keys par ses valeurs
    $fk_status = $db ->query('SELECT status FROM status WHERE id_status ="'.$row['fk_status'].'"');
    $status = $fk_status->fetch();

    $fk_type = $db ->query('SELECT type FROM type WHERE id_type ="'.$row['fk_type'].'"');
    $type = $fk_type->fetch();

    $fk_sectors = $db ->query('SELECT sectors FROM sectors WHERE id_sectors ="'.$row['fk_sectors'].'"');
    $sectors = $fk_sectors->fetch();

    //Mettre le contenu de la base de données dans un array pour ensuite le mettre dans le fichier de téléchargement
    $text = array($row['company'], $row['founding_year'], $row['web'], $row['rc'], $status['status'], $row['exit_year'], $row['time_to_exit'], $type['type'], $row['capital'], $row['investor_platform'], $row['epfl_grant'], $row['prix_hors_epfl'], $row['impact'], $sectors['sectors'], $row['key_words'], $row['ba_ma_phd_epfl'], $row['founders_origin'], $row['founders_country'], $row['name'], $row['firstname'], $row['function'], $row['email1'], $row['email2'], $row['name2'], $row['firstname2'], $row['function2'], $row['prof_as_founder'], $row['gender_female_ratio'], $row['gender_female_number'], $row['fac_dpt'], $row['laboratory'], $row['prof'], $row['investment_2020'],$row['investor_2020'], $row['description'], $row['comments']);
    $text_replace = str_replace('"', '', $text);
    fputcsv($file,$text_replace,",");

}


//Dire que le fichier est un csv et mettre les accents de français
header('Content-type: text/csv; charset=UTF-8');

//Donner le nom au fichier
header("Content-Disposition: attachment; filename=".$filename);

//Mettre le contenu du fichier dans le fichier de téléchargement
readfile($filepath);

//Fermer le fichier créé
fclose($file);

//Supprimer le fichier créé du serveur
unlink($filepath);

require 'disconnection_db.php';


?>
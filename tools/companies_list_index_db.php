<?php

require 'connection_db.php';

/*
Mettre dans un tableau les données nécessaires pour afficher le graphique des consommations de download pour le mois courant 
et affiche aussi le quota du mois et le quota du plan
*/
$companies_data = $db ->query('SELECT company, founding_year, web, rc, status, sectors FROM startup INNER JOIN status ON startup.fk_status = status.id_status INNER JOIN sectors ON sectors.id_sectors = startup.fk_sectors');
$company_data = $companies_data ->fetchAll();
foreach ($company_data as $data_company)
{
    //convertir à l'aide de la fonction au-dessus, les valeurs de bytes à gigabytes avec deux chiffres après la virgule
    $output[] = array 
    (
        'company'=> $data_company['company'],
        'founding_year' => $data_company['founding_year'],
        'web'=>$data_company['web'],
        'rc'=>$data_company['rc'],
        'status'=>$data_company['status'],
        'sectors'=>$data_company['sectors'],
    );

}
echo json_encode($output);


?>
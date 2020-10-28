<?php



//Si l'utilisateur est connecté
if(isset($_SESSION['user']))
{
    require 'header.php';
    require 'tools/connection_db.php';
    
    //Si l'utilisateur a le droit d'écrire
    if($_SESSION['TequilaPHPWrite'] == "TequilaPHPWritetrue")
    {
        echo '
        <div class="container my-5">
            <h5 class="font-weight-bold my-5 pl-0"> Import from CSV to database </h5>
            <form method="post" id="form_csv_upload" class="form_csv_upload col-12 col-sm-12 col-lg-8 col-xl-8 my-5" enctype="multipart/form-data" action="'; echo security_text($_SERVER["PHP_SELF"]); echo'">
                <div class="">
                    <!-- input type="file" permet d\'aller chercher sur le disque de l\'utilisateur, le csv qu\'il veut ajouter-->
                    <input type="file" class="form-control-file border" name="fileToUpload" id="fileToUpload" >  
                </div>
                <div class="">
                    <button class="btn btn-outline-secondary my-5" id="import" name="import" type="submit">Import</button>
                </div>
            </form>
            <div id="echo_result" class=""></div>
        </div>';

        //Si le bouton import a été cliqué
        if(isset($_POST["import"])) 
        {
            //Initialiser une variable à 1 pour dire que tout va bien avec l'importation du fichier
            $uploadOk = 1;

            //Mettre dans une array, tous les formats de csv accéptés
            $mimes = array('application/vnd.ms-excel','text/csv');

            //Si le mime du fichier est dans l'array
            if(in_array($_FILES['fileToUpload']['type'],$mimes))
            {
                //Donner le répertoire où le csv va être télécharger
                $target_dir = "csv_imported/";


                //Il regarde si la taille du fichier ne dépasse les 500 Mb
                if ($_FILES["fileToUpload"]["size"] > 500000000) 
                {
                    echo "
                    <script>
                        alert('Sorry, your file have more that 500 Mb, it\'s too large.');
                    </script>
                    ";
                
                    $uploadOk = 0;
                }

                //Si une de ces conditions est vraie, alors il n'importe pas le fichier
                if ($uploadOk == 0) 
                {
                    echo "
                    <script>
                        alert('Sorry, the file was not upload.');
                    </script>
                    ";
                }

                //Si tout se passe bien
                else 
                {
                    //Répertoire où va être enregistrer le fichier
                    $uploadfile = $_SERVER['DOCUMENT_ROOT']."/".$target_dir.basename(($_FILES["fileToUpload"]["name"]));
                    
                    //Enregistrer le fichier dans le répertoire
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadfile)) 
                    {
                        //"Ouvrir" le fichier importé, en lui mettant des droits de lire seulement
                        $input = fopen('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'', 'r');
                        
                        //"Ouvrir" le fichier qui aura le résultat après traitement du fichier importé, en lui mettant des droits d'écriture seulement 
                        $output = fopen('csv_imported/startups_modified_good_order.csv', 'w'); 

                        //Lire le fichier importé
                        while(($data = fgetcsv($input, 5000, ",")) !== FALSE)
                        {
                            //Changer l'ordre du fichier importé, en mettant les foreign keys à la fin (dans la base de données, les fks sont à la fin)
                            $order = array(0,1,2,3,5,6,7,8,9,10,11,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,4,7,12);
                            
                            //Lire le fichier importé
                            while (($csv = fgetcsv($input, 5000, ",")) !== FALSE) 
                            {
                                //Faire un nouveau tableau avec les données changés pour y mettre les id's des foreign keys
                                $new = array();

                                foreach($order as $index)
                                {
                                    //Mettre le résultat du fichier importé dans le nouveau tableau avec les changements de place
                                    $new[] = $csv[$index];

                                    //Conditions pour aller chercher les ids si un statut correspond à ceux qui sont dans la base de données
                                    if ($csv[4] == "Private" || $csv[4] == "Stopped" || $csv[4] == "M&A" || $csv[4] == "Sarl" || $csv[4] == "Public" || $csv[4] == "Private & M&A") 
                                    {
                                        //Remplacer le nom du statut par l'id du statut qui est dans la base de données
                                        $ids_change_status = $db -> query('SELECT id_status FROM status WHERE status = "'.$csv[4].'"');
                                        $id_change_status = $ids_change_status->fetch();
                                        $csv[4] = $id_change_status['id_status'];
                                    }

                                    //Conditions pour aller chercher les ids si un type correspond à ceux qui sont dans la base de données
                                    if ($csv[7] == "SA" || $csv[7] == "Sarl" || $csv[7] == "SAS" || $csv[7] == "LLC USA" || $csv[7] == "LLC" || $csv[7] == "Inc." || $csv[7] == "Snc / Sarl" || $csv[7] == "Individuelle" || $csv[7] == "Assoc & Sarl" || $csv[7] == "Fondation" || $csv[7] == "d.o.o" || $csv[7] == "AG" || $csv[7] == "Ltd" || $csv[7] == "China" || $csv[7] == "Corp" || $csv[7] == "SNC" || $csv[7] == "GmbH" || $csv[7] == "Soc. nom indiv." || $csv[7] == "Association")
                                    {
                                        //Remplacer le nom du type par l'id du type qui est dans la base de données
                                        $ids_change_type = $db -> query('SELECT id_type FROM type WHERE type = "'.$csv[7].'"');
                                        $id_change_type = $ids_change_type->fetch();
                                        $csv[7] = $id_change_type['id_type'];
                                    }

                                    //Conditions pour aller chercher les ids si un secteur correspond à ceux qui sont dans la base de données
                                    if ($csv[12] == "Biotech" || $csv[12] == "Medtech" || $csv[12] == "ICT" || $csv[12] == "Engineering" || $csv[12] == "Fintech" || $csv[12] == "Cleantech" || $csv[12] == "Mechanical") 
                                    {
                                        //Remplacer le nom du secteur par l'id du secteur qui est dans la base de données
                                        $ids_change_sectors = $db -> query('SELECT id_sectors FROM sectors WHERE sectors = "'.$csv[12].'"');
                                        $id_change_sectors = $ids_change_sectors->fetch();
                                        $csv[12] = $id_change_sectors['id_sectors'];
                                    }

                                    //Donner l'id de "None" si dans le fichier importé, le champ statut, type ou secteur est vide
                                    if($csv[12] == null || $csv[12] == '') 
                                    {
                                        $csv[12] = 7;
                                    }
                                    if($csv[7] == null || $csv[7] == '')
                                    {
                                        $csv[7] = 20;
                                    }
                                    if($csv[4] == null || $csv[4] == '')
                                    {
                                        $csv[4] = 7;
                                    }
                                }

                                //Ecrire dans le nouveau fichier le résultat avec le changement de place et remplacement des mots par les ids
                                fputcsv($output, $new);

                                //Ecrire dans la base de données, les données du fichier
                                $import_data_to_db = $db -> prepare('INSERT INTO startup(company,founding_year,web,rc,exit_year,time_to_exit,capital,innogrant,prix_pre_seed,impact,key_words,ba_ma_phd_epfl,founders_origin,founders_country,name,firstname,function,email,email1,linkedin,name2,firstname2,function2,gender_female_ratio,gender_female_number,fac_dpt,laboratory,prof,investment_2020,investor_2020,description,fk_status,fk_type,fk_sectors) VALUES ("'.$csv[0].'","'.$csv[1].'","'.$csv[2].'","'.$csv[3].'","'.$csv[5].'","'.$csv[6].'","'.$csv[8].'","'.$csv[9].'","'.$csv[10].'","'.$csv[11].'","'.$csv[13].'","'.$csv[14].'","'.$csv[15].'","'.$csv[16].'","'.$csv[17].'","'.$csv[18].'","'.$csv[19].'","'.$csv[20].'","'.$csv[21].'","'.$csv[22].'","'.$csv[23].'","'.$csv[24].'","'.$csv[25].'","'.$csv[26].'","'.$csv[27].'","'.$csv[28].'","'.$csv[29].'","'.$csv[30].'","'.$csv[31].'","'.$csv[32].'", "'.$csv[33].'", "'.$csv[4].'","'.$csv[7].'","'.$csv[12].'")');
                                $import_data_to_db -> execute();
                            }
                        
                        }
                        //"Fermer" les fichiers qu'il a ouvert au-dessus
                        fclose($input);
                        fclose($output);

                        //Supprimer le fichier qui a été importé par l'utilsateur et le fichier de traitement des données
                        unlink('csv_imported/'.basename(($_FILES["fileToUpload"]["name"])).'');
                        unlink('csv_imported/startups_modified_good_order.csv');

                        //Pop-up d'avertissement pour dire que le fichier a été importé et que les données ont été importées dans la base de donnée
                        echo " 
                        <script>
                        var filename = '".basename($_FILES["fileToUpload"]["name"])."';
                            alert('The file '+filename+' has been uploaded and the data was imported in database.');
                        </script>
                        ";
                    } 
                    //Pop-up d'avertissement s'il y a eu un problème avec l'importation des données 
                    else 
                    {
                        echo "  
                        <script>
                            alert('Sorry, there was an error uploading your file.');
                        </script>
                        ";
                    } 
                    
                }
            }
            //Si le fichier n'est pas valide 
            else 
            {
                echo "
                <script>
                    alert('Sorry, your file is not valid.');
                </script>
                ";
            }
        }

        require 'tools/disconnection_db.php';
        require 'footer.php';
    }

    //Si l'utilisateur n'a pas le droit d'écrire, un pop-up d'avertissement sera affiché et il sera redirigé vers la page d'accueil
    elseif($_SESSION['TequilaPHPRead'] == "TequilaPHPReadtrue")
    {
        echo "
        <script>
            alert('You don't have enough rights to access this page.');
            window.location.replace('https://itsidevfsd0008.xaas.epfl.ch/');
        </script>
        ";
    }
}
else
{
    echo "
    <script>
        alert('You have to be connected to see this page.');
        window.location.replace('https://itsidevfsd0008.xaas.epfl.ch/login.php');
    </script>
    ";
}

?>
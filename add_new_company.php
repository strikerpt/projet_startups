<?php

require 'header.php';
require 'tools/connection_db.php';


//Formulaire pour ajouter une nouvelle startup
echo '
<div class="container">
    <h5 class="font-weight-bold my-3"> Add new company</h5>
    <form method="post" class="form_add_new_company col-12 col-sm-12 col-lg-8 col-xl-8 my-5" action="'; echo security_text($_SERVER["PHP_SELF"]); echo'">
        <!-- Champ pour le nom de la startup -->
        <div class="form-group row">
            <label for="company_name" class="col-sm-3 col-form-label">Company name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="company_name" id="company_name" pattern="[A-Za-z0-9\-\,\(\)\à\ä\è\ü\.\_\é\ö\ï\@\#\*\ç\+\&\=\ã\á\ñ\â\ô\!\$\£\?\'\/\<\>\;\:\^\`\~\|\& ]{2, 300}" title="Minimum 2 characters and maximum 300." required>
            </div>
        </div>
        <!-- Champ pour l\'année de création de la startup -->
        <div class="form-group row">
            <label for="founding_year" class="col-sm-3 col-form-label">Founding Year</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="founding_year" id="founding_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers required." required>
            </div>
        </div>
        <!-- Champ pour l\'url de la startup -->
        <div class="form-group row">
            <label for="web" class="col-sm-3 col-form-label">Web</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="web" id="web" pattern="(^http[s]?:\/{2})|(^www)|(non-existant)" title="Your url must begin by &quot;www&quot;,&quot;http://&quot; or &quot;https://&quot;. If doesn\'t exist url, please write &quot;non-existant&quot;">
            </div>
        </div>
        <!--  -->
        <div class="form-group row">
            <label for="rc" class="col-sm-3 col-form-label">RC</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="rc" id="rc" pattern="[A-Za-z0-9\-\. ]{2,300}" title="Minimum 2 characters and maximum 300.">
            </div>
        </div>
        <!-- Combobox pour afficher tout les status d\'une startup -->
        <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-6">
                <select class="form-control" name="status" id="status" required>
                    <option name="default" value="default" disabled selected>Select a status</option>';
                    $status_data = $db-> query('SELECT status FROM status');
                    $data_status = $status_data -> fetchAll();
                    foreach ($data_status as $status)
                    {
                        echo '<option value="'.$status['status'].'">'.$status['status'].'</option>';
                    }
                echo '
                </select>
            </div>
        </div>
        <!-- Champ pour l\'année de sortie de la startup -->
        <div class="form-group row">
            <label for="exit_year" class="col-sm-3 col-form-label">Exit year</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="exit_year" id="exit_year" pattern="[0-9]{4}" title="Only numbers, 4 numbers required.">
            </div>
        </div>
        <!-- Champ pour le temps de sortie de la startup -->
        <div class="form-group row">
            <label for="time_to_exit" class="col-sm-3 col-form-label">Time to exit</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="time_to_exit" id="time_to_exit" pattern="[0-9]{1, 5}" title="Only numbers, 1 minimum and 5 maximum.">
            </div>
        </div>
        <!-- Combobox pour afficher tout les types d\'une startup -->
        <div class="form-group row">
            <label for="type" class="col-sm-3 col-form-label">Type</label>
            <div class="col-sm-6">
                <select class="form-control" class="selectpicker" data-dropup-auto="true" name="type" id="status" required>
                    <option name="default" value="default" disabled selected>Select a type</option>
                    <option name="none" value="None">None</option>';
                    $type_data = $db-> query('SELECT type FROM type');
                    $data_type = $type_data -> fetchAll();
                    foreach ($data_type as $type)
                    {
                        echo '<option value="'.$type['type'].'">'.$type['type'].'</option>';
                    }
                echo '
                </select>
            </div>
        </div>
        <!-- Champ pour le capital de la startup -->
        <div class="form-group row">
            <label for="capital" class="col-sm-3 col-form-label">Capital</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="capital" id="capital" pattern="(^CHF)|[0-9]" title="Only numbers, 4 numbers required.">
            </div>
        </div>
        <!-- Champ pour l\'innogrant de la startup -->
        <div class="form-group row">
            <label for="innogrant" class="col-sm-3 col-form-label">Innogrant</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="innogrant" id="innogrant">
            </div>
        </div>
        <!-- Champ pour le prix pre seed de la startup -->
        <div class="form-group row">
            <label for="prix_pre_seed" class="col-sm-3 col-form-label">Prix pre seed</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="prix_pre_seed" id="prix_pre_seed">
            </div>
        </div>
        <!-- Champ pour l\'impact de la startup -->
        <div class="form-group row">
            <label for="impact" class="col-sm-3 col-form-label">Impact</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="impact" id="impact">
            </div>
        </div>
        <!-- Combobox pour afficher tout les sectors d\'une startup -->
        <div class="form-group row">
            <label for="sectors" class="col-sm-3 col-form-label">Field / Sectors</label>
            <div class="col-sm-6">
            <select class="form-control" class="selectpicker" data-dropup-auto="true" name="sector" id="status" required>
                <option name="default" value="default" disabled selected>Select a sector</option>';
                $sectors_data = $db-> query('SELECT sectors FROM sectors');
                $data_sectors = $sectors_data -> fetchAll();
                foreach ($data_sectors as $sectors)
                {
                    echo '<option value="'.$sectors['sectors'].'">'.$sectors['sectors'].'</option>';
                }
            echo '
            </select>
            </div>
        </div>
        <!-- Champ pour les keys words de la startup -->
        <div class="form-group row">
            <label for="key_words" class="col-sm-3 col-form-label">Key words</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="key_words" id="key_words">
            </div>
        </div>
        <!-- Champ pour le ba, ma, phd, @EPFL de la startup -->
        <div class="form-group row">
            <label for="ba_ma_phd_epfl" class="col-sm-3 col-form-label">ba, ma, phd, @EPFL</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="ba_ma_phd_epfl" id="ba_ma_phd_epfl">
            </div>
        </div>
        <!-- Champ pour l\'origine des fondateurs de la startup -->
        <div class="form-group row">
            <label for="founders_origin" class="col-sm-3 col-form-label">Founders origin</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="founders_origin" id="founders_origin">
            </div>
        </div>
        <!-- Champ pour le pays d\'origine des fondateurs de la startup -->
        <div class="form-group row">
            <label for="founders_country" class="col-sm-3 col-form-label">Founders Country</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="founders_country" id="founders_country">
            </div>
        </div>
        <!-- Champ pour le nom des fondateurs de la startup -->
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="name" id="name">
            </div>
        </div>
        <!-- Champ pour le pays prénom des fondateurs de la startup -->
        <div class="form-group row">
            <label for="firstname" class="col-sm-3 col-form-label">Firstname</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="firstname" id="firstname">
            </div>
        </div>
        <!-- Champ pour la fonction des fondateurs de la startup -->
        <div class="form-group row">
            <label for="function" class="col-sm-3 col-form-label">Function</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="function" id="function">
            </div>
        </div>
        <!-- Champ pour email-->
        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
            <input type="email" class="form-control" name="email" id="email">
            </div>
        </div>
        <!-- Champ pour un autre email-->
        <div class="form-group row">
            <label for="email1" class="col-sm-3 col-form-label">Email1</label>
            <div class="col-sm-6">
            <input type="email" class="form-control" name="email1" id="email1">
            </div>
        </div>
        <!-- Champ pour le linkedin des fondateurs-->
        <div class="form-group row">
            <label for="linkedin" class="col-sm-3 col-form-label">Linkedin</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="linkedin" id="linkedin">
            </div>
        </div>
        <!-- Champ pour le deuxième nom-->
        <div class="form-group row">
            <label for="name2" class="col-sm-3 col-form-label">Name2</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="name2" id="name2">
            </div>
        </div>
        <!-- Champ pour le deuxième prénom-->
        <div class="form-group row">
            <label for="firstname2" class="col-sm-3 col-form-label">Firstname2</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="firstname2" id="firstname2">
            </div>
        </div>
        <!-- Champ pour autres fonctions-->
        <div class="form-group row">
            <label for="function2" class="col-sm-3 col-form-label">Function2</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="function2" id="function2">
            </div>
        </div>
        <!-- Champ pour le ratio de femmes/hommes dans la startup-->
        <div class="form-group row">
            <label for="gender_female_ratio" class="col-sm-3 col-form-label">Gender female Ratio</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="gender_female_ratio" id="gender_female_ratio">
            </div>
        </div>
        <!-- Champ pour le nombre de femmes dans la startup-->
        <div class="form-group row">
            <label for="gender_female_number" class="col-sm-3 col-form-label">Gender female number</label>
            <div class="col-sm-6">
            <input type="number" class="form-control" name="gender_female_number" id="gender_female_number">
            </div>
        </div>
        <!-- Champ pour la faculté ou département où appartient la startup-->
        <div class="form-group row">
            <label for="fac_dpt" class="col-sm-3 col-form-label">fac / dpt</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="fac_dpt" id="fac_dpt">
            </div>
        </div>
        <!-- Champ pour le nom du laboratoire-->
        <div class="form-group row">
            <label for="laboratory" class="col-sm-3 col-form-label">Laboratory</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="laboratory" id="laboratory">
            </div>
        </div>
        <!-- Champ pour le nom du prof-->
        <div class="form-group row">
            <label for="prof" class="col-sm-3 col-form-label">Prof</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="prof" id="prof">
            </div>
        </div>
        <!-- Champ pour le s\'il y a eu des investissement en 2020-->
        <div class="form-group row">
            <label for="investment_2020" class="col-sm-3 col-form-label">2020 investment</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="investment_2020" id="investment_2020">
            </div>
        </div>
        <!-- Champ pour le nom de l\investisseur-->
        <div class="form-group row">
            <label for="investor_2020" class="col-sm-3 col-form-label">2020 Investor</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="investor_2020" id="investor_2020">
            </div>
        </div>
        <!-- Champ pour une description de la startup-->
        <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label">Short description</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="description" id="description">
            </div>
        </div>
        <button class="btn btn-outline-secondary mt-5" id="submit_new_company" name="submit_new_company" type="submit">Submit</button>
    </form>
</div>
';

if(isset($_POST['submit_new_company']))
{
    $company_name = security_text($_POST['company_name']);
    $founding_year = security_text($_POST['founding_year']);
    $web = security_text($_POST['web']);
    $rc = security_text($_POST['rc']);
    $status = security_text($_POST['status']);
    $exit_year = security_text($_POST['exit_year']);
    $time_to_exit = security_text($_POST['time_to_exit']);
    $type = security_text($_POST['type']);
    $capital = security_text($_POST['capital']);
    $innogrant = security_text($_POST['innogrant']);
    $prix_pre_seed = security_text($_POST['prix_pre_seed']);
    $impact = security_text($_POST['impact']);
    $sector = security_text($_POST['sector']);
    $key_words = security_text($_POST['key_words']);
    $ba_ma_phd_epfl = security_text($_POST['ba_ma_phd_epfl']);
    $founders_origin = security_text($_POST['founders_origin']);
    $founders_country = security_text($_POST['founders_country']);
    $name = security_text($_POST['name']);
    $firstname = security_text($_POST['firstname']);
    $function = security_text($_POST['function']);
    $email = security_text($_POST['email']);
    $email1 = security_text($_POST['email1']);
    $linkedin = security_text($_POST['linkedin']);
    $name2 = security_text($_POST['name2']);
    $firstname2 = security_text($_POST['firstname2']);
    $function2 = security_text($_POST['function2']);
    $gender_female_ratio = security_text($_POST['gender_female_ratio']);
    $gender_female_number = security_text($_POST['gender_female_number']);
    $fac_dpt = security_text($_POST['fac_dpt']);
    $laboratory = security_text($_POST['laboratory']);
    $prof = security_text($_POST['prof']);
    $investment_2020 = security_text($_POST['investment_2020']);
    $investor_2020 = security_text($_POST['investor_2020']);
    $description = security_text($_POST['description']);


}

require 'tools/disconnection_db.php';
require 'footer.php';
?>
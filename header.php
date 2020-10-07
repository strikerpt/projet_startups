<?php

//Initialiser les modules nécessaires pour le site (bootstrap, jquery, summernote, ajax)
echo '
<!DOCTYPE html>
    <html>
    <head>
        <meta charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title> Project Startups </title>
    </head>
    <body>
        <script>
            /*
            Script qui empêche l\historique sur les pages. 
            Surtout utilisé pour les formulaires, si l\'utilisateur rafraichi la page, il ne soumet pas les données
            */
            if ( window.history.replaceState ) 
            {
            window.history.replaceState( null, null, window.location.href );
            }
        </script>

        <!-- L\'en-tête du site -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white mb-3">
            <a class="navbar-brand" href="https://www.epfl.ch">
                <img src="medias/epfl_logo.png" alt="epfl" width="100" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">';
                
                    //Il affiche seulement le menu si l'utilisateur est connecté
                    if(isset($_COOKIE['TequilaPHP']))
                    {
                        echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link text-danger dropdown-toggle " id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </a>
                            <div class="dropdown-menu dropdown-warning" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item dropdown-item-danger text-danger" href="index.php">Download and Upload All Enterprises</a>
                                <a class="dropdown-item text-danger" href="consumption_all_enterprises.php">Consumptions All Enterprises</a>
                                <a class="dropdown-item text-danger" href="add_enterprise.php">Add Enterprises</a>
                                <a class="dropdown-item text-danger" href="add_bandwidths_type.php">Add Bandwidths Types</a>
                                <a class="dropdown-item text-danger" href="add_change_enterprise_category.php">Add and Change Enterprise Category</a>
                                <a class="dropdown-item text-danger" href="bandwidth_pack_extra_quota_changes.php?band=actif&pack=actif">Change bandwidth and pack extra quota</a>
                                <a class="dropdown-item text-danger" href="limit_messages_changes.php">Change Warnings messages and limits</a>          
                            </div>
                        </li>';
                    }
                    echo '
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">';

                    /*
                    Si l'utilisateur est connecté, sur l'en-tête il y a le lien de logout
                    Si l'utilisateur est deconnecté, sur l'en-tête il y a le lien de login 
                    */
                    if(isset($_COOKIE['TequilaPHP']))
                    {
                        echo '
                        <a class="nav-link text-danger" href="logout.php">Logout</a>';
                    }
                    else
                    {
                        echo '
                        <a class="nav-link text-danger" href="login.php">Login</a>';
                    }
                    echo '
                    </li>
                </ul>
            </div>
        </nav>
     
';

?>
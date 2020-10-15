<?php

require 'header.php';

if(isset($_COOKIE['TequilaPHP']))
{
    echo "

    <script type='text/javascript'>

        //Recharger l\'API et le piechart package
        google.charts.load('current', {'packages':['table', 'corechart', 'controls']});
        
        //Permet de faire appel à l\'API quand elle est rechargée 
        google.charts.setOnLoadCallback(load_companies_data);
        
        //Chercher dans la base de données les données nécessaires pour importer dans la fonction de dessin du tableau (Celle-ci est la même que celles au dessous, la seule différence est que cette partie est pour la checkbox qui est cochée par défaut, donc quand il n'y a pas de changement de checkbox)
        function load_companies_data()
        {
            $.ajax
            ({
                url:'tools/companies_list_index_db.php',
                method:'POST',
                dataType:'JSON',
                //Si tout se passe bien avec le résultat final du fichier 'companies_list_index_db.php' alors il passe à success et écrire les données dans le tableau
                success:function(data)
                {
                    drawChart_companies_data(data);
                    console.log('sucess');
                },
                //En revanche, s'il y a eu problème ou s'il n'y a aucune donnée, il ne met rien sur le tableau
                error:function (data) 
                {
                    drawChart_companies_data();
                    console.log('error');
                }
            });
        }

        //Mettre les données dans le tableau et le dessiner
        function drawChart_companies_data(chart_data)
        {
            //Mettre dans une variable les données récupérées
            var jsonData = chart_data;

            //Initialiser la base d\'un google chart
            var data = new google.visualization.DataTable();

            //Initialiser les colonnes pour mettre les données
            data.addColumn('string', 'company');
            data.addColumn('string', 'founding_year');
            data.addColumn('string', 'web');
            data.addColumn('string', 'rc');
            data.addColumn('string', 'status');
            data.addColumn('string', 'sectors');

            //Mettre les données dans les colonnes
            $.each(jsonData, function(i, jsonData)
            {
                var company = jsonData.company;
                var founding_year = jsonData.founding_year;
                var web = jsonData.web;
                var rc = jsonData.rc;
                var status = jsonData.status;
                var sectors = jsonData.sectors;
                data.addRows([[company, founding_year, web, rc, status, sectors]]);
            });
            
            //Initialiser les deux champs de recherche d\'une entreprise ou d\'une unité 
            var dashboard = new google.visualization.Dashboard
            (
                document.getElementById('dashboard_div')
            );

            //Permet de spécifier plus en détail le filtre dans les 2 champs. (Dans ce cas le filtre n'est pas sensible à la case et le match peut être fait avec des minuscules ou majuscules)
            var stringFilter = new google.visualization.ControlWrapper
            ({
                controlType: 'StringFilter',
                containerId: 'search_company',
                options: 
                {
                    ui: 
                    {
                        label: '',
                        placeholder : 'Search Company',
                    }, 
                    matchType: 'any',
                    caseSensitive : 'false',
                    filterColumnLabel: 'company',
                }
            });

            var CategoryFilter_status = new google.visualization.ControlWrapper
            ({
                'controlType': 'CategoryFilter',
                'containerId': 'status_dropdown_menu',
                'options': 
                {
                    ui: 
                    {
                        label: '',
                        placeholder : 'status',
                        selectedValuesLayout : 'below',
                        'caption': 'Choose a Status',
                    }, 
                    'filterColumnLabel': 'status',

                }
            });

            var CategoryFilter_sectors = new google.visualization.ControlWrapper
            ({
                'controlType': 'CategoryFilter',
                'containerId': 'sectors_dropdown_menu',
                'options': 
                {
                    ui: 
                    {
                        label: '',
                        placeholder : 'sectors',
                        selectedValuesLayout : 'below',
                        'caption': 'Choose a Sector',
                    }, 
                    'filterColumnLabel': 'sectors',

                }
            });

            //Quelques options de plus, dans ce cas, il n'affiche pas les id\'s à chaque ligne
            var table = new google.visualization.ChartWrapper
            ({
                chartType: 'Table',
                containerId: 'table',
                options: 
                {
                    showRowNumber: false,
                    width:'100%',
                }
            });
            
            //Permet d'ajouter un evenement pour que quand l\'utilisateur clique sur une ligne, le script cherche le nom de l'entreprise et puisse rediriger l'utilisateur vers la page de details
            google.visualization.events.addListener(table, 'ready', function() 
            {
                var container = document.getElementById(table.getContainerId());
                Array.prototype.forEach.call(container.getElementsByTagName('TD'), function(cell) 
                {
                cell.addEventListener('click', selectCell);
                });
            
                function selectCell(sender) 
                {
                    //Récupérer le tableau qui est affiché
                    var tableDataView = table.getDataTable();

                    //Mettre en variable tous les elements de la ligne que l'utilisateur a cliqué
                    var cell = sender.target;
                    var row = cell.closest('tr');
                
                    //Mettre en variable la position de la ligne que l'utilisateur a cliqué
                    var selectedRow = row.rowIndex - 1;
                    
                    //Permet de savoir quelle celulle l'utilisateur a cliqué
                    var e = event || window.event;
                    var cell_e = e.target;
                    var id_cell = cell_e.cellIndex;

                    //Cette condition permet rediriger l'utilisateur vers la bonne page suivant la celulle cliquée
                    if(id_cell == 0 || id_cell == 1 || id_cell == 2 || id_cell == 3)
                    {
                        var str = tableDataView.getFormattedValue(selectedRow, 0);
                        window.location.href = 'https://itsidevfsd0008.xaas.epfl.ch/company_information_modification.php?company_name='+str;
                    }
                    else if (id_cell == 4 || id_cell == 5)
                    {
                        var str = tableDataView.getFormattedValue(selectedRow, 0);
                        window.location.href = 'https://itsidevfsd0008.xaas.epfl.ch/company_information_modification.php?company_name='+str;
                    }   
                }
            
            });

            //Partie pour télécharger les données du tableau en format CSV
            $('.csv-button').on('click', function () 
            {
                //Fonction pour avoir la date du jour avec le format dd_mm_yyyy
                function GetFormattedDate() 
                {
                    var today = new Date();
                    var day = String(today.getDate()).padStart(2, '0');
                    var month = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var year = today.getFullYear();
                    return day + '_' + month + '_' + year;
                }

                var csvColumns;
                var csvContent;
                var downloadLink;
            
                // L\'en-tête du fichier CSV
                csvColumns = '';
                for (var i = 0; i < data.getNumberOfColumns(); i++) 
                {
                    csvColumns += data.getColumnLabel(i);
                    if (i < (data.getNumberOfColumns() - 1)) 
                    {
                        csvColumns += ',';
                    }
                }
                csvColumns += '\\n';
            
                //Récupérer les données pour les mettre dans le fichier et le télécharger en mettant la date du jour sur le nom du téléchangement
                csvContent = csvColumns + google.visualization.dataTableToCsv(data);
                downloadLink = document.createElement('a');
                downloadLink.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvContent);
                downloadLink.download = 'startups_'+GetFormattedDate()+'.csv';
                downloadLink.click();
                downloadLink = null;

            });

            //Dessiner les champs et faire appel aux fonctions des filtres
            dashboard.bind([stringFilter, CategoryFilter_status, CategoryFilter_sectors], [table]);
            dashboard.draw(data);
        }
    </script>

    <!-- Partie HTML pour placer les checkboxes, les champs filtres, le tableau et le bouton de téléchargement du fichier CSV -->
    <div class='container'>
        <h5 class='font-weight-bold'> Homepage: Companies List </h5>
        <div id='dashboard_div'>
            <div class='row'>
                <div id='search_company' class='text-left col-3 my-5 '></div>
                <div id='status_dropdown_menu' class='text-right col-3 my-5 '></div>
                <div id='sectors_dropdown_menu' class='text-right col-3 my-5 '></div>
                <button id='button-csv' class='csv-button btn btn-sm btn-outline-secondary col-3 my-5'>Download to CSV file</button>
                <div id='table' class='col-12'></div>
            </div>
        </div>
        
    </div>";

    require 'footer.php';    
}
?>

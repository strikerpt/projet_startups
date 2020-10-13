#!/bin/bash

#Backup des répertoires du site "projet_startups/"

#Extraction du backup sur linux
#tar -zxvf  ~/backup_site/backup_site__(date).tar.gz

#Récupérer le backup de la base de données
#mysql -u vpi_startup_mgmt -h mysql-scx.epfl.ch -P 33001 -p < backup_db_(date).sql

#Mettre dans une variable la date du jour
today=$(date +"%d_%m_%Y")

#Compresser les fichiers du site et mettre la date du jour dans le nom du tar
tar -zcvf ~/backup_site/backup_site__${today}.tar.gz /var/www/html/projet_startups/

#Créer un dump de la base de données et placer le fichier dans le répertoire backup_site/
mysqldump --user="vpi_startup_mgmt" --password="TeCwM5/w?3~DH?k)PKiMR," --databases vpi_startup -h mysql-scx.epfl.ch -P 33001 > ~/backup_site/backup_db_${today}.sql

#!/bin/bash

# Backup des fichiers du site et de la base de données. Les backups d'il y a 4 mois seront supprimés.

# Extraction du backup sur linux
# tar -zxvf  ~/backup_site/backup_site__(date).tar.gz

# Récupérer le backup de la base de données
# mysql -u vpi_startup_mgmt -h mysql-scx.epfl.ch -P 33001 --password="$SECRET" < ~/backup_site/backup_db_16_10_2020.sql

####################################################################################################################

# Mettre à jour les variables d'environnement du système
source /etc/profile 

# Si la variable d'environnement "SECRET" n'est pas saisie, il la met comme valeur "default"
SECRET=${SECRET:-default}

# Condition pour dire que si la variable d'environnement est égale à "default", alors il affiche un message d'erreur
if [ "default" = "${SECRET}" ]; then
    echo "SECRET NOT DEFINED"
    exit 1
fi

# Mettre la date du jour dans une variable
today=$(date +"%d_%m_%Y")

# Mettre le mois d'il y a 4 mois dans une variable
four_months_ago=$(date --date='4 months ago' +%m)

find_files=$(find ~/backup_site/ -name "*${four_months_ago}*")

if [ ! -z "${find_files}" ]
then
        #rm les backups d'il y a 4 mois
        rm ${find_files}

        # Compresser les fichiers du site et mettre la date du jour dans le nom du tar
        tar -zcvf ~/backup_site/backup_site__${today}.tar.gz /var/www/html/projet_startups/
        
        # Créer un dump de la base de données et placer le fichier dans le répertoire backup_site/
        mysqldump --user="vpi_startup_mgmt" --password="$SECRET" --databases vpi_startup -h mysql-scx.epfl.ch -P 33001 > ~/backup_site/backup_db_${today}.sql
else
        # Compresser les fichiers du site et mettre la date du jour dans le nom du tar
        tar -zcvf ~/backup_site/backup_site__${today}.tar.gz /var/www/html/projet_startups/

        # Créer un dump de la base de données et placer le fichier dans le répertoire backup_site/
        mysqldump --user="vpi_startup_mgmt" --password="$SECRET" --databases vpi_startup -h mysql-scx.epfl.ch -P 33001 > ~/backup_site/backup_db_${today}.sql
fi
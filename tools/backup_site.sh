#!/bin/bash

# Backup des fichiers du site et de la base de données
# Extraction du backup sur linux
# tar -zxvf  ~/backup_site/backup_site__(date).tar.gz

# Récupérer le backup de la base de données
# mysql -u vpi_startup_mgmt -h mysql-scx.epfl.ch -P 33001 -p < backup_db_(date).sql

# Mettre à jour les variables d'environnement du système
source /etc/profile 

# Si la variable d'environnement "SECRET" n'est pas saisie, il la met comme valeur "default"
SECRET=${SECRET:-default}

# Condition pour dire que si la variable d'environnement est égale à "default", alors il affiche un message d'erreur
if [ "default" = "${SECRET}" ]; then
    echo "SECRET NOT DEFINED"
    exit 1
fi

# Mettre dans une variable la date du jour
today=$(date +"%d_%m_%Y")

# Compresser les fichiers du site et mettre la date du jour dans le nom du tar
tar -zcvf ~/backup_site/backup_site__${today}.tar.gz /var/www/html/projet_startups/

# Créer un dump de la base de données et placer le fichier dans le répertoire backup_site/
mysqldump --user="vpi_startup_mgmt" --password="$SECRET" --databases vpi_startup -h mysql-scx.epfl.ch -P 33001 > ~/backup_site/backup_db_${today}.sql

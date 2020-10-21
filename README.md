<h1> Site-web pour gérer les startups de l'EPFL </h1>

<p>Ce site permet aux utilisateurs crédités de gérer les startups de l'EPFL.</p>
<p>Pour voir le contenu du site, il vous faut un <strong>compte Tequila EPFL</strong> et appartenir au groupe EPFL <strong>startups_read</strong> ou/et <strong>startups_write</strong>.<p>
<p> Si vous appartenez au groupe startups_write, vous avez le droit d'écrire et modifier les données des startups. En revanche si vous appartenez seulement au groupe startups_read, alors vous n'avez pas de droits d'écriture, donc vous avez seulement le droit de voir la page d'accueil du site.</p>
<p> La gestion des droits est faite par les sessions de PHP (<strong> $_SESSION </strong>), la connexion à Tequila va créer une variable session PHP et va chercher vos groupes pour créer une autre variable de session PHP avec le nom de votre groupe.</p>
<p>Il permet de : </p>
<ul>
  <li>Voir les données d'une startup</li>
  <li>Modifier les données d'une startup</li>
  <li>Ajouter une nouvelle startup</li>
  <li>Fermer une startup (mettre une date de fin pour dire qu'elle n'est plus gérée par l'EPFL)</li>
  <li>Importer un fichier csv pour insérer les données de ce fichier dans la table startup</li>
</ul>
<h1> Pages du site-web </h1>

<h3> Index.php </h3>

<p> La page d'accueil du site contient un tableau avec toutes les données des startups, un champ de recherche par nom de startup, deux comboboxes pour trier les startups par secteur ou/et status et un bouton qui permet de télécharger le tableau en format CSV.</p>

<h3> add_new_company.php </h3>

<p> Formulaire pour ajouter une nouvelle startup à la base de données. Le formulaire contient tous les champs de la base de données, mais il faut remplir seulement ceux qui ont l'astérisque rouge qui indique les champs obligatoires. </p>
<p> Un pop-up d'avertissement apparaît si l'écriture de la startup a été faite avec succès. </p>

<h3> company_information_modification.php </h3>

<p> Formulaire identique au formulaire de la page <em> add_new_company.php </em>, mais il affiche les données de l'entreprise et la possibilité de les modifier ou supprimer.</p>
<p> Il y a aussi la possibilité de fermer une startup (mettre l'année de fin dans la base de données)</p>
<p> Avant chaque changement un pop-up de confirmation apparaît, en affichant les données d'avant et d'après le changement, pour que l'utilisateur soit au courant de ce va changer sur la base de données et pour qu'il confirme qu'il veut vraiment faire ces modifications.</p>

<h3> header.php </h3>

<p> L'en-tête de la page permet d'afficher à l'utilisateur les pages du site, si a le droit de les voir et permet de vous connecter à Tequila. </p>

<h3> import_from_csv.php </h3>

<p> Permet aux utilisateurs d'importer un fichier CSV pour importer les données de ce fichier dans la base de données. </p>
<p> PHP va vérifier si le fichier est vraiment un fichier CSV et s'il ne dépasse pas les 500 Mb. Si ces conditions sont respectées, alors il met le fichier dans le répertoire <strong> csv_imported/ </strong>. Ensuite, il va traiter le fichier, en modifiant son ordre. Les données status, type et sector vont à la fin du fichier et les données de ces 3 colonnes sont remplacés par leurs respectives id's de la base de données. Cette manipulation est nécessaire car dans la table startup de la base de données, les 3 colonnes sont à la fin et sont des foreign keys, donc il est nécessaire de donner leurs id's. Finalement, PHP importe les données dans la base de données et supprime les fichiers créés. </p>
<p> Dans le répertoire csv_imported/, il y a un fichier CSV template pour que vous voyez comment faire votre fichier CSV pour que les données soient bien importées vers la base de données. </p>

<h3> login.php et logout.php </h3>

<p> Fichiers qui permettent la connexion à Tequila et création des variables de session PHP pour la gestion des droits de l'utilisateur et déconnexion de Tequila. </p>

<h3> css/ </h3>

<p> Contient le fichier <strong> style.css</strong> qui est le fichier CSS du site.</p>

<h3> tools/ </h3>

<p> Contient les fichiers avec les requêtes SQL pour écrire ou lire dans la base de données ou pour récuperer des données dans la base de données (nécessaire pour la page d'accueil du site). Les fichiers de configuration de Tequila. Les fichiers de connexion et déconnexion à la base de données. Le script de backup des fichiers du serveur et de la base de données.</p> 
<p>Le script fait des "full backups" tous les jours ouvrables et dans les commentaires du script, il y a les commandes à lancer pour utiliser ces backups en cas de besoin.</p>

<h3> medias/ </h3>

<p> Contient le png avec le logo de l'EPFL qui est utilisé dans l'en-tête du site. Si vous cliquez sur le logo, vous êtes redirigé vers la page d'accueil de l'epfl. </p>




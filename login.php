<?php
require_once("tools/tequila.php");

$oClient = new TequilaClient();

//Nom du service quand le login tequila apparaît
$oClient->SetApplicationName('Gestion des startups');

//Variables demandées au serveur par rapport à la personne qui se connecte avec tequila
$oClient->SetWantedAttributes(array('uniqueid','name','firstname','unit', 'unitid', 'where', 'group'));
$oClient->SetWishedAttributes(array('email', 'title'));

//URL de redirection quand le login est bien fait
$oClient->SetApplicationURL('http://itsidevfsd0008.xaas.epfl.ch/');

//1 jour de cookie
$oClient->SetTimeout('86400');

/*
Groupes qui peuvent accéder au site. 
Les membres du groupe startups_read ne peuvent accéder au site qu'en lecture.
Les membres du groupe startups_write peuvent accéder au site en écriture et lecture.
*/
$oClient->SetCustomFilter('org=EPFL&group=startups_read');


$group  = $oClient->getValue('group');
$sKey = $oClient->GetKey();

echo <<<EOT
<html>
	<head>
		<title>Test Tequila</title>
	</head>
	<body>
		<h3>Test Tequila :</h3>
		<pre>
             group = $group
             key = $sKey

EOT;

echo "\nCookies = ";
print_r($_COOKIE);
echo "\nSession = ";
print_r($_SESSION);

echo <<<EOT
		</pre>
		<p>
		<a href="{$_SERVER['PHP_SELF']}">Test session key</a><br/>
	</body>
</html>

EOT;
//$oClient->SetCustomFilter('org=EPFL&group=startups_write');

//Definir le nom du cookie par rapport au groupe où est l'utilisateur
/*$cookie_name  = $oClient->getValue('group');
if($cookie_name == "startups_read")
{
    $sCookieName = "TequilaPHPRead";
}
elseif($cookie_name == "startups_write")
{
    $sCookieName = "TequilaPHPWrite";
}
else
{
    $sCookieName = "ERROR";
}*/

//Faire appel à la page de login de tequila
$oClient->Authenticate();

?>
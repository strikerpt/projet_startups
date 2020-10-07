<?php


//Logout de tequila
require_once ("tools/tequila.php");
$oClient = new TequilaClient();
$oClient-> Logout ($redirectUrl ="http://itsidevfsd0008.xaas.epfl.ch/");

?>
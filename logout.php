<?php


//Logout de tequila
require_once ("tools/tequila.php");
$oClient = new TequilaClient();
$oClient-> Logout ($redirectUrl ="https://itsidevfsd0008.xaas.epfl.ch/");
setcookie('TequilaPHPWrite', 'TequilaPHPWrite', time()-86400);
setcookie('TequilaPHPRead', 'TequilaPHPRead', time()-86400);

?>
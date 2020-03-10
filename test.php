<?php
function getCredentials($filename) {
    $iniFile = parse_ini_file($filename,true);
    return $iniFile["dbInfo"];
}


$credentials = getCredentials("surf.ini");
print_r($credentials);
?>
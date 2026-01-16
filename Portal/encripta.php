<?php
$desencripta = 'VmtaYVJrOVdRbEpRVkRBOQ';
echo "Texto desencriptado: <strong>".base64_decode($desencripta)."</strong><br>";

$encripta = '103';//c2lzdGFtZXgyMDIy
echo "Texto Encriptado: <strong>".base64_encode($encripta)."</strong>";
?>
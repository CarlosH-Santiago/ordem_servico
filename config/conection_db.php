<?php 
    $osdatabase = new mysqli('localhost', 'root', '', 'db_ordemservico');
    $osdatabase->set_charset('utf8');

    if ($osdatabase == false) {
        echo "Erro de conexão";
    }
?>
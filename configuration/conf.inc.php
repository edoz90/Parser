<?php
$db_user = "root"; //username database
$db_pass = ""; //password database per utente root
$db_database = "Parser"; //nome del database
$db_host = "localhost"; //server che ospita il database
//mi connetto al database
$db_connect = mysql_connect($db_host, $db_user, $db_pass);
//se la connessione non avviene restituisco un errore
if ($db_connect == FALSE)
    die("Errore nella connessione, verificare i parametri nel file conf.inc.php");
//seleziono il database di electrobuy
mysql_select_db($db_database, $db_connect) or die("Errore nella selezione del database");
?>

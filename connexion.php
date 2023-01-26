<?php
$dbhost = 'tuxa.sme.utc';
$dbuser = 'nf92a075';
$dbpass = 'sKiIW0Xz';
$dbname = 'nf92a075';
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
mysqli_set_charset($connect, 'utf8');
?>

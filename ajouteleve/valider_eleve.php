<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>

<?php
include ("../connexion.php");

date_default_timezone_set('Europe/Paris');
$date=date("Y\-m\-d");

$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$dateNaiss=$_POST['datedenaissance'];

$query="insert into eleves values (NULL, \"$nom\", \"$prenom\", \"$dateNaiss\", \"$date\")"; //creation du paramètre requete
// echo "br".$query."br";
$result= mysqli_query($connect, $query); //envoi par la connexion du parametre requete
    if (!$result)
      {
        echo "<br><br><br><br><div class='contenant'> La requête a échoué : ".mysqli_error($connect)."</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
      }
    else
      {
        echo "<br><br><br><br><div class='contenant'> Eleve ajouté(e) avec succés </div><br>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_eleve.html">';
      }

  mysqli_close($connect);
?>

</center>
</body>


</html>

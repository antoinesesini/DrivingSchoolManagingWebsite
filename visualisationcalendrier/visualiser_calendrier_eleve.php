<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>
    <?php
      include("../connexion.php");

      date_default_timezone_set('Europe/Paris');
      $date=date("Y\-m\-d");

      $elevechoisi=$_POST['elevechoisi'];

      $query="SELECT * FROM eleves  INNER JOIN inscription ON eleves.ideleve=inscription.ideleve
-- pour avoir toutes les inscriptions de l'élève
                                                INNER JOIN seances ON inscription.idseance=seances.idseance
-- pour avoir les données concernant les séances en question
                                                INNER JOIN themes ON seances.idtheme=themes.idtheme
-- pour avoir les données concernant les thèmes de ces séances
                                                WHERE eleves.ideleve=\"$elevechoisi\" AND DateSeance>=\"$date\"
-- là ou on a l'eleve choisi et quand les seances sont à venir (ce jour ou plus tard)
                                                ORDER BY seances.DateSeance ASC";
      // echo "br".$query."br";
      $result=mysqli_query($connect, $query);
      if (!$result)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=visualisation_calendrier_eleve.php">';
          exit;
        }

      $query="SELECT * FROM eleves WHERE ideleve=\"$elevechoisi\""; //on récupère des infos sur l'identité de l'élève
      // echo "br".$query."br";
      $identite_eleve=mysqli_query($connect, $query);
      if (!$identite_eleve)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=visualisation_calendrier_eleve.php">';
          exit;
        }

      if (mysqli_num_rows($result)>=1) //si l'élève choisi a des séances dans le futur, on les affiche dans un tableau
        {
          $random_row=mysqli_fetch_row($identite_eleve);
          echo "<br><br><br><br><div class='contenant'>CALENDRIER DE ".$random_row[2]." ".$random_row[1]."</div><br><br><br><br>";
          echo "<br><br><br><br><div class='contenant'><table class='tableau'>";
          echo "<tr>"."<td>"."Date"."</td>"."<td>"."Thème"."</td>"."<td>"."Descriptif"."</td>"."</tr>";
          while ($row=mysqli_fetch_row($result))
            {
              echo "<tr>"."<td>".$row[9]."</td>"."<td>".$row[13]."</td>"."<td>".$row[15]."</td>"."</tr>";
            }
          echo "</table></div>";
        }
      else //sinon, on prévient l'utilisateur
        {
          echo "<br><br><br><br><div class='contenant'>L'élève n'a aucune séance à venir !</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="6;URL=visualisation_calendrier_eleve.php">';
        }
      mysqli_close($connect);
    ?>
</center>
</body>

</html>

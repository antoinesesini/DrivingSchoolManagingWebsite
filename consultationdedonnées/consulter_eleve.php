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

      //on va ici récupérer dans un premier temps, les infos de l'élève et de toutes ses inscriptions puis les infos des séances qu'il a passé et leur thème. Ensuite, on range les séances par date de la moins à la plus récente
      $query="SELECT * FROM eleves  INNER JOIN inscription ON eleves.ideleve=inscription.ideleve
                                                INNER JOIN seances ON inscription.idseance=seances.idseance
                                                INNER JOIN themes ON seances.idtheme=themes.idtheme
                                                WHERE eleves.ideleve=\"$elevechoisi\" AND DateSeance<\"$date\"
                                                ORDER BY seances.DateSeance ASC";
      // echo "br".$query."br";
      $infos_eleve=mysqli_query($connect, $query);
      if (!$infos_eleve)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=consultation_eleve.php">';
          exit;
        }

      $query="SELECT * FROM eleves WHERE ideleve=\"$elevechoisi\""; //on ne récupère ici que les infos sur l'identité de l'élève
      // echo "br".$query."br";
      $data=mysqli_query($connect,$query);
      if (!$data)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=consultation_eleve.php">';
          exit;
        }
      $identite_eleve=mysqli_fetch_row($data);

      echo "<br><br><br><br><div class='contenant'><br>Identité<br><br><table class='tableau'>"; // on les affiche dans un tableau
      echo "<tr><td>Prénom</td>"."<td>  </td><td>".$identite_eleve['2']."</td></tr>";
      echo "<tr><td>Nom</td>"."<td>  </td><td>".$identite_eleve['1']."</td></tr>";
      echo "<tr><td>Date de naissance</td>"."<td>  </td><td>".$identite_eleve['3']."</td></tr>";
      echo "<tr><td>Date d'inscription</td>"."<td>  </td><td>".$identite_eleve['4']."</td></tr>";
      echo "</table><br><br></div><br><br><br><br>";

      $existance=0;

      echo "<div class='contenant'>Parcours<br><br><table class='tableau'>"; //en dessous on fait un tableau avec les infos sur les séances qu'a passé l'élève
      echo "<tr><td>Date</td><td>  </td><td>Thème</td><td>Note</td></tr>";
      while ($row=mysqli_fetch_row($infos_eleve))
        {
          if ($row[7]==-1)
            {
              $row[7]="Non noté";
            }
          echo "<tr><td>$row[9]</td><td>  </td><td>$row[13]</td><td><center>$row[7]</center></td></tr>";
          $existance=1;
        }
      if (!$existance)
        {
          echo "<tr><td>Aucune séance effectuée à ce jour !</td></tr>";
        }
      echo "</table></div>";
      mysqli_close($connect);
    ?>
  </center>
</body>


</html>

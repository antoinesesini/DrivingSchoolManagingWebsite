<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>

  <br><br><br><br><br><br>

  <?php
    include ("../connexion.php");
    date_default_timezone_set('Europe/Paris');
    $date=date("Y\-m\-d");
    $query="SELECT * from inscription INNER JOIN seances ON inscription.idseance=seances.idseance WHERE DateSeance<\"$date\""; //on récupère toutes les notes de l'autoécole
    // echo "br".$query."br";
    $infonotes=mysqli_query($connect,$query);
    if (!$infonotes)
      {
        echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=statistiques.php">';
        exit;
      }
    mysqli_close($connect);
  ?>

  <div class='contenant'>
    <center>
      <?php
        echo "STATISTIQUES GENERALES DE L'AUTO-ECOLE";
      ?>
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <center>
    <?php
      if (mysqli_num_rows($infonotes)>=1) //si il y a eu des élèves d'inscrits, on calcule des statistiques
        {
          $somme=0;
          $compt=0;
          $notemax=0;
          $notemin=40;
          while ($row=mysqli_fetch_row($infonotes)) //Attention, on ne prend en compte que les élèves notés dans les statistiques
            {
              if ($row[2]!=-1)
                {
                  $somme=$somme+$row[2];
                  $compt=$compt+1;
                  if ($row[2]>$notemax)
                    {
                      $notemax=$row[2];
                    }
                  if ($row[2]<$notemin)
                    {
                      $notemin=$row[2];
                    }
                }
            }
          if ($compt!=0)
            {
              echo "MOYENNE :"."<br>";
              $somme=round($somme/$compt,2);
              echo "$somme"."/40"."<br><br>"; //on affiche les stats

              echo "MEILLEURE NOTE :"."<br>";
              echo "$notemax"."<br><br>";

              echo "NOTE MINIMALE :"."<br>";
              echo "$notemin"."<br><br>";
            }
          else
            {
              echo "Les élèves inscrits n'ont pas été notés";
            }
        }
      else //si il n'y avait aucun élève d'inscrit, on prévient l'utilisateur
        {
          echo "Les statistiques ne sont pas disponibles car l'auto-école n'a encore fait passé aucun examen.";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=statistiques.php">';
          exit;
        }
    ?>
    </center>
  </div>
</body>

</html>

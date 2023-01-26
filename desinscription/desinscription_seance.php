<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>

  <br><br><br><br><br><br>

  <div class='contenant'>
    <center>
    DESINSCRIPTION D'UN(E) ELEVE A UNE SEANCE
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <form action='desinscrire_seance.php' method='post'>
      Elève à désinscrire :
      <select class="" name="elevechoisi" required>
        <option value="" disabled selected>**Sélectionnez un(e) élève à désinscrire** </option>
        <?php
          include("../connexion.php");
          $query="SELECT * FROM eleves"; //on récupère tous les élèves de l'auto école puis on en choisit un en select
          // echo "br".$query."br";
          $liste_eleves=mysqli_query($connect,$query);
          if (!$liste_eleves)
            {
              echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=desinscription_seance.php">';
              exit;
            }
          else
            {
              while($row=mysqli_fetch_row($liste_eleves))
                {
                  echo "<option value=\"$row[0]\"> $row[2] $row[1] né le $row[3] et inscrit le $row[4] </option>";
                }
            }
          mysqli_close($connect);
        ?>
      </select><br><br>
      De quelle séance :
      <select class="" name="seancechoisie" required>
      <option value="" disabled selected> **Sélectionnez une séance** </option>
        <?php
          date_default_timezone_set('Europe/Paris');
          $date=date("Y\-m\-d");

          include("../connexion.php");
          $query="SELECT * FROM themes INNER JOIN seances ON seances.idtheme=themes.idtheme WHERE  DateSeance>=\"$date\""; //on récupère toutes les séances futures
          // echo "br".$query."br";
          $liste_seances_possibles=mysqli_query($connect,$query);
          if (!$liste_seances_possibles)
            {
              echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=desinscription_seance.php">';
              exit;
            }
          else
            {
              while($row=mysqli_fetch_row($liste_seances_possibles)) //on en choisit une en select
                {
                  echo "<option value=\"$row[4]\"> Thème : $row[1] Date : $row[5]</option>";
                }
            }
          mysqli_close($connect);
        ?>
      </select><br><br>
      <input type="submit" value="Désinscrire cet(te) élève">
    </form>
    <center>
  </div>
</body>

</html>

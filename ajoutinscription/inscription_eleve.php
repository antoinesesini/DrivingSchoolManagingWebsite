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
    INSCRIPTION D'UN(E) ELEVE A UNE SEANCE
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <form action='inscrire_eleve.php' method='post'>

    Elève à inscrire :
      <select class="" name="elevechoisi">
        <option value="" disabled selected>**Sélectionnez un(e) élève à inscrire** </option>
          <?php
          include("../connexion.php");
          $query="SELECT * FROM eleves"; //on récupère tous les élèves de l'auto-école
          // echo "br".$query."br";
          $liste_eleves=mysqli_query($connect,$query);
          if (!$liste_eleves)
            {
              echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
              exit;
            }
          else //on les affiche 1 par 1 avec leur nom prénom et date de naissance dans un select
            {
              while($row=mysqli_fetch_row($liste_eleves))
                {
                  echo "<option value=\"$row[0]\"> $row[2] $row[1] né le $row[3] et inscrit le $row[4] </option>";
                }
            }
          mysqli_close($connect);
          ?>
      </select><br><br>


    A quelle séance :
      <select class="" name="seancechoisie">
        <option value="" disabled selected> **Sélectionnez une séance** </option>
          <?php
          date_default_timezone_set('Europe/Paris');
          $date=date("Y\-m\-d");
          include("../connexion.php");
          $query="SELECT * FROM themes INNER JOIN seances ON seances.idtheme=themes.idtheme WHERE supprime='0' AND (DateSeance>='$date')"; //on récupère des infos sur les séances futures dont le thème n'est pas supprimé et leur thème
          // echo "br".$query."br";
          $liste_seances_possibles=mysqli_query($connect,$query);
          if (!$liste_seances_possibles)
            {
              echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
              exit;
            }
          else //on les affiche une par une dans un select
            {
              while($row=mysqli_fetch_row($liste_seances_possibles))
                {
                  echo "<option value=\"$row[4]\"> Thème : $row[1] Date : $row[5]</option>";
                }
            }
          mysqli_close($connect);
          ?>
      </select><br><br>
      <input type="submit" value="Inscrire cet(te) élève">
    </form>
  </div>

  <center>
</body>


</html>

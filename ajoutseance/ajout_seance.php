<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>


<body style="background-color: #DCDCDC;">
  <br><br><br><br><br><br>

  <div class='contenant'>
    <center>
    CREATION D'UNE SEANCE
    </center>
  </div>

  <br><br><br><br>

  <div class='contenant'>
    <center>
    <form action="ajouter_seance.php" method="post">
      Date : <input type ="date" name="date" value=""><br><br>
      Effectif maximum : <input type ="number" name="effmax" min='1' value=""><br><br>
      <select class="" name="theme">
          <option value="" disabled selected> Thème </option>
            <?php
            include("../connexion.php");
            $query="SELECT idtheme, nom, supprime FROM themes"; //on récupère tous les thèmes enregistrés
            // echo "br".$query."br";
            $liste_themes=mysqli_query($connect,$query);
            if (!$liste_themes)
              {
                echo "<p>La requête a échoué : ".mysqli_error($connect)."</p>";
                echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_seance.php">';
                exit;
              }
            else
              {
                while($row=mysqli_fetch_row($liste_themes))// on test chaque thème pour n'afficher que les supprime=0 c'est à dire ceux qui sont dispo
                  {
                    if (!$row[2])
                      {
                        echo "<option value=\"$row[0]\">$row[1]</option>";
                      }
                  }
              }
            mysqli_close($connect);
            ?>
      </select><br><br>
      <input type="submit" value="Valider la séance">
    </form>
  </center>
</div>

</body>


</html>

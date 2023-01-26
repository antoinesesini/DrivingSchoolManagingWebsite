<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <center>
  <?php

    $seancechoisie=$_POST['seancechoisie'];

    if (empty ($seancechoisie)) //on test qu'une séance ait bien été entrée
      {
        echo "<br><br><br><br><div class='contenant'> Il faut choisir une séance à noter ! </div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
        exit;
      }

    include ("../connexion.php");

    //début des autres tests
    $query="SELECT * from inscription INNER JOIN eleves ON inscription.ideleve=eleves.ideleve WHERE idseance=\"$seancechoisie\" AND note<>'-1'"; //on récupère des infos sur tous les élèves inscrits à cette séance dont la note est différente de -1 (ceux qui ont été notés)
    // echo "br".$query."br";
    $liste_eleves_notes=mysqli_query($connect, $query);
    if (!$liste_eleves_notes)
      {
        echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
        exit;
      }
    $query="SELECT * from inscription INNER JOIN eleves ON inscription.ideleve=eleves.ideleve WHERE idseance=\"$seancechoisie\" AND note='-1'";//on récupère des infos sur les élèves inscrits à cette séance qui n'ont pas encore été notés
    // echo "br".$query."br";
    $liste_eleves_nonnotes=mysqli_query($connect, $query);
    if (!$liste_eleves_nonnotes)
      {
        echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
        exit;
      }

    if (mysqli_num_rows($liste_eleves_notes)==0 and mysqli_num_rows($liste_eleves_nonnotes)==0)
      {
        echo "<br><br><br><br><div class='contenant'> Il n'y avait aucun élève inscrit à cette séance ! </div>";
        echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=validation_seance.php">';
        exit;
      }
    //fin des tests


    //début de l'affichage des input
    echo "<br><br><br><br><div class='contenant'><form action='noter_eleves.php' method='post'>"; //on dévoile un formulaire de notation pour la séance choisie avec d'abord les élèves déjà notés puis les non notés
      echo "<input type='hidden' name='seancechoisie' value=\"$seancechoisie\">";
      echo "Veuillez entrer les notes des élèves présents à cette séance :"."<br><br>";
      while ($row=mysqli_fetch_row($liste_eleves_notes))
        {
          echo "$row[5] $row[4] né(e) le $row[6]";
          echo "<input type='hidden' name='eleve[]' value=\"$row[1]\" multiple>";
          echo "<input type='number' name='note[]' value=\"$row[2]\" pattern='[0-9]{2}' min='0' max='40' multiple >"."<br><br>";
        }
      while ($row=mysqli_fetch_row($liste_eleves_nonnotes))
        {
          echo "$row[5] $row[4] né(e) le $row[6]";
          echo "<input type='hidden' name='eleve[]' value=\"$row[1]\" multiple>";
          echo "<input type='number' name='note[]' pattern='[0-9]{2}' min='0' max='40' multiple >"."<br><br>";
        }
      $nbtotal=mysqli_num_rows($liste_eleves_notes)+mysqli_num_rows($liste_eleves_nonnotes);
      echo "<input type='hidden' name='nbtotal' value=\"$nbtotal\">";
      echo "<br><input type='submit' value='Envoyer les notes'>";
    echo "</form></div>";
    //fin de l'affichage des input

  mysqli_close($connect);
  ?>
  </center>
</body>


</html>

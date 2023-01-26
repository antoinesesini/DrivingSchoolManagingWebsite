<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
  <?php

  @$elevechoisi=$_POST['elevechoisi'];
  @$seancechoisie=$_POST['seancechoisie'];
  $notedepart=-1;

  if (empty($elevechoisi) || empty($seancechoisie)) //on test les champs pour voir s'ils sont vides
    {
      echo "<br><br><br><br><div class='contenant'> Il faut saisir les données. </div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
      exit;
    }

  include("../connexion.php");
  $query="SELECT idseance, ideleve  FROM inscription WHERE idseance=\"$seancechoisie\" AND ideleve=\"$elevechoisi\""; //on récupère les inscriptions qui ont le même élève et la même séance pour savoir si l'élève est déjà inscrit
  // echo "br".$query."br";
  $result=mysqli_query($connect,$query);
  if (!$result)
    {
      echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
      exit;
    }
  if (mysqli_num_rows($result)>=1)  //si déjà inscrit on prévient l'utilisateur
    {
      echo "<br><br><br><br><div class='contenant'>L'élève est déjà inscrit à cette séance !</div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
      exit;
    }
  else //sinon on l'inscrit
    {
      $query="SELECT EffMax FROM seances WHERE idseance=\"$seancechoisie\""; //on récupère l'effectif max de cette séance
      // echo "br".$query."br";
      $result=mysqli_query($connect,$query);
      if (!$result)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
          exit;
        }
      $EffMax_seancechoisie=mysqli_fetch_row($result);
      $query="SELECT ideleve FROM inscription WHERE idseance=\"$seancechoisie\""; //on récupère les id de tous les élèves inscrits à cette séance
      // echo "br".$query."br";
      $Liste_eleves_seancechoisie=mysqli_query($connect,$query);
      if (!$Liste_eleves_seancechoisie)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
          exit;
        }
      if (($EffMax_seancechoisie[0]-mysqli_num_rows($Liste_eleves_seancechoisie))>0) //si l'effectif est strictement supérieur au nombre d'inscrit, on inscrit notre élève
        {
          $query="insert into inscription values (\"$seancechoisie\",\"$elevechoisi\",\"$notedepart\")";
          // echo "br".$query."br";
          $result=mysqli_query($connect,$query);
          if (!$result)
            {
              echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
              exit;
            }
          else
            {
              echo "<br><br><br><br><div class='contenant'>L'élève a bien été inscrit à cette séance </div><br>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
              exit;
            }
         }
       else //sinon on prévient l'utilisateur qu'il n'y a plus de place
         {
           echo "<br><br><br><br><div class='contenant'> Il n'y a malheureusement plus aucune place de libre lors de cette séance ! </div>";
           echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=inscription_eleve.php">';
           exit;
         }
     }
    mysqli_close($connect);

  ?>
</body>


</html>

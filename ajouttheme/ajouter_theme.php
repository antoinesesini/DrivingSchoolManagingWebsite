<html>

<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../form.css">
</head>

<body style="background-color: #DCDCDC;">
<center>
<?php


  $nom=$_POST['nom'];
  //On change les noms en format Mmmmmm
  @$datachange="";
  for ($i=1; $i<strlen($nom)+1; $i++)
    {
      @$newchar=strtolower($nom[$i]);
      $datachange=$datachange.$newchar;
    }
  $nom=strtoupper($nom[0]).$datachange;

  $descriptif=$_POST['descriptif'];
  $supprime=0;

  if (empty($nom) || empty($descriptif))//test du formulaire non vide
    {
      echo "<br><br><br><br><div class='contenant'> Il faut saisir les données </div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
      exit;
    }

  include("../connexion.php");
  $query="SELECT * from themes WHERE nom=\"$nom\" or descriptif=\"$descriptif\""; //recherche d'un thème déjà existant sous ce nom ou cette description
  $result=mysqli_query($connect,$query);
  if (!$result)
    {
      echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
      echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
      exit;
    }

  if (mysqli_num_rows($result)>=1)//si on a un résultat positif
    {
      $themesimilaire=mysqli_fetch_row($result);
      if ($themesimilaire[2]==0) //si il est existant est actif, on prévient l'utilisateur
        {
          echo "<br><br><br><br><div class='contenant'> Ce thème est déjà existant !</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
          exit;
        }
      else //si il est existant est inactif, on le réactive
        {
          echo "<br><br><br><br><div class='contenant'> Ce thème étant déjà existant dans la base de données, nous le réactivons !</div>";
          $query="UPDATE themes set supprime=0 WHERE idtheme=\"$themesimilaire[0]\"";
          $result=mysqli_query($connect,$query);
          if (!$result)
            {
              echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
              echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
              exit;
            }
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
        }
    }
  else //sinon, si il n'y a pas de thème similaire
    {
      $query=" insert into themes values (NULL, \"$nom\",\"$supprime\",\"$descriptif\")"; //creation du paramètre requete
      $result= mysqli_query($connect, $query); //envoi par la connexion du parametre requete
      if (!$result)
        {
          echo "<br><br><br><br><div class='contenant'>La requête a échoué : ".mysqli_error($connect)."</div>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
          exit;
        }
      else
        {
          echo "<br><br><br><br><div class='contenant'> Thème ajouté avec succés </div><br>";
          echo '<META HTTP-EQUIV="Refresh" CONTENT="3;URL=ajout_theme.html">';
          exit;
        }
    }

mysqli_close($connect);


?>
</center>
</body>


</html>

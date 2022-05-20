<?php

  $mysqli = include 'databaseConnect.php';
  include 'databaseUtils.php';

  $_TITRE_PAGE = 'Accueil projet RS ESEO';

  

  if(isset($_GET['logout'])){
    if($_GET['logout'] == 1) {
      unset($_SESSION['compte']);
      header("Location: ./");
    }
  }


  //is connected ?
  $compte = "not connected";
  if(isset($_POST['connexion_submit']) && $_POST['connexion_submit'] == 1){
    if($_POST['password'] == 'network'){
      $compte = "connected";
    }
  }

  if(isset($_POST['inscription_submit']) && $_POST['inscription_submit'] == 1){
    $compte="connected";
    if(isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['first_name']) && $_POST['year']!="Annee Scolaire" && $_POST['password_confirmation']==$_POST['password']){
      
      $mail = againstSQLInjection($_POST['mail'],$mysqli);
      $mdphash = password_hash(againstSQLInjection($_POST['password'],$mysqli), PASSWORD_DEFAULT);
      $name = againstSQLInjection($_POST['name'],$mysqli);
      $first_name = againstSQLInjection($_POST['first_name'],$mysqli);
      $year = againstSQLInjection($_POST['year'],$mysqli);
  
      $mail = addslashes($mail);
      $mdphash = addslashes($mdphash);
      $name = addslashes($name);
      $first_name = addslashes($first_name);
      $year = addslashes($year);
  
  
      $sql = "INSERT INTO data(mail,password,name,first_name,year) 
                          VALUES('$mail', '$mdphash', '$name', '$first_name', $year)";
      echo $sql;

      sendQuery($sql, $mysqli);
    } 
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href = "style.css" rel = "stylesheet">
    <title><?php echo $_TITRE_PAGE ?></title>
  </head>
  <body>
    <header>
        <div class="container-fluid pt-3 pb-3">
            <img src="img/logoESEO.png" alt="logo ESEO" class="logo-header img-fluid">
            <button type="button" class="btn btn-header text-white">Etudiants</button>
            <button type="button" class="btn btn-header text-white">Accueil</button>
        </div>

    </header>
    <section>
        <div class="container-fluid row justify-content-center mx-auto">
            <div class="text-center pt-5">
                <h2>Bienvenue sur RS ESEO !</h2>
            </div>
            <?php
              if($_SESSION['compte']="not connected"){
            ?>
            <div class="rounded-3 col-sm-4 m-2 p-1 h-50" id="connexion_div">
                <h5 class="text-center text-white">Connexion</h5>
                <form method="POST">
                    <div class="input-group p-2">
                      <!-- <label for="mail">Email</label> -->
                      <input name="mail" type="text" class="form-control" placeholder="Email" id="mail">
                    </div>
                  
                    <div class="input-group p-2">
                      <!-- <label for="defaultLoginFormPassword">Mot de passe</label> -->
                      <input name="password" type="password" class="form-control" placeholder="Mot de passe" id="defaultLoginFormPassword">
                    </div>

                    <div class="input-group p-2 justify-content-center">
                        <button name="connexion_submit" type="valider-connexion" value="1" class="btn btn-connexion text-white w-100">CONNEXION</button>
                      </div>
                  </form>
                  <div class="forgot-password justify-content-center">
                    <div class="img-forgot-password float-left pr-1">
                      <img src="img/logoKey.png" alt="Logo clé" class="logo-key">
                    </div>
                    <div class="text-forgot-password float-right">
                      <a href=#><p>Mot de passe oublié ?</p></a>
                    </div>
                  </div>
            </div>
            <div class="rounded-3 col-sm-4 m-2 p-1" id="inscription_div">
              <h5 class="text-center text-white">Inscription</h5>
              <form method="POST">
                <div class="input-group p-2">
                  <input type="text" class="form-control"name="name"  placeholder="Nom">
                </div>
              
                <div class="input-group p-2">
                  <input type="text" class="form-control" name="first_name" placeholder="Prenom">
                </div>
              
                <div class="input-group p-2">
                    <select class="form-select" name="year" aria-label="Default select example">
                        <option selected>Annee Scolaire</option>
                        <option value="1">E1</option>
                        <option value="2">E2</option>
                        <option value="3">E3</option>
                        <option value="4">E4</option>
                        <option value="5">E5</option>
                    </select>
                  </div>
                  
                  <div class="input-group p-2">
                    <input type="text" class="form-control" name="mail" placeholder="Email">
                  </div>
                
                  <div class="input-group p-2">
                    <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                  </div>
              
                  <div class="input-group p-2">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmez votre mot de passe">
                  </div>
        
                  <div class="input-group p-2 justify-content-center">
                    <button type="valider-inscription" name="inscription_submit" value="1" class="btn btn-inscription text-white w-100">INSCRIPTION</button>
                  </div>
                </form>
            
              </div>
            
              <?php
                }
                else{
              ?>
              <div>
                <h2>Vous êtes connecté !</h2>
              </div>
              <div>
                <a href="http://192.168.56.80/pwnd?logout=1">Se déconnecter</a>
              </div>
              <?php
                }
              ?>
              </div>
    </section>
    <footer>
        <div class="footer text-center text-white p-1 m-0">
            <p class="h-auto">@ 2022 - By Arthur Delannoy - Tous droits réservés</p>
        </div>
    </footer>
  </body>
</html>
<?php
session_start();
$bdd = new PDO('mysql:host=mariadb;dbname=becode', 'root', 'root');
// if(isset($_GET["id"]) AND $_GET["id"] > 0){
if (empty($_SESSION["passwdChecksOut"])) {
  $_SESSION = array();
  session_destroy();
  header("Location : index.php");
  exit;
} else if (isset($_POST['logOff'])){
    $_SESSION["loggedOff"] = 1; //créer une variable pour afficher un message par la suite dans index
    header("Location: logoff.php");
} else {
  $getid = intval($_SESSION["id"]);
  $sql = "SELECT * FROM students WHERE id = ?";
  $query = $bdd->prepare($sql);
  $query->execute(array($getid));
  $result = $query->fetch();

  $github_address = "https://github.com/" .$result["github"];
  $linkedin_address = "https://www.linkedin.com/in/" .$result["linkedin"];
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil de <?php echo $result["username"] ?></title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="main">
        <div class="card">
          <div class="half-circle-shadow"></div>
          <img src="https://avatars1.githubusercontent.com/u/99944?s=400&v=4" />
          <div class="card-content">
            <ul>
              <li>
                <ion-icon name="happy"></ion-icon><span>
                  <?php echo $result["username"] ?></span>
              </li>
              <li>
                <ion-icon name="person"></ion-icon><span>
                  <?php echo !$result["first_name"] && !$result["last_name"] ? "<span class='red darken-1'>Votre nom et prénom ne sont pas encore remplis</span>" : $result["first_name"] . " " . $result["last_name"] ?></span>
              </li>
              <li>
                <ion-icon name="mail"></ion-icon><span>
                  <?php echo $result["mail"]; ?></span>
              </li>
              <li>
                <ion-icon name="logo-github"></ion-icon><span>
                  <?php echo !$result["github"] ? "Vous avez Github ? Indiquez le nous !" : 
                  "<a href='$github_address' target='_blank' >$github_address</a>" ?></span>
              </li>
              <li>
                <ion-icon name="logo-linkedin"></ion-icon><span>
                  <?php echo !$result["linkedin"] ? "Vous avez Linkedin ? Indiquez le nous !" : 
                  "<a href='$linkedin_address' target='_blank' >$linkedin_address</a>" ?></span>
              </li>
            </ul>
          </div>
        </div>
        <?php if ($result["id"] == $_SESSION["id"]) : ?>
          <div class="group-btn-edit-delete">
            <a class="btn waves-effect waves-light" href="update.php">Mettre à jour
              <ion-icon name="create"></ion-icon>
            </a>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
            <button class="btn waves-effect waves-light grey darken-1" type="submit" name="logOff">Se deconnecter
              <ion-icon name="bed"></ion-icon>
            </button>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php

?>
  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  </html>
<?php } ?>

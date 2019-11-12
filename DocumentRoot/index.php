<?php
session_start();

$bdd = new PDO('mysql:host=mariadb;dbname=becode', 'root', 'root');
if (isset($_POST["login"])) {
    $email = $_POST['email'];
    $passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT, array('cost' => 10));

    $sql = "SELECT * FROM students WHERE mail=:email";
    $query = $bdd->prepare($sql);
    $query->bindParam(':email', $email);
    $query->execute();
    $result = $query->fetch();


    if ($query) {
        if (password_verify($_POST['passwd'], $result['passwd'])) {
            $_SESSION["id"] = $result["id"];
            $_SESSION["email"] = $result["mail"];
            $_SESSION["username"] = $result["username"];
            $_SESSION["passwdChecksOut"] = 1;
            exit(header("location: profil.php"));
        } else {
            $erreur = "Le mot de passe est invalide !";
        }
    } else {
        $erreur = "Les informations rentrées sont incorrectes !";
    }
}
if($_SESSION["id"]){header("Location: profil.php");} //redirection si l'utilisateur est deja connecté
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogYourSelfIn</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="container">
        <div class="main">
            <img class="" src="https://media1.tenor.com/images/a7e004f24af8ca4289fe65803a6580ba/tenor.gif?itemid=13730108" alt="">
            <form class="login" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
                    <div class="input-field">
                        <input type="email" name="email" id="email" class="validate">
                        <label for="email">Email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="passwd" id="passwd" class="validate">
                        <label for="passwd">Mot de passe</label>
                    </div>
                    <div><?php echo $erreur ?></div>
                    <div class="input-field">
                        <button class="btn waves-effect waves-light" type="submit" name="login">Se connecter
                            <ion-icon name="arrow-round-forward"></ion-icon>
                        </button>
                    </div>
                    <div>Nouveau ? <a href="register.php">Crée un compte ici !</a></div>
            </form>
        </div>
    </div>
    <?php if($_SESSION["deleted"]===1) : ?>
            <div class="alert-deleted z-depth-5">
                <div class="inner-alert">
                    <p>Votre compte a été <strong>supprimé</strong> !</p>
                    <ion-icon name="close" id="closeIcon"></ion-icon>
                </div>
            </div>
            <?php
            $_SESSION = array();
            session_destroy();
            ?>
    <?php endif; ?>
    <?php if($_SESSION["loggedOff"]===1) : ?>
            <div class="alert-loggedOff z-depth-5">
                <div class="inner-alert">
                    <p>A la prochaine !</p>
                    <ion-icon name="close" id="closeIcon"></ion-icon>
                </div>
            </div>
            <?php
            $_SESSION = array();
            session_destroy();
            ?>
    <?php endif; ?>
</body>
<script src="profil.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
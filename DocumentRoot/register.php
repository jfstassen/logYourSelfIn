<?php
session_start();
    $bdd = new PDO('mysql:host=mariadb;dbname=becode', 'root', 'root');

    if(isset($_POST["submit"])){
        $username = htmlspecialchars($_POST["username"]);
        $email = htmlspecialchars($_POST["email"]);
        $email2 = htmlspecialchars($_POST["email2"]);
        $passwd = password_hash($_POST["passwd"], PASSWORD_BCRYPT, array('cost' =>10));
        $passwd2 = password_hash($_POST["passwd2"], PASSWORD_BCRYPT, array('cost' =>10));

        if(!empty($_POST["username"]) AND 
        !empty($_POST["passwd"]) AND 
        !empty($_POST["passwd2"]) AND
        !empty($_POST["email"]) AND
        !empty($_POST["email2"]) AND
        empty($_POST["field"])
        ){
            $usernamelength = strlen($username);
            if($usernamelength <= 255){
                if($email == $email2){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $checkDBforExistingMail = $bdd->prepare("SELECT mail FROM students WHERE mail = ?");
                        $checkDBforExistingMail->execute(array($email));
                        $mailExist = $checkDBforExistingMail->rowCount();
                        if($mailExist == 0){
                            if(password_verify($_POST["passwd"], $passwd2)){
                                $registerStudent = $bdd->prepare("INSERT INTO students (username, mail, passwd) VALUES (?, ?, ?)");
                                $registerStudent->execute(array($username, $email, $passwd));
                                $_SESSION["account-created"];
                                header('Location: index.php');
                            }else{
                                $erreur = "Vos mots de passe ne sont pas identiques";
                            }
                        }else{
                            $erreur = "L'email existe déjà";
                        }
                    }else{
                        $erreur = "Votre email n'est pas valide";
                    }
                }else{
                    $erreur = "Vos emails ne correspondent pas";
                }
            }else{
                $erreur = "Votre username ne doit pas depassé 255 charactères";
            }
        }else {
            $erreur = "Tous les champs doivent etre complétés";
        }
    };
if($_SESSION["id"]){header("Location: profil.php");} //redirection si l'utilisateur est deja connecté
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>S'enregistrer</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<div class="container">
    <div class="main">
        <img src="https://media1.tenor.com/images/96962e37c70f6ec923405cd6d5374f5b/tenor.gif?itemid=7676976" alt="">
        <form class="register" action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
            <div class="input-field"><!-- Username -->
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" value="<?php if(isset($username)){echo $username;} ?>">
            </div>
            <div class="input-field"><!-- Email -->
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php if(isset($email)){echo $email;} ?>">
            </div>
            <div class="input-field"><!-- Verif Email -->
                <label for="email2">Confirmer votre mail</label>
                <input type="email" name="email2" id="email2" value="<?php if(isset($email2)){echo $email2;} ?>">
            </div>
            <div class="input-field"><!-- Password -->
                <label for="passwd">Mot de passe</label>
                <input type="password" name="passwd" id="passwd">
            </div>
            <div class="input-field"><!-- Verif Password -->
                <label for="passwd2">Confirmer le mot de passe</label>
                <input type="password" name="passwd2" id="passwd2">
            </div>
                <label for="field">field</label>
                <input type="text" name="field" id="field">

            <div class="group-btn-edit-delete">
            <button class="btn waves-effect waves-light green darken-1" type="submit" name="submit">S'inscrire
                <ion-icon name="checkmark"></ion-icon>
            </button>
            <a class="btn waves-effect waves-light grey darken-1" href="<?php echo $_SERVER["index.php"]; ?>">Annuler
                <ion-icon name="hand"></ion-icon>
            </a>
            </div>
            <div><?php if(isset($erreur)){echo $erreur;} ?></div>
        </form>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
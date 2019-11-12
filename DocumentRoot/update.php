<?php
session_start();
$bdd = new PDO('mysql:host=mariadb;dbname=becode', 'root', 'root');

if (empty($_SESSION["id"]) || !$_SESSION["passwdChecksOut"]) {
    $_SESSION = array();
    session_destroy();
    exit(header("Location : index.php"));
} else {
    $id = $_SESSION["id"];
    $sql = "SELECT * FROM students WHERE id = ?";
    $query = $bdd->prepare($sql);
    $query->execute(array($id));
    $result = $query->fetch();

    $id = $result["id"];
}
if (isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $github = $_POST['github'];
    $linkedin = $_POST['linkedin'];
    // $passwd = password_hash($_POST['passwd'], PASSWORD_BCRYPT, array('cost' => 10));

    $sql = "UPDATE students SET first_name=:fn , last_name=:ln, github=:git, linkedin=:linkedin WHERE id=:id";
    $query = $bdd->prepare($sql);
    $query->bindParam(':fn', $first_name);
    $query->bindParam(':ln', $last_name);
    $query->bindParam(':git', $github);
    $query->bindParam(':linkedin', $linkedin);
    $query->bindParam(':id', $id);
    $query->execute();
    header("Location: profil.php");
}
if (isset($_POST['delete'])) {
    $sql = "DELETE FROM students WHERE id = ?";
    $query = $bdd->prepare($sql);
    $query->execute(array($id));
    $_SESSION["deleted"] = 1; //créer une variable pour afficher un message par la suite dans index
    header("Location: logoff.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mettre a jour mon profil</title>
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="container">
        <div class="main">
            <form class="update-form" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                <div class="input-field">
                    <!-- PRENOM -->
                    <input type="text" id="first_name" name="first_name" value="<?php echo $result["first_name"] ?>" class="validate">
                    <label for="first_name">Votre Prenom</label>
                </div>
                <div class="input-field">
                    <!-- NOM -->
                    <input type="text" id="last_name" name="last_name" value="<?php echo $result["last_name"] ?>" class="validate">
                    <label for="last_name">Votre Nom</label>
                </div>
                <div id="try">
                    <!-- GITHUB -->
                    <label id="labelAddress" for="github">https://github.com/</label>
                    <div class="input-field inline mb-0">
                        <input type="text" id="github" name="github" value="<?php echo $result["github"] ?>" class="validate">
                        <label for="github">Identifiant Github</label>
                    </div>
                    <label id="labelAddress">/</label>
                </div>
                <div id="try">
                    <!-- LINKEDIN -->
                    <label id="labelAddress" for="linkedin">https://www.linkedin.com/in/</label>
                    <div class="input-field inline mb-0">
                        <input type="text" id="linkedin" name="linkedin" value="<?php echo $result["linkedin"] ?>" class="validate">
                        <label for="linkedin">Profil Linkedin</label>
                    </div>
                    <label id="labelAddress">/</label>
                </div>
                <div class="group-btn-edit-delete">
                    <button class="btn waves-effect waves-light" type="submit" name="update">Sauvegarder
                        <ion-icon name="save"></ion-icon>
                    </button>
                    <a class="btn waves-effect waves-light grey darken-1" href="profil.php">Annuler
                        <ion-icon name="hand"></ion-icon>
                    </a>
                    <button class="btn waves-effect waves-light red darken-4" type="submit" name="delete">Supprimer mon compte
                        <ion-icon name="flame"></ion-icon>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</html>
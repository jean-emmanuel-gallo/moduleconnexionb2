<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
          <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
          </ul>
        </nav>
    </header>
      
    <main>
        <div class="login-block">
            <h1>Connexion</h1>
            <form action="connexion.php" method="post">
                <div class="form-group">
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </main>



    <?php
session_start();

$servername = "localhost";
$username = "root";
$password = "@Jedeviles88";
$dbname = "moduleconnexionb2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM user WHERE login = :login AND password = :password");
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION['id_utilisateur'] = $result['id']; 

            // Vérifiez si le login et le mot de passe correspondent à "admin1337$"
            if ($login === 'admin1337$' && $password === 'admin1337$') {
                $_SESSION['login'] = 'admin';  
                header("Location: admin.php");
                exit();
            } else {
                header("Location: profil.php");
                exit();
            }
        } else {
            echo "Identifiants incorrects";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>


</body>
</html>
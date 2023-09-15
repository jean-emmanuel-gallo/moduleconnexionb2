<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        <div class="signup-block">
            <h2>Inscription</h2>
            <form action="inscription.php" method="post">
              <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required>
              </div>
              <div class="form-group">
                <label for="firstname">Prénom:</label>
                <input type="text" id="firstname" name="firstname" required>
              </div>
              <div class="form-group">
                <label for="lastname">Nom:</label>
                <input type="text" id="lastname" name="lastname" required>
              </div>
              <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
              </div>
              <div class="form-group">
                <label for="confirm-password">Confirmer le mot de passe:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
              </div>
              <button type="submit">S'inscrire</button>
            </form>
          </div>          
      </main>


      <?php
$servername = "localhost";
$username = "root";
$password = "@Jedeviles88";
$dbname = "moduleconnexionb2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définissez le mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Utilisation d'une requête préparée pour l'insertion
        $stmt = $conn->prepare("INSERT INTO user (login, firstname, lastname, password) VALUES (:login, :firstname, :lastname, :password)");

        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            header("Location: connexion.php");
        } else {
            echo "Erreur lors de l'inscription : " . $stmt->errorInfo()[2];
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

</body>
</html>
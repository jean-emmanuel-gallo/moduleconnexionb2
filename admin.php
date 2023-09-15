<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'administration</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 600px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: inline-block;
        }

        input[type="text"] {
            width: 150px;
            margin-right: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <nav>
          <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
          </ul>
        </nav>
    </header>

    <main>
        <h1>Liste des utilisateurs</h1>
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
        $enteredPassword = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPassword = $result['password'];

            if (password_verify($enteredPassword, $hashedPassword)) {
                $_SESSION['id_utilisateur'] = $result['id'];

                if ($login === 'admin1337$') {
                    $_SESSION['login'] = 'admin';
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location: profil.php");
                    exit();
                }
            } else {
                echo "Mot de passe incorrect";
            }
        } else {
            echo "Identifiant incorrect";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>


    </main>
</body>
</html>
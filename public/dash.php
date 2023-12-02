<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include("./include/db.php");

$id = $_SESSION['id'];

// Function to fetch user information
function getUserInfo($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        header("Location: login.php");
        exit();
    }
}

// Get user information
$user = getUserInfo($conn, $id);

// Function to fetch dashboard information
function getDashboardInfo($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM services WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $dashboardResult = $stmt->get_result();

    return ($dashboardResult->num_rows > 0) ? $dashboardResult->fetch_assoc() : array();
}

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    processFormSubmissions($conn, $id);
}

// Get updated dashboard information after form submissions
$dashboardData = getDashboardInfo($conn, $id);

// Process disconnect button
if (isset($_POST["disconnect"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Function to get all services for display
function getAllServices($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM services WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $allServicesResult = $stmt->get_result();

    return $allServicesResult->fetch_all(MYSQLI_ASSOC);
}

// Get all services for display
$allServices = getAllServices($conn, $id);

// Process modify profile form
if (isset($_POST["modify_profile"])) {
    $new_nom = $_POST["new_nom"];
    $new_email = $_POST["new_email"];
    $new_password = $_POST["new_password"];

    $updateStmt = $conn->prepare("UPDATE users SET nom = ?, email = ?, password = ? WHERE id = ?");
    $updateStmt->bind_param("sssi", $new_nom, $new_email, $new_password, $id);
    $updateStmt->execute();

    $updateMessage = ($updateStmt->affected_rows > 0) ? "Profil modifié avec succès." : "Erreur lors de la modification du profil.";

    $updateStmt->close();
}

// Function to handle form submissions
function processFormSubmissions($conn, $id)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process add service form
        if (isset($_POST["add_service"])) {
            $nom_service = $_POST["nom_service"];
            $nom_demande = $_POST["nom_demande"];
            $service_cin = $_POST["service_cin"];
            $service_address = $_POST["service_address"];

            $stmt = $conn->prepare("INSERT INTO services (user_id, service_name, nom_demande, service_cin, service_address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $id, $nom_service, $nom_demande, $service_cin, $service_address);
            $stmt->execute();
        } elseif (isset($_POST["delete_service"])) {
            // Process delete service form
            $delete_service_id = $_POST["delete_service_id"];

            $stmt = $conn->prepare("DELETE FROM services WHERE user_id = ? AND service_id = ?");
            $stmt->bind_param("ii", $id, $delete_service_id);
            $stmt->execute();
        } elseif (isset($_POST["modify_service"])) {
            // Process modify service form
            $modify_service_id = $_POST["modify_service_id"];
            $new_service_address = $_POST["new_service_address"];
            $new_nom_service = $_POST["new_nom_service"];
            $new_nom_demande = $_POST["new_nom_demande"];
            $new_service_cin = $_POST["new_service_cin"];

            $stmt = $conn->prepare("UPDATE services SET nom_service = ?, nom_demande = ?, service_cin = ?, service_address = ? WHERE user_id = ? AND service_id = ?");
            $stmt->bind_param("ssssii", $new_nom_service, $new_nom_demande, $new_service_cin, $new_service_address, $id, $modify_service_id);
            $stmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FFA500;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #FFF;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: left;
        }

        h2 {
            color: #333;
        }

        h3 {
            color: #555;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #FF4500;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        button:hover {
            background-color: #FF8C00;
        }

        .hidden {
            display: none;
        }

        nav {
            background-color: #FF4500;
            padding: 10px;
            text-align: center;
        }

        nav button {
            margin: 0 10px;
        }

        #allServices {
            border-collapse: collapse;
            width: 40%;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: auto;
            text-align: center;
        }

        #allServices th,
        #allServices td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            text-align: center;
        }

        #allServices th {
            background-color: #FF4500;
            color: white;
            text-align: center;
        }

        #allServices tr:nth-child(even) {
            background-color: #FFA07A;
        }

        #allServices tr:hover {
            background-color: #FFD700;
        }
    </style>

    <script>
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            form.classList.toggle('hidden');
        }

        function showAllServices() {
            var allServicesDiv = document.getElementById('allServices');
            allServicesDiv.style.display = (allServicesDiv.style.display === 'none') ? 'block' : 'none';
        }
    </script>

</head>

<body>
    <br>
    <nav>
        <button onclick="toggleForm('addForm')">Ajouter Service</button>
        <button onclick="toggleForm('deleteForm')">Supprimer Service</button>
        <button onclick="toggleForm('modifyForm')">Modifier Service</button>
        <button onclick="showAllServices()">Afficher tous les services</button>
        <button onclick="toggleForm('profileForm')">Modifier le profil</button>
        <br><br>
        <form method="POST" action="">
            <button type="submit" name="disconnect">Déconnecter</button>
        </form>
    </nav>

    <div class="container">
        <h2>Bienvenue dans votre Dashboard!</h2>
        <p>Votre ID: <?php echo $user['id']; ?></p>

        <form method="POST" action="" id="addForm" class="hidden">
            <label for="service_id">ID du Service:</label>
            <input type="text" name="service_id" required>
            <label for="nom_service">Nom du Service:</label>
            <select name="nom_service" required>
                <option value="Ménage et Nettoyage">Ménage et Nettoyage</option>
                <option value="Plomberie">Plomberie</option>
                <option value="Jardinage">Jardinage</option>
                <option value="Électricité">Électricité</option>
                <option value="Services de Livraison à Domicile">Services de Livraison à Domicile</option>
                <option value="Services Informatiques à Domicile">Services Informatiques à Domicile</option>
                <option value="Coiffure et Esthétique à Domicile">Coiffure et Esthétique à Domicile</option>
                <option value="Cours et Tutorat à Domicile">Cours et Tutorat à Domicile</option>
                <option value="Assistance Personnelle">Assistance Personnelle</option>
            </select>
            <label for="nom_demande">Demandeur :</label>
            <input type="text" name="nom_demande" required>
            <label for="service_cin">CIN du Demandeur:</label>
            <input type="text" name="service_cin" required>
            <label for="service_address">Adresse du demandeur:</label>
            <input type="text" name="service_address" required>
            <button type="submit" name="add_service">Ajouter Service</button>
        </form>

        <form method="POST" action="" id="deleteForm" class="hidden">
            <label for="delete_service_id">ID du service à supprimer:</label>
            <input type="text" name="delete_service_id" required>
            <button type="submit" name="delete_service">Supprimer Service</button>
        </form>

        <form method="POST" action="" id="modifyForm" class="hidden">
            <label for="modify_service_id">ID du Service à modifier:</label>
            <input type="text" name="modify_service_id" required>
            <label for="new_nom_service">Nouveau Nom:</label>
            <input type="text" name="new_nom_service" required>
            <label for="new_nom_demande">Nouveau Adresse de la demandeur:</label>
            <input type="text" name="new_nom_demande" required>
            <button type="submit" name="modify_service">Modifier Service</button>
        </form>

        <form method="POST" action="" id="profileForm" class="hidden">
            <label for="new_nom">Nouveau nom:</label>
            <input type="text" name="new_nom" value="<?php echo $user['name']; ?>" required>
            <label for="new_email">Nouveau Email:</label>
            <input type="email" name="new_email" value="<?php echo $user['email']; ?>" required>
            <label for="new_password">Nouveau mot de passe:</label>
            <input type="password" name="new_password" required>
            <button type="submit" name="modify_profile">Modifier le profil</button>
        </form>
    </div>

    <div id="allServices" style="display: none;">
        <h3>Toutes les informations des services:</h3>
        <br>
        <table border="1" id="allServices">
            <thead>
                <tr>
                    <th>ID du Service</th>
                    <th>Nom</th>
                    <th>Nom de la Demande</th>
                    <th>Adresse</th>
                    <th>CIN</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($allServices as $service) {
                    echo "<tr>";
                    echo "<td>{$service['service_id']}</td>";
                    echo "<td>{$service['service_name']}</td>";
                    echo "<td>{$service['nom_demande']}</td>";
                    echo "<td>{$service['service_address']}</td>";
                    echo "<td>{$service['service_cin']}</td>";
                    echo "<td>{$service['service_stat']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

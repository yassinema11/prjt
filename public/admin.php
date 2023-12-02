<?php
session_start();

include("./include/db.php");

$stmt = $conn->prepare("SELECT * FROM admins WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

$allServicesResult = $conn->query("SELECT * FROM services");
$allServices = $allServicesResult->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_service"])) {
    // Process add service form
    $nom_service = $_POST["nom_service"];
    $nom_demande = $_POST["nom_demande"];
    $service_cin = $_POST["service_cin"];
    $service_address = $_POST["service_address"];

    $stmt = $conn->prepare("INSERT INTO services (service_name, nom_demande, service_cin, service_address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom_service, $nom_demande, $service_cin, $service_address);
    $stmt->execute();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modify_service"])) {
    // Process modify service form
    $modify_service_id = $_POST["modify_service_id"];
    $new_service_address = $_POST["new_service_address"];
    $new_nom_service = $_POST["new_nom_service"];
    $new_nom_demande = $_POST["new_nom_demande"];
    $new_service_cin = $_POST["new_service_cin"];

    $stmt = $conn->prepare("UPDATE services SET service_name = ?, nom_demande = ?, service_cin = ?, service_address = ? WHERE service_id = ?");
    $stmt->bind_param("ssssi", $new_nom_service, $new_nom_demande, $new_service_cin, $new_service_address, $modify_service_id);
    $stmt->execute();
}

$stmt->close();

// Get all services
$allServicesResult = $conn->query("SELECT * FROM services");
$allServices = $allServicesResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffa500; /* Orange color */
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

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #555  ; /* Orange color */
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        button:hover {
            background-color: #ff7f00; 
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: auto;
            text-align: center;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #555;
            color: white;
            text-align: center;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Style for individual form blocks */
        .form-block {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Welcome, Admin!</h2>

        <div class="form-block">
            <h3>All Services</h3>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Demand Name</th>
                    <th>Service CIN</th>
                    <th>Service Address</th>
                    <!-- Add more service fields as needed -->
                </tr>
                <?php foreach ($allServices as $service) : ?>
                    <tr>
                        <td><?= $service['service_id']; ?></td>
                        <td><?= $service['service_name']; ?></td>
                        <td><?= $service['nom_demande']; ?></td>
                        <td><?= $service['service_cin']; ?></td>
                        <td><?= $service['service_address']; ?></td>
                        <!-- Add more service fields as needed -->
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="form-block">
            <h3>Add Service</h3>
            <form method="POST" action="">
                <label for="nom_service">Service Name:</label>
                <input type="text" name="nom_service" required>
                <label for="nom_demande">Demand Name:</label>
                <input type="text" name="nom_demande" required>
                <label for="service_cin">Service CIN:</label>
                <input type="text" name="service_cin" required>
                <label for="service_address">Service Address:</label>
                <input type="text" name="service_address" required>
                <button type="submit" name="add_service">Add Service</button>
            </form>
        </div>

        <div class="form-block">
            <h3>Modify Service</h3>
            <form method="POST" action="">
                <label for="modify_service_id">Service ID to Modify:</label>
                <input type="text" name="modify_service_id" required>
                <label for="new_nom_service">New Service Name:</label>
                <input type="text" name="new_nom_service" required>
                <label for="new_nom_demande">New Demand Name:</label>
                <input type="text" name="new_nom_demande" required>
                <label for="new_service_cin">New Service CIN:</label>
                <input type="text" name="new_service_cin" required>
                <label for="new_service_address">New Service Address:</label>
                <input type="text" name="new_service_address" required>
                <button type="submit" name="modify_service">Modify Service</button>
            </form>
        </div>

        <a href="logout.php">Logout</a>
    </div>
</body>

</html>


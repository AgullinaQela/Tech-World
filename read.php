<?php
include 'config.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Përdoruesit</title>
</head>
<body>
    <h2>Përdoruesit</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Emri</th>
            <th>Email</th>
            <th>Mosha</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["age"]. "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nuk ka përdorues</td></tr>";
        }
        ?>
    </table>
</body>
</html>
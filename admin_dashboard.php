<?php
include 'db.php';

// Lexo të gjitha produktet
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Produktet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Admin Dashboard - Menaxhimi i Produkteve</h2>

<!-- Forma për Shtimin e Produktit -->
<h3>Shto Produkt të Ri</h3>
<form method="POST" action="manage_products.php">
    <input type="hidden" name="action" value="add">
    <input type="text" name="name" placeholder="Emri i produktit" required>
    <input type="number" name="price" placeholder="Çmimi" required>
    <input type="text" name="image" placeholder="URL e imazhit" required>
    <button type="submit">Shto Produkt</button>
</form>

<hr>

<!-- Lista e Produkteve -->
<h3>Lista e Produkteve</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Emri</th>
        <th>Çmimi</th>
        <th>Imazhi</th>
        <th>Veprimet</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td>€<?php echo $row['price']; ?></td>
        <td><img src="<?php echo $row['image']; ?>" width="50"></td>
        <td>
            <form style="display:inline;" method="POST" action="manage_products.php">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit">Fshij</button>
            </form>

            <button onclick="editProduct('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['image']; ?>')">
                Përditëso
            </button>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Forma për Përditësimin e Produktit -->
<div id="editForm" style="display:none;">
    <h3>Përditëso Produktin</h3>
    <form method="POST" action="manage_products.php">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" id="edit_id">
        <input type="text" name="name" id="edit_name" required>
        <input type="number" name="price" id="edit_price" required>
        <input type="text" name="image" id="edit_image" required>
        <button type="submit">Ruaj Ndryshimet</button>
    </form>
</div>

<script>
function editProduct(id, name, price, image) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_image').value = image;
    document.getElementById('editForm').style.display = "block";
}
</script>

</body>
</html>

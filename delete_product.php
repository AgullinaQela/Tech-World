<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $sql = "SELECT image FROM products WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];
        
        
        $sql = "DELETE FROM products WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            echo "Produkti u fshi me sukses!";
        } else {
            echo "Gabim gjatë fshirjes: " . $conn->error;
        }
    }
}


header("Location: products.php");
exit();
?>
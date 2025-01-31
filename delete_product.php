<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Së pari marrim informacionin e imazhit
    $sql = "SELECT image FROM products WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];
        
        // Fshijmë produktin nga databaza
        $sql = "DELETE FROM products WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            // Fshijmë imazhin nga serveri
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            echo "Produkti u fshi me sukses!";
        } else {
            echo "Gabim gjatë fshirjes: " . $conn->error;
        }
    }
}

// Ridrejtojmë tek faqja e produkteve
header("Location: products.php");
exit();
?>
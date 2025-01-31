<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Konvertojmë në integer për siguri
    
    // Marrim informacionin e imazhit para fshirjes
    $sql = "SELECT image FROM products WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];
        
        // Fshijmë produktin nga databaza
        $sql_delete = "DELETE FROM products WHERE id = $id";
        
        if($conn->query($sql_delete)) {
            // Fshijmë imazhin nga serveri
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            $message = "Produkti u fshi me sukses!";
        } else {
            $message = "Gabim gjatë fshirjes së produktit: " . $conn->error;
        }
    } else {
        $message = "Produkti nuk u gjet!";
    }
}

// Ridrejtojmë tek faqja kryesore e admin-it
header("Location: admin_products.php?message=" . urlencode($message));
exit();
?>
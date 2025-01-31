<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Marrim informacionin e imazhit para fshirjes
    $result = lexoTeDhena($conn, 'products', "WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];
        
        // Fshijmë produktin
        if(fshiTeDhena($conn, 'products', "id = $id")) {
            // Fshijmë imazhin nga serveri
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }
}

header("Location: admin_products.php");
exit();
?>
<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; 
    
 
    $sql = "SELECT image FROM products WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];
        
       
        $sql_delete = "DELETE FROM products WHERE id = $id";
        
        if($conn->query($sql_delete)) {
           
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


header("Location: admin_products.php?message=" . urlencode($message));
exit();
?>
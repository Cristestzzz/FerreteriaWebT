<?php
    $conn = new mysqli("localhost","root","","animetineda");
    if ($conn->connect_error) {
        echo $error -> $conn->connect_error;
    }
    
?>

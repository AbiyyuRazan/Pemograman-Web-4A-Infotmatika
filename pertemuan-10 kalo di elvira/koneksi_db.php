<?php 
 
   $conn = new mysqli('localhost', 'root', '', 'praktikum_database_buku'); 
   if ($conn->connect_error) { 
       die("Connection failed: " . $conn->connect_error); 
   } 
?> 

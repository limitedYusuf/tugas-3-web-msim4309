<?php 

// KONEKSI DATABASE PDO

try {
   $dsn = "mysql:host=127.0.0.1;dbname=pendidikan";
   $username = "root";
   $password = "";
   $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // set error bawaan
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // set default type fetch data
   ];

   $conn = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
   echo "Koneksi Gagal : " . $e->getMessage();
}

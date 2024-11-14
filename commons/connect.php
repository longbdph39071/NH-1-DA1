<?php
    $hostname = DB_HOST;
    $port = DB_PORT;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;
    
    try {
      $conn = new PDO("mysql:host=$hostname;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
      // Chế độ báo lỗi
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // Trả giữ liệu
      $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
      debug("Connection failed: " . $e->getMessage()); 
    }

// Kết nối

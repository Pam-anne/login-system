<?php


    // Get config values
    $config = require 'config.php';
    $db = $config['database'];
    
    // Build DSN string
    $dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['dbname']};charset={$db['charset']}";
    
    // Create PDO instance
    $conn = new PDO($dsn, $db['username'], $db['password']);
    
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    

<?php
    // データベース接続情報
    $host = 'localhost';
    $db   = 'TestDB';
    $user = 'username';
    $pass = 'password';
    $charset = 'utf8mb4';

    // PDOでデータベースに接続
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    // フォームから受け取ったデータ
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // SQLクエリの準備
    $sql = "INSERT INTO Comments (name, email, message) VALUES (:name, :email, :message)";
    $stmt = $pdo->prepare($sql);

    // パラメータをバインド
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    // SQLクエリの実行
    $stmt->execute();
?>

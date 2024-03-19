<?php
    // データベース接続情報
    $host = 'localhost';
    $db   = 'git_test';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    // フォームから送信されたデータを取得
$nickname = $_POST['nickname'];
$email = $_POST['email'];
$content = $_POST['content'];


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

    // パラメータをバインド

    // // SQLクエリの実行
    // $stmt->execute();
//     $sql = 'INSERT INTO `survey`(`nickname`, `email`, `content`) VALUES (:nickname, :email, :content)';
// $stmt = $dbh->prepare($sql);
// $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
// $stmt->bindParam(':email', $email, PDO::PARAM_STR);
// $stmt->bindParam(':content', $content, PDO::PARAM_STR);
// $stmt->execute();
?>

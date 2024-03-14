<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'yoga';
$username = 'root';
$password = '';

try {
    // データベース接続処理
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST['id'];
    $isHidden = null;
    if ($_POST['is_hidden'] == 1) {
        $isHidden = 0;
    }
    if ($_POST['is_hidden'] == 0) {
        $isHidden = 1;
    }

    // 表示フラグを更新
    $stmt = $pdo->prepare("UPDATE inquiries SET is_hidden = :is_hidden WHERE id = :id");
    $stmt->execute([':is_hidden' => $isHidden, ':id' => $id]);

    echo 'toggle visibility successed!';

} catch (PDOException $e) {
    echo $e->getMessage();
    throw $e;
} catch (Exception $e) {
    echo $e->getMessage();
    throw $e;
}
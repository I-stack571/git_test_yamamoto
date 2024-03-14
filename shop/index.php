<?php
// データベース接続設定
// $dsn = 'mysql:host=localhost;dbname=shop;charset=utf8';
// $db_user = 'root';
// $db_password = '';
// $options = [
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// ];

// // エラーメッセージ
$error_messages = [];

$dsn = 'mysql:host=localhost;dbname=shop;charset=utf8';
$db_user = 'root';
$db_password = '';
$pdo = new PDO($dsn, $db_user, $db_password);


// バリデーションチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $quantity1 = trim($_POST['quantity1']);
    $quantity2 = trim($_POST['quantity2']);

    if (empty($name)) {
        $error_messages[] = '氏名を入力してください';
    }
    if (empty($address)) {
        $error_messages[] = '住所を入力してください';
    }
    if (!is_numeric($quantity1) || $quantity1 <= 0) {
        $error_messages[] = '商品の個数が不正です';
    }
    if (!is_numeric($quantity2) || $quantity2 <= 0) {
        $error_messages[] = '商品の個数が不正です';
    }

    if (count($error_messages) === 0) {
        try {
            $pdo = new PDO($dsn, $db_user, $db_password, $options);

            // 注文をordersテーブルへ保存
            $stmt = $pdo->prepare('INSERT INTO orders (customer_name, customer_address) VALUES (?, ?)');
            $stmt->execute([$name, $address]);
            $orderId = $pdo->lastInsertId();

            // order_itemsテーブルへ注文詳細を保存
            $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)');
            $stmt->execute([$orderId, 1, $quantity1]);
            $stmt->execute([$orderId, 2, $quantity2]);

            $error_messages[] = '注文が完了しました！';
        } catch (PDOException $e) {
            $error_messages[] = '注文中にエラーが発生しました (' . $e->getMessage() . ')';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Vagel Note - 仮想店舗</title>
    <style>
        /* スタイル設定 */
        body { text-align: center; }
        .product { display: inline-block; margin: 10px; }
        input[type="text"], input[type="number"], textarea { margin-bottom: 10px; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Vagel Note</h1>

    <!-- エラーメッセージ表示 -->
    <?php foreach ($error_messages as $message): ?>
    <div class="error"><?= htmlspecialchars($message) ?></div>
    <?php endforeach; ?>

    <form action="" method="post">
        <div class="product">
            <img src="images/product2.png" alt="クリームチーズベーグル" style="width: 100px; height: 100px;"><br>
            クリームチーズベーグル<br>
            <input type="number" name="quantity1" value="1">
        </div>
        <div class="product">
            <img src="images/product1.png" alt="ミートソースベーグル" style="width: 100px; height: 100px;"><br>
            ミートソースベーグル<br>
            <input type="number" name="quantity2" value="1">
        </div>
        <div>
            <input type="text" name="name" placeholder="氏名"><br>
            <textarea name="address" placeholder="住所"></textarea><br>
            <input type="submit" value="送信">
        </div>
    </form>
</body>
</html>

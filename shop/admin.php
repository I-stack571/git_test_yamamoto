<?php
// データベース接続設定
$dsn = 'mysql:host=localhost;dbname=shop;charset=utf8';
$db_user = 'root';
$db_password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_password, $options);

    // 注文キャンセル処理
    if (isset($_POST['cancel_order_id'])) {
        $cancelOrderId = $_POST['cancel_order_id'];
        $stmt = $pdo->prepare('UPDATE orders SET is_cancelled = 1 WHERE id = ?');
        $stmt->execute([$cancelOrderId]);
        header("Location: admin.php");
        exit();
    }
    
    // キャンセルされていない注文を取得
    $stmt = $pdo->query('SELECT orders.id, orders.customer_name, orders.customer_address FROM orders WHERE is_cancelled = 0');
    $orders = $stmt->fetchAll();

    // 各注文の商品詳細を取得
    foreach ($orders as $key => $order) {
        $stmt = $pdo->prepare('SELECT products.name, order_items.quantity FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = ?');
        $stmt->execute([$order['id']]);
        $orders[$key]['items'] = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    die('データベースエラー: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文管理画面</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>注文一覧</h1>
    <table>
        <tr>
            <th>注文ID</th>
            <th>顧客名</th>
            <th>住所</th>
            <th>注文詳細</th>
            <th></th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['id']) ?></td>
            <td><?= htmlspecialchars($order['customer_name']) ?></td>
            <td><?= htmlspecialchars($order['customer_address']) ?></td>
            <td>
                <?php foreach ($order['items'] as $item): ?>
                    <?= htmlspecialchars($item['name']) ?>: <?= htmlspecialchars($item['quantity']) ?>個<br>
                <?php endforeach; ?>
            </td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="cancel_order_id" value="<?= $order['id'] ?>">
                    <button type="submit">キャンセル</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
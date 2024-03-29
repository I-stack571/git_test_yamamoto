<?php
$host = 'localhost'; // XAMPPのデフォルト
$dbname = 'testdb'; // データベース名
$user = 'root'; // XAMPPのデフォルトユーザー名
$password = ''; // XAMPPのデフォルトパスワードは空

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // フォームから送信されたデータを取得
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];
    
    // SQL文を準備
    $sql = "INSERT INTO comments (name,address,comment,subject) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    // パラメータをバインドして実行
    $stmt->execute([$name, $email, $message,$subject]);
    
    echo "お問い合わせありがとうございます。";
    } catch (PDOException $e) {
    echo "データベース接続失敗: " . $e->getMessage();
    }

// フォームが送信されたかを確認
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ここで入力値の検証や処理を行う
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $subject = htmlspecialchars($_POST['subject']);
    // 入力値を確認するために表示（実際のアプリケーションでは使用しないでください）
    echo "<p>受け取った情報：</p>";
    echo "<p>名前: $name</p>";
    echo "<p>宛先: $subject</p>";
    echo "<p>メールアドレス: $email</p>";
    echo "<p>メッセージ: $message</p>";
    echo "<a href='./index.php'>戻る</a>";

    // 実際にはここでメールを送信したり、データベースに保存したりする
}
?>

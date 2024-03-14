<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'yoga';
$username = 'root';
$password = '';

// 入力データの整形
function input_data_sanitaization($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

// POSTリクエストの値を取得
$name = input_data_sanitaization($_POST['name']);
$email = input_data_sanitaization($_POST['email']);
$comments = input_data_sanitaization($_POST['comments']);

try {
    // データベース接続処理
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* バリデーションチェック */
    // 必須チェック
    if (empty($name) || empty($email) || empty($comments)) {
        throw new Exception('すべての項目を入力してください');
    }
    // メールアドレスの形式チェック
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('有効なメールアドレスを入力してください');
    }
    // 氏名の長さチェック
    if (strlen($name) > 50) {
        throw new Exception('氏名は50字以内で入力してください');
    }
    // コメントの長さチェック
    if (strlen($comments) > 400) {
        throw new Exception('コメントは400字以内で入力してください');
    }

    // 登録処理
    $stmt = $pdo->prepare("INSERT INTO inquiries (name, email, comments) VALUES (:name, :email, :comments)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':comments', $comments);
    $stmt->execute();

    session_start();
    $_SESSION['success_message'] = 'お問い合わせが正常に送信されました';
    
} catch (PDOException $e) {
    // データベースエラー時の処理
    session_start();
    $_SESSION['error_message'] = 'お問い合わせ送信でエラーが発生しました';
} catch (Exception $e) {
    // その他のエラー処理
    session_start();
    $_SESSION['error_message'] = $e->getMessage();
} finally {
    header('Location: index.php'); // index.phpにリダイレクト
    exit;
}

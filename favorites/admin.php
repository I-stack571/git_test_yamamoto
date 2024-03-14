<?php
session_start();

// データベース接続情報
$host = 'localhost';
$dbname = 'yoga';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created DESC");
  $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $errorMessage = 'お問い合わせ表示でエラーが発生しました';
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ管理画面</title>
  <meta name="description" content="yoga">
  <!-- <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" /> -->
  <link rel="stylesheet" href="style2.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <script>
    $(document).ready(function() {
      <?php if (isset($_SESSION['success_message'])) : ?>
        toastr.success('<?php echo $_SESSION['success_message']; ?>');
        <?php unset($_SESSION['success_message']); // メッセージを表示したらセッションから削除 
        ?>
      <?php endif; ?>
      <?php if (isset($_SESSION['error_message'])) : ?>
        toastr.error('<?php echo $_SESSION['error_message']; ?>');
        <?php unset($_SESSION['error_message']); // メッセージを表示したらセッションから削除 
        ?>
      <?php endif; ?>
    });
  </script>
</head>

<body>
  <main class="main">
    <table>
      <tr>
        <th>ID</th>
        <th>お名前</th>
        <th>メールアドレス</th>
        <th>メッセージ</th>
        <th>状態</th>
        <th>操作</th>
      </tr>
      <?php foreach ($inquiries as $inquiry) : ?>
        <tr>
          <td><?= htmlspecialchars($inquiry['id']); ?></td>
          <td><?= htmlspecialchars($inquiry['name']); ?></td>
          <td><?= htmlspecialchars($inquiry['email']); ?></td>
          <td><?= htmlspecialchars($inquiry['comments']); ?></td>
          <td><?= $inquiry['is_hidden'] ? '非表示' : '表示'; ?></td>
          <td>
            <button class="toggle-visibility" data-id="<?php echo $inquiry['id']; ?>" data-is-hidden="<?php echo $inquiry['is_hidden']; ?>">
                <?php echo $inquiry['is_hidden'] ? '表示にする' : '非表示にする'; ?>
            </button>
        </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <a href="index.php">ヨガ紹介ページへ戻る</a>
  </main>

  <script>
    $(document).ready(function() {
      $('.toggle-visibility').click(function() {
        var button = $(this);
        var id = button.data('id');
        var isHidden = button.data('is-hidden');
        $.ajax({
          url: 'toggle_visibility.php',
          type: 'POST',
          data: {
            'id': id,
            'is_hidden': isHidden
          },
          success: function(response) {
            toastr.success('状態が更新されました。');
            // ページをリロードして更新を反映
            location.reload();
          },
          error: function(response) {
            toastr.error('状態の更新に失敗しました。');
          }
        });
      });
    });
  </script>
</body>

</html>
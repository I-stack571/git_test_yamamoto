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

  $stmt = $pdo->query("SELECT * FROM inquiries WHERE is_hidden != 1 ORDER BY created DESC");
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
  <title>The Wonders of Yoga</title>
  <meta name="description" content="yoga">
  <!-- <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" /> -->
  <link rel="stylesheet" href="style2.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <script>
    $(document).ready(function() {
        <?php if (isset($_SESSION['success_message'])): ?>
            toastr.success('<?php echo $_SESSION['success_message']; ?>');
            <?php unset($_SESSION['success_message']); // メッセージを表示したらセッションから削除 ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            toastr.error('<?php echo $_SESSION['error_message']; ?>');
            <?php unset($_SESSION['error_message']); // メッセージを表示したらセッションから削除 ?>
        <?php endif; ?>
    });
  </script>
</head>

<body>
  <main class="main">
    <header class="header">
      <h1>ヨガは素晴らしい</h1>
      <nav>
        <ul>
          <li><a href="link1">ヨガとは何ですか？</a></li>
          <li><a href="link1">ヨガの利点</a></li>
          <li><a href="link1">ヨガを始める</a></li>
        </ul>
      </nav>
    </header>

    <p class="resizeimage">
      <img src="yoga.jpg" alt="Yoga Pose">
    </p>

    <h2>ヨガとは何ですか？</h2>
    <p>ヨガは、身体的な姿勢、呼吸法、瞑想、倫理原則を組み合わせた心と体の実践です。古代インドで生まれ、数千年かけて進化してきました。「ヨガ」という言葉はサンスクリット語のyujに由来しており、これはくびきや結合を意味し、身体と意識の結合を象徴しています。
    </p>

    <h2>ヨガの利点</h2>
    <p>ヨガは身体的、精神的、感情的に幅広いメリットをもたらします。主な利点には次のようなものがあります。</p>

    <ul>
      <li>柔軟性とバランスの向上</li>
      <li>ストレス解消とリラクゼーション</li>
      <li>筋力と姿勢の強化</li>
      <li>自己認識とマインドフルネスの向上</li>
      <li>メンタルヘルスへのプラスの効果</li>
    </ul>

    <h2>ヨガを始める</h2>
    <p>ヨガが初めての場合は、地元のクラスに参加するか、オンライン リソースを使用して基本を学ぶことをお勧めします。初心者向けのポーズから始めて、筋力と柔軟性を高めながら徐々に進歩していくといいです。ヨガは個人的な旅であり、自分の体の声に耳を傾け、自分のペースで練習することできる素晴らしいエクササイズです。
    </p>
    <p class="resizeimage">
      <img src="yoga_1.jpg" alt="Yoga Pose">
    </p>
    <form action="regist.php" method="post">
      お名前：
      <input type="text" name="name" size="30" value="" /><br />
      メールアドレス:
      <input type="text" name="email" size="30" value="" /><br />
      コメント：<br />
      <textarea name="comments" cols="30" rows="5"></textarea><br />
      <br />
      <input type="submit" value="登録する" />
    </form>

    <?php if (!empty($errorMessage)): ?>
      <p style="color: red;"><?php echo $errorMsg; ?></p>
    <?php else: ?>
      <table>
        <tr>
          <th>送信日時</th>
          <th>お名前</th>
          <th>コメント</th>
        </tr>
        <?php foreach ($inquiries as $inquiry): ?>
        <tr>
          <td><?= htmlspecialchars(($inquiry['created'])) ?></td>
          <td><?= htmlspecialchars(($inquiry['name'])) ?></td>
          <td><?= htmlspecialchars(($inquiry['comments'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </main>
</body>

</html>

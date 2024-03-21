<?php 
session_start();

// データベース接続情報
$host = 'localhost';
$dbname = 'testdb';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->query("SELECT * FROM `comments`");
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
<link rel="stylesheet" href="20240314_profile/style.css">
<title>"My Profile-sheet"</title>
<meta name="discription" content="私のプロフィールページです">
</head>    
<body>
    <div>
            <p class="greeting">Nice to meet you!</p>
    <div class="header-navi">
        <div class ="heaser-navi-bar">
            <ul>
              <li><a href="index.html">home</a></li>
              <li><a href="20240314_profile/another information.html">Other</a></li>
              
            </ul>
        </div>
    </div>
    </div>
<div>
    <img src="20240314_profile/izumi_photo.jpg"><br>


   </div>
   <div class="profile"></div>
    <h1>Izumi Yamamoto</h1> 
   </div>   
  <link rel="stylesheet" href="style.css2">
<h2>プロフィール</h2>
<p>山口県岩国市在住</p>
<p>山本いずみ</p>
<div> 
<p>3月3日生まれ 魚座 血液型 o型</p>

<li>趣味:　美術館巡り</li>
<p>海外の美術館は、パリルーブル美術館、ニューヨークメトロポリタン美術館、イギリス大英博物館は最高でした。</p>
<p>国内の美術館は、彫刻の森美術館、国立美術館、足立美術館も何度でも訪れたいです。</p>
<li>最近はまっている事：ヨガ、ベーグル</li>
<p>身体に良いこと全般大好きで、ペスカタリアンをめざしています。薬膳料理食べ歩きたい。</p>

<li>経歴・実績:　学生時代から洋楽、海外映画が大好きで、海外へ行ける仕事・英語にかかわれる会社＝商社へ就職。
<p>学生時代は、愛知県名古屋市で過ごしました。</p>
<p>楽器・音響機器を製造、輸出する仕事で海外へ行く機会がたくさんありました。</p>
<p>訪問外先は：アメリカ、ドイツ、フランス、イギリス、イタリア、バチカン、スイス、香港、韓国
<p>商社で貿易事務～英文事務、結婚後ECCジュニアホームティーチャー、派遣社員としてコールセンターも経験</p>

<li>夢: プログラマー／SE（フリーランス）</li>
<li>好きな言葉: 一期一会</li>
<li>スポーツ: テニス</li>
<ul>＊other：出身地山口県についての観光スポットをご紹介しています。</ul>
</section>
</ul>
  </div>
  <section class="Profile">
       <div class="img_container">
           <img class="frame" src="Jidori.jpg" alt="">
       </div>
       <div class="text_container">
           <p class="Name">ジソウスイッチ6期生 サブ講師 宮下 志大</p>
           どうも！最近第三の目が開眼しそうな宮下です！ <br>
           趣味は競馬で、好きな馬はエフフォーリア、ドウデュースです！<br>
           オススメのレースはやっぱり<a href="https://youtu.be/iFHXutgs0MQ?si=pr8YOCs7PQkzqcMF">2021年 天皇賞秋</a>と<a href="https://youtu.be/B51PM7I54Us?si=ABXkAQTtWrAsBWGf">2022年 日本ダービー</a>ですね！<br>
           ちょっとでも競馬に興味があったら気軽に連絡ください！<br>
           一緒に競馬場に行きましょう！
       </div>

   </section> 

<!-- お問い合わせフォーム -->
<form action="submit_contact.php" method="post">
    <label for="name">名前：</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">メールアドレス：</label><br>
    <input type="email" id="email" name="email" required><br><br>
    宛先：<br><select name="subject" id="Atesaki">
     <option value=""></option>
     <option value="宮下">宮下</option>
     <option value="山本">山本</option>
    </select><br><br>

    <label for="message">お問い合わせ内容：</label><br>
    <textarea id="message" name="message" rows="4" required></textarea><br><br>

    <input type="submit" value="送信">
</form>
<?php if (!empty($errorMessage)): ?>
      <p style="color: red;"><?php echo $errorMsg; ?></p>
    <?php else: ?>
      <table>
        <tr>
       
          <th>お名前</th>
          <th>宛先</th>
          <th>コメント</th>
        </tr>
        <?php foreach ($inquiries as $inquiry): ?>
        <tr>
          <td><?= htmlspecialchars(($inquiry['name'])) ?></td>
          <td><?= htmlspecialchars(($inquiry['subject'])) ?></td>
          <td><?= htmlspecialchars(($inquiry['comment'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>

</body>
</html>







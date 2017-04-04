<!DOCTYPE html>
<!-- phpからシェルコマンドを実行することでJavaプログラムを実行 -->
<?php
// classファイルのファイルパス
$classFilePath = "group_lens/ AnimeRecommender";

// 引数
$args = " ";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $args = $args . implode(" ", $_POST);
} else {
  exit("error: 不正な入力");
}

// シェルのメタ文字をエスケープ
$cmd = escapeshellcmd("java -classpath " . $classFilePath . $args);

// コマンドを実行して出力の文字列を取得
$result = shell_exec($cmd);
if ($result == false) {
  exit("error: アニメの推薦に失敗");
}

// $resultからアニメのIDと推定Ratingを取得
$tmp = explode("/", $result);
$ids = explode(":", $tmp[0]);
$ratings = explode(":", $tmp[1]);

// アニメタイトルを配列に格納
$titles = file("titles.txt", FILE_IGNORE_NEW_LINES);

// 推薦するアニメのタイトルを取得
$top_titles = array();
foreach ($ids as $id) {
  $top_titles[] = $titles[$id - 1];
}

print_r($top_titles);
print_r($ratings);
?>

<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>オススメのアニメ | 2015アニメ推薦システム</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sticky-footer.css" rel="stylesheet">

    <!-- Fontawesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link href="css/styles.css" rel="stylesheet">
    <link href="app_icon.png" rel="apple-touch-icon">
    <link href="favicon.ico" rel="icon">
  </head>

  <body>
    <div class="container" id="content">
      <p>あなたにおすすめのアニメは <?php echo $result; ?> です。</p>
    </div>

    <footer class="footer">
      <hr>
      <div  class="container, text-center">
        <a href="index.html" class="col-xs-4">Home</a>
        <a href="about.html" class="col-xs-4">About</a>
        <a href="contact.html" class="col-xs-4">Contact</a>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

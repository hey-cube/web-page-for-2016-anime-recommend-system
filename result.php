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
  exit("error: invalid input");
}

// シェルのメタ文字をエスケープ
$cmd = escapeshellcmd("java -classpath " . $classFilePath . $args);

// コマンドを実行して出力の文字列を取得
$result = shell_exec($cmd);
if ($result == false) {
  exit("error: failed");
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
      <p>あなたに最もおすすめのアニメは<?php echo $top_titles[0]; ?>です。</p>

      <a href="https://twitter.com/share" class="twitter-share-button"
      data-url="http://hoge"
      data-text="私がおすすめされたアニメは<?php echo $top_titles[0]; ?>でした">
        Tweet
      </a>
      <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
      </script>
      <br>

      <div class="fb-share-button"
      data-href="https://hoge"
      data-layout="button_count" data-size="small" data-mobile-iframe="true">
        <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fhoge%2F&amp;src=sdkpreparse">
          シェア
        </a>
      </div>

      <div class="frame">
        <img class="img-responsive center-block shadow"
        src="animeImage/<?php echo $ids[0] ?>.jpg" alt="<?php echo $top_titles[0]; ?>"
        width="60%" height="60%">
      </div>
      <br>

      <p>また、おすすめのアニメTOP5と評価の推定値は以下の通りです。</p>
      <br>

      <table class="table table-bordered">
        <?php
        for ($i = 0; $i < 5; $i++) {
          echo "<tr><td>" . $top_titles[$i] . "</td><td>" . round($ratings[$i], 5) . "</td></tr>";
        }
        ?>
      </table>
    </div>

    <div class="container">
      <div class="col-xs-2 col-sm-3"></div>
      <a class="btn btn-primary col-xs-8 col-sm-6" href="input.html">
        <i class="fa fa-hand-o-left" aria-hidden="true"></i> もう一回やってみる
      </a>
      <div class="col-xs-2 col-sm-3"></div>
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
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.8";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
  </body>
</html>

<!DOCTYPE html>
<?php
if (!$_POST) {
	exit("error: 不正アクセス");
}

$title = "問い合わせ【2016アニメ推薦システム】";
$to   = "s1411396@u.tsukuba.ac.jp";
$from = "s1411396@u.tsukuba.ac.jp";
$header  = "From: $from\n";
$header .= "Reply-To: $from";

$message =<<< HTML
{$_POST["name"]}様よりお問い合わせがありました。
メールアドレス：
{$_POST["address"]}
種類：
{$_POST["selection"]}
本文：
{$_POST["main"]}
HTML;

mb_language("ja");
mb_internal_encoding("UTF-8");

if (!mb_send_mail($to, $title, $message, $header)) {
  exit("error: お問い合わせの送信に失敗");
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send | 2016アニメ推薦システム</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sticky-footer.css" rel="stylesheet">

    <link href="css/styles.css" rel="stylesheet">
    <link href="app_icon.png" rel="apple-touch-icon">
    <link href="favicon.ico" rel="icon">
  </head>

  <body>
    <div class="container" id="content">
      <p>お問い合わせが送信されました。</p>
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

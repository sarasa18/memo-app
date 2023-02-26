<?php
require_once 'dbconnect.php';

$id = $_REQUEST['id'];

$delSuccess = '';
$delError = '';

if (isset($id) && is_numeric($id) && $id >= 1) {
  $protocol = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
  $prevurl = $protocol . $_SERVER["HTTP_HOST"] . '/sarasite/memo-app/single.php?id=' . $id;
  if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === $prevurl) {
    $delete = $db->prepare('DELETE FROM memos WHERE id=?');
    $delete->execute(array($id));

    $delSuccess = 'メッセージを削除しました';
  } else {
    $delError = '削除できませんでした。編集画面からもう一度やり直してください。';
  }
} else {
  $delError = 'メッセージは存在していないか、idが無効です。';
}


// 参考
// echo $_SERVER['REQUEST_URI'];
// echo "<br>";
// echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
// echo "<br>";
// echo (empty($_SERVER["HTTPS"]) ? "http://" : "https://") .
//   $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
// 表示
// /memo-app/delete.php?id=16
// localhost/memo-app/delete.php?id=16
// http://localhost/memo-app/delete.php?id=16

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEMO</title>
  <!-- google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
  <!-- css -->
  <link rel="stylesheet" href="css/docter_reset.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/default.css">
</head>

<body>
  <div class="allbg">
    <div class="c-container">
      <header>
        <div class="h-flex">
          <h1>DELETE</h1>
          <a href="index.php"><span>←</span></a>
        </div>
      </header>

      <main>
        <div class="c-bg">
          <div class="txta-cent">
            <p class="col-ws"><?= $delSuccess ?></p>
            <p class="col-ws"><?= $delError ?></p>
            <div class="c-btnbox txta-cent">
              <a href="index.php" class="c-btn">BACK</a>
            </div>
          </div>
        </div><!-- /.c-bg -->

      </main>

      <?php require_once 'footer.html' ?>
    </div>
  </div>
</body>

</html>
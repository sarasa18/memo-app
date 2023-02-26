<?php
require_once 'dbconnect.php';

if (!empty($_POST['memo'])) {
  $stmt = $db->prepare('INSERT INTO memos SET memo=?, created_at=NOW()');
  $stmt->bindParam(1, $_POST['memo']);
  $stmt->execute();

  header('Location: index.php');
  exit;
}

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
          <h1>CREATE NEW</h1>
          <a href="index.php"><span>←</span></a>
        </div>
      </header>

      <main>
        <div class="c-bg">
          <form action="" method="POST">
            <textarea name="memo" class="memo_area"></textarea>
            <div class="c-btnbox txta-cent">
              <input type="submit" name="btn_submit" value="SAVE" class="c-btn">
            </div>
          </form>
          <!-- 送信後の表示 -->
          <!-- <div class="txta-cent">
          <p class="col-ws">メッセージを登録しました</p>
          <div class="c-btnbox txta-cent">
            <a href="index.php" class="c-btn">BACK</a>
          </div>
        </div> -->

        </div><!-- /.c-bg -->

      </main>

      <?php require_once 'footer.html' ?>
    </div>
  </div>
</body>

</html>
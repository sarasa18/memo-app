<?php
require_once 'dbconnect.php';

$id = $_REQUEST['id'];

if (!is_numeric($id) || $id <= 0) {
  $coution = 'idは１以上の数字で指定してください';
} else {
  $memos = $db->prepare('SELECT * FROM memos WHERE id=?');
  $memos->bindParam(1, $id);
  $memos->execute();
  $memo = $memos->fetch();

  if (!isset($memo['id'])) {
    $coution = 'メッセージは存在しません';
  }
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
          <h1>DETAILS</h1>
          <a href="index.php"><span>←</span></a>
        </div>
      </header>

      <main>
        <div class="c-bg">
          <?php if (isset($memo['id'])) : ?>
            <div class="show-memo">
              <?= nl2br(htmlspecialchars($memo['memo'], ENT_QUOTES)) ?>
            </div>
            <div class="c-btnbox txta-cent">
              <a href="update.php?id=<?= $memo['id'] ?>" class="c-btn">EDIT</a>
              <a href="index.php" class="c-btn">BACK</a>
              <a href="delete.php?id=<?= $memo['id'] ?>" class="d-btn" onclick="return confirm('本当に削除してよろしいですか？')">DELETE</a>
            </div>
          <?php else : ?>
            <div class="txta-cent">
              <p class="col-ws"><?= $coution ?></p>
              <div class="c-btnbox txta-cent">
                <a href="index.php" class="c-btn">BACK</a>
              </div>
            </div>
          <?php endif; ?>

        </div><!-- /.c-bg -->

      </main>

      <?php require_once 'footer.html' ?>
    </div>
  </div>
</body>

</html>
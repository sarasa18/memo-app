<?php
require_once 'dbconnect.php';

$id = $_REQUEST['id'];

if (!is_numeric($id) || $id < 1) {
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

if (isset($_POST['memo'])) {
  $update = $db->prepare('UPDATE memos SET memo=? WHERE id=?');
  $update->bindParam(1, $_POST['memo']);
  $update->bindParam(2, $id);
  $update->execute();

  header('Location: single.php?id=' . $id);
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
          <h1>EDIT</h1>
          <a href="index.php"><span>←</span></a>
        </div>
      </header>

      <main>
        <div class="c-bg">
          <?php if (isset($memo['id'])) : ?>
            <form action="" method="post">
              <textarea name="memo" class="memo_area"><?= htmlspecialchars($memo['memo'], ENT_QUOTES) ?></textarea>
              <input type="hidden" name="id" value="<?= $id ?>">
              <div class="c-btnbox txta-cent">
                <a href="single.php?id=<?= $memo['id'] ?>" class="c-btn">BACK</a>
                <input type="submit" name="btn_submit" value="SAVE" class="c-btn">
              </div>
            </form>
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
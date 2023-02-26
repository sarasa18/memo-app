<?php
require_once 'dbconnect.php';

$counts = $db->query('SELECT COUNT(*) AS cnt FROM memos');
$cnt = $counts->fetch();

// ページャー
if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
  $page = $_REQUEST['page'];
} else {
  $page = 1;
}



$perPage = 5; // １ページあたりのデータ件数
$start = $perPage * ($page - 1);
$max_page = ceil($cnt['cnt'] / $perPage);

$lists = $db->prepare('SELECT * FROM memos ORDER BY id DESC LIMIT ?,?');
$lists->bindParam(1, $start, PDO::PARAM_INT);
$lists->bindParam(2, $perPage, PDO::PARAM_INT);
$lists->execute();

//ページの表示範囲
if ($page == 1 || $page == $max_page) {
  $range = 4;
} elseif ($page == 2 || $page == $max_page - 1) {
  $range = 3;
} else {
  $range = 2;
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
          <h1>MEMO</h1>
          <a href="input.php"><span>+</span></a>
        </div>
      </header>

      <main>
        <?php if ($cnt['cnt'] < 1) : ?>
          <div class="c-bg">
            <div class="txta-cent">
              <p class="col-ws">まだメモはありません</p>
            </div>
          </div>
        <?php endif; ?>
        <?php if ($page <= 0 || $page > $max_page) : ?>
          <div class="c-bg">
            <div class="txta-cent">
              <p class="col-ws">ページは存在しません</p>
            </div>
          </div>
        <?php endif; ?>


        <?php foreach ($lists as $list) : ?>
          <a href="single.php?id=<?= $list['id'] ?>" class="memo-bg">
            <h2>
              <?php if (mb_strlen($list['memo']) <= 50) {
                echo htmlspecialchars($list['memo'], ENT_QUOTES);
              } else {
                echo mb_substr(htmlspecialchars($list['memo'], ENT_QUOTES), 0, 50) . '…';
              } ?>
            </h2>
            <time class="date"><?= htmlspecialchars($list['created_at'], ENT_QUOTES); ?></time>
          </a>
        <?php endforeach; ?>

        <!-- ページャー -->
        <!-- 前へ -->
        <div class="pager-box">
          <?php if ($page >= 2) : ?>
            <a href="index.php?page=<?= $page - 1 ?>" class="pager">◀︎ PREV </a>
          <?php endif; ?>
          <!-- 数字 -->
          <?php for ($i = 1; $i <= $max_page; $i++) : ?>
            <?php if ($i >= $page - $range && $i <= $page + $range) : ?>
              <?php if ($i == $page) : ?>
                <a href="index.php?page=<?php echo $i; ?>" disable=”disabled” tabindex="-1" class="now-page"><?php echo $i; ?></a>
              <?php else : ?>
                <a href="index.php?page=<?php echo $i; ?>" class="pager"><?php echo $i; ?></a>
              <?php endif; ?>
            <?php endif; ?>
          <?php endfor; ?>
          <!-- 次へ -->
          <?php if ($page < $max_page) : ?>
            <a href="index.php?page=<?= $page + 1 ?>" class="pager"> NEXT ▶︎</a>
          <?php endif; ?>
        </div>

      </main>

      <?php require_once 'footer.html' ?>
    </div><!-- /c-container -->
  </div><!-- /callbg -->
</body>

</html>
<?php
require_once 'dbconnect.php';

// 参考
// https://zenn.dev/okkun510/articles/c987b8d66fa3eae6b132

// 共通
//SQL文を変数にいれる。$count_sqlはデータの件数取得に使うための変数。
$count_sql = 'SELECT COUNT(*) AS cnt FROM memos';

//ページ数を取得する。GETでページが渡ってこなかった時(最初のページ)のときは$pageに１を格納する。
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}

//最大ページ数を取得する。
//５件ずつ表示させているので、$count['cnt']に入っている件数を５で割って小数点は切りあげると最大ページ数になる。
$counts = $db->query($count_sql);
$count = $counts->fetch(PDO::FETCH_ASSOC);
$max_page = ceil($count['cnt'] / 5);

//表示範囲を決める
if ($page == 1 || $page == $max_page) {
  $range = 4;
} elseif ($page == 2 || $page == $max_page - 1) {
  $range = 3;
} else {
  $range = 2;
}

// ○件目と表示するには
$from_record = ($page - 1) * 5 + 1;

if ($page == $max_page && $count['cnt'] % 5 !== 0) {
  $to_record = ($page - 1) * 5 + $count['cnt'] % 5;
} else {
  $to_record = $page * 5;
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
  <!-- <link rel="stylesheet" href="css/docter_reset.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/default.css"> -->
</head>

<body>
  <style>
    a:link {
      text-decoration: none
    }

    a.page_number:visited {
      color: black;
      text-decoration: none
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin: 15px;
    }

    .page_feed {
      width: 30px;
      margin: 0 10px;
      padding: 5px 10px;
      text-align: center;
      background: #b8b8b8;
      color: black;
    }

    .first_last_page {
      width: 30px;
      margin: 0 10px;
      padding: 5px 10px;
      text-align: center;
      background: #f0f0f0;
      color: black;
    }

    a:link {
      text-decoration: none
    }

    a.page_number:visited {
      color: black;
      text-decoration: none
    }

    .page_number {
      width: 30px;
      margin: 0 10px;
      padding: 5px;
      text-align: center;
      background: #b8b8b8;
      color: black;
    }

    .now_page_number {
      width: 30px;
      margin: 0 10px;
      padding: 5px;
      text-align: center;
      background: #f0f0f0;
      color: black;
      font-weight: bold;
    }
  </style>
  <main>
    <!-- 件名を表示 -->
    <p class="from_to"><?php echo $count['cnt']; ?>件中 <?php echo $from_record; ?> - <?php echo $to_record; ?> 件目を表示</p>
    <div class="pagination">
      <!-- 前へ -->
      <?php if ($page >= 2) : ?>
        <a href="index.php?page=<?php echo ($page - 1); ?>" class="page_feed">&laquo;</a>
      <?php else :; ?>
        <span class="first_last_page">&laquo;</span>
      <?php endif; ?>
      <!-- ページ番号 -->
      <?php for ($i = 1; $i <= $max_page; $i++) : ?>
        <?php if ($i >= $page - $range && $i <= $page + $range) : ?>
          <?php if ($i == $page) : ?>
            <span class="now_page_number"><?php echo $i; ?></span>
          <?php else : ?>
            <a href="?page=<?php echo $i; ?>" class="page_number"><?php echo $i; ?></a>
          <?php endif; ?>
        <?php endif; ?>
      <?php endfor; ?>
      <!-- 次へ -->
      <?php if ($page < $max_page) : ?>
        <a href="index.php?page=<?php echo ($page + 1); ?>" class="page_feed">&raquo;</a>
      <?php else : ?>
        <span class="first_last_page">&raquo;</span>
      <?php endif; ?>
    </div>

  </main>



</body>

</html>
<?php 

//タイムゾーン
date_default_timezone_set('Asia/Tokyo');

//年月
$year = date('y');
$month = date('m');
$day = date('d');

//月末の日
$end_month = date('t', strtotime($year.$month.'01'));

//月末の曜日
$last_week = date('w', strtotime($year.$month.$end_month));

//月初の曜日
$first_week = date('w', strtotime($year.$month.'01'));

$calendar = [];
$j = 0;

//月初の曜日までの穴埋め
for($i = 0; $i < $first_week; $i++){
  $calendar[$j][] = '';
}

//月初から月末までずっとループする
for($i = 1; $i <= $end_month; $i++){
  //週毎に改行
  if(isset($calendar[$j]) && count($calendar[$j]) === 7){
    $j++;
  }
  $calendar[$j][] = $i;
}

//月末曜日からの穴埋め
for($i = count($calendar[$j]); $i < 7; $i++){
    $calendar[$j][] = '';
}

$week = ['日','月','火','水','木','金','土'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>カレンダー</title>
	<link rel="stylesheet" href="calendar.css">
</head>
<body>
	<header>
  <a href= "index.html" >TOPへ戻る</a>
	<h1>カレンダー</h1>
  </header>	
  <table class="calendar">
    <!-- 曜日表示 -->
    <tr>
    <?php foreach($week as $week){ ?>
      <!-- th（見出し）に曜日を入れる -->
        <th><?php echo $week ?></th>
    <?php } ?>
    </tr>
    <!-- 日付部分表示 -->
    <?php foreach($calendar as $tr){ ?>
    <tr>
        <?php foreach($tr as $td){ ?>
            <?php if($td != date('j')){ ?>
                <td><?php echo $td ?></td>
            <?php }else{ ?>
                <!-- 今日の日付 -->
                <td class="today"><?php echo $td ?></td>
            <?php } ?>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
</body>
</html>
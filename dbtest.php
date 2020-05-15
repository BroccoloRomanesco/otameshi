<?php
$link = sqlite_open('test.db', 0666, $sqliteerror);
if (!$link) {
    die('接続失敗です。'.$sqliteerror);
}

print('接続に成功しました。<br>');

$sql = "SELECT id, date FROM schedule";
$result = sqlite_query($link, $sql, SQLITE_BOTH, $sqliteerror);
if (!$result) {
    die('クエリーが失敗しました。'.$sqliteerror);
}

for ($i = 0 ; $i < sqlite_num_rows($result) ; $i++){
    $rows = sqlite_fetch_array($result, SQLITE_ASSOC);
    print('id='.$rows['id']);
    print(',name='.$rows['name'].'<br>');
}

sqlite_close($link);

print('切断しました。<br>');

?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>PHPとSQLite</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">SQLiteのDBファイルと接続！</h1>    
</header>
<?php 
while( $row = $res->fetchArray() ) {
	echo '<p>' . $row[0] . '</p>';
}
?>

</body>    
</html>
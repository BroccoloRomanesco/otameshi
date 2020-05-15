<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$link = sqlite_open('dbtest.db', 0666, $sqliteerror);
if (!$link) {
    die('接続失敗です。'.$sqliteerror);
}

print('接続に成功しました。<br>');

// SQLiteに対する処理

sqlite_close($link);

print('切断しました。<br>');

?>
</body>
</html>
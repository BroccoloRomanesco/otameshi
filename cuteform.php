<?php

//メッセージを保存する場所
define('FILENAME', './memosave.txt');

//タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

//変数の初期化
$now_date = null;
$data = null;
$file_handle = null;
//文字列を特定の文字で分割　「'」で分割する
$split_data = null;
//配列
$memo = array();
$m_array = array();
//メッセージ
$success_message = null;
$error_message = array();
//サニタイズ
$clean = array();

//もし空じゃなかったら送る
if (!empty($_POST['btn_submit'])) {

	//タイトルの入力をチェックする
	if (empty($_POST['title'])) {
		$error_message[] = 'タイトルを入力してください';
	} else {
		$clean['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES);
		$clean['title'] = preg_replace('/\\r\\n|\\n|\\r/', '', $clean['title']);
	}
	//内容の入力をチェックする
	if (empty($_POST['memo'])) {
		$error_message[] = 'メモ内容を入力してください';
	} else {
		$clean['memo'] = htmlspecialchars($_POST['memo'], ENT_QUOTES);
		$clean['memo'] = preg_replace('/\\r\\n|\\n|\\r/', '<br>', $clean['memo']);
	}

	if (empty($error_message)) {

		// if ($file_handle = fopen(FILENAME, "a")) {

		// 	// 書き込み日時を取得
		// 	$now_date = date("Y-m-d H:i:s");

		// 	// 書き込むデータを作成
		// 	$data = "'" . $clean['title'] . "','" . $clean['memo'] . "','" . $now_date . "'\n";

		// 	// 書き込み
		// 	fwrite($file_handle, $data);

		// 	// ファイルを閉じる
		// 	fclose($file_handle);

		// 	$success_message = 'メッセージを書き込みました。';
		// }

		// データベース接続
		$mysqli = new mysqli( 'localhost', 'memotest', 'memowoDBni', 'test');

		// 接続エラー確認
		if( $mysqli->connect_errno ) {
			$error_message[] = '書き込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
		} else {

			// 文字コード
			$mysqli->set_charset('utf8');
			
			// 書き込み日時取得
			$now_date = date("Y-m-d H:i:s");
			
			// データ登録SQL
			$sql = "INSERT INTO message (title, memo, post_date) VALUES ( '$clean[title]', '$clean[memo]', '$now_date')";
			
			// データを登録
			$res = $mysqli->query($sql);
		
			if( $res ) {
				$success_message = 'メッセージを書き込みました。';
			} else {
				$error_message[] = '書き込みに失敗しました。';
			}
		
			// データベースの接続を閉じる
			$mysqli->close();
		}
	}
}

//これはファイルを開く「r」
if ($file_handle = fopen(FILENAME, 'r')) {

	//fgets関数、ファイルから1行ずつ取得する
	while ($data = fgets($file_handle)) {
		$split_data = preg_split('/\'/', $data);

		$memo = array(
			'title' => $split_data[1],
			'memo' => $split_data[3],
			'post_date' => $split_data[5]
		);
		array_unshift($m_array, $memo);
	}


	// ファイルを閉じる
	fclose($file_handle);
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>input.html</title>
	<link rel="stylesheet" type="text/css" href="cuteformcss.css">
	<link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">

</head>

<body>
	<span class="marker">
		<a href="index.html">TOPへ戻る</a>

		<h1>メモ入力画面</h1>
		<a href="cuteform.php">《キュートデザイン》</a>
		<a href="coolform.php">《クールデザイン》</a>
		<a href="japanform.php">《和風デザイン》</a>
		<a href="form.php">《デフォルトデザイン》</a>
	</span>

	<?php if (!empty($success_message)) : ?>
		<p class="success_message"><?php echo $success_message; ?></p>
	<?php endif; ?>
	<?php if (empty($error_message)) : ?>
		<ul class="error_message">
			<?php foreach ($error_message as $value) : ?>
				<li>・<?php echo $value; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<span class="marker">
		<p>メモを入力しましょう</p>
	</span>
	<form method="post">
		<div>
			 <label for="title">メモのタイトル</label>
			<input id="title" type="text" name="title" value="">
		</div>
		<div>
			<label for="memo">メモの内容</label>
			<textarea id="memo" name="memo"></textarea>
		</div>
		<input type="submit" name="btn_submit" value="メモ作成">
	</form>
	<hr>
	<section>

		<?php if (!empty($m_array)) : ?>
			<?php foreach ($m_array as $value) : ?>
				<article>
					<div class="info">
						<h2><?php echo $value['title']; ?></h2>
						<time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
					</div>
					<p><?php echo $value['memo']; ?></p>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</section>

</body>

</html>
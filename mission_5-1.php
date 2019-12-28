	<!DOCTYPE html>
<html>
 <head>
    <meta charset = "utf-8">
    <title>mission_5-1</title>
 <head>
<body>
	<form action = "mission_5-1.php" method = "post">
	<input type = "text" placeholder ="名前" name = "name" ><br>
	<input type = "text" placeholder = "コメント" name = "comment" ><br>
	<input type = "hidden"placeholder = "hidden" name = "hidden" >
	<input type = "text" placeholder = "パスワード" name = "pass">
	<input type = "submit" value = "送信"><br><br>
	<input type = "text" placeholder = "削除番号"name = "delete"><br>
	<input type = "text" placeholder = "パスワード"name = "delpass">
	<input type = "submit" value = "削除"><br><br>
	<input type = "text" placeholder = "編集番号" name ="editor"><br>
	<input type = "text" placeholder = "パスワード" name = "edipass">
	<input type = "submit" value = "編集"><br><br>

<?php
//data baseの接続完了
$dsn = 'データベース名';
//$dsnの式の中にスペースを入れないこと！
$user = 'ユーザー名';
$password = 'パスワード';
//data baseで発生したerror表示
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//data base内にtableを作成
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name TEXT,"
	. "comment TEXT,"
	. "date DATETIME,"
	. "pass TEXT"
	.");";

//指定したsql文をdata baseに発行
$stmt = $pdo->query($sql);
//挿入する値は空のまま、sql実行の準備をする
$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':date', $date, PDO::PARAM_STR);
$sql -> bindParam(':pass', $hidden, PDO::PARAM_STR);
//入力フォームを獲得する
$name = $_POST['name'];
$comment = $_POST['comment'];
$pass = $_POST['pass'];
$date = $date->format('Y年M月D日 H:i:s');
$sql -> execute($date);
	
	$sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	
		foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['date'].' '.'<br>';
	echo "<hr>";
	}

	?>
	
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <title>mission_3-5</title>
<head>
<body>
<?php
$filename = "mission_3-5.txt";
//使いたいfileを変数定義
$name = $_POST["name"];
$comment = $_POST["comment"];
$pass = $_POST["password"];
$time = date("Y年m月d日 H:i:s");
//本日の日付と時間

if(file_exists($filename)){
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    end($lines);
    $last = explode("<>", end($lines));
    $num = $last[0] + 1;
}
//変数と投稿番号の定義
$newdata = $num."<>".$name."<>".$comment."<>".$time."<>".$pass;
//変数を結合した


//削除設定
if(
!empty($_POST["delete"])||
!empty($_POST["delpass"])
){
//$_POST["delete"]に値があるなら機能する
		
		$delete = $_POST["delete"];
		$delpass = $_POST["delpass"];
		//送信formの信号を変数として定義	
		$del = fopen($filename, "a");
		//txt上に追加書き込み
		$lines = file($filename, FILE_IGNORE_NEW_LINES);
		//読み込んだtext fileを行ごとに配列して返す
		// FILE_IGNORE_NEW_LINESにより最後の改行文字が含まれない
		fwrite(fopen($filename, "w"),"");
		//fleの中をからにする
		
		foreach($lines as $line){			
		//file($filename, FILE_IGNORE_NEW_LINES)の中の行($newdata)を1投稿ずつ確認する
		$delete_str = explode("<>", $line);
		
		if($delete_str[0] == $delete&&
		$delpass == $delete_str[4]
		){
			if($delete_str[0] != $delete){
			fwrite($del, $newdata.PHP_EOL);
			}else{
			}
		}else{
		fwrite($del, $line.PHP_EOL);
		}				
		}fclose($del);
}
//削除完了

//編集開始
if(!empty($_POST["editor"])&&
!empty($_POST["edipass"])
){
    //もし編集番号のフォームに書かれているかつ編集passwordの中にpasswordが入力されているなら
    $editor = $_POST["editor"];
    $edipass = $_POST["edipass"];
    //掲示板編集変数
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    //fileの中身を１行一要素として配列変数に代入
    foreach($lines as $newdata){$editor_str = explode("<>", $newdata);
        //配列の要素数だけをループさせ、投稿番号を所得

        if($editor == $editor_str[0]&&
        $edipass == $editor_str[4]
        //投稿番号が同じかつpasswordが同じ場合
        ){
            $editor = $editor_str[0];
            $editorname = $editor_str[1];
            $editorcomment = $editor_str[2];
            //切り取った要素を変数に代入
        }
    }
}

if(!empty($name)||
!empty($comment)
//名前、コメントの入力フォームが埋まっている場合
){
    
	    if(!empty($_POST["hidden"])){
       	//hiddenが埋まっている場合
       	$hidden = $_POST["hidden"];
		$edit = fopen($filename, "a");
        //txt上に追加書き込み
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        //読み込んだtext fileを行ごとに配列して返す
        // FILE_IGNORE_NEW_LINESにより最後の改行文字が含まれない
        fwrite(fopen($filename, "w"),"");
	    //fleの中をからにする        
	    
	        foreach($lines as $line){
	        //file()の中身を行ごとに取り出す
	        $editdata_str = explode("<>", $line);
	       	
	            if($editdata_str[4] == $pass
	           	//hiddenと取り出した投稿番号が同じ場合
	            ){
	            $editdata = $editdata_str[0]."<>".$name."<>".$comment."<>".$time."<>".$pass;	
				//編集後の表示する文字を作成
	            	if($hidden == $editdata_str[0]){
	            	//passwordと取り出したpasswordが同じ場合
	            	fwrite($edit, $editdata.PHP_EOL);
	            	}else{
	            	fwrite($edit, $line.PHP_EOL);
	            	}
	           	}else{
	            fwrite($edit, $line.PHP_EOL);	
	            }
      		}fclose($edit);
		}
}

?> 
<form action = "mission_3-5.php" method = "post">
    名前:<input type = "text" name = "name" value = "<?php if(!empty($editor)&&!empty($edipass)){if($editor == $editor_str[0]&&
        $edipass == $editor_str[4]){echo $editor_str[1];}} ?>"><br>
    コメント:<input type = "text" name = "comment" value = "<?php if(!empty($editor)&&!empty($edipass)){if($editor == $editor_str[0]&&
        $edipass == $editor_str[4]){echo $editor_str[2];}} ?>"><br>
    <input type = "hidden" name = "hidden" value = "<?php if(!empty($editor)&&!empty($edipass)){if($editor == $editor_str[0]&&
        $edipass == $editor_str[4]){echo $editor;}} ?>" >
    パスワード:<input type = "text" name = "password"><input type = "submit" value = "送信"><br><br>
    削除番号:<input type = "text" name = "delete"><br>
    パスワード:<input type = "text" name = "delpass"><input type = "submit" value = "削除"><br><br>
    編集番号:<input type = "text" name ="editor"><br>
    パスワード:<input type = "text" name = "edipass"><input type = "submit" value = "編集"><br><br>

<?php
//投稿開始

if(!empty($name)||
!empty($comment)||
empty($hidden)
){    
$fpa = fopen($filename, "a");
fwrite($fpa, $newdata.PHP_EOL);

    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $newdata = $num."<>".$name."<>".$comment."<>".$time."<>".$pass;
    //変数を結合した
    foreach($lines as $newdata){$nd_str = explode("<>", $newdata);
    $newdata1 = $nd_str[0]." ".$nd_str[1]." ".$nd_str[2]." ".$nd_str[3];  
    echo  $newdata1."<br>";
    }fclose($fpa);
}
//投稿終了
?>
</body>
</html>

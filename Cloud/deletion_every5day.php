<?php
try{
// PDOクラスのオブジェクトを作成
//$pdo = new PDO('mysql:host=35.197.70.52;port=33060;dbname=pool;charset=utf8', 'c0117178', 'e6jA#gTz6', array(PDO::ATTR_EMULATE_PREPARES => false));
$pdo = new PDO('mysql:host=localhost;dbname=home_pi;charset=utf8;', 'c0117178', 'e6jA#gTz6', array(PDO::ATTR_EMULATE_PREPARES => false));
}catch(PDOException $e){
exit('データベース接続失敗。'.$e->getMessage());
}
//削除処理
$sql = "delete from temp_val where datediff(now(), temp_val.ts) > 5";
//SQL実行準備
$st = $pdo->prepare($sql);
//実行
$st->execute();

?>

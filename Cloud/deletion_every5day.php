<?php
try{
// PDOクラスのオブジェクトを作成
$pdo = new PDO('mysql:host=localhost;dbname=dbname;charset=utf8;', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
}catch(PDOException $e){
exit('データベース接続失敗。'.$e->getMessage());
}
//削除処理
$sql = "delete from sensor_val where datediff(now(), sensor_val.ts) > 5";
//SQL実行準備
$st = $pdo->prepare($sql);
//実行
$st->execute();

?>

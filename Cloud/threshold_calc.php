<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
try{
// PDOクラスのオブジェクトを作成
$pdo = new PDO('mysql:host=host;dbname=dbname;charset=utf8', 'user', 'password', array(PDO::ATTR_EMULATE_PREPARES => false));
}catch(PDOException $e){
  exit('データベース接続失敗。'.$e->getMessage());
}
//削除処理
$sql = "select ts, mod(time_to_sec(timediff(now(), temp_val.ts)), 86400) as 'time', temp from temp_val where ((mod(time_to_sec(timediff(now(), temp_val.ts)), 86400) > 82740) or (mod(time_to_sec(timediff(now(), temp_val.ts)), 86400) < 7260)) order by ts desc;";
//SQL実行準備
$st = $pdo->prepare($sql);
//実行
$st->execute();
//表示
$res = $st->fetchAll(PDO::FETCH_ASSOC);
$max = (float)$res[0]['temp'];
$min = 0;
$sum = $max;
$num = count($res);
for($i = 1; $i < $num; $i++){
  $val = (float)$res[$i]['temp'];
  $sum += $val;
  if($max < $val){
    $max = $val;
  }
  if($min > $val){
    $min = $val;
  }
}
$avg = $sum / $num;
$max_up = $avg * 2;
if($max < $max_up){
  $max = $max_up;
}
echo '>>閾値計算完了'.'<br>';
echo 'min:'.$min;
echo '<br>';
echo 'max:'.$max;
echo '<br>';
//閾値更新
$upd_max = 'update threshold set max_val='.$max.' where id=0;';
$upd_min = 'update threshold set min_val='.$min.' where id=0;';
$st_max = $pdo->prepare($upd_max);
$st_max->execute();
$st_min = $pdo->prepare($upd_min);
$st_min->execute();
echo '>>更新完了';
?>

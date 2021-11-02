<?php

require_once __DIR__ . '/vendor/autoload.php';

// 
// Eloquentの初期化
// 

class_alias(Illuminate\Database\Capsule\Manager::class, 'DB');
$database = new DB();
$config = [
    'driver'    => 'mysql',              // データベースの種類
    'host'      => 'localhost',          // ホスト名
    'database'  => '',           // データベース名
    'username'  => '',               // ユーザー名
    'password'  => '',           // パスワード
    // 'charset'   => 'utf8mb4',            // 文字セット(任意)
    // 'collation' => 'utf8mb4_general_ci', // コレーション(任意)
];
$database->addConnection($config);
$database->setAsGlobal();
$database->bootEloquent();


// 
// POSTされたときの処理
// 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    preg_match("/送信パケット:                   (\d+)/u", mb_convert_encoding($_POST["lan1"], "UTF-8", "sjis"), $d["lan1_total_send"]);
    preg_match("/受信パケット:                   (\d+)/u", mb_convert_encoding($_POST["lan1"], "UTF-8", "sjis"), $d["lan1_total_receive"]);
    preg_match("/IPv4\(全体\/ファストパス\):      (\d+) パケット/u", mb_convert_encoding($_POST["lan1"], "UTF-8", "sjis"), $d["lan1_v4_send"]);
    preg_match("/IPv6\(全体\/ファストパス\):      (\d+) パケット/u", mb_convert_encoding($_POST["lan1"], "UTF-8", "sjis"), $d["lan1_v6_send"]);
    preg_match("/IPv4:                         (\d+) パケット/u", mb_convert_encoding($_POST["lan1"], "UTF-8", "sjis"), $d["lan1_v4_receive"]);
    preg_match("/IPv6:                         (\d+) パケット/u", mb_convert_encoding($_POST["lan1"], "UTF-8", "sjis"), $d["lan1_v6_receive"]);

    preg_match("/送信パケット:                   (\d+)/u", mb_convert_encoding($_POST["lan2"], "UTF-8", "sjis"), $d["lan2_total_send"]);
    preg_match("/受信パケット:                   (\d+)/u", mb_convert_encoding($_POST["lan2"], "UTF-8", "sjis"), $d["lan2_total_receive"]);
    preg_match("/IPv4\(全体\/ファストパス\):      (\d+) パケット/u", mb_convert_encoding($_POST["lan2"], "UTF-8", "sjis"), $d["lan2_v4_send"]);
    preg_match("/IPv6\(全体\/ファストパス\):      (\d+) パケット/u", mb_convert_encoding($_POST["lan2"], "UTF-8", "sjis"), $d["lan2_v6_send"]);
    preg_match("/IPv4:                         (\d+) パケット/u", mb_convert_encoding($_POST["lan2"], "UTF-8", "sjis"), $d["lan2_v4_receive"]);
    preg_match("/IPv6:                         (\d+) パケット/u", mb_convert_encoding($_POST["lan2"], "UTF-8", "sjis"), $d["lan2_v6_receive"]);

    preg_match("/受信: (\d+) パケット/u", mb_convert_encoding($_POST["pp1"], "UTF-8", "sjis"), $d["pp1_receive"]);
    preg_match("/送信: (\d+) パケット/u", mb_convert_encoding($_POST["pp1"], "UTF-8", "sjis"), $d["pp1_send"]);
    // デバッグ用ログ
    // logging($d);


    // 現在時刻を取得
    $dt = new DateTime();
    $dt = $dt->modify('-9 hours'); //GrafanaはUTCで登録する必要あり

    // DBに入れるデータを作成する
    $data = array_map(function ($item) {
        if (isset($item[1])) {
            return $item[1];
        } else {
            return null;
        }
    }, $d);
    $data["update_at"] = $dt;
    $data["host"]=$_SERVER["REMOTE_ADDR"];


    // DBにインサートする
    DB::table("traffics")->insert($data);
}



function logging($val)
{
    // ログ保存ファイル名
    define("TXTFILE", "rtxlogger.log");
    // ファイルを追記モードでオープン
    $fh = fopen(TXTFILE, "a+");
    // GETされたデータをすべて取得して、配列として取得
    $str = print_r($val, true);
    // ファイルに追記する
    fputs($fh,  $str);
    // ファイルを閉じる
    fclose($fh);
}

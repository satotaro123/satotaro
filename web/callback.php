<?php
//テーブル名を定義
define ( 'TABLE_NAME_BOTLOG', 'botlog' );

 //パラメータ
 $data = array('input'=>array("text"=>$event->getText()));

error_log ( $line );
$accessToken = getenv ( 'LINE_CHANNEL_ACCESS_TOKEN' );

// ユーザーからのメッセージ取得
$json_string = file_get_contents ( 'php://input' );
$jsonObj = json_decode ( $json_string );

$type = $jsonObj->{"events"} [0]->{"message"}->{"type"};
$eventType = $jsonObj->{"events"} [0]->{"type"};
// メッセージ取得
$text = $jsonObj->{"events"} [0]->{"message"}->{"text"};
// ReplyToken取得
$replyToken = $jsonObj->{"events"} [0]->{"replyToken"};
// ユーザーID取得
$userID = $jsonObj->{"events"} [0]->{"source"}->{"userId"};

error_log ( $eventType );
if ($eventType == "follow") {
	$response_format_text = [
			"type" => "template",
			"altText" => "this is a buttons template",
			"template" => [
					"type" => "buttons",
					"thumbnailImageUrl" => "https://" . $_SERVER ['SERVER_NAME'] . "/gyosei.jpg",
					"title" => "行政市役所",
					// "text" => "こんにちは。行政市のすいか太郎です。\n皆さんの質問にはりきってお答えしますよ～\nまずは、下のメニュータブをタップしてみてください",
					"text" => "こんにちは。\n行政市のすいか太郎です。\n皆さんの質問にはりきってお答えしますよ～",
					"actions" => [
							[
									"type" => "postback",
									"label" => "LINEで質問",
									"data" => "action=qaline"
							],
							[
									"type" => "postback",
									"label" => "証明書",
									"data" => "action=shomei"
							],
							[
									"type" => "postback",
									"label" => "施設予約",
									"data" => "action=shisetsu"
							],
							[
									"type" => "postback",
									"label" => "ご利用方法",
									"data" => "action=riyo"
							]
					]
			]
	];
	goto lineSend;
}

/*$fp = fopen ( "https://" . $_SERVER ['SERVER_NAME'] . "/php.txt", "r" );
while ( $line = fgets ( $fp ) ) {
	echo "$line<br />";
	error_log ( $line );
}
fclose ( $fp );*/

if ($eventType == "postback") {
	$bData = $jsonObj->{"events"} [0]->{"postback"}->{"data"};
	if ($bData == 'action=qaline') {
		$response_format_text = [
				"type" => "text",
				"text" => "それでは、質問をお願いします。"
		];
		goto lineSend;
	}

	if ($bData == 'action=shomei') {
		$response_format_text = [
				"type" => "text",
				"text" => "証明書についてはこちらをごらんください。"
		];
		goto lineSend;
	}

	if ($bData == 'action=shisetsu') {
		$response_format_text = [
				"type" => "text",
				"text" => "施設予約についてはこちらをごらんください。"
		];
		goto lineSend;
	}

	if ($bData == 'action=riyo') {
		$response_format_text = [
				"type" => "text",
				"text" => "ご利用方法についてはこちらをごらんください。"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_1_1') {
		$response_format_text = [
				"type" => "text",
				"text" => "①○○地区、△△地区、□□地区ですね。\nその場合、最寄りの税務署は「行政第一税務署」になります。「行政第一税務署」の詳細はURLをご確認ください。\n他に質問はありますか？"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_1_2') {
		$response_format_text = [
				"type" => "text",
				"text" => "②●●地区、▲▲地区、■■地区ですね。\nその場合、最寄りの税務署は「行政第二税務署」になります。「行政第二税務署」の詳細はURLをご確認ください。\n他に質問はありますか？"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_1_3') {
		$response_format_text = [
				"type" => "text",
				"text" => "③Ａ地区、Ｂ地区、Ｃ地区ですね。\nその場合、最寄りの税務署は「行政第三税務署」になります。「行政第三税務署」の詳細はURLをご確認ください。\n他に質問はありますか？"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_1_4') {
		$response_format_text = [
				"type" => "text",
				"text" => "④あ地区、い地区、う地区ですね。\nその場合、最寄りの税務署は「行政第四税務署」になります。「行政第四税務署」の詳細はURLをご確認ください。\n他に質問はありますか？"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_2_1') {
		$response_format_text = [
				"type" => "text",
				"text" => "ありがとうございます。\n個人番号カードをお持ちでコンビニエンスストアでの証明書交付の利用申請がお済の方は、下記のコンビニエンスストアでも住民票の写しが取れますよ～\n\n・セブンイレブン\n・ローソン\n・ファミリーマート\n・サークルＫサンクス\n\nまた、コンビニエンスストアの証明交付サービスは、年末年始（12月29日～翌年1月3日）を除き、毎日6:30から23:00まで、ご利用いただけます。\n他に質問はありますか？"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_2_2') {
		$response_format_text = [
				"type" => "text",
				"text" => "個人番号カードを持っていればコンビニで住民票が発行できて便利ですよ。\n他に質問はありますか？"
		];
		goto lineSend;
	}

	if ($bData == 'action=uc_2_3') {
		$response_format_text = [
				"type" => "text",
				"text" => "もし、個人番号カードを持っていればコンビニで住民票が発行できて便利ですよ。\n他に質問はありますか？"
		];
		goto lineSend;
	}
}

// メッセージ以外のときは何も返さず終了
if ($type != "text") {
	exit ();
}

$classfier = "12d0fcx34-nlc-410";
$workspace_id = "07465486-684f-4618-b5e6-fa7362b20e6c";

// $url = "https://gateway.watson-j.jp/natural-language-classifier/api/v1/classifiers/".$classfier."/classify?text=".$text;
// $url = "https://gateway.watson-j.jp/natural-language-classifier/api/v1/classifiers/".$classfier."/classify";
$url = "https://gateway.watsonplatform.net/conversation/api/v1/workspaces/" . $workspace_id . "/message?version=2017-04-21";

$username = "fe038c2b-1a1b-41fe-8a10-3cda71c90203";
$password = "HsJnOFDeFLIU";

 $data = array("text" => $text);
$data = array (
		'input' => array (
				"text" => $text
		)
);

  $data["context"] = array("conversation_id" => "",
  "system" => array("dialog_stack" => array(array("dialog_node" => "")),
  "dialog_turn_counter" => 1,
  "dialog_request_counter" => 1));

  $curl = curl_init($url);

  $options = array(
  CURLOPT_HTTPHEADER => array(
  'Content-Type: application/json',
  ),
  CURLOPT_USERPWD => $username . ':' . $password,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_RETURNTRANSFER => true,
  );

  curl_setopt_array($curl, $options);
  $jsonString = curl_exec($curl);

$jsonString = callWatson ();
$json = json_decode ( $jsonString, true );

// 会話データを取得
$conversation_id = $json ["context"] ["conversation_id"];
$dialogNode = $json ["context"] ["system"] ["dialog_stack"] [0] ["dialog_node"];

// データベースに保存
$conversationData = array (
		'conversation_id' => $conversationId,
		'dialog_node' => $dialogNode
);
$setLastConversationData ( $event->getUserId (), $conversationData );

// conversationからの返答を取得
$outputText = $json ['output'] ['text'] [count ( $json ['output'] ['text'] ) - 1];

// ユーザーに返信
replyTextMessage ( $bot, $event->getReplyToken (), $outputText );

$userArray [$userID] ["cid"] = $conversation_id;
$userArray [$userID] ["time"] = date ( 'Y/m/d H:i:s' );

$data ["context"] = array (
		"conversation_id" => $conversation_id,
		"system" => array (
				"dialog_stack" => array (
						array (
								"dialog_node" => "root"
						)
				),
				"dialog_turn_counter" => 1,
				"dialog_request_counter" => 1
		)
);

/*
 * $curl = curl_init($url);
 * $options = array(
 * CURLOPT_HTTPHEADER => array(
 * 'Content-Type: application/json',
 * ),
 * CURLOPT_USERPWD => $username . ':' . $password,
 * CURLOPT_POST => true,
 * CURLOPT_POSTFIELDS => json_encode($data),
 * CURLOPT_RETURNTRANSFER => true,
 * );
 *
 * curl_setopt_array($curl, $options);
 * $jsonString = curl_exec($curl);
 */
$jsonString = callWatson ();
// error_log($jsonString);
$json = json_decode ( $jsonString, true );

$mes = $json ["output"] ["text"] [0];
// $mes = $json["output"];

if ($mes == "usrChoise_1") {
	$response_format_text = [
			"type" => "template",
			"altText" => "this is a buttons template",
			"template" => [
					"type" => "buttons",
					"text" => "お調べしますので、あなたのお住いの地区名を下記から選択してください。",
					"actions" => [
							[
									"type" => "postback",
									"label" => "①○○地区、△△地区、□□地区",
									"data" => "action=uc_1_1"
							],
							[
									"type" => "postback",
									"label" => "②●●地区、▲▲地区、■■地区",
									"data" => "action=uc_1_2"
							],
							[
									"type" => "postback",
									"label" => "③Ａ地区、Ｂ地区、Ｃ地区",
									"data" => "action=uc_1_3"
							],
							[
									"type" => "postback",
									"label" => "④あ地区、い地区、う地区",
									"data" => "action=uc_1_4"
							]
					]
			]
	];
	goto lineSend;
}

if ($mes == "usrChoise_2") {
	$response_format_text = [
			"type" => "template",
			"altText" => "this is a buttons template",
			"template" => [
					"type" => "buttons",
					"text" => "住民票の写しは行政市役所本庁舎、行政第一支所、行政第二支所の窓口で発行できます。\n受付時間は、月曜日～金曜日の午前8時30分～午後5時です。\nちなみに個人番号カードはお持ちですか？",
					"actions" => [
							[
									"type" => "postback",
									"label" => "１．はい",
									"data" => "action=uc_2_1"
							],
							[
									"type" => "postback",
									"label" => "２．いいえ",
									"data" => "action=uc_2_2"
							],
							[
									"type" => "postback",
									"label" => "３．わからない",
									"data" => "action=uc_2_3"
							]
					]
			]
	];
	goto lineSend;
}

$response_format_text = [
		"type" => "text",
		"text" => $mes
];

$fp = fopen ( "https://" . $_SERVER ['SERVER_NAME'] . "/php.txt", "w" );
fwrite ( $fp, "ファイルへ書き込みサンプル" );
fclose ( $fp );

lineSend;
error_log ( $response_format_text );
$post_data = [
		"replyToken" => $replyToken,
		"messages" => [
				$response_format_text
		]
];

$ch = curl_init ( "https://api.line.me/v2/bot/message/reply" );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode ( $post_data ) );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
		'Content-Type: application/json; charser=UTF-8',
		'Authorization: Bearer ' . $accessToken
) );
$result = curl_exec ( $ch );
curl_close ( $ch );

// 会話データをデータベースに保存
function setLastConversationData($userId, $lastConversationData) {
	$conversationId = $lastConversationData ['conversation_id'];
	$dialogNode = $lastConversationData ['dialog_node'];

	if (getLastConversationData ( $userId ) === PDO::PARAM_NULL) {
		$dbh = dbConnection::getConnection ();
		$sql = 'insert into' . TABLE_NAME_BOTLOG . '(conversation_id,
						dialog_node,userid) values(?,?,
						pgp_sym_encrypt(?,\'' . getenv ( 'DB_ENCRYPT_PASS' ) . '\'))';
		$sth = $dbh->prepare ( $sql );
		$sth->execute ( array (
				$conversationId,
				$dialogNode,
				$userId
		) );
	} else {
		$dbh = dbConnection::getConnection ();
		$sql = 'update' . TABLE_NAME_BOTLOG . 'set conversation_id =
						?,dialog_node = ? where ? =
						pgp_sym_decrypt(userid,\'' . getenv ( 'DB_ENCRYPT_PASS' ) . '\')';
		$sth = $dbh->prepare ( $sql );
		$sth->execute ( array (
				$conversationId,
				dialogNode,
				$userId
		) );
	}
}
function makeOptions() {
	global $username, $password, $data;
	return array (
			CURLOPT_HTTPHEADER => array (
					'Content-Type: application/json'
			),
			CURLOPT_USERPWD => $username . ':' . $password,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => json_encode ( $data ),
			CURLOPT_RETURNTRANSFER => true
	);
}
function callWatson() {
	global $curl, $url, $username, $password, $data, $options;
	$curl = curl_init ( $url );

	$options = array (
			CURLOPT_HTTPHEADER => array (
					'Content-Type: application/json'
			),
			CURLOPT_USERPWD => $username . ':' . $password,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => json_encode ( $data ),
			CURLOPT_RETURNTRANSFER => true
	);

	curl_setopt_array ( $curl, $options );
	return curl_exec ( $curl );
}

//データベースから会話データを取得
function getLastConversatiponData($userId){
	$dbh = dbConnection::getConnection();
	$sql ='select conversation_id,dialog_node from'.
								TABLE_NAME_BOTLOG . 'where ? =
								pgp_sym_decrypt(userid,\''.getenv(
								'DB_ENCRYPT_PASS').'\')';
	$sth = $dbh->prepare($sql);
	$sth->execute(array($userId));
	if(!($row = $sth->fetch())){
		return PDO::PARAM_NULL;
	}else{
		return array ('conversation_id' => $row['conversation_id'],
										'dialog_node' =>$row['dialog_node']);

	}
}

//データベースへの接続を管理するクラス
class dbConnection{
	//インスタンス
	protected static $db;
	//コンストラクタ
	private function_construct(){

	try {
		// 環境変数からデータベースへの接続情報を取得し
		$url = parse_url ( getenv ( 'DATABASE_URL' ) );
		// データソース
		$dsn = sprintf ( 'pgsql:host=%s;dbname=%s', $url ['host'], substr ( $url ['path'], 1 ) );
		// 接続を確立
		self::$db = new PDO ( $dsn, $url ['user'], $url ['path'] );
		// エラー時例外を投げるように設定
		self::$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	} catch ( PDOException $e ) {
		echo 'Connection Error:' . $e->getMessage ();
	}
}

	//シングルトン。存在しない場合のみインスタンス化
	public static function getConnection(){
		if(!self::$db){
			new dbConnection();
		}
		return self::$db;
	}
}

?>



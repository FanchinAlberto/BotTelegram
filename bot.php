<?php

$token = "5597907724:AAF9o5qy78gHSOSNau2VxPLZZs11hinAnNM";
$link = "https://api.telegram.org/bot". $token;

$updates = file_get_contents('php://input');
$updates = json_decode($updates, TRUE);

$msgID = $updates['message']['from']['id'];
$name = $updates['message']['from']['username'];
$text = $updates['message']['text'];

switch($text){
	case "/start":
		//sendimg($msgID, "https://pbs.twimg.com/media/DRerClJW0AAas3t.jpg");
		sendmsg($msgID, "Hello there");
		break;
	case "/meme":
		//sendimg($msgID, "random");
		break;
}

function sendmsg($ID, $t){
	$url = $GLOBALS[link] . '/sendMessage?chat_id=' . $ID . '&text=' . urlencode($t);
	file_get_contents($url);
}
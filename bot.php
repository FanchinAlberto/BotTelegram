<?php
require 'vendor/autoload.php';
require_once 'db.php';
use Illuminate\Database\Capsule\Manager as Capsule;
use Telegram\Bot\Api;
// creazione dell'oggetto client
$client = new Api('5597907724:AAF9o5qy78gHSOSNau2VxPLZZs11hinAnNM');
/* per l'attivazione del long polling memorizziamo
l'id dell'ultimo update elaborato */
$last_update_id=0;
while(true){
    // leggiamo gli ultimi update ottenuti
	$response = $client->getUpdates(['offset'=>$last_update_id, 'timeout'=>5]);
	if (count($response)<=0) continue;
	/* per ogni update scaricato restituiamo il messaggio
	sulla stessa chat su cui è stato ricevuto */
	foreach ($response as $r){
        $last_update_id=$r->getUpdateId()+1;
		$message=$r->getMessage();
		$chatId=$message->getChat()->getId();
		$text=$message->getText();
	
		switch($text){
			case '/start':
				$response = $client->sendMessage([
					'chat_id' => $chatId,
					'text' => 'https://www.giantfreakinrobot.com/wp-content/uploads/2022/06/hellotherethumb.jpg',
			  	]);
				break;
			case '/random':
				$memeResponse = file_get_contents('https://meme-api.com/gimme');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
  					'chat_id' => $chatId,
  					'text' => $meme,
					'reply_markup' => $keyboard
				]);
				break;
			case '/dark':
				$memeResponse = file_get_contents('https://meme-api.com/gimme/darkmemers');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
					  'chat_id' => $chatId,
					  'text' => $meme
				]);
				break;
			case '/nsfw':
				$memeResponse = file_get_contents('https://meme-api.com/gimme/thensfwmemes');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
					  'chat_id' => $chatId,
					  'text' => $meme
				]);
				break;
			case '/boomer':
				$memeResponse = file_get_contents('https://meme-api.com/gimme/croppedboomermemes');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
					  'chat_id' => $chatId,
					  'text' => $meme
				]);
				break;
			case '/genZ':
				$memeResponse = file_get_contents('https://meme-api.com/gimme/GenZMemes');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
					  'chat_id' => $chatId,
					  'text' => $meme
				]);
				break;
			case '/football':
				$memeResponse = file_get_contents('https://meme-api.com/gimme/footballmemes');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
					  'chat_id' => $chatId,
					  'text' => $meme
				]);
				break;
			case '/italian':
				$memeResponse = file_get_contents('https://meme-api.com/gimme/italianmemes');
				$memeResponse = json_decode($memeResponse, true);
				$meme = $memeResponse['url'];
				$response = $client->sendMessage([
					  'chat_id' => $chatId,
					  'text' => $meme
				]);
				break;
			case "/setFavourite":
				Capsule::table('favourites')->insert([
				'user_id' => $chatId,
				'url' => $meme]);
				break;
			case '/favourites':
				$favourites = Capsule::table('favourites')->get();
				$response = $client->sendMessage([
					'chat_id' => $chatId,
					'text' => 'Ecco i tuoi meme preferiti'
				]);
				foreach ($favourites as $fav) {
					if($fav->user_id == $chatId){
					$response = $client->sendMessage([
						'chat_id' => $chatId,
						'text' => $fav->url,
					]);
				}
				}
				break;
		}
		
	}
}

?>

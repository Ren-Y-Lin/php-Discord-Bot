<?php

include __DIR__.'/vendor/autoload.php';

$dbname = "u8_AtraData";
$username = "u8_Kaze";
$password = "SecurePassword";
$servername = "localhost";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$discord = new \Discord\Discord([
    'token' => 'Secret',
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready.", PHP_EOL;
    $kill = false;
    
    // Listen for events here
    $discord->on('message', function ($message) {
	if($GLOBALS['kill']){
		exit("timetogo");
	}
	
	$content = explode(' ', $message->content);
	if ($content[0] == '!!$$kill'){
		$message->channel->sendMessage('Test Complete',false);
		sleep(1);
		exit("timetogo");
	}elseif($content[0] == '$$rollDice'){
		if($content[1]== null){
			$message->reply("Default D20. You have rolled a ".rand(1,20));
		}else{
			$message->reply("Dice selected: D".$content[1].".You have rolled a ".rand(1,$content[1]));
		}
		
	}elseif($content[0] == '$$kill'){
		$GLOBALS['kill'] = true;
		$message->channel->sendMessage("I will return to the shadows");
	}elseif($content[0] == '$$testChannel'){
		$message->channel->sendMessage('Test Complete',false);
	}elseif($content[0] == '$$help'){
		$helpmessage = "This is Version 0.3, it has a 90% uptime and includes: ";
		$helpmessage .= "\n";
		$helpmessage .= "f($\$testChannel) will return a confirmation";
		$helpmessage .= "\n";
		$helpmessage .= "f($\$help) see recursion";
		$helpmessage .= "\n";
		$helpmessage .= "f($\$next) echos next word";
		$helpmessage .= "\n";
		$helpmessage .= "f($\$rollDice) can be used raw for D20 or with a maximum value";
		$helpmessage .= "\n";
		
		$message->channel->sendMessage($helpmessage,false);
	}elseif($content[0] == '$$next'){
		$message->channel->sendMessage('Message sent: '.$content[1],false);
	}elseif($content[0] == '$$sendMail'){
		$msg = $content[2];
		$msg = wordwrap($msg,170);
		mail($content[1],"Discord Message",$msg,'From: atra@core.atra-night.work','-f atra@core.atra-night.work');
		$message->channel->sendMessage("Message sent");
	}elseif($content[0] == '$$sendTest'){
		//$message->channel->sendMessage("http://core.atra-night.work/Atra/src/test.png");
		$message->channel->sendFile( __DIR__ . "/src/test.png", "test.png", "testContent");
	}elseif($content[0] == '$$joinVoice'){
		$debug = $message->guild->channels;
		foreach($debug as $chan){
			$message->channel->sendMessage($chan->id);
			$message->channel->sendMessage($chan->type);
		
		}
			
	}else{
		
	}
        


		
    });
});

$discord->run();
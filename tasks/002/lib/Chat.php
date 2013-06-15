<?php
function eachReceive(&$r, $key) {
  $r->receive($fromWhom, $chatRoom, $message);
}

class Client {
	public $name;
	public $room;
	private $listenners = array ();
	
	function __construct($clientName) {
		$this->name = $clientName;
	}
	
	public function addListenner ($listenner) {
		$this->listenners[] = $listenner;
	}
	
	public function receive ($fromWhom, $chatRoom, $message) {
		array_walk($this->listenners, 'eachReceive');
	}
}

class Chatroom {
	private $name;
	private $clients = array ();
	
	function __construct($roomName) {
		$this->name = $roomName;
	}
	
	public function addClient ($client) {
		$client->room = $this;
		$this->clients[$client->name] = $client;
	}
	
	public function getOccupants () {
		return $this->clients;
	}
	
	public function send ($fromWhom, $message) {
		array_walk($this->clients, 'eachReceive');
	}
}

class Listenner {
	public function receive ($fromWhom, $chatRoom, $message) {
	}
}

class Chat {
	private $chatRooms = array ();
	
	function createClient($clientName) {
		$client = new Client ($clientName);
		return $client;
	}
	
	function createChatroom($roomName) {
		$room = new Chatroom ($roomName);
		$this->chatRooms[] = $room;
		return $room ;
	}

}
?>

<?php
	class Chat{
		private $chatId, $chatUserID, $chatText;

		public function getChatId(){
			return $this->chatId;
		}

		public function setChatId($chatId){
			$this->chatId = $chatId;
		}

		public function getChatUserId(){
			return $this->chatUserId;
		}

		public function setChatUserId($chatUserId){
			$this->chatUserId = $chatUserId;
		}

		public function getChatText(){
			return $this->chatText;
		}

		public  function setChatText($chatText){
			$this->chatText = $chatText;
		}
	}	
?>


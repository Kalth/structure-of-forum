<?php 

class UpdateLastMsgEntity
{
	private $isEverSee;
	private $lastMsgId;

	public function getIsEverSee(){
      return $this->isEverSee;
   }

   public function setIsEverSee($isEverSee){
      $this->isEverSee = $isEverSee;
   }

   public function getLastMsgId(){
      return $this->lastMsgId;
   }

   public function setLastMsgId($lastMsgId){
      $this->lastMsgId = $lastMsgId;
   }
}
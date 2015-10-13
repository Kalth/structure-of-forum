<?php 

class UpdateLastMsgEntity
{
	private $isEverSee;

	public function getIsEverSee(){
      return $this->isEverSee;
   }

   public function setIsEverSee($isEverSee){
      $this->isEverSee = $isEverSee;
   }
}
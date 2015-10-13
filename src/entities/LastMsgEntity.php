<?php 

class LastMsgEntity
{
	private $pseudo;
	private $msgDateCrea;
	private $topicId;
	private $topicName;
	private $cateId;
   private $isUpToDate;

   public function getIsUpToDate(){
      return $this->isUpToDate;
   }

   public function setIsUpToDate($isUpToDate){
      $this->isUpToDate = $isUpToDate;
   }

   public function getCateId(){
      return $this->cateId;
   }

   public function setCateId($cateId){
      $this->cateId = $cateId;
   }

	public function getTopicName(){
      return $this->topicName;
   }

   public function setTopicName($topicName){
      $this->topicName = $topicName;
   }

	public function getTopicId(){
      return $this->topicId;
   }

   public function setTopicId($topicId){
      $this->topicId = $topicId;
   }
   
   public function getPseudo(){
   	return $this->pseudo;
   }

   public function setPseudo($pseudo){
      $this->pseudo = $pseudo;
   }

   public function getMsgDateCrea(){
      return $this->msgDateCrea;
   }

   public function setMsgDateCrea($msgDateCrea){
      $this->msgDateCrea = $msgDateCrea;
   }
}
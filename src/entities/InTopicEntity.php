<?php 

class InTopicEntity
{
	private $id;
	private $content;
	private $topicId;
	private $userId;
	private $dateCrea;
	private $dateLastChange;
   private $topicName;
   private $userPseudo;
   private $cateId;
   private $cateName;

   public function getId(){
      return $this->id;
   }

   public function getContent(){
      return $this->content;
   }

   public function setContent($content){
      $this->content = $content;
   }

   public function getTopicId(){
      return $this->topicId;
   }

   public function setTopicId($topicId){
      $this->topicId = $topicId;
   }

   public function getUserId(){
      return $this->userId;
   }

   public function setUserId($userId){
      $this->userId = $userId;
   }

   public function getDateCrea(){
      return $this->dateCrea;
   }

   public function setDateCrea($dateCrea){
      $this->dateCrea = $dateCrea;
   }

   public function getDateLastChange(){
      return $this->dateLastChange;
   }

   public function setDateLastChange($dateLastChange){
      $this->dateLastChange = $dateLastChange;
   }

   public function getTopicName(){
      return $this->topicName;
   }

   public function setTopicName($topicName){
      $this->topicName = $topicName;
   }

   public function getUserPseudo(){
      return $this->userPseudo;
   }

   public function setUserPseudo($userPseudo){
      $this->userPseudo = $userPseudo;
   }

   public function getCateId(){
      return $this->cateId;
   }

   public function setCateId($cateId){
      $this->cateId = $cateId;
   }

   public function getCateName(){
      return $this->cateName;
   }

   public function setCateName($cateName){
      $this->cateName = $cateName;
   }
}

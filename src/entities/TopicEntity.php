<?php 

class TopicEntity
{
	private $name;
	private $id;
	private $cateName;
   private $cateId;
	private $userId;
	private $open;
	private $onTop;
   private $lastMsgDate;
   private $lastMsgUser;
   private $nbrMsg;
   private $lastMsgId;
   private $author;
   private $isUpToDate;

   public function getIsUpToDate(){
      return $this->isUpToDate;
   }

   public function setIsUpToDate($isUpToDate){
      $this->isUpToDate = $isUpToDate;
   }

   public function getAuthor(){
      if ($this->author === null) {
         $this->author = 'Ano';
      }
      return $this->author;
   }

   public function setAuthor($author){
      $this->author = $author;
   }

   public function getLastMsgId(){
      return $this->lastMsgId;
   }

   public function setLastMsgId($lastMsgId){
      $this->lastMsgId = $lastMsgId;
   }

   public function getLastMsgDate(){
      return $this->lastMsgDate;
   }

   public function setLastMsgDate($lastMsgDate){
      $this->lastMsgDate = $lastMsgDate;
   }

   public function getLastMsgUser(){
      if ($this->lastMsgUser === null) {
         $this->lastMsgUser = 'Ano';
      }
      return $this->lastMsgUser;
   }

   public function setLastMsgUser($lastMsgUser){
      $this->lastMsgUser = $lastMsgUser;
   }

   public function getNbrMsg(){
      return $this->nbrMsg;
   }

   public function setNbrMsg($nbrMsg){
      $this->nbrMsg = $nbrMsg;
   }

   public function getId(){
      return $this->id;
   }

   public function getCateName(){
      return $this->cateName;
   }

   public function setCateName($cateName){
      $this->cateName = $cateName;
   }

   public function getCateId(){
      return $this->cateId;
   }

   public function setCateId($cateId){
      $this->cateIde = $cateId;
   }

   public function getUserId(){
      return $this->userId;
   }

   public function setUserId($userId){
      $this->userId = $userId;
   }

   public function getOpen(){
      return $this->open;
   }

   public function setOpen($open){
      $this->open = $open;
   }

   public function getOnTop(){
      return $this->onTop;
   }

   public function setOnTop($onTop){
      $this->onTop = $onTop;
   }

      public function getName(){
      return $this->name;
   }

   public function setName($name){
      $this->name = $name;
   }
}

<?php 

class CategorieEntity
{
	private $id;
	private $name;
	private $descri;
	private $private;
   private $pseudo;
   private $lastMsg;
   private $topicName;

   public function getPseudo(){
      if ($this->pseudo === null) {
         $this->pseudo = 'Ano';
      }
      return $this->pseudo;
   }

   public function setPseudo($pseudo){
      $this->pseudo = $pseudo;
   }

   public function getLastMsg(){
      return $this->lastMsg;
   }

   public function setLastMsg($lastMsg){
      $this->lastMsg = $lastMsg;
   }

   public function getTopicName(){
      return $this->topicName;
   }

   public function setTopicName($topicName){
      $this->topicName = $topicName;
   }

	public function getId(){
      return $this->id;
   }

   public function getName(){
      return $this->name;
   }

   public function setName($name){
      $this->name = $name;
   }

   public function getDescri(){
      return $this->descri;
   }

   public function setDescri($descri){
      $this->descri = $descri;
   }

   public function getPrivate(){
      return $this->private;
   }

   public function setPrivate($private){
      $this->private = $private;
   }
}

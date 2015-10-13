<?php 

class LogInEntity
{
	private $id;
	private $pseudo;
	private $right;

   public function getId(){
      return $this->id;
   }

   public function getPseudo(){
      return $this->pseudo;
   }

   public function setPseudo($pseudo){
      $this->pseudo = $pseudo;
   }

   public function getRight(){
      return $this->right;
   }

   public function setRight($right){
      $this->right = $right;
   }
}
<?php

class MySQL extends PDO
{
    public function __construct()
    {
      parent::__construct('mysql:host=localhost;dbname=forum', 'logInMYSQL', 'passwordMYSQL');
    }

    public function myQuery($query, $resultClass, $params = false)
    {
    	if (is_array($params)) {
    		$stmt = $this->prepare($query);
    		$stmt->execute($params);
    	} else {
    		$stmt = $this->query($query);
    	}
    	
    	return $stmt->fetchAll(PDO::FETCH_CLASS, $resultClass);
    }
}

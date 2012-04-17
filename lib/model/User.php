<?php

class User extends BaseUser
{
    public function __toString(){
        return $this->getName();
    }
    public function getCreateDate($format = 'Y-m-d H:i:s') {
      // if($format=== null) $format = "Y-m-d H:i:s"; 
       
       return date("Y-m-d H:i:s", strtotime($this->getCreatedAt())+25200);
    }
}

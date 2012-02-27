<?php

class Permission extends BasePermission
{
	public function __toString(){
		return $this->getModuleName().'::'.$this->getActionName();
	}
}

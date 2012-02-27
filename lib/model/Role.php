<?php

class Role extends BaseRole
{
	public function __toString(){
		return $this->getName();
	}
}

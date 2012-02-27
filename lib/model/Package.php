<?php

class Package extends BasePackage
{
	public function __toString()
	{
		return $this->getName();
	}
}

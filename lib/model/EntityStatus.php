<?php

class EntityStatus extends BaseEntityStatus
{
	public function __toString()
	{
		return $this->getName();
	}
}

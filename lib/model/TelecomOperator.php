<?php

class TelecomOperator extends BaseTelecomOperator
{
	public function __toString()
	{
		return $this->getName();
	}
}

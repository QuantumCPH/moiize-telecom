<?php

class SupportActivityStatus extends BaseSupportActivityStatus
{
	public function __toString()
	{
		return $this->getName();
	}
}

<?php

class SupportIssue extends BaseSupportIssue
{
	public function __toString(){
		return $this->getName();
	}
}

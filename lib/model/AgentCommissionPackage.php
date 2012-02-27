<?php

class AgentCommissionPackage extends BaseAgentCommissionPackage
{
	public function __toString()
	{
		return $this->getName();
	}
}

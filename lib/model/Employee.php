<?php

class Employee extends BaseEmployee
{
	public function __toString(){
		return $this->getFirstName() .' '.$this->getLastName();
	}
	
	public function getVatNo()
	{
		if ($company = $this->getCompany())
			return $company->getVatNo();
		else
			0;
	}
}

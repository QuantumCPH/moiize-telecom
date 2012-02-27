<?php
	if($this->$employee->getCompany()->getVatNo())
	{
		echo $this->$employee->getCompany()->getVatNo();
	}
	else
		echo 'N/A';
?>
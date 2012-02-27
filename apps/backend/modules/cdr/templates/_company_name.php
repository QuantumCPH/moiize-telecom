<?php
	if ($cdr_log->getEmployee())
	{
		if ($cdr_log->getEmployee()->getCompany())
			echo $cdr_log->getEmployee()->getCompany();
	}
?>
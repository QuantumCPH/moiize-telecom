<?php
	if ($cdr_log->getEmployee())
	{
			echo $cdr_log->getEmployee()->getFirstName().$cdr_log->getEmployee()->getLastName();
	}
?>
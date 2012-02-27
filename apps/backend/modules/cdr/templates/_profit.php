<?php
	$profit;
	
	try
	{
		$profit = $cdr_log->getSalePrice()-$cdr_log->getPurchasePrice();
	}
	catch(Exception $ex)
	{
		$profit = '-';
	}
	
	echo $profit;
?>
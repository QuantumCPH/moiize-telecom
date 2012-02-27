<?php
	$c = new Criteria();
	$c->addAscendingOrderByColumn('mobile_number');
	$employees = EmployeePeer::doSelect($c);
	
	
	$employee_list = array();
	
	foreach ($employees as $employee)
	{
		$employee_list[$employee->getMobileNumber()] = $employee->getMobileNumber();
	}
	
	echo select_tag('filters[from_no]', options_for_select($employee_list, isset($filters['from_no']) ? $filters['from_no'] : '', array('include_blank' => true)));
?>
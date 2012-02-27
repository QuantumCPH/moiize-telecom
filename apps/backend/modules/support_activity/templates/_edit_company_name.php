<?php

	$c = new Criteria();
	$c->addAscendingOrderByColumn('name');
	$companies = CompanyPeer::doSelect($c);
	
	$company_list = array();
	
	foreach ($companies as $company)
	{
		$company_list[$company->getId()] = $company->getName();
	}
	
	//if ($support_activity->getEmployeeId())
	//{
	//	echo select_tag('support_activity[company_id]', options_for_select($company_list, $support_activity->getEmployee()->getCompanyId(), array('include_blank' => false)));
	//}
	//else
	//{
		echo select_tag('company_id', options_for_select($company_list, (
													$support_activity->getEmployeeId()?
													$support_activity->getEmployee()->getCompanyId():
													null
												), array('include_blank' => true)),
																array('onchange'=> remote_function(array(
													    			'update'  => 'employee_id_zone',
													    			'url'     => 'support_activity/getEmployeeChoice',
						  											'with' => "'cid=' + this.options[this.selectedIndex].value" ,
																	'loading'  => "Element.show('employees_loading_indicator')",
														    		'complete' => "Element.hide('employees_loading_indicator')",
													  			))
							  			)
			);		
	//}
	
	echo image_tag('/images/loading_green.gif', array(
											'id'=>'employees_loading_indicator',
											'width'=>'16px',
											'height'=>'16px',
											'style'=>'display: none;'));
	
	echo javascript_tag(
		remote_function(array(
	    	'update'  => 'employee_id_zone',
	    	'url'     => 'support_activity/getEmployeeChoice',
	  		'with' => "'cid=' + '" . ($support_activity->getEmployee()?
									$support_activity->getEmployee()->getCompanyId():'').
								"'+'&eid=' + " . ($support_activity->getEmployee()?
									$support_activity->getEmployeeId():''),
			'loading'  => "Element.show('employees_loading_indicator')",
    		'complete' => "Element.hide('employees_loading_indicator')",
									

	  	))
  	)
?>
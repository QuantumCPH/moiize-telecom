<?php
	$c = new Criteria();
	$c->addAscendingOrderByColumn('name');
	$companies = CompanyPeer::doSelect($c);
	
	
	$company_list = array();
	
	foreach ($companies as $company)
	{
		$company_list[''.$company->getId()] = $company->getName();
	}
	
	echo select_tag('filters[id]', options_for_select($company_list, isset($filters['id']) ? $filters['id'] : '', array('include_blank' => true)));
?>
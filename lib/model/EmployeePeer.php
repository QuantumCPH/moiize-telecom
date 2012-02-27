<?php

class EmployeePeer extends BaseEmployeePeer
{
    private static function getEmployeeList($agent_company_id){

        $c = new Criteria();
        $c->add(CompanyPeer::AGENT_COMPANY_ID, $agent_company_id);
        $c->addJoin(EmployeePeer::COMPANY_ID, CompanyPeer::ID);
        $company_list = CompanyPeer::doSelect($c);

        foreach($company_list as $company){

            $user_list[] = $company->getEmployees();

        }

        return $user_list;

    }
}

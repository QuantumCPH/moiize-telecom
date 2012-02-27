<?php

/**
 * agent_commission actions.
 *
 * @package    zapnacrm
 * @subpackage agent_commission
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class agent_commissionActions extends autoagent_commissionActions
{
    public function executeCreate($request){
        parent::executeCreate($request);

        $this->agent_user->setDefault('agent_company_id', $request->getParameter('id'));
    }

     public function executeSelectCompany($request){

  

       // $id = $request->getParameter('id');

        $this->form = new AgentCommissionForm();

//        if($id){
//           $this->form->setDefault('agent_company_id', $id);
//        }

     }
      public function executeAgentProduct(sfRequest $request){

            $this->agentid = $request->getParameter('agent_commission[agent_company_id]');

if(isset($_POST['product'])){

           $c = new Criteria();
           $c->add(AgentProductPeer::AGENT_ID, $_POST['agentid'] );
           $rs = AgentProductPeer::doDelete($c);

            foreach ($_POST['product'] as $key => $item)
            {

             if(isset($_POST['pv'][$key]) && $_POST['pv'][$key]!="") {
              $pv=$_POST['pv'][$key];
             }else{
                 $pv="";
             }
               if(isset($_POST['pvp'][$key]) && $_POST['pvp'][$key]!="") {
              $pvp=$_POST['pvp'][$key];
               }else{
                 $pvp=0;
               }
                 if(isset($_POST['pve'][$key]) && $_POST['pve'][$key]!="") {
              $pve=$_POST['pve'][$key];
                 }else{
                     $pve=0;
                 }
              if(isset($_POST['epv'][$key]) && $_POST['epv'][$key]!="") {
              $epv=$_POST['epv'][$key];
              }else{

                $epv="";
              }

                if(isset($_POST['epvp'][$key]) && $_POST['epvp'][$key]!="") {
              $epvp=$_POST['epvp'][$key];
                }else{
                  $epvp=0;
                }
                  if(isset($_POST['epve'][$key]) && $_POST['epve'][$key]!="") {
              $epve=$_POST['epve'][$key];
                  }else{
                    $epve=0;
                  }
              $agent=new AgentProduct();
              $agent->setAgentId($_POST['agentid']);
              $agent->setProductId($item);
              $agent->setRegShareValue($pv);
              $agent->setIsRegShareValuePc($pvp);
              $agent->setRegShareEnable($pve);
              $agent->setExtraPaymentsShareValue($epv);
              $agent->setIsExtraPaymentsShareValuePc($epvp);
              $agent->setExtraPaymentsShareEnable($epve);

              $agent->save();
            // echo "<li><b>$key:</b> $item<br/></li>";

              $this->message="Your modifications have been saved";
            }
 $this->agentid =$_POST['agentid'];
}else{
            if(isset($_POST['agentid'])){



                          $c = new Criteria();
           $c->add(AgentProductPeer::AGENT_ID, $_POST['agentid'] );
           $rs = AgentProductPeer::doDelete($c);

           $this->agentid =$_POST['agentid'];

            }
}
                  $ag = new Criteria();
                  $ag->add(AgentCompanyPeer::ID , $this->agentid);
                  $agenttdata = AgentCompanyPeer::doSelectOne($ag);
                  $this->agenttdata=$agenttdata;

            
                 $cunt = new Criteria();
                 $cunt->add(ProductPeer::COUNTRY_ID , $this->agenttdata->getCountryId());
                 $product = ProductPeer::doSelect($cunt);
                 $this->products=$product;

                 
$this->redirectUnless($this->agentid, "agent_commission/selectCompany");
  

     }
    
}

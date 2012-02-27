<?php

/**
 * agent_company actions.
 *
 * @package    zapnacrm
 * @subpackage agent_company
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 5125 2007-09-16 00:53:55Z dwhittle $
 */
class agent_companyActions extends autoagent_companyActions
{

         public function handleErrorSave() {
     $this->forward('agent_company','edit');
  }
    public function executeCountrycity($request){

		$this->country_id = 2;
		$this->city_id = $request->getParameter('city_id');

		$c = new Criteria();
                $c->add(EnableCountryPeer::STATUS ,1);
		$c->addAscendingOrderByColumn('name');
		$Lcountries = EnableCountryPeer::doSelect($c);

		$c->add(CityPeer::COUNTRY_ID, $this->country_id);
		$Lcities = CityPeer::doSelect($c);

		$cities_List = '';
		foreach($Lcountries as $country)
		{
			$countries_List[''.$country->getId()] = $country->getName();
		}

		if(isset($Lcities)){

			foreach($Lcities as $city)
			{
				$cities_List[''.$city->getId()] = $city->getName();
			}
		}

		$this->cities_list = $cities_List;
		$this->countries_list = $countries_List;


		$this->setLayout(false);

    }

    public function executeAddUser($request){
        $this->redirect('agent_user/addUser?id='.$request->getParameter('id'));
    }

    public function executeView($request){
        $this->agent_company = AgentCompanyPeer::retrieveByPk($request->getParameter('id'));
    }


	public function executeNewsUpdate(sfWebRequest $request)
  {
     $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");
     
     $date='';
     $sdate= '';

     //echo "outside if";
     if($request->getParameter('message') and $request->getParameter('heading'))
     {

        $message=$request->getParameter('message');
        $heading=$request->getParameter('heading');

        //getting start date
        $day=$request->getParameter('day');
        $month=$request->getParameter('month');
        $year=$request->getParameter('year');

        //getting end date
        
         $eday=$request->getParameter('eday');        
         $emonth=$request->getParameter('emonth');
         $eyear=$request->getParameter('eyear');
        
	     $news  = new Newupdate();

         $date_starting = new DateTime();
         date_date_set($date_starting, $year, $month, $day);
         $news->setStartingDate( date('Y-m-d H:m:s',$date_starting->getTimestamp()));
         //echo date('Y-m-d H:m:s',$date_starting->getTimestamp());

         $date_ending = new DateTime();
         date_date_set($date_ending, $eyear, $emonth, $eday);

         $news->setExpireDate( date('Y-m-d H:m:s',$date_ending->getTimestamp()));
        // echo date('Y-m-d H:m:s',$date_ending->getTimestamp());

       
        $news->setMessage($message);
        $news->setHeading($heading);
        
//      
//        
//        $update->setExpireDate($sdate);
       if ($news->save())
		$this->redirect('agent_company/newsList');

     }
  }

  public function executeNewsList(sfWebRequest $request)
  {
	  $c=new Criteria();
      $this->messages= NewupdatePeer::doSelect($c);
  }

public function executeNewsDelete(sfWebRequest $request)
  {
           
          
         // return sfView::NONE;
          if($request->getMethod('post'))
          {


            $id= $request->getParameter('id');
            $value= $request->getParameter('value');
            
                //echo $id."<br />";
                //echo $value."<br />";
                $cid=new Criteria();
                $cid->add(NewupdatePeer::ID ,$id);
                $this->view=NewupdatePeer::doDelete($id , null);
                

				$this->redirect('agent_company/newsList');
            
          }
          
            
  }

public function executeNewsEdit(sfWebRequest $request)
{
   $this->redirectUnless($this->getUser()->isAuthenticated(), "@homepage");
   
   
  //  echo "here";


     $id= $request->getParameter('id');
    // echo $id;
     $value= $request->getParameter('value');
     
     $this->message=NewupdatePeer::retrieveByPK($id);
     
     




     $months = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
     $this->months = $months;
     $this->id =$id;
           
    $this->count==0;


     if($value=="update")
     {
        $update=NewupdatePeer::retrieveByPK($id);
          
        $message=$request->getParameter('message');
        $heading=$request->getParameter('heading');


        //getting start date
        $day=$request->getParameter('day');
        $month=$request->getParameter('month');
        $year=$request->getParameter('year');


        //getting end date


//         $eday=$request->getParameter('eday');
//         $emonth=$request->getParameter('emonth');
//         $eyear=$request->getParameter('eyear');






         $date_starting = new DateTime();
         date_date_set($date_starting, $year, $month, $day);
         $update->setStartingDate( date('Y-m-d H:m:s',$date_starting->getTimestamp()));
         //echo date('Y-m-d H:m:s',$date_starting->getTimestamp());


//         $date_ending = new DateTime();
//         date_date_set($date_ending, $eyear, $emonth, $eday);


        // $update->setExpireDate( date('Y-m-d H:m:s',$date_ending->getTimestamp()));
        // echo date('Y-m-d H:m:s',$date_ending->getTimestamp());




        $update->setMessage($message);
        $update->setHeading($heading);


//
//
//        $update->setExpireDate($sdate);
       $update->save();         

	   $this->redirect('agent_company/newsList');
     }
     
    //return sfView::NONE;


}


}

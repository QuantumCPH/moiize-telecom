<?php
require_once(sfConfig::get('sf_lib_dir').'/Browser.php');
/**
 * LandingPages actions.
 *
 * @package    zapnacrm
 * @subpackage LandingPages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class LandingPagesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
      sfView::NONE;
  }
   public function executeTravelLink(sfWebRequest $request)
  {
    $bid=$request->getParameter('bid');
    $hid=$request->getParameter('hid');
    
    $c=new Criteria();
    $c->add(HostPeer::ID,$hid);
    $host=HostPeer::doSelectOne($c);

    if($host)
    {
        $count=$host->getCounter();
        $count++;
        $host->setCounter($count);
        $host->save();
    }
    $con=new Criteria();
    $con->add(BannerPeer::ID,$bid);
    $banner=BannerPeer::doSelectOne($con);
    if($banner)
    {
        $count=$banner->getCounter();
        $count++;
        $banner->setCounter($count);
        $banner->save();
    }

    $visitor = new Visitor();
    $visitor->setHid($hid);
    $visitor->setBid($bid);
    $status = $visitor->getStatus();
    $visitor->setStatus($status."> Travel Link Page ");
    $visitor->save();

    $this->visitor = $visitor();
  }
  public function executeB2C(sfWebRequest $request)
  {
      $c = new Criteria();
      $c->add(VisitorsPeer::ID, $request->getParameter('visitor'));
      $visitor=  VisitorsPeer::doSelectOne($c);
      $status = $visitor->getStatus();
      $visitor->setStatus($status."> B2C Page ");
      $visitor->save();

      $hc = new Criteria();
      $hc->add(HostPeer::ID, $visitor->getHostId());
      $host = HostPeer::doSelectOne($hc);

      $this->host = $host;
      $this->visitor = $visitor;
      $this->setLayout(false);

  }
  public function executeB2B(sfWebRequest $request)
  {
      $this->browser = new Browser();
      
      $c = new Criteria();
      $c->add(VisitorsPeer::ID, $request->getParameter('visitor'));
      $visitor=  VisitorsPeer::doSelectOne($c);
      $status = $visitor->getStatus();
      $visitor->setStatus($status."> B2B Page ");
      $visitor->save();

      $this->visitor = $visitor;
      $this->setLayout(false);
    


      $this->alert = "Venligst udfyld kontakt formular for at sende forespørgsel til Zapna";
      if($request->getParameter('message') and $request->getParameter('phone') and $request->getParameter('email'))
      {
          $host = NULL;
          if ($request->getParameter('visitor') ){
              $vistor = VisitorsPeer::retrieveByPK($request->getParameter("visitor"));
              $host = HostPeer::retrieveByPK($visitor->getHostId());
          }
          
          


          $sender_name=$request->getParameter('name');
          $sender_email=$request->getParameter('email');
          $sender_phone=$request->getParameter('phone');
          $user_message=$request->getParameter('message');
          if ($host){
          $user_subject='Referrer: '.$host->getHostName().': '.$request->getParameter('subject');
          }else{
          $user_subject='No Referrer - '.$request->getParameter('subject');
          }
          
          $visitor_id=$request->getParameter('visitor');

          $c = new Criteria();
          $c->add(VisitorsPeer::ID, $request->getParameter('visitor'));
          $visitor=  VisitorsPeer::doSelectOne($c);
          $status = $visitor->getStatus();
          $visitor->setStatus($status."> B2B Email ");
          $visitor->save();
          $message_body = "
              <b>There is a new query from B2B landing Page</b>
              <br/><br/>
              <b>Name: </b>".$sender_name."<br/>
              <b>Email Address: </b>". $sender_email."<br/>
              <b>Phone Number: </b>". $sender_phone."<br/>
              <b>Subject: </b>".$user_subject."<br/>
              <b>Message</b> <p>".$user_message."</p><br/>
              <br/><br/>
              Other Details:<br/>
              <b>Date:</b> ".date('D-d-M-Y')."<br/>
              <b>Time: </b>".date('g:i:s A')."<br/>
            ";


          $cdu_email = new EmailQueue();
          $cdu_email->setSubject("B2B Landing Page - ".$user_subject);
	  $cdu_email->setReceipientName("cdu@zapna.com");
	  $cdu_email->setReceipientEmail("cdu@zapna.com");
	  $cdu_email->setMessage($message_body);
          $cdu_email->setEmailType("CDU Email for B2B");
          $cdu_email->save();

          $support_email = new EmailQueue();
          $support_email->setSubject("B2B Landing Page - ".$user_subject);
	  $support_email->setReceipientName("okhan@zapna.com");
	  $support_email->setReceipientEmail("okhan@zapna.com");
	  $support_email->setMessage($message_body);
          $support_email->setEmailType("Support Email for B2B");
          $support_email->save();


          $user_message_body = '



            <img src="http://test.zerocall.com/b2c/zerocall/images/logo.gif">
            <br/><br/>

            <div style="float:top;display:block; background-image:url(http://test.zerocall.com/b2c/zerocall/images/b2b/background-line.png); overflow:hidden; text-indent:9000em;
            white-space:nowrap;">

            <table  >

            <tr>

            <td>
            <img src="http://test.zerocall.com/b2c/zerocall/images/b2b/girl.jpg"/>
            </td>

            <td>

            <h3>Thankyou for Contacting Zapna.com</h3>

            <p>Your message has been forwarded to the Zapna Support, you will be shortly contacted by them in this regards.<br/>
            Your original message was:</p>

            <b>Date: '.date('D-M-Y').'</b><br/><br/>
            <b>Name: </b>'.$sender_name.'<br/><br/>

            <b>Email: </b>'.$sender_email.'<br/><br/>

            <b>Message Heading: </b>'.$user_subject.'<br/><br/>

            <b>Message: </b><p>'.$user_subject.'</p><br/><br/>


            </td>
            </td>

            </tr>

            </table>



            <br/><br/>

            </div>



            <hr style="color:#e77714">
            <div id="sec" style="float:bottom"class="fr"><script type="text/javascript"
                    src="https://seal.thawte.com/getthawteseal?host_name=zerocall.com&amp;size=S&amp;lang=en"></script>


            Copyright &copy; Zapna 2010

            <br/>

            <img src="http://test.zerocall.com/b2c/zerocall/images/ccs.png" alt="Credit Cards" />

            </div>



          ';
		if(trim($sender_name)!=''){
			$user_email = new EmailQueue();
			$user_email->setSubject("Your message has been received");
			$user_email->setReceipientName($sender_name);
			$user_email->setReceipientEmail($sender_email);
			$user_email->setMessage($user_message_body);
			$user_email->setEmailType("User Email for B2B");
			$user_email->save();
		}

          $this->alert = "Tak for din meddelse, du vil snarest blive kontaktet af vores sælger";
       }

        $this->setLayout(false);

  }
  public function executeConformation(sfWebRequest $request)
  {
      

  }
  public function executeWindow(sfWebRequest $request)
  {
   $bid=$request->getParameter('bid');
    $hid=$request->getParameter('hid');

    $c=new Criteria();
    $c->add(HostPeer::ID,$hid);
    $host=HostPeer::doSelectOne($c);

    if($host)
    {
        $count=$host->getCounter();
        $count++;
        $host->setCounter($count);
        $host->save();
    }
    $con=new Criteria();
    $con->add(BannerPeer::ID,$bid);
    $banner=BannerPeer::doSelectOne($con);
    if($banner)
    {
        $count=$banner->getCounter();
        $count++;
        $banner->setCounter($count);
        $banner->save();
    }

    $visitor = new Visitors();
    $visitor->setHostId($hid);
    $visitor->setBannerId($bid);
    $visitor->setStatus(" Landing Page ");
    $visitor->save();

    $this->visitor = $visitor;

    $this->setLayout(false);
  }
}

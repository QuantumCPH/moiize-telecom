<?php

/**
 * Customer form.
 *      
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: CustomerForm.class.php,v 1.6 2010-09-19 22:20:12 orehman Exp $
 */
class CustomerForm extends BaseCustomerForm
{

	
  public function configure()
  {
  	parent::setup();
  	//mobile_number
        if(sfConfig::get('sf_app')=='agent'){
            //-----------------------------------
            $Ac = new Criteria();
            $Ac->add(AgentCompanyPeer::ID, sfContext::getInstance()->getUser()->getAttribute('agent_company_id', '', 'agentsession'));
            $country_id = AgentCompanyPeer::doSelectOne($Ac);//->getId();
            $country_id = $country_id->getCountryId();
            //------------Get The Country List For Customer Registration - From Agent
         
            $enableCountry = new Criteria();
            $enableCountry->add(EnableCountryPeer::ID, $country_id);
            $countrylngs = EnableCountryPeer::doSelectOne($enableCountry);
            $languageSymbol = $countrylngs->getLanguageSymbol();
            
        }elseif(sfConfig::get('sf_app')=='b2c'){
             //-----------------------------------
               $activelanguage = sfContext::getInstance()->getUser()->getAttribute('activelanguage', '');
               $lngSymbol = sfContext::getInstance()->getRequest()->getParameter('language');
               if($activelanguage!='' &&  ($lngSymbol=='')){
                   $lngSymbol = sfContext::getInstance()->getUser()->getAttribute('activelanguage', '');
               }

               //Product / Country Change As Per Sub-Domain - dk/pl/intl - Against New Feature
                $mystring = @$_SERVER["HTTP_REFERER"];
               // Add As Per requirements - - - -

                    $lngSymbol='de';
                $countrylng = new Criteria();
                $countrylng->add(EnableCountryPeer::LANGUAGE_SYMBOL, $lngSymbol);
                $countrylng = EnableCountryPeer::doSelectOne($countrylng);
                $countryName = $countrylng->getName();
                $languageSymbol = $countrylng->getLanguageSymbol();
                $lngId = $countrylng->getId();
                //-----------------------------------
                
        }
        //echo $languageSymbol;
        //This Condtion for - Phone number is currently 8 digits but in Poland this is 10 digits - against New Feature - 02/28/11

          $context =  sfContext::getInstance();
        $request = $context->getRequest();
         
       $actionmodule=  $context->getActionName();

            



            $mobilePattern = "/^[0-9]{8,14}$/";
           
        
        
	 $this->validatorSchema['mobile_number'] = new sfValidatorAnd(
		array(
			 $this->validatorSchema['mobile_number'],
			new sfValidatorRegex(
				array(
					'pattern'=>$mobilePattern,
                                        'max_length'=>14,
				),
				array('invalid'=>sfContext::getInstance()->getI18N()->__('Please enter a valid 8 to 14 digit mobile number.'))
			)
		)
	);




//        //This Code Add For Duplication Entery Again Task # 4.3 Date:01-18-11
         $mobileno=000000000;

           if(sfContext::getInstance()->getRouting()->getCurrentInternalUri()=='customer/passwordchange'){


          
             }else{

                if(isset($_REQUEST['customer']) && $_REQUEST['customer']!=""){
            $mobileno=$_REQUEST['customer']['mobile_number'];

            }
             }
          //$this->form->getValues('mobile_number');
   if(sfContext::getInstance()->getRouting()->getCurrentInternalUri()=='customer/settings'){

   }else{ 
		$count=0;
		$countc=0;
		$mobile = new Criteria();
		$mobile->add(CustomerPeer::MOBILE_NUMBER, $mobileno);
		$mobile->add(CustomerPeer::CUSTOMER_STATUS_ID, 1);
		$count = CustomerPeer::doCount($mobile);

    if(isset($count) &&  $count>=1){

		$mobilec = new Criteria();
		$mobilec->add(CustomerPeer::MOBILE_NUMBER, $mobileno);
		$mobilec->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
		$countc = CustomerPeer::doCount($mobilec);

		 if(isset($countc) &&  $countc>=1){
		  $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(new sfValidatorPropelUnique(
					array(
							'model' => 'customer',
							'column' => 'mobile_number'
					),array(
							'invalid' => sfContext::getInstance()->getI18N()->__('Mobile Number already existing.')
					))
					))
				);
		
		 }



        
    }else{


		$mobilec = new Criteria();
		$mobilec->add(CustomerPeer::MOBILE_NUMBER, $mobileno);
		$mobilec->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
		$countc = CustomerPeer::doCount($mobilec);

		 if(isset($countc) &&  $countc>=1){
				$this->validatorSchema->setPostValidator(new sfValidatorAnd(array(new sfValidatorPropelUnique(
					array(
							'model' => 'customer',
							'column' => 'mobile_number'
					),array(
							'invalid' => sfContext::getInstance()->getI18N()->__('Mobile Number already existing.')
					))
					))
				);
		 }
    }
    
	}     
	//pobox
	//This Condtion for - Phone number is currently 8 digits but in Poland this is 10 digits - against New Feature - 02/28/11
        if($languageSymbol=='pl'){
           $po_boxPattern = sfContext::getInstance()->getI18N()->__("Please enter a valid postal code. E.g. 33444");
           
        }else{
            $po_boxPattern = sfContext::getInstance()->getI18N()->__("Please enter a valid postal code. E.g. 33444");
                   }
		$poboxPattern = "/^[0-9\s]{4,5}$/";
	$this->validatorSchema['po_box_number'] = new sfValidatorAnd(
		array(
			 $this->validatorSchema['po_box_number'],
			new sfValidatorRegex(
				array(
					'pattern'=>$poboxPattern,
                                        'max_length'=>5,
                                        'min_length' =>4 ,

				),
                                array(
                                        'max_length' => '"%value%" is too long 5 characters max.',
                                        'min_length' => '"%value%" is too short 4 characters min.',
                                        'invalid'=>sfContext::getInstance()->getI18N()->__('Please enter a valid postal code with 4 or 5 digits.'))
			)
		)
	);
  	
  	//product
  	
	
	
                   $dc = new Criteria();
                  $dc->add(AgentProductPeer::AGENT_ID, sfContext::getInstance()->getUser()->getAttribute('agent_company_id', '', 'usersession'));
                 
                  $temp = AgentProductPeer::doCount($dc);
	
        $product_criteria = new Criteria();
        if(sfConfig::get('sf_app')=='agent'){
         sfContext::getInstance()->getUser()->getAttribute('agent_company_id', '', 'usersession');
		 
            //-----------------------------------
			if( $temp>0){
		$product_criteria->add(ProductPeer::IS_IN_STORE, true);
		$product_criteria->addJoin( ProductPeer::ID ,  AgentProductPeer::PRODUCT_ID ,  Criteria::LEFT_JOIN);
			$product_criteria->add(AgentProductPeer::AGENT_ID, sfContext::getInstance()->getUser()->getAttribute('agent_company_id', '', 'usersession'));	
			}else{
				
			 $product_criteria->add(ProductPeer::IS_IN_STORE, true);

                        
              if($actionmodule=='signupus'){
                  $product_criteria->addAnd(ProductPeer::PRODUCT_COUNTRY_US, 1);
              }else{
            $product_criteria->add(ProductPeer::COUNTRY_ID, $country_id);	
              }
			}
           
   

            //------------Get The Country List For Customer Registration - From Agent
            $enableCountry = new Criteria();
            $enableCountry->add(EnableCountryPeer::ID, $country_id);

            $this->widgetSchema['country_id'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'EnableCountry',
                    'order_by' => array('Name','asc'),
                                   'criteria'	=>	$enableCountry,
                                    //'add_empty' => 'Choose a product',
            ));
            //----------------------------------------------------------------------
			
            //-----------------For get the Products---------------------
            $this->widgetSchema['product'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'Product',
                    'order_by' => array('ProductOrder','asc'),
                                    'criteria'	=>	$product_criteria,
                                    //'add_empty' => 'Choose a product',
            ));
            //----------------------------------------------------------

        } else if(sfConfig::get('sf_app')=='b2c'){          

 


   if(isset($_REQUEST['ref'])){

                   $dc = new Criteria();
                  $dc->add(AgentProductPeer::AGENT_ID, $_REQUEST['ref']);
 
                 
                  $temp = AgentProductPeer::doCount($dc);

  }

            $countrylng = new Criteria();
            $countrylng->add(EnableCountryPeer::LANGUAGE_SYMBOL, $lngSymbol);
            $countrylng = EnableCountryPeer::doSelectOne($countrylng);
            $countryName = $countrylng->getName();
            $lngId = $countrylng->getId();
			
			
			  if(isset($_REQUEST['ref'])){
			if($temp>0){
		$product_criteria->add(ProductPeer::IS_IN_STORE, true);
		$product_criteria->addJoin( ProductPeer::ID ,  AgentProductPeer::PRODUCT_ID ,  Criteria::LEFT_JOIN);
			$product_criteria->add(AgentProductPeer::AGENT_ID, $_REQUEST['ref']);	
			}else{
				
			 $product_criteria->add(ProductPeer::IS_IN_STORE, true);
			
            $product_criteria->add(ProductPeer::COUNTRY_ID, $lngId);	
				
			}
			  }
			if(isset($_REQUEST['ref']) && $_REQUEST['ref']!=""){
				
			}else{
				
			 $product_criteria->add(ProductPeer::INCLUDE_IN_ZEROCALL, true);

              if($actionmodule=='signupus'){
                  $product_criteria->addAnd(ProductPeer::PRODUCT_COUNTRY_US,1);
              }else{
            $product_criteria->add(ProductPeer::COUNTRY_ID, $lngId);
              }
			}
			
            //-----------------------------------
           

            //-----------------For get the Products---------------------
            $this->widgetSchema['product'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'Product',
                    'order_by' => array('ProductOrder','asc'),
                                    'criteria'	=>	$product_criteria,
                                    //'add_empty' => 'Choose a product',
            ));
            //----------------------------------------------------------
        }




         if(sfConfig::get('sf_app')=='b2c'){
            $enableCountry = new Criteria();
            $enableCountry->add(EnableCountryPeer::LANGUAGE_SYMBOL, $lngSymbol);

			$this->widgetSchema['country_id'] = new sfWidgetFormPropelChoice(array(
			'model' => 'enableCountry',
			'order_by' => array('Name','asc'),
							'criteria'	=>	$enableCountry,
							//'add_empty' => 'Choose a product',
			));
			$this->widgetSchema['country_id']->setAttribute('style', 'display: none;');
					
         }
	        

	        
	$this->validatorSchema['product'] = new sfValidatorPropelChoice(array(
    								'model'		=> 'Product',
    								'column'	=> 'id',
									'criteria'	=>	$product_criteria,
    							),array(
    								'required'	=> sfContext::getInstance()->getI18N()->__('Please choose a product'),
    								'invalid'	=> 'Invalid product',
    							));

    //date of birth


       $setdate=date('Y');
       $setstartdate=$setdate-13;
       $setenddate=$setdate-110;
	$years = range($setstartdate, $setenddate);
	$this->widgetSchema['date_of_birth']->setOption('years' , array_combine($years, $years));
	$this->widgetSchema['date_of_birth']->setOption('format', '%day% %month% %year%');
	       
	//manufacturer

        //manufacturer
        $manufacturer_oper = new Criteria();
        $manufacturer_oper->add(TelecomOperatorPeer::STATUS_ID, 1);
        if(sfConfig::get('sf_app')=='agent'){
            //echo $country_id;
            $manufacturer_oper->add(TelecomOperatorPeer::COUNTRY_ID, $country_id);
        }elseif(sfConfig::get('sf_app')=='b2c'){
            //echo $lngId.'---<br />';
           $manufacturer_oper->add(TelecomOperatorPeer::COUNTRY_ID, $lngId);
        }

         //-----------------For get the Products---------------------
            $this->widgetSchema['telecom_operator_id'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'TelecomOperator',
                    'order_by' => array('Name','asc'),
                                    'criteria'	=>	$manufacturer_oper,
                                    //'add_empty' => 'Choose a product',
            ));
            

            $this->widgetSchema['manufacturer'] = new sfWidgetFormPropelChoice(array(
	                'model' => 'Manufacturer',
	                'order_by' => array('Name','asc'),
	        		), array (
	        			'required'=> sfContext::getInstance()->getI18N()->__('Please choose a manufacturer')	        		)
	        );
            
//
//	$this->widgetSchema['manufacturer'] = new sfWidgetFormPropelChoice(array(
//	                'model' => 'Manufacturer',
//	                'order_by' => array('Name','asc'),
//	        		), array (
//	        			'required'=> 'Please choose a manufacturer'
//	        		)
//	        );
	/*
	$this->widgetSchema['device_id'] = new sfWidgetFormPropelChoice(array(
	                'model' => 'Device',
	                'order_by' => array('Name','asc'),
					'add_empty' => 'select model'
	        ));
	
	*/
	//device_id
        //This Area Add For Get Modile Brand With Jquery
         $device_oper = new Criteria();
         $zerocalldummy = "Empty The select Box On registration page - zerocall";
         $device_oper->add(DevicePeer::MANUFACTURER_ID, $zerocalldummy);
         
       // $device_oper->add(DevicePeer::MANUFACTURER_ID, 1);
//        if(isset($_REQUEST['customer']['manufacturer']) && $_REQUEST['customer']['manufacturer']!=''){
//            $requestedManufacturedId = $_REQUEST['customer']['manufacturer'];
//            //echo $country_id;
//            $device_oper->add(DevicePeer::MANUFACTURER_ID, $requestedManufacturedId);
//        }else{
//            //echo $lngId.'---<br />';
//            // add Dummy Id So that First Time It will Empty
//            $customer_id =  sfContext::getInstance()->getUser()->getAttribute('customer_id', '', 'usersession');
//            if(isset($customer_id) && $customer_id!=''){
//                $getcustomer = new Criteria();
//                $getcustomer->add(CustomerPeer::ID, $customer_id);
//                $customers = CustomerPeer::doSelectOne($getcustomer);
//                //echo $customers->getDeviceId();
//
//                $c = new Criteria();
//	  	$c->add(DevicePeer::ID, $customers->getDeviceId());
//
//	  	$device = DevicePeer::doSelectOne($c);
//
//	  	$manufacturer = $device->getManufacturerId();
//
//                 $device_oper->add(DevicePeer::MANUFACTURER_ID, $manufacturer);
//            }else{
//                $zerocalldummy = "Empty The select Box On registration page - zerocall";
//                $device_oper->add(DevicePeer::MANUFACTURER_ID, $zerocalldummy);
//            }
//        }

        $this->widgetSchema['device_id'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'Device',
                                    'criteria'	=>	$device_oper,
                                    'add_empty' => '',
            ));
        
     /*   $this->validatorSchema['device_id'] = new sfValidatorPropelChoice(array(
        'model'		=> 'Device',
        'column'	=> 'id',
        ),array(
        'required'	=> sfContext::getInstance()->getI18N()->__('Please choose mobile model'),
        'invalid'	=> 'Invalid model',
        ));
*/
  	//email
  	$this->validatorSchema['email'] = new sfValidatorAnd(
  		array(
  			$this->validatorSchema['email'],
  			
  			new sfValidatorRegex(
				array(
					'pattern'=>'/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i',
                                        'min_length'=>5,
                                        'min_length' => null ,

				),
				array('invalid'=>sfContext::getInstance()->getI18N()->__('Please enter a valid Email address.'))
			)
  			
  		)
  	);
  	
  	//password
   	$this->validatorSchema['password'] = new sfValidatorAnd(
  		array(
  			$this->validatorSchema['password'],
  			new sfValidatorString(
  				array (
  					'min_length'=>6,

                                    ),
                                array('min_length' => 'password "%value%" at least six characters.')

  			),
  			
  		)
  	); 	
  	
  $this->widgetSchema['password_confirm']= new sfWidgetFormInputPassword();
  $this->widgetSchema['to_date']= new sfWidgetFormInput();
  $this->widgetSchema['from_date']= new sfWidgetFormInput();
  	//password_confirm

  $this->validatorSchema['password_confirm'] = clone $this->validatorSchema['password'];
  $this->validatorSchema['password']->setOption('required', true);
  $this->validatorSchema['telecom_operator_id']->setOption('required', false);
  	
  	
  	$this->setWidget('password_confirm', $this->widgetSchema['password']);
  	
  	$this->widgetSchema->moveField('password_confirm', 'after', 'password'); 
 $this->widgetSchema->moveField('password_confirm', 'after', 'password');
  $this->mergePostValidator(new sfValidatorSchemaCompare('password',
                                  sfValidatorSchemaCompare::EQUAL, 'password_confirm',
                                  array(),
                                  array('invalid' => sfContext::getInstance()->getI18n()->__('The two passwords must be the same.'))
                                          ));


    //terms and conditions
	$this->setWidget('terms_conditions', new sfWidgetFormInputCheckbox(array(), array('class'=>'chkbx')));
	$this->setValidator('terms_conditions', new sfValidatorString(array('required' => true), array('required' => sfContext::getInstance()->getI18n()->__('Please accept the terms and conditions'))));
    
	//news letter subscriber
	$this->widgetSchema['is_newsletter_subscriber'] = new sfWidgetFormInputCheckbox(array(), array('class'=>'chkbx'));

	//auto_refill_amount
	$this->setWidget('auto_refill_amount', new sfWidgetFormChoice(array(
								'choices'=>ProductPeer::getRefillHashChoices(),
								'expanded'=>false,
					)));

	$this->setValidator('auto_refill_amount', new sfValidatorChoice( 
		array(
		'choices' => array_keys(ProductPeer::getRefillHashChoices()),
		'required' => false				
		)
	));
	
	//auto_refill_min_balance
	$this->setWidget('auto_refill_min_balance', new sfWidgetFormChoice(
		array(
			'choices'=>ProductPeer::getAutoRefillLowerLimitHashChoices(),
			'expanded'=>false,
		)
	));
	
	$this->setValidator('auto_refill_min_balance', new sfValidatorChoice( 
		array(
			'choices' => array_keys(ProductPeer::getAutoRefillLowerLimitHashChoices()),
			'required' => false				
		)
	));
	
	//hidden filelds
  	//referrer
  	
  	$this->widgetSchema['referrer_id'] = new sfWidgetFormInputHidden();	
	$this->widgetSchema['customer_status_id'] = new sfWidgetFormInputHidden();

	//set help
	$this->widgetSchema->setHelp('terms_conditions', sfContext::getInstance()->getI18n()->__('I accept all terms and conditions'));
	$this->widgetSchema->setHelp('is_newsletter_subscriber', sfContext::getInstance()->getI18n()->__('Yes, subscribe me to newsletter'));
	$this->widgetSchema->setHelp('auto_refill', sfContext::getInstance()->getI18N()->__('Auto refill?'));
	$this->validatorSchema->addOption('allow_extra_fields', true);
	
	//set up other fields
	$this->setWidget('HTTP_COOKIE', new sfWidgetFormInputHidden());
	
	//labels
	$this->widgetSchema->setLabels(
		array(
			'po_box_number'=>'Post code',
			'telecom_operator_id'=>'Telecom operator',
			'manufacturer'=>'Mobile brand',
                    'to_date'=>'to date',
                    'from_date'=>'from date',
			'country_id'=>'Country',
			'device_id'=>'Mobile Model',
			'password_confirm'=>'Retype password',
			'date_of_birth'=>'Birth date <br />(dd-mm-yyyy)',
		)
	);
	
	//defaults
	$this->setDefaults(array(
		'is_newsletter_subscriber'=> true,
		'country_id'=>53,
		'is_newsletter_subscriber'=>1,
		'customer_status_id'=>1,
		'telecom_operator_id'=>37
	));

	
    $decorator = new sidFormFormatter($this->widgetSchema, $this->validatorSchema);
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom'); 
	
	
  }
  
  /*
   * return all values back, to identify if there is any customer with
   * specified mobile number and with status not equals 1
   */
  public function validateUniqueCustomer(sfValidatorBase $validator, $values)
  {
  	
  	$c = new Criteria();  	
  	$c->add(CustomerPeer::MOBILE_NUMBER, $values['mobile_number']);
  	$c->add(CustomerPeer::CUSTOMER_STATUS_ID, 3);
  	
  	if (CustomerPeer::doCount($c)>=1)
  	{
  	      throw new sfValidatorErrorSchema($validator, array(
	        'mobile_number' => new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Number already registered.')),
	      ));	
  	}
  	
  	return $values;
	
  }
}

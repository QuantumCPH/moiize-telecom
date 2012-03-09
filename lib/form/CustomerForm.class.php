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

	$this->validatorSchema['mobile_number'] = new sfValidatorAnd(
		array(
			$this->validatorSchema['mobile_number'],
			new sfValidatorRegex(
				array(
					'pattern'=>'/^[0-9]{8,12}$/',
				),
				array('invalid'=>'Please enter a valid 8 digit mobile number.')
			)
		)
	);
	
	//$this->widgetSchema->setClass('mobile_number', 'required');
       // $emailWidget = new sfWidgetFormInput(array(), array('class' => 'required email'));

	//pobox
	
	$this->validatorSchema['po_box_number'] = new sfValidatorNumber(
		array('required'=>true),
		array('invalid'=>'Please enter a valid postal code. E.g. 3344 ')
	);
  	
  	//product
  	
	$product_criteria = new Criteria();
	if(sfConfig::get('sf_app')=='agent'){
            $product_criteria->add(ProductPeer::IS_IN_STORE, true);
        }
        else if(sfConfig::get('sf_app')=='b2c'){
            $product_criteria->add(ProductPeer::INCLUDE_IN_ZEROCALL, true);
        }
  
        //$product_criteria->add(ProductPeer::IS_IN_STORE, false);
//        if(strcmp(sfConfig::get('sf_app'),'agent')){
//        $product_criteria->add(ProductPeer::IS_IN_STORE, 1, Criteria::EQUAL);
//        }else if (strcmp(sfConfig::get('sf_app'),'b2c')){
//        $product_criteria->add(ProductPeer::INCLUDE_IN_ZEROCALL, 1, Criteria::EQUAL);
//        }
	$this->widgetSchema['product'] = new sfWidgetFormPropelChoice(array(
	                'model' => 'Product',
	                'order_by' => array('ProductOrder','asc'),
					'criteria'	=>	$product_criteria,
					//'add_empty' => 'Choose a product',
	        ));
	        

	        
	$this->validatorSchema['product'] = new sfValidatorPropelChoice(array(
    								'model'		=> 'Product',
    								'column'	=> 'id',
									'criteria'	=>	$product_criteria,
    							),array(
    								'required'	=> 'Please choose a product',
    								'invalid'	=> 'Invalid product',
    							));

    //date of birth
	$years = range(1950, 2020);
	$this->widgetSchema['date_of_birth']->setOption('years' , array_combine($years, $years));
	$this->widgetSchema['date_of_birth']->setOption('format', '%day% %month% %year%');
	       
	//manufacturer
	$this->widgetSchema['manufacturer'] = new sfWidgetFormPropelChoice(array(
	                'model' => 'Manufacturer',
	                'order_by' => array('Name','asc'),
	        		), array (
	        			'required'=> 'Please choose a manufacturer'
	        		)
	        );
	/*
	$this->widgetSchema['device_id'] = new sfWidgetFormPropelChoice(array(
	                'model' => 'Device',
	                'order_by' => array('Name','asc'),
					'add_empty' => 'select model'
	        ));
	
	*/
	//device_id
	$this->validatorSchema['device_id'] = new sfValidatorPropelChoice(array(
    								'model'		=> 'Device',
    								'column'	=> 'id',
    							),array(
    								'required'	=> 'Please choose mobile model',
    								'invalid'	=> 'Invalid model',
    							));

  	//email
  	$this->validatorSchema['email'] = new sfValidatorAnd(
  		array(
  			$this->validatorSchema['email'],
  			new sfValidatorString(
  				array (
  					'min_length'=>5,
  				)
  			),
  			new sfValidatorRegex(
				array(
					'pattern'=>'/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i',
                                        'min_length'=>3,
				),
				array('invalid'=>sfContext::getInstance()->getI18N()->__('Please enter a valid Email address.ff'))
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
  				)
  			),
  			
  		)
  	); 	
  	
  	$this->widgetSchema['password'] = new sfWidgetFormInputPassword();
  	
  	//password_confirm
  	
  	$this->validatorSchema['password_confirm'] = clone $this->validatorSchema['password'];
  	
  	$this->setWidget('password_confirm', $this->widgetSchema['password']);
  	
  	$this->widgetSchema->moveField('password_confirm', 'after', 'password'); 


    
    //terms and conditions
	$this->setWidget('terms_conditions', new sfWidgetFormInputCheckbox(array(), array('class'=>'chkbx')));
	$this->setValidator('terms_conditions', new sfValidatorString(array('required' => true), array('required' => 'Please accept the terms and conditions')));
    
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
                    'to_date'=>'To date',
                    'from_date'=>'From date',
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
		'customer_status_id'=>1
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
  	$c->addAnd(CustomerPeer::CUSTOMER_STATUS_ID,3);
  	 
  	if (CustomerPeer::doCount($c)>=1)
  	{
  	      throw new sfValidatorErrorSchema($validator, array(
	        'mobile_number' => new sfValidatorError($validator, 'Number already registered.'),
	      ));	
  	}

  	return $values;
	  }
}

<?php
	class AccountRefillAgent extends sfForm
	{
		public function configure()
		{
			$this->setWidgets(array(
				'mobile_number'=>new sfWidgetFormInput(),
				'extra_refill'=>new sfWidgetFormSelect(array(
					'choices'=>ProductPeer::getRefillHashChoices()
				))
			));
			
			$c = new Criteria();
			$c->add(CustomerPeer::CUSTOMER_STATUS_ID, sfConfig::get('app_status_completed'));
			$c->add(CustomerPeer::FONET_CUSTOMER_ID, NULL, Criteria::ISNOTNULL);
			
			$this->setValidators(array(
				'mobile_number' => new sfValidatorPropelChoice(array(
    								'model'		=> 'Customer',
    								'column'	=> 'mobile_number',
    								'criteria'	=> clone $c,
    							),array(
    								'required'	=> 'Please enter mobile number for the customer.',
    								'invalid'	=> 'Mobile number doesn\'t exists',
    							)),
    							
    			'extra_refill' => new sfValidatorChoice(array('choices'=>ProductPeer::getRefillChoices()))
    		
			));
		}
	}
?>
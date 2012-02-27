<?php
class CustomerFormAgent extends CustomerForm
{
	public function configure()
	{
		parent::configure();

                $this->unsetAllExcept(array(
                        'mobile_number',
                        'first_name',
                        'last_name',
                        'country_id',
                        'city',
                        'product',
                        'po_box_number',
                        'device_id',
                        'email',
                        'password',
                        'password_confirm',
                        'terms_conditions',
                        'is_newsletter_subscriber',
                        'address',
                        'referrer_id',
                        'telecom_operator_id',
                        'date_of_birth',
                        'manufacturer',
                        'other',
                        'subscription_type',
                    ));


                /*
		unset(
			$this['terms_conditions'],
  			$this['auto_refill_amount'],
  			$this['last_auto_refill'],
  			$this['auto_refill_min_balance']
  		);
                 */
  		
  		$this->mergePostValidator(
	        new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirm', array(), array('invalid' => 'Passwords don\'t match'))
	    );
  		
  		$this->mergePostValidator(
		    new sfValidatorCallback(
		    			array(
		    				'callback'=> array(new CustomerForm, 'validateUniqueCustomer')
						)
		    		)
	    );
	}
}
?>
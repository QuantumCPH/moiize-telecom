<?php
class CustomerFormB2C extends CustomerForm
{
	public function configure()
	{
            parent::configure();

               $context =  sfContext::getInstance();
        $request = $context->getRequest();

       $actionmodule=  $context->getActionName();



              if($actionmodule=='signupus'){
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
                         'to_date',
                    'from_date', 




                ));


              }else{
           
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

              

                
               
                ));



              }




            $this->mergePostValidator(
		    new sfValidatorCallback (
                        array (
                                'callback'=> array(new CustomerForm, 'validateUniqueCustomer')
                        )
		    )
	    );

            $this->mergePostValidator(
	        new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirm', array(), array('invalid' => 'Passwords don\'t match'))
	    );

	}

}
?>
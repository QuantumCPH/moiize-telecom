<?php
class CustomerFormSettings extends CustomerForm
{
	public function config()
	{
		parent::config();
		
                $this->unsetAllExcept(array(
                        'mobile_number',
                        'first_name',
                        'last_name',
                        'country_id',
                        'city',
                        'po_box_number',
                        'device_id',
                        'email',
                        'is_newsletter_subscriber',
                        'address',
                        'telecom_operator_id',
                        'date_of_birth',
                        'manufacturer',
                    ));
	}
}
?>
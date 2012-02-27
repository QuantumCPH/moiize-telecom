<?php
	class HistoryFilterForm extends sfForm
	{
		public function configure()
		{
			$this->setWidget(array(
				'phone_number'=> new sfWidgetPropelChoice(),
				
				'from_day'=> new sfWidgetFormChoice(),
				'from_month'=> new sfWidgetFormChoice(),
				'from_year'=> new sfWidgetFormChoice(),
			
				'to_day'=> new sfWidgetFormChoice(),
				'to_month'=> new sfWidgetFormChoice(),
				'to_year'=> new sfWidgetFormChoice(),				
			));
		}
	}
?>
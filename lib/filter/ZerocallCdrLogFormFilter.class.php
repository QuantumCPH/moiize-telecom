<?php

/**
 * ZerocallCdrLog filter form.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: ZerocallCdrLogFormFilter.class.php,v 1.1 2010-08-05 20:37:36 orehman Exp $
 */
class ZerocallCdrLogFormFilter extends BaseZerocallCdrLogFormFilter
{
  public function configure()
  {
	$this->widgetSchema['to_no'] = new sfWidgetFormPropelChoice(array(
	                'model' => 'ZerocallCdrLog',
	                'order_by' => array('ToNo','asc'),
					'method' => 'getToNo',
					'add_empty' => true,
	        ));
	        
	 $this->widgetSchema['to_no']->setLabel('Phone number');
	 
	 $this->widgetSchema['date']->setDefault(date('Y-m-d'));
  }
}

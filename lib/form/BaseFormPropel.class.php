<?php

/**
 * Project form base class.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: BaseFormPropel.class.php,v 1.2 2010-09-19 22:20:12 orehman Exp $
 */
abstract class BaseFormPropel extends sfFormPropel
{
  public function setup()
  {
  }
  
  /**
   *  unset all fields except given parameters
   *
   * @param array $fields Array of fields
   */
  public function unsetAllExcept($fields = array())
  {
  	$tmp = array_keys($this->getWidgetSchema()->getFields());


  	foreach(array_diff($tmp, $fields) as $value){
            unset($this[$value]);
  	}

  }
}

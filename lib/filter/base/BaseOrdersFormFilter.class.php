<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Orders filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseOrdersFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'OrderNo' => new sfWidgetFormFilterInput(),
      'P_Id'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'OrderNo' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'P_Id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('orders_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Orders';
  }

  public function getFields()
  {
    return array(
      'O_Id'    => 'Number',
      'OrderNo' => 'Number',
      'P_Id'    => 'Number',
    );
  }
}

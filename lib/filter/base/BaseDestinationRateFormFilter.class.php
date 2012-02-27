<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * DestinationRate filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseDestinationRateFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'destination_name' => new sfWidgetFormFilterInput(),
      'purchase_price'   => new sfWidgetFormFilterInput(),
      'sale_price'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'destination_name' => new sfValidatorPass(array('required' => false)),
      'purchase_price'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'sale_price'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('destination_rate_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'DestinationRate';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'destination_name' => 'Text',
      'purchase_price'   => 'Number',
      'sale_price'       => 'Number',
    );
  }
}

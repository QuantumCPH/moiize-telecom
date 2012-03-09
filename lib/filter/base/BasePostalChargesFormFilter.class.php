<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * PostalCharges filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BasePostalChargesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'charges' => new sfWidgetFormFilterInput(),
      'country' => new sfWidgetFormPropelChoice(array('model' => 'EnableCountry', 'add_empty' => true)),
      'status'  => new sfWidgetFormPropelChoice(array('model' => 'Status', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'charges' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'country' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'EnableCountry', 'column' => 'id')),
      'status'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Status', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('postal_charges_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostalCharges';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'charges' => 'Number',
      'country' => 'ForeignKey',
      'status'  => 'ForeignKey',
    );
  }
}

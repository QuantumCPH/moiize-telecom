<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * C9Numbers filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseC9NumbersFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'c9_number'   => new sfWidgetFormFilterInput(),
      'is_assigned' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'c9_number'   => new sfValidatorPass(array('required' => false)),
      'is_assigned' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('c9_numbers_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'C9Numbers';
  }

  public function getFields()
  {
    return array(
      'c9_number'   => 'Text',
      'id'          => 'Number',
      'is_assigned' => 'Boolean',
    );
  }
}

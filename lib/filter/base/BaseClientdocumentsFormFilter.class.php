<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Clientdocuments filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseClientdocumentsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'    => new sfWidgetFormFilterInput(),
      'filename' => new sfWidgetFormFilterInput(),
      'status'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'    => new sfValidatorPass(array('required' => false)),
      'filename' => new sfValidatorPass(array('required' => false)),
      'status'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('clientdocuments_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Clientdocuments';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'title'    => 'Text',
      'filename' => 'Text',
      'status'   => 'Text',
    );
  }
}

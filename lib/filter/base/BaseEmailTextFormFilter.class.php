<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * EmailText filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseEmailTextFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'subject'     => new sfWidgetFormFilterInput(),
      'bodyText'    => new sfWidgetFormFilterInput(),
      'senderName'  => new sfWidgetFormFilterInput(),
      'senderEmail' => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'subject'     => new sfValidatorPass(array('required' => false)),
      'bodyText'    => new sfValidatorPass(array('required' => false)),
      'senderName'  => new sfValidatorPass(array('required' => false)),
      'senderEmail' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('email_text_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EmailText';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'subject'     => 'Text',
      'bodyText'    => 'Text',
      'senderName'  => 'Text',
      'senderEmail' => 'Text',
      'created_at'  => 'Date',
    );
  }
}

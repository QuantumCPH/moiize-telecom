<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Taisys filter form base class.
 *
 * @package    zapnacrm
 * @subpackage filter
 * @author     Your name here
 */
class BaseTaisysFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'serv'                  => new sfWidgetFormFilterInput(),
      'imsi'                  => new sfWidgetFormFilterInput(),
      'dn'                    => new sfWidgetFormFilterInput(),
      'smscontent'            => new sfWidgetFormFilterInput(),
      'checksum'              => new sfWidgetFormFilterInput(),
      'checksum_verification' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'serv'                  => new sfValidatorPass(array('required' => false)),
      'imsi'                  => new sfValidatorPass(array('required' => false)),
      'dn'                    => new sfValidatorPass(array('required' => false)),
      'smscontent'            => new sfValidatorPass(array('required' => false)),
      'checksum'              => new sfValidatorPass(array('required' => false)),
      'checksum_verification' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('taisys_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Taisys';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'serv'                  => 'Text',
      'imsi'                  => 'Text',
      'dn'                    => 'Text',
      'smscontent'            => 'Text',
      'checksum'              => 'Text',
      'checksum_verification' => 'Boolean',
      'created_at'            => 'Date',
    );
  }
}

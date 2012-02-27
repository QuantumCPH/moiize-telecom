<?php
require_once(sfConfig::get('sf_lib_dir').'/sfWidgetFormTextareaFCKEditor.class.php');
/**
 * Userguide form.
 *
 * @package    zapnacrm
 * @subpackage form
 * @author     Your name here
 */
class UserguideForm extends BaseUserguideForm
{
  public function configure()
  {
      $this->widgetSchema['description'] =  new sfWidgetFormTextareaFCKEditor(
      array(
        'width' => 550,
        'height' => 350,

        'config'=> 'myfckconfig'  // points to web/js/myfckconfig.js
      ));

      $this->widgetSchema->setLabels(
		array(
			'country_id'=>'Country',
			'status_id'=>'Status',
			

		)
	);

  }
}

<?php

/**
 * LyraUserProfile form.
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LyraUserProfileForm extends BaseLyraUserProfileForm
{

  public function configure()
  {
    $this->widgetSchema['first_name']->setLabel('FIRST_NAME');
    $this->widgetSchema['last_name']->setLabel('LAST_NAME');
    $this->widgetSchema['email']->setLabel('EMAIL');

    $this->validatorSchema['email'] = new sfValidatorEmail(array(
      'required' => false
    ));

    $this->widgetSchema->setNameFormat('profile[%s]');
  }
}

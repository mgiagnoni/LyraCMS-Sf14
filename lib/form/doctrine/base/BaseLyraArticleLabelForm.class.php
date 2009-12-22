<?php

/**
 * LyraArticleLabel form base class.
 *
 * @method LyraArticleLabel getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraArticleLabelForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id' => new sfWidgetFormInputHidden(),
      'label_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'article_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'article_id', 'required' => false)),
      'label_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'label_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_article_label[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraArticleLabel';
  }

}

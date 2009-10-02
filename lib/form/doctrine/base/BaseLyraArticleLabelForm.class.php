<?php

/**
 * LyraArticleLabel form base class.
 *
 * @package    form
 * @subpackage lyra_article_label
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraArticleLabelForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id' => new sfWidgetFormInputHidden(),
      'label_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'article_id' => new sfValidatorDoctrineChoice(array('model' => 'LyraArticleLabel', 'column' => 'article_id', 'required' => false)),
      'label_id'   => new sfValidatorDoctrineChoice(array('model' => 'LyraArticleLabel', 'column' => 'label_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lyra_article_label[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraArticleLabel';
  }

}

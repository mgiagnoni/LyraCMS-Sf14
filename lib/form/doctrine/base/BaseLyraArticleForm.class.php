<?php

/**
 * LyraArticle form base class.
 *
 * @package    form
 * @subpackage lyra_article
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraArticleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'title'               => new sfWidgetFormInput(),
      'subtitle'            => new sfWidgetFormInput(),
      'summary'             => new sfWidgetFormTextarea(),
      'content'             => new sfWidgetFormTextarea(),
      'meta_title'          => new sfWidgetFormInput(),
      'meta_descr'          => new sfWidgetFormTextarea(),
      'meta_keys'           => new sfWidgetFormTextarea(),
      'meta_robots'         => new sfWidgetFormInput(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'is_featured'         => new sfWidgetFormInputCheckbox(),
      'is_sticky'           => new sfWidgetFormInputCheckbox(),
      'publish_start'       => new sfWidgetFormDateTime(),
      'publish_end'         => new sfWidgetFormDateTime(),
      'status'              => new sfWidgetFormInput(),
      'options'             => new sfWidgetFormTextarea(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'locked_by'           => new sfWidgetFormInput(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'slug'                => new sfWidgetFormInput(),
      'article_labels_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraLabel')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => 'LyraArticle', 'column' => 'id', 'required' => false)),
      'title'               => new sfValidatorString(array('max_length' => 255)),
      'subtitle'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'summary'             => new sfValidatorString(array('required' => false)),
      'content'             => new sfValidatorString(array('required' => false)),
      'meta_title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_descr'          => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'meta_keys'           => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'meta_robots'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'           => new sfValidatorBoolean(),
      'is_featured'         => new sfValidatorBoolean(),
      'is_sticky'           => new sfValidatorBoolean(),
      'publish_start'       => new sfValidatorDateTime(array('required' => false)),
      'publish_end'         => new sfValidatorDateTime(array('required' => false)),
      'status'              => new sfValidatorInteger(),
      'options'             => new sfValidatorString(array('required' => false)),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'locked_by'           => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'slug'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'article_labels_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraLabel', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'LyraArticle', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('lyra_article[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraArticle';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['article_labels_list']))
    {
      $this->setDefault('article_labels_list', $this->object->ArticleLabels->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveArticleLabelsList($con);
  }

  public function saveArticleLabelsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['article_labels_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ArticleLabels->getPrimaryKeys();
    $values = $this->getValue('article_labels_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ArticleLabels', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ArticleLabels', array_values($link));
    }
  }

}

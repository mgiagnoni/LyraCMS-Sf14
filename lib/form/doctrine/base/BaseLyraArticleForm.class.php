<?php

/**
 * LyraArticle form base class.
 *
 * @method LyraArticle getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraArticleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'ctype_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContentType'), 'add_empty' => true)),
      'title'               => new sfWidgetFormInputText(),
      'subtitle'            => new sfWidgetFormInputText(),
      'summary'             => new sfWidgetFormTextarea(),
      'content'             => new sfWidgetFormTextarea(),
      'meta_title'          => new sfWidgetFormInputText(),
      'meta_descr'          => new sfWidgetFormTextarea(),
      'meta_keys'           => new sfWidgetFormTextarea(),
      'meta_robots'         => new sfWidgetFormInputText(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'is_featured'         => new sfWidgetFormInputCheckbox(),
      'is_sticky'           => new sfWidgetFormInputCheckbox(),
      'publish_start'       => new sfWidgetFormDateTime(),
      'publish_end'         => new sfWidgetFormDateTime(),
      'status'              => new sfWidgetFormInputText(),
      'options'             => new sfWidgetFormTextarea(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'add_empty' => true)),
      'locked_by'           => new sfWidgetFormInputText(),
      'num_comments'        => new sfWidgetFormInputText(),
      'num_active_comments' => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'slug'                => new sfWidgetFormInputText(),
      'article_labels_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'ctype_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ContentType'), 'required' => false)),
      'title'               => new sfValidatorString(array('max_length' => 255)),
      'subtitle'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'summary'             => new sfValidatorString(array('required' => false)),
      'content'             => new sfValidatorString(array('required' => false)),
      'meta_title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_descr'          => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'meta_keys'           => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'meta_robots'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'           => new sfValidatorBoolean(array('required' => false)),
      'is_featured'         => new sfValidatorBoolean(array('required' => false)),
      'is_sticky'           => new sfValidatorBoolean(array('required' => false)),
      'publish_start'       => new sfValidatorDateTime(array('required' => false)),
      'publish_end'         => new sfValidatorDateTime(array('required' => false)),
      'status'              => new sfValidatorInteger(array('required' => false)),
      'options'             => new sfValidatorString(array('required' => false)),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleCreatedBy'), 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'required' => false)),
      'locked_by'           => new sfValidatorInteger(array('required' => false)),
      'num_comments'        => new sfValidatorInteger(array('required' => false)),
      'num_active_comments' => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'slug'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'article_labels_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'LyraArticle', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('lyra_article[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

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
    $this->saveArticleLabelsList($con);

    parent::doSave($con);
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

    if (null === $con)
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

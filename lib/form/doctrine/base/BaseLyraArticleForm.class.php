<?php

/**
 * LyraArticle form base class.
 *
 * @method LyraArticle getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraArticleForm extends LyraContentForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['title'] = new sfWidgetFormInputText();
    $this->validatorSchema['title'] = new sfValidatorString(array('max_length' => 255));

    $this->widgetSchema   ['subtitle'] = new sfWidgetFormInputText();
    $this->validatorSchema['subtitle'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['summary'] = new sfWidgetFormTextarea();
    $this->validatorSchema['summary'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormTextarea();
    $this->validatorSchema['content'] = new sfValidatorString(array('required' => false));

    $this->widgetSchema   ['meta_title'] = new sfWidgetFormInputText();
    $this->validatorSchema['meta_title'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['meta_descr'] = new sfWidgetFormTextarea();
    $this->validatorSchema['meta_descr'] = new sfValidatorString(array('max_length' => 500, 'required' => false));

    $this->widgetSchema   ['meta_keys'] = new sfWidgetFormTextarea();
    $this->validatorSchema['meta_keys'] = new sfValidatorString(array('max_length' => 500, 'required' => false));

    $this->widgetSchema   ['meta_robots'] = new sfWidgetFormInputText();
    $this->validatorSchema['meta_robots'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['is_active'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['is_active'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema   ['is_featured'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['is_featured'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema   ['is_sticky'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['is_sticky'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema   ['publish_start'] = new sfWidgetFormDateTime();
    $this->validatorSchema['publish_start'] = new sfValidatorDateTime(array('required' => false));

    $this->widgetSchema   ['publish_end'] = new sfWidgetFormDateTime();
    $this->validatorSchema['publish_end'] = new sfValidatorDateTime(array('required' => false));

    $this->widgetSchema   ['status'] = new sfWidgetFormInputText();
    $this->validatorSchema['status'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['created_by'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleCreatedBy'), 'add_empty' => true));
    $this->validatorSchema['created_by'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleCreatedBy'), 'required' => false));

    $this->widgetSchema   ['updated_by'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'add_empty' => true));
    $this->validatorSchema['updated_by'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'required' => false));

    $this->widgetSchema   ['locked_by'] = new sfWidgetFormInputText();
    $this->validatorSchema['locked_by'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['num_comments'] = new sfWidgetFormInputText();
    $this->validatorSchema['num_comments'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['num_active_comments'] = new sfWidgetFormInputText();
    $this->validatorSchema['num_active_comments'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['created_at'] = new sfWidgetFormDateTime();
    $this->validatorSchema['created_at'] = new sfValidatorDateTime();

    $this->widgetSchema   ['updated_at'] = new sfWidgetFormDateTime();
    $this->validatorSchema['updated_at'] = new sfValidatorDateTime();

    $this->widgetSchema   ['slug'] = new sfWidgetFormInputText();
    $this->validatorSchema['slug'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['article_labels_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel'));
    $this->validatorSchema['article_labels_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel', 'required' => false));

    $this->widgetSchema->setNameFormat('lyra_article[%s]');
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

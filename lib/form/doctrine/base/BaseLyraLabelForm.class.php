<?php

/**
 * LyraLabel form base class.
 *
 * @method LyraLabel getObject() Returns the current form's model object
 *
 * @package    lyra
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraLabelForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'catalog_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LabelCatalog'), 'add_empty' => true)),
      'name'                => new sfWidgetFormInputText(),
      'title'               => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormTextarea(),
      'meta_title'          => new sfWidgetFormInputText(),
      'meta_robots'         => new sfWidgetFormInputText(),
      'meta_descr'          => new sfWidgetFormTextarea(),
      'meta_keys'           => new sfWidgetFormTextarea(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LabelCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LabelUpdatedBy'), 'add_empty' => true)),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'slug'                => new sfWidgetFormInputText(),
      'root_id'             => new sfWidgetFormInputText(),
      'lft'                 => new sfWidgetFormInputText(),
      'rgt'                 => new sfWidgetFormInputText(),
      'level'               => new sfWidgetFormInputText(),
      'label_articles_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraArticle')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'catalog_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LabelCatalog'), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'title'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'         => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'meta_title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_robots'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_descr'          => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'meta_keys'           => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'is_active'           => new sfValidatorBoolean(array('required' => false)),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LabelCreatedBy'), 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LabelUpdatedBy'), 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'slug'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'root_id'             => new sfValidatorInteger(array('required' => false)),
      'lft'                 => new sfValidatorInteger(array('required' => false)),
      'rgt'                 => new sfValidatorInteger(array('required' => false)),
      'level'               => new sfValidatorInteger(array('required' => false)),
      'label_articles_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraArticle', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'LyraLabel', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('lyra_label[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraLabel';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['label_articles_list']))
    {
      $this->setDefault('label_articles_list', $this->object->LabelArticles->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveLabelArticlesList($con);

    parent::doSave($con);
  }

  public function saveLabelArticlesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['label_articles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->LabelArticles->getPrimaryKeys();
    $values = $this->getValue('label_articles_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('LabelArticles', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('LabelArticles', array_values($link));
    }
  }

}

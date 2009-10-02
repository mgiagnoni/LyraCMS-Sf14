<?php

/**
 * LyraLabel form base class.
 *
 * @package    form
 * @subpackage lyra_label
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseLyraLabelForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'catalog_id'          => new sfWidgetFormDoctrineChoice(array('model' => 'LyraCatalog', 'add_empty' => true)),
      'name'                => new sfWidgetFormInput(),
      'title'               => new sfWidgetFormInput(),
      'description'         => new sfWidgetFormTextarea(),
      'meta_title'          => new sfWidgetFormInput(),
      'meta_robots'         => new sfWidgetFormInput(),
      'meta_descr'          => new sfWidgetFormTextarea(),
      'meta_keys'           => new sfWidgetFormTextarea(),
      'is_active'           => new sfWidgetFormInputCheckbox(),
      'created_by'          => new sfWidgetFormInput(),
      'updated_by'          => new sfWidgetFormInput(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'slug'                => new sfWidgetFormInput(),
      'root_id'             => new sfWidgetFormInput(),
      'lft'                 => new sfWidgetFormInput(),
      'rgt'                 => new sfWidgetFormInput(),
      'level'               => new sfWidgetFormInput(),
      'label_articles_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'LyraArticle')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => 'LyraLabel', 'column' => 'id', 'required' => false)),
      'catalog_id'          => new sfValidatorDoctrineChoice(array('model' => 'LyraCatalog', 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'title'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'         => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'meta_title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_robots'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'meta_descr'          => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'meta_keys'           => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'is_active'           => new sfValidatorBoolean(),
      'created_by'          => new sfValidatorInteger(array('required' => false)),
      'updated_by'          => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'slug'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'root_id'             => new sfValidatorInteger(array('required' => false)),
      'lft'                 => new sfValidatorInteger(array('required' => false)),
      'rgt'                 => new sfValidatorInteger(array('required' => false)),
      'level'               => new sfValidatorInteger(array('required' => false)),
      'label_articles_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'LyraArticle', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'LyraLabel', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('lyra_label[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

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
    parent::doSave($con);

    $this->saveLabelArticlesList($con);
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

    if (is_null($con))
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

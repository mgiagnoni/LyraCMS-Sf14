<?php

/**
 * LyraArticle filter form base class.
 *
 * @package    lyra
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseLyraArticleFormFilter extends LyraContentFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['title'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['title'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['subtitle'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['subtitle'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['summary'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['summary'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['content'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['content'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['meta_title'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['meta_title'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['meta_descr'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['meta_descr'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['meta_keys'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['meta_keys'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['meta_robots'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['meta_robots'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['is_active'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['is_active'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema   ['is_featured'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['is_featured'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema   ['is_sticky'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['is_sticky'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema   ['publish_start'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate()));
    $this->validatorSchema['publish_start'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema   ['publish_end'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate()));
    $this->validatorSchema['publish_end'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema   ['status'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['status'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['created_by'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleCreatedBy'), 'add_empty' => true));
    $this->validatorSchema['created_by'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ArticleCreatedBy'), 'column' => 'id'));

    $this->widgetSchema   ['updated_by'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'add_empty' => true));
    $this->validatorSchema['updated_by'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ArticleUpdatedBy'), 'column' => 'id'));

    $this->widgetSchema   ['locked_by'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['locked_by'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['num_comments'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['num_comments'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['num_active_comments'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['num_active_comments'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['created_at'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
    $this->validatorSchema['created_at'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema   ['updated_at'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
    $this->validatorSchema['updated_at'] = new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59'))));

    $this->widgetSchema   ['slug'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['slug'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['article_labels_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel'));
    $this->validatorSchema['article_labels_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LyraLabel', 'required' => false));

    $this->widgetSchema->setNameFormat('lyra_article_filters[%s]');
  }

  public function addArticleLabelsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.LyraArticleLabel LyraArticleLabel')
          ->andWhereIn('LyraArticleLabel.label_id', $values);
  }

  public function getModelName()
  {
    return 'LyraArticle';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'title' => 'Text',
      'subtitle' => 'Text',
      'summary' => 'Text',
      'content' => 'Text',
      'meta_title' => 'Text',
      'meta_descr' => 'Text',
      'meta_keys' => 'Text',
      'meta_robots' => 'Text',
      'is_active' => 'Boolean',
      'is_featured' => 'Boolean',
      'is_sticky' => 'Boolean',
      'publish_start' => 'Date',
      'publish_end' => 'Date',
      'status' => 'Number',
      'created_by' => 'ForeignKey',
      'updated_by' => 'ForeignKey',
      'locked_by' => 'Number',
      'num_comments' => 'Number',
      'num_active_comments' => 'Number',
      'created_at' => 'Date',
      'updated_at' => 'Date',
      'slug' => 'Text',
      'article_labels_list' => 'ManyKey',
    ));
  }
}

<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * LyraComment filter form base class.
 *
 * @package    filters
 * @subpackage LyraComment *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseLyraCommentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'LyraArticle', 'add_empty' => true)),
      'author_name'  => new sfWidgetFormFilterInput(),
      'author_email' => new sfWidgetFormFilterInput(),
      'author_url'   => new sfWidgetFormFilterInput(),
      'content'      => new sfWidgetFormFilterInput(),
      'is_active'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'article_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'LyraArticle', 'column' => 'id')),
      'author_name'  => new sfValidatorPass(array('required' => false)),
      'author_email' => new sfValidatorPass(array('required' => false)),
      'author_url'   => new sfValidatorPass(array('required' => false)),
      'content'      => new sfValidatorPass(array('required' => false)),
      'is_active'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('lyra_comment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LyraComment';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'article_id'   => 'ForeignKey',
      'author_name'  => 'Text',
      'author_email' => 'Text',
      'author_url'   => 'Text',
      'content'      => 'Text',
      'is_active'    => 'Boolean',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
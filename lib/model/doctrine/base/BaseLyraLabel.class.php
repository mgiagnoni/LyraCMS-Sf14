<?php

/**
 * BaseLyraLabel
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $catalog_id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $meta_title
 * @property string $meta_robots
 * @property string $meta_descr
 * @property string $meta_keys
 * @property boolean $is_active
 * @property integer $created_by
 * @property integer $updated_by
 * @property LyraCatalog $LabelCatalog
 * @property sfGuardUser $LabelCreatedBy
 * @property sfGuardUser $LabelUpdatedBy
 * @property Doctrine_Collection $LabelArticles
 * @property Doctrine_Collection $LyraArticleLabel
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method integer             getCatalogId()        Returns the current record's "catalog_id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getTitle()            Returns the current record's "title" value
 * @method string              getDescription()      Returns the current record's "description" value
 * @method string              getMetaTitle()        Returns the current record's "meta_title" value
 * @method string              getMetaRobots()       Returns the current record's "meta_robots" value
 * @method string              getMetaDescr()        Returns the current record's "meta_descr" value
 * @method string              getMetaKeys()         Returns the current record's "meta_keys" value
 * @method boolean             getIsActive()         Returns the current record's "is_active" value
 * @method integer             getCreatedBy()        Returns the current record's "created_by" value
 * @method integer             getUpdatedBy()        Returns the current record's "updated_by" value
 * @method LyraCatalog         getLabelCatalog()     Returns the current record's "LabelCatalog" value
 * @method sfGuardUser         getLabelCreatedBy()   Returns the current record's "LabelCreatedBy" value
 * @method sfGuardUser         getLabelUpdatedBy()   Returns the current record's "LabelUpdatedBy" value
 * @method Doctrine_Collection getLabelArticles()    Returns the current record's "LabelArticles" collection
 * @method Doctrine_Collection getLyraArticleLabel() Returns the current record's "LyraArticleLabel" collection
 * @method LyraLabel           setId()               Sets the current record's "id" value
 * @method LyraLabel           setCatalogId()        Sets the current record's "catalog_id" value
 * @method LyraLabel           setName()             Sets the current record's "name" value
 * @method LyraLabel           setTitle()            Sets the current record's "title" value
 * @method LyraLabel           setDescription()      Sets the current record's "description" value
 * @method LyraLabel           setMetaTitle()        Sets the current record's "meta_title" value
 * @method LyraLabel           setMetaRobots()       Sets the current record's "meta_robots" value
 * @method LyraLabel           setMetaDescr()        Sets the current record's "meta_descr" value
 * @method LyraLabel           setMetaKeys()         Sets the current record's "meta_keys" value
 * @method LyraLabel           setIsActive()         Sets the current record's "is_active" value
 * @method LyraLabel           setCreatedBy()        Sets the current record's "created_by" value
 * @method LyraLabel           setUpdatedBy()        Sets the current record's "updated_by" value
 * @method LyraLabel           setLabelCatalog()     Sets the current record's "LabelCatalog" value
 * @method LyraLabel           setLabelCreatedBy()   Sets the current record's "LabelCreatedBy" value
 * @method LyraLabel           setLabelUpdatedBy()   Sets the current record's "LabelUpdatedBy" value
 * @method LyraLabel           setLabelArticles()    Sets the current record's "LabelArticles" collection
 * @method LyraLabel           setLyraArticleLabel() Sets the current record's "LyraArticleLabel" collection
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLyraLabel extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('labels');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('catalog_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 4000, array(
             'type' => 'string',
             'length' => 4000,
             ));
        $this->hasColumn('meta_title', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('meta_robots', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('meta_descr', 'string', 4000, array(
             'type' => 'string',
             'length' => 4000,
             ));
        $this->hasColumn('meta_keys', 'string', 4000, array(
             'type' => 'string',
             'length' => 4000,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('created_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('updated_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LyraCatalog as LabelCatalog', array(
             'local' => 'catalog_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as LabelCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as LabelUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasMany('LyraArticle as LabelArticles', array(
             'refClass' => 'LyraArticleLabel',
             'local' => 'label_id',
             'foreign' => 'article_id'));

        $this->hasMany('LyraArticleLabel', array(
             'local' => 'id',
             'foreign' => 'label_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             'canUpdate' => true,
             'unique' => true,
             ));
        $nestedset0 = new Doctrine_Template_NestedSet(array(
             'hasManyRoots' => true,
             'rootColumnName' => 'root_id',
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
        $this->actAs($nestedset0);
    }
}
<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
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
             'length' => '4',
             ));
        $this->hasColumn('catalog_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('description', 'string', 4000, array(
             'type' => 'string',
             'length' => '4000',
             ));
        $this->hasColumn('meta_title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('meta_robots', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('meta_descr', 'string', 4000, array(
             'type' => 'string',
             'length' => '4000',
             ));
        $this->hasColumn('meta_keys', 'string', 4000, array(
             'type' => 'string',
             'length' => '4000',
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('created_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('updated_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('LyraCatalog as LabelCatalog', array(
             'local' => 'catalog_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

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
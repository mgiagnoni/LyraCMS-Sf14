<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseLyraContentType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('content_types');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('description', 'string', 4000, array(
             'type' => 'string',
             'length' => '4000',
             ));
        $this->hasColumn('db_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('module', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasMany('LyraCatalog as ContentTypeCatalogs', array(
             'refClass' => 'LyraContentTypeCatalog',
             'local' => 'ctype_id',
             'foreign' => 'catalog_id'));

        $this->hasMany('LyraContentTypeCatalog', array(
             'local' => 'id',
             'foreign' => 'ctype_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
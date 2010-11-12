<?php

/**
 * BaseLyraContentType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $model
 * @property string $module
 * @property string $plugin
 * @property string $item_slug
 * @property string $format
 * @property boolean $is_active
 * @property clob $params
 * @property Doctrine_Collection $ContentTypeCatalogs
 * @property Doctrine_Collection $Contents
 * @property Doctrine_Collection $ContentTypeRoutes
 * @property Doctrine_Collection $LyraContentTypeCatalog
 * @property Doctrine_Collection $LyraMenu
 * @property Doctrine_Collection $LyraPath
 * 
 * @method integer             getId()                     Returns the current record's "id" value
 * @method string              getType()                   Returns the current record's "type" value
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getDescription()            Returns the current record's "description" value
 * @method string              getModel()                  Returns the current record's "model" value
 * @method string              getModule()                 Returns the current record's "module" value
 * @method string              getPlugin()                 Returns the current record's "plugin" value
 * @method string              getItemSlug()               Returns the current record's "item_slug" value
 * @method string              getFormat()                 Returns the current record's "format" value
 * @method boolean             getIsActive()               Returns the current record's "is_active" value
 * @method clob                getParams()                 Returns the current record's "params" value
 * @method Doctrine_Collection getContentTypeCatalogs()    Returns the current record's "ContentTypeCatalogs" collection
 * @method Doctrine_Collection getContents()               Returns the current record's "Contents" collection
 * @method Doctrine_Collection getContentTypeRoutes()      Returns the current record's "ContentTypeRoutes" collection
 * @method Doctrine_Collection getLyraContentTypeCatalog() Returns the current record's "LyraContentTypeCatalog" collection
 * @method Doctrine_Collection getLyraMenu()               Returns the current record's "LyraMenu" collection
 * @method Doctrine_Collection getLyraPath()               Returns the current record's "LyraPath" collection
 * @method LyraContentType     setId()                     Sets the current record's "id" value
 * @method LyraContentType     setType()                   Sets the current record's "type" value
 * @method LyraContentType     setName()                   Sets the current record's "name" value
 * @method LyraContentType     setDescription()            Sets the current record's "description" value
 * @method LyraContentType     setModel()                  Sets the current record's "model" value
 * @method LyraContentType     setModule()                 Sets the current record's "module" value
 * @method LyraContentType     setPlugin()                 Sets the current record's "plugin" value
 * @method LyraContentType     setItemSlug()               Sets the current record's "item_slug" value
 * @method LyraContentType     setFormat()                 Sets the current record's "format" value
 * @method LyraContentType     setIsActive()               Sets the current record's "is_active" value
 * @method LyraContentType     setParams()                 Sets the current record's "params" value
 * @method LyraContentType     setContentTypeCatalogs()    Sets the current record's "ContentTypeCatalogs" collection
 * @method LyraContentType     setContents()               Sets the current record's "Contents" collection
 * @method LyraContentType     setContentTypeRoutes()      Sets the current record's "ContentTypeRoutes" collection
 * @method LyraContentType     setLyraContentTypeCatalog() Sets the current record's "LyraContentTypeCatalog" collection
 * @method LyraContentType     setLyraMenu()               Sets the current record's "LyraMenu" collection
 * @method LyraContentType     setLyraPath()               Sets the current record's "LyraPath" collection
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
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
             'length' => 4,
             ));
        $this->hasColumn('type', 'string', 80, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 80,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 4000, array(
             'type' => 'string',
             'length' => 4000,
             ));
        $this->hasColumn('model', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('module', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('plugin', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('item_slug', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('format', 'string', 4, array(
             'type' => 'string',
             'length' => 4,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('params', 'clob', null, array(
             'type' => 'clob',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('LyraCatalog as ContentTypeCatalogs', array(
             'refClass' => 'LyraContentTypeCatalog',
             'local' => 'ctype_id',
             'foreign' => 'catalog_id'));

        $this->hasMany('LyraContent as Contents', array(
             'local' => 'id',
             'foreign' => 'ctype_id'));

        $this->hasMany('LyraRoute as ContentTypeRoutes', array(
             'local' => 'id',
             'foreign' => 'ctype_id'));

        $this->hasMany('LyraContentTypeCatalog', array(
             'local' => 'id',
             'foreign' => 'ctype_id'));

        $this->hasMany('LyraMenu', array(
             'local' => 'id',
             'foreign' => 'ctype_id'));

        $this->hasMany('LyraPath', array(
             'local' => 'id',
             'foreign' => 'ctype_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
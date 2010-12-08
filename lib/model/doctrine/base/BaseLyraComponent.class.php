<?php

/**
 * BaseLyraComponent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $ctype_id
 * @property string $module
 * @property string $action
 * @property LyraContentType $ComponentContentType
 * @property Doctrine_Collection $ComponentRegions
 * @property Doctrine_Collection $LyraRegionComponent
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method integer             getCtypeId()              Returns the current record's "ctype_id" value
 * @method string              getModule()               Returns the current record's "module" value
 * @method string              getAction()               Returns the current record's "action" value
 * @method LyraContentType     getComponentContentType() Returns the current record's "ComponentContentType" value
 * @method Doctrine_Collection getComponentRegions()     Returns the current record's "ComponentRegions" collection
 * @method Doctrine_Collection getLyraRegionComponent()  Returns the current record's "LyraRegionComponent" collection
 * @method LyraComponent       setId()                   Sets the current record's "id" value
 * @method LyraComponent       setCtypeId()              Sets the current record's "ctype_id" value
 * @method LyraComponent       setModule()               Sets the current record's "module" value
 * @method LyraComponent       setAction()               Sets the current record's "action" value
 * @method LyraComponent       setComponentContentType() Sets the current record's "ComponentContentType" value
 * @method LyraComponent       setComponentRegions()     Sets the current record's "ComponentRegions" collection
 * @method LyraComponent       setLyraRegionComponent()  Sets the current record's "LyraRegionComponent" collection
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLyraComponent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('components');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('ctype_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('module', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('action', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LyraContentType as ComponentContentType', array(
             'local' => 'ctype_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('LyraRegion as ComponentRegions', array(
             'refClass' => 'LyraRegionComponent',
             'local' => 'component_id',
             'foreign' => 'region_id'));

        $this->hasMany('LyraRegionComponent', array(
             'local' => 'id',
             'foreign' => 'component_id'));
    }
}
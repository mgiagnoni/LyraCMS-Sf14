<?php

/**
 * BaseLyraRoute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $ctype_id
 * @property string $name
 * @property string $action
 * @property clob $params
 * @property LyraContentType $RouteContentType
 * 
 * @method integer         getId()               Returns the current record's "id" value
 * @method integer         getCtypeId()          Returns the current record's "ctype_id" value
 * @method string          getName()             Returns the current record's "name" value
 * @method string          getAction()           Returns the current record's "action" value
 * @method clob            getParams()           Returns the current record's "params" value
 * @method LyraContentType getRouteContentType() Returns the current record's "RouteContentType" value
 * @method LyraRoute       setId()               Sets the current record's "id" value
 * @method LyraRoute       setCtypeId()          Sets the current record's "ctype_id" value
 * @method LyraRoute       setName()             Sets the current record's "name" value
 * @method LyraRoute       setAction()           Sets the current record's "action" value
 * @method LyraRoute       setParams()           Sets the current record's "params" value
 * @method LyraRoute       setRouteContentType() Sets the current record's "RouteContentType" value
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id$
 */
abstract class BaseLyraRoute extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('routes');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('ctype_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('action', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
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
        $this->hasOne('LyraContentType as RouteContentType', array(
             'local' => 'ctype_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}
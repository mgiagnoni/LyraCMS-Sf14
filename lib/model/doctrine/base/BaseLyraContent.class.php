<?php

/**
 * BaseLyraContent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $ctype_id
 * @property string $path
 * @property clob $params
 * @property string $meta_title
 * @property string $meta_descr
 * @property string $meta_keys
 * @property string $meta_robots
 * @property LyraContentType $ContentType
 * 
 * @method integer         getCtypeId()     Returns the current record's "ctype_id" value
 * @method string          getPath()        Returns the current record's "path" value
 * @method clob            getParams()      Returns the current record's "params" value
 * @method string          getMetaTitle()   Returns the current record's "meta_title" value
 * @method string          getMetaDescr()   Returns the current record's "meta_descr" value
 * @method string          getMetaKeys()    Returns the current record's "meta_keys" value
 * @method string          getMetaRobots()  Returns the current record's "meta_robots" value
 * @method LyraContentType getContentType() Returns the current record's "ContentType" value
 * @method LyraContent     setCtypeId()     Sets the current record's "ctype_id" value
 * @method LyraContent     setPath()        Sets the current record's "path" value
 * @method LyraContent     setParams()      Sets the current record's "params" value
 * @method LyraContent     setMetaTitle()   Sets the current record's "meta_title" value
 * @method LyraContent     setMetaDescr()   Sets the current record's "meta_descr" value
 * @method LyraContent     setMetaKeys()    Sets the current record's "meta_keys" value
 * @method LyraContent     setMetaRobots()  Sets the current record's "meta_robots" value
 * @method LyraContent     setContentType() Sets the current record's "ContentType" value
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLyraContent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('lyra_content');
        $this->hasColumn('ctype_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('path', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('params', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('meta_title', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('meta_descr', 'string', 500, array(
             'type' => 'string',
             'length' => 500,
             ));
        $this->hasColumn('meta_keys', 'string', 500, array(
             'type' => 'string',
             'length' => 500,
             ));
        $this->hasColumn('meta_robots', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LyraContentType as ContentType', array(
             'local' => 'ctype_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}
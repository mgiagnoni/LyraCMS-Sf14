<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BasesfGuardPermission extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_permission');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'length' => '255',
             ));
        $this->hasColumn('description', 'string', 1000, array(
             'type' => 'string',
             'length' => '1000',
             ));
    }

    public function setUp()
    {
        $this->hasMany('sfGuardGroup as Groups', array(
             'refClass' => 'sfGuardGroupPermission',
             'local' => 'permission_id',
             'foreign' => 'group_id'));

        $this->hasMany('sfGuardGroupPermission', array(
             'local' => 'id',
             'foreign' => 'permission_id'));

        $this->hasMany('sfGuardUser as Users', array(
             'refClass' => 'sfGuardUserPermission',
             'local' => 'permission_id',
             'foreign' => 'user_id'));

        $this->hasMany('sfGuardUserPermission', array(
             'local' => 'id',
             'foreign' => 'permission_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
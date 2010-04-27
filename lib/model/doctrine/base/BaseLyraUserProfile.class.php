<?php

/**
 * BaseLyraUserProfile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property sfGuardUser $User
 * 
 * @method integer         getId()         Returns the current record's "id" value
 * @method integer         getUserId()     Returns the current record's "user_id" value
 * @method string          getFirstName()  Returns the current record's "first_name" value
 * @method string          getLastName()   Returns the current record's "last_name" value
 * @method string          getEmail()      Returns the current record's "email" value
 * @method sfGuardUser     getUser()       Returns the current record's "User" value
 * @method LyraUserProfile setId()         Sets the current record's "id" value
 * @method LyraUserProfile setUserId()     Sets the current record's "user_id" value
 * @method LyraUserProfile setFirstName()  Sets the current record's "first_name" value
 * @method LyraUserProfile setLastName()   Sets the current record's "last_name" value
 * @method LyraUserProfile setEmail()      Sets the current record's "email" value
 * @method LyraUserProfile setUser()       Sets the current record's "User" value
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLyraUserProfile extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('users');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('first_name', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('last_name', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('email', 'string', 150, array(
             'type' => 'string',
             'length' => 150,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}
<?php

/**
 * BaseLyraComment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $article_id
 * @property string $author_name
 * @property string $author_email
 * @property string $author_url
 * @property clob $content
 * @property boolean $is_active
 * @property integer $created_by
 * @property LyraArticle $CommentArticle
 * @property sfGuardUser $CommentCreatedBy
 * 
 * @method integer     getId()               Returns the current record's "id" value
 * @method integer     getArticleId()        Returns the current record's "article_id" value
 * @method string      getAuthorName()       Returns the current record's "author_name" value
 * @method string      getAuthorEmail()      Returns the current record's "author_email" value
 * @method string      getAuthorUrl()        Returns the current record's "author_url" value
 * @method clob        getContent()          Returns the current record's "content" value
 * @method boolean     getIsActive()         Returns the current record's "is_active" value
 * @method integer     getCreatedBy()        Returns the current record's "created_by" value
 * @method LyraArticle getCommentArticle()   Returns the current record's "CommentArticle" value
 * @method sfGuardUser getCommentCreatedBy() Returns the current record's "CommentCreatedBy" value
 * @method LyraComment setId()               Sets the current record's "id" value
 * @method LyraComment setArticleId()        Sets the current record's "article_id" value
 * @method LyraComment setAuthorName()       Sets the current record's "author_name" value
 * @method LyraComment setAuthorEmail()      Sets the current record's "author_email" value
 * @method LyraComment setAuthorUrl()        Sets the current record's "author_url" value
 * @method LyraComment setContent()          Sets the current record's "content" value
 * @method LyraComment setIsActive()         Sets the current record's "is_active" value
 * @method LyraComment setCreatedBy()        Sets the current record's "created_by" value
 * @method LyraComment setCommentArticle()   Sets the current record's "CommentArticle" value
 * @method LyraComment setCommentCreatedBy() Sets the current record's "CommentCreatedBy" value
 * 
 * @package    lyra
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLyraComment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('comments');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('article_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('author_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('author_email', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('author_url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('content', 'clob', 65532, array(
             'type' => 'clob',
             'notnull' => true,
             'length' => 65532,
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

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LyraArticle as CommentArticle', array(
             'local' => 'article_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as CommentCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
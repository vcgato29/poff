<?php

/**
 * BaseNew
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $url
 * @property integer $group_id
 * 
 * @method string  getName()     Returns the current record's "name" value
 * @method string  getUrl()      Returns the current record's "url" value
 * @method integer getGroupId()  Returns the current record's "group_id" value
 * @method New     setName()     Sets the current record's "name" value
 * @method New     setUrl()      Sets the current record's "url" value
 * @method New     setGroupId()  Sets the current record's "group_id" value
 * @property  $
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseNew extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('new');
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '50',
             ));
        $this->hasColumn('url', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '50',
             ));
        $this->hasColumn('group_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Newsgroup', array(
             'local' => 'group_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));
    }
}
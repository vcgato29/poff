<?php

/**
 * BaseProductComment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $product_id
 * @property string $name
 * @property string $message
 * @property string $ip
 * @property string $host
 * @property Product $Product
 * 
 * @method integer        getProductId()  Returns the current record's "product_id" value
 * @method string         getName()       Returns the current record's "name" value
 * @method string         getMessage()    Returns the current record's "message" value
 * @method string         getIp()         Returns the current record's "ip" value
 * @method string         getHost()       Returns the current record's "host" value
 * @method Product        getProduct()    Returns the current record's "Product" value
 * @method ProductComment setProductId()  Sets the current record's "product_id" value
 * @method ProductComment setName()       Sets the current record's "name" value
 * @method ProductComment setMessage()    Sets the current record's "message" value
 * @method ProductComment setIp()         Sets the current record's "ip" value
 * @method ProductComment setHost()       Sets the current record's "host" value
 * @method ProductComment setProduct()    Sets the current record's "Product" value
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProductComment extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product_comment');
        $this->hasColumn('product_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('message', 'string', 500, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 500,
             ));
        $this->hasColumn('ip', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('host', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Product', array(
             'local' => 'product_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
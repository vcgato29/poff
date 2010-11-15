<?php

/**
 * BaseProductFile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $file
 * @property integer $pri
 * @property string $original_filename
 * @property string $name
 * @property string $parameter
 * @property integer $product_id
 * @property Product $Product
 * 
 * @method string      getFile()              Returns the current record's "file" value
 * @method integer     getPri()               Returns the current record's "pri" value
 * @method string      getOriginalFilename()  Returns the current record's "original_filename" value
 * @method string      getName()              Returns the current record's "name" value
 * @method string      getParameter()         Returns the current record's "parameter" value
 * @method integer     getProductId()         Returns the current record's "product_id" value
 * @method Product     getProduct()           Returns the current record's "Product" value
 * @method ProductFile setFile()              Sets the current record's "file" value
 * @method ProductFile setPri()               Sets the current record's "pri" value
 * @method ProductFile setOriginalFilename()  Sets the current record's "original_filename" value
 * @method ProductFile setName()              Sets the current record's "name" value
 * @method ProductFile setParameter()         Sets the current record's "parameter" value
 * @method ProductFile setProductId()         Sets the current record's "product_id" value
 * @method ProductFile setProduct()           Sets the current record's "Product" value
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProductFile extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product_file');
        $this->hasColumn('file', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('pri', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('original_filename', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('parameter', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'default',
             'length' => 255,
             ));
        $this->hasColumn('product_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
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

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->actAs($i18n0);
    }
}
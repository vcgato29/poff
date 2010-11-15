<?php

/**
 * BaseParameterProductOption
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $option_id
 * @property integer $product_id
 * @property float $priceadd
 * @property ParameterOption $ParameterOption
 * @property Product $Product
 * 
 * @method integer                getOptionId()        Returns the current record's "option_id" value
 * @method integer                getProductId()       Returns the current record's "product_id" value
 * @method float                  getPriceadd()        Returns the current record's "priceadd" value
 * @method ParameterOption        getParameterOption() Returns the current record's "ParameterOption" value
 * @method Product                getProduct()         Returns the current record's "Product" value
 * @method ParameterProductOption setOptionId()        Sets the current record's "option_id" value
 * @method ParameterProductOption setProductId()       Sets the current record's "product_id" value
 * @method ParameterProductOption setPriceadd()        Sets the current record's "priceadd" value
 * @method ParameterProductOption setParameterOption() Sets the current record's "ParameterOption" value
 * @method ParameterProductOption setProduct()         Sets the current record's "Product" value
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseParameterProductOption extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('parameter_product_option');
        $this->hasColumn('option_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('product_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('priceadd', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ParameterOption', array(
             'local' => 'option_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));

        $this->hasOne('Product', array(
             'local' => 'product_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));
    }
}
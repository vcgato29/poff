<?php

/**
 * BaseProductVsProduct
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $product1
 * @property integer $product2
 * 
 * @method integer          getProduct1() Returns the current record's "product1" value
 * @method integer          getProduct2() Returns the current record's "product2" value
 * @method ProductVsProduct setProduct1() Sets the current record's "product1" value
 * @method ProductVsProduct setProduct2() Sets the current record's "product2" value
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProductVsProduct extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product_vs_product');
        $this->hasColumn('product1', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('product2', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}
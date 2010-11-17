<?php

/**
 * BaseProduct
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property string $code
 * @property string $slug
 * @property string $original_title
 * @property string $producer
 * @property string $trailer_link
 * @property string $country
 * @property clob $synopsis
 * @property string $producer_description
 * @property string $critics
 * @property string $language
 * @property string $type
 * @property string $parameter
 * @property string $name
 * @property integer $year
 * @property integer $pri
 * @property integer $rating_sum
 * @property integer $rating_votes
 * @property float $price
 * @property string $description
 * @property boolean $is_active
 * @property Doctrine_Collection $ConnectedProducts
 * @property Doctrine_Collection $ParameterOptions
 * @property Doctrine_Collection $BannerGroups
 * @property Doctrine_Collection $ProductGroups
 * @property Doctrine_Collection $ProductPictures
 * @property Doctrine_Collection $ProductFiles
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $Exemplars
 * @property Doctrine_Collection $ProductOrder
 * @property Doctrine_Collection $ProductOrderVsProduct
 * @property Doctrine_Collection $OrederedItems
 * @property Doctrine_Collection $ParameterProductValues
 * @property Doctrine_Collection $ParameterProductOptions
 *
 * @method string              getCode()                    Returns the current record's "code" value
 * @method string              getSlug()                    Returns the current record's "slug" value
 * @method string              getOriginalTitle()           Returns the current record's "original_title" value
 * @method string              getProducer()                Returns the current record's "producer" value
 * @method string              getTrailerLink()             Returns the current record's "trailer_link" value
 * @method string              getCountry()                 Returns the current record's "country" value
 * @method clob                getSynopsis()                Returns the current record's "synopsis" value
 * @method string              getProducerDescription()     Returns the current record's "producer_description" value
 * @method string              getCritics()                 Returns the current record's "critics" value
 * @method string              getLanguage()                Returns the current record's "language" value
 * @method string              getType()                    Returns the current record's "type" value
 * @method string              getParameter()               Returns the current record's "parameter" value
 * @method string              getName()                    Returns the current record's "name" value
 * @method integer             getYear()                    Returns the current record's "year" value
 * @method integer             getPri()                     Returns the current record's "pri" value
 * @method integer             getRatingSum()               Returns the current record's "rating_sum" value
 * @method integer             getRatingVotes()             Returns the current record's "rating_votes" value
 * @method float               getPrice()                   Returns the current record's "price" value
 * @method string              getDescription()             Returns the current record's "description" value
 * @method boolean             getIsActive()                Returns the current record's "is_active" value
 * @method Doctrine_Collection getConnectedProducts()       Returns the current record's "ConnectedProducts" collection
 * @method Doctrine_Collection getParameterOptions()        Returns the current record's "ParameterOptions" collection
 * @method Doctrine_Collection getBannerGroups()            Returns the current record's "BannerGroups" collection
 * @method Doctrine_Collection getProductGroups()           Returns the current record's "ProductGroups" collection
 * @method Doctrine_Collection getProductPictures()         Returns the current record's "ProductPictures" collection
 * @method Doctrine_Collection getProductFiles()            Returns the current record's "ProductFiles" collection
 * @method Doctrine_Collection getComments()                Returns the current record's "Comments" collection
 * @method Doctrine_Collection getExemplars()               Returns the current record's "Exemplars" collection
 * @method Doctrine_Collection getProductOrder()            Returns the current record's "ProductOrder" collection
 * @method Doctrine_Collection getProductOrderVsProduct()   Returns the current record's "ProductOrderVsProduct" collection
 * @method Doctrine_Collection getOrederedItems()           Returns the current record's "OrederedItems" collection
 * @method Doctrine_Collection getParameterProductValues()  Returns the current record's "ParameterProductValues" collection
 * @method Doctrine_Collection getParameterProductOptions() Returns the current record's "ParameterProductOptions" collection
 * @method Product             setCode()                    Sets the current record's "code" value
 * @method Product             setSlug()                    Sets the current record's "slug" value
 * @method Product             setOriginalTitle()           Sets the current record's "original_title" value
 * @method Product             setProducer()                Sets the current record's "producer" value
 * @method Product             setTrailerLink()             Sets the current record's "trailer_link" value
 * @method Product             setCountry()                 Sets the current record's "country" value
 * @method Product             setSynopsis()                Sets the current record's "synopsis" value
 * @method Product             setProducerDescription()     Sets the current record's "producer_description" value
 * @method Product             setCritics()                 Sets the current record's "critics" value
 * @method Product             setLanguage()                Sets the current record's "language" value
 * @method Product             setType()                    Sets the current record's "type" value
 * @method Product             setParameter()               Sets the current record's "parameter" value
 * @method Product             setName()                    Sets the current record's "name" value
 * @method Product             setYear()                    Sets the current record's "year" value
 * @method Product             setPri()                     Sets the current record's "pri" value
 * @method Product             setRatingSum()               Sets the current record's "rating_sum" value
 * @method Product             setRatingVotes()             Sets the current record's "rating_votes" value
 * @method Product             setPrice()                   Sets the current record's "price" value
 * @method Product             setDescription()             Sets the current record's "description" value
 * @method Product             setIsActive()                Sets the current record's "is_active" value
 * @method Product             setConnectedProducts()       Sets the current record's "ConnectedProducts" collection
 * @method Product             setParameterOptions()        Sets the current record's "ParameterOptions" collection
 * @method Product             setBannerGroups()            Sets the current record's "BannerGroups" collection
 * @method Product             setProductGroups()           Sets the current record's "ProductGroups" collection
 * @method Product             setProductPictures()         Sets the current record's "ProductPictures" collection
 * @method Product             setProductFiles()            Sets the current record's "ProductFiles" collection
 * @method Product             setComments()                Sets the current record's "Comments" collection
 * @method Product             setExemplars()               Sets the current record's "Exemplars" collection
 * @method Product             setProductOrder()            Sets the current record's "ProductOrder" collection
 * @method Product             setProductOrderVsProduct()   Sets the current record's "ProductOrderVsProduct" collection
 * @method Product             setOrederedItems()           Sets the current record's "OrederedItems" collection
 * @method Product             setParameterProductValues()  Sets the current record's "ParameterProductValues" collection
 * @method Product             setParameterProductOptions() Sets the current record's "ParameterProductOptions" collection
 *
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProduct extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product');
        $this->hasColumn('code', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 255,
             ));
        $this->hasColumn('original_title', 'string', 400, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 400,
             ));
        $this->hasColumn('producer', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('trailer_link', 'string', 400, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 400,
             ));
        $this->hasColumn('country', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('synopsis', 'clob', null, array(
             'type' => 'clob',
             'notnull' => false,
             ));
        $this->hasColumn('producer_description', 'string', 70000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 70000,
             ));
        $this->hasColumn('director_bio', 'string', 700, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 700,
             ));
        $this->hasColumn('critics', 'string', 700, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 700,
             ));
        $this->hasColumn('language', 'string', 700, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 700,
             ));
        $this->hasColumn('type', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('parameter', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'default' => 'default',
             'length' => 255,
             ));
        $this->hasColumn('name', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('pri', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 100,
             ));
        $this->hasColumn('rating_sum', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 5,
             ));
        $this->hasColumn('rating_votes', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('price', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('description', 'string', 600000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 600000,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));

        $this->hasColumn('eventival_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('director_name', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('director_filmography', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('cast', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('writer', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('music', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('editor', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('production', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('world_sales', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('distributor', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('operator', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('runtime', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('webpage', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));
        $this->hasColumn('festivals', 'string', 1000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 1000,
             ));

        $this->index('myindex', array(
             'fields' =>
             array(
              0 => 'pri',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Product as ConnectedProducts', array(
             'refClass' => 'ProductVsProduct',
             'local' => 'product1',
             'foreign' => 'product2',
             'equal' => true));

        $this->hasMany('ParameterOption as ParameterOptions', array(
             'refClass' => 'ParameterProductOption',
             'local' => 'product_id',
             'foreign' => 'option_id'));

        $this->hasMany('BannerGroupVsProduct as BannerGroups', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductVsProductGroup as ProductGroups', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductPictures', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductFile as ProductFiles', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductComment as Comments', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductExemplar as Exemplars', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductOrder', array(
             'refClass' => 'ProductOrderVsProduct',
             'local' => 'product_id',
             'foreign' => 'order_id'));

        $this->hasMany('ProductOrderVsProduct', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ProductOrderItem as OrederedItems', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ParameterProductValue as ParameterProductValues', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $this->hasMany('ParameterProductOption as ParameterProductOptions', array(
             'local' => 'id',
             'foreign' => 'product_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' =>
             array(
              0 => 'name',
              1 => 'description',
              2 => 'slug',
              3 => 'synopsis',
              4 => 'producer_description',
              5 => 'critics',
              6 => 'language',
              7 => 'country',
              8 => 'director_bio',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $userid0 = new Doctrine_Template_Userid(array(
             'created' =>
             array(
              'name' => 'created_by',
              'type' => 'integer',
             ),
             'updated' =>
             array(
              'name' => 'updated_by',
              'type' => 'integer',
             ),
             ));
        $this->actAs($i18n0);
        $this->actAs($timestampable0);
        $this->actAs($userid0);
    }
}
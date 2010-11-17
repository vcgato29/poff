<?php

/**
 * BaseTransUnitVariable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $variable
 * @property boolean $multilang
 * @property Doctrine_Collection $Variables
 * 
 * @method string              getVariable()  Returns the current record's "variable" value
 * @method boolean             getMultilang() Returns the current record's "multilang" value
 * @method Doctrine_Collection getVariables() Returns the current record's "Variables" collection
 * @method TransUnitVariable   setVariable()  Sets the current record's "variable" value
 * @method TransUnitVariable   setMultilang() Sets the current record's "multilang" value
 * @method TransUnitVariable   setVariables() Sets the current record's "Variables" collection
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseTransUnitVariable extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('trans_unit_variable');
        $this->hasColumn('variable', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => '255',
             ));
        $this->hasColumn('multilang', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('TransUnit as Variables', array(
             'local' => 'id',
             'foreign' => 'variable_id'));
    }
}
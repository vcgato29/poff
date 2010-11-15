<?php

/**
 * BaseBannerGroupVsStructure
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $banner_group_id
 * @property integer $structure_id
 * @property BannerGroup $BannerGroup
 * @property Structure $Structure
 * 
 * @method integer                getBannerGroupId()   Returns the current record's "banner_group_id" value
 * @method integer                getStructureId()     Returns the current record's "structure_id" value
 * @method BannerGroup            getBannerGroup()     Returns the current record's "BannerGroup" value
 * @method Structure              getStructure()       Returns the current record's "Structure" value
 * @method BannerGroupVsStructure setBannerGroupId()   Sets the current record's "banner_group_id" value
 * @method BannerGroupVsStructure setStructureId()     Sets the current record's "structure_id" value
 * @method BannerGroupVsStructure setBannerGroup()     Sets the current record's "BannerGroup" value
 * @method BannerGroupVsStructure setStructure()       Sets the current record's "Structure" value
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseBannerGroupVsStructure extends BaseDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('banner_group_vs_structure');
        $this->hasColumn('banner_group_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('structure_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BannerGroup', array(
             'local' => 'banner_group_id',
             'foreign' => 'id'));

        $this->hasOne('Structure', array(
             'local' => 'structure_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE',
             'onUpdate' => 'CASCADE'));
    }
}
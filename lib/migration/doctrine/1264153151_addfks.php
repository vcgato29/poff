<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addfks extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('jobeet_category_affiliate', 'jobeet_category_affiliate_category_id_jobeet_category_id', array(
             'name' => 'jobeet_category_affiliate_category_id_jobeet_category_id',
             'local' => 'category_id',
             'foreign' => 'id',
             'foreignTable' => 'jobeet_category',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('jobeet_category_affiliate', 'jobeet_category_affiliate_affiliate_id_jobeet_affiliate_id', array(
             'name' => 'jobeet_category_affiliate_affiliate_id_jobeet_affiliate_id',
             'local' => 'affiliate_id',
             'foreign' => 'id',
             'foreignTable' => 'jobeet_affiliate',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('jobeet_job', 'jobeet_job_category_id_jobeet_category_id', array(
             'name' => 'jobeet_job_category_id_jobeet_category_id',
             'local' => 'category_id',
             'foreign' => 'id',
             'foreignTable' => 'jobeet_category',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('jobeet_category_affiliate', 'jobeet_category_affiliate_category_id_jobeet_category_id');
        $this->dropForeignKey('jobeet_category_affiliate', 'jobeet_category_affiliate_affiliate_id_jobeet_affiliate_id');
        $this->dropForeignKey('jobeet_job', 'jobeet_job_category_id_jobeet_category_id');
    }
}
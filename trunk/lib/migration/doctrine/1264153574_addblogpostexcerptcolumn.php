<?php

class Addblogpostexcerptcolumn extends Doctrine_Migration_Base
{
   public function up()
    {
      $this->addColumn('jobeet_category', 'specparam', 'string', array('length' => '255'));
    }
 
    public function down()
    {
      $this->removeColumn('jobeet_category', 'specparam');
    }
	
}

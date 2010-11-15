<?php 

 class BaseDoctrineRecord extends sfDoctrineRecord
  {
    /**
     *
     * @param bool $deep
     * @return BaseDoctrineRecord
     */
    public function copy($deep = false)
    {
      $ret = parent::copy(false);
      if (!$deep)
        return $ret;

      // ensure to have loaded all references (unlike Doctrine_Record)
      foreach ($this->getTable()->getRelations() as $name => $relation){
      	
        if (empty($this->$name) && $name != 'StructureIndex' )
          $this->loadReference($name);
      }
	
      //exit;
      // copy the record itself and the references as well
      foreach ($this->getReferences() as $key => $value)
      {
        if ($value instanceof Doctrine_Collection)
        {
          foreach ($value as $record)
            $ret->{$key}[] = $record->copy($deep);
        }
        /*
         * This would duplicate parent records as well, I don't want this to happen!!!
         *
        else if ($value instanceof Doctrine_Record)
        {
          $ret->set($key, $value->copy($deep));
        }
        */
      }
      return $ret;
    }
  }

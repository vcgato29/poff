<?php

class CSIComponents extends myComponents
{
  public function executeRender(){
    $this->node = $this->getRoute()->getObject();

  }
}
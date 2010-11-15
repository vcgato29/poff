<?php
class articleComponents extends myComponents
{
  public function executeRender()
  {
  	
  	
		$this->node = $this->getObject();
		$this->content = $this->node->content;
		$this->title = $this->node->pageTitle;
		$this->type = $this->node->parameter;	
		$this->layout = $this->node->layout;
		$this->nodeTitle = $this->node->pageTitle;
  }
  
  public function executeLeftMenu(){
  	$this->articles = $this->getQuery()->execute();
  }
  
  public function getLangNode(){
  	if( !$this->langNode )
  		$this->langNode = Doctrine::getTable('Structure')->getLangNode( $this->getObject()->getLang() ); 
  	
  	return $this->langNode;
  }
  
  public function getQuery(){
  	return Doctrine::getTable('Structure')->createQuery('ba')->from('Structure s')
		->innerJoin('s.Structure ch')
		->where('s.parentid = ?', $this->getLangNode()->getId())
		->andWhere('ch.parentid = s.id')
		->andWhere('s.isHidden = ?', 0)
		->andWhere('ch.isHidden = ?', 0)
		->setHydrationMode( Doctrine::HYDRATE_RECORD_HIERARCHY );
  }
  
  
}
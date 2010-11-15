<?php
require_once dirname(__FILE__).'/../../headerMenu/actions/components.class.php';
require_once dirname(__FILE__).'/../lib/ArticleLeftMenuHelper.class.php';

class articlesLeftMenuWidgetComponents extends headerMenuComponents
{

  # renders second and third level of menu
  public function executeRender(){

  	# view helper
  	$this->helper = $this->getHelper();

	# currently active nodes
	$this->activeNodes = $this->getActiveMenuItemsIDs();

	# menu hierarchia starting from second level
	$this->secondLevelMenuItems = $this->getSecondLevelMenuItems();

	# redirect if current node is empty
	if($this->redirectToNextItem() && $this->getRoute()->getObject()->getNode()->hasChildren()){
		foreach($this->getRoute()->getObject()->getNode()->getChildren() as $child){
			if(!$child['isHidden']){
				$link =  $this->controller->getComponent('linker', 'articleLinkBuilder',
				    			array( 'node' => $child ) );
				$this->getAction()->redirect($link);
			}
		}
	}

  }

  protected function getSecondLevelMenuItems(){
  	$structHierarchia = $this->getNodes()->toArray();

  	if( isset( $structHierarchia[$this->getRoute()->getStructureOfLevel(2)->getId()] ) ){
		if( !empty( $structHierarchia[$this->getRoute()->getStructureOfLevel(2)->getId()]['__children'] ) ){
			 $secondLevel = $structHierarchia[$this->getRoute()->getStructureOfLevel(2)->getId()]['__children'];
		}
	}

	if($secondLevel){
		$firstLevel = $this->getRoute()->getStructureOfLevel(2);
	  	foreach( $secondLevel as $index => &$node ){

                 if($this->helper->hiddenNode($node)){
                     unset($secondLevel[$index]);
                     continue;
                 }

                // second level menu item link
		$node['link'] = $this->controller->getComponent('linker', 'articleLinkBuilder',
				    			array( 'params' => array('p0' => $node['lang'], 'p1' => $firstLevel['slug'], 'p2' => $node['slug'] ) ) );

		if( in_array($node['id'], $this->activeNodes) ){
			if( !empty($node['__children']) )
				foreach( $node['__children'] as &$subNode ){ // third level menu item link
					$subNode['link'] = $this->controller->getComponent('linker', 'articleLinkBuilder',
						    			array( 'params' => array('p0' => $node['lang'], 'p1' => $firstLevel['slug'], 'p2' => $node['slug'], 'p3' => $subNode['slug'] ) ) );
				}
		}
	}


	}

	return $secondLevel;

  }

  protected function getHelper(){
  	return new ArticleLeftMenuHelper();
  }

  protected function getCurrentStructureNode(){
  	return $this->getRoute()->getObject();
  }

  protected function getActiveMenuItemsIDs(){
  	$z = $this->getCurrentStructureNode()->getNode()->getAncestors()->getPrimaryKeys();
  	$z[] = $this->getCurrentStructureNode()->getId();
  	return $z;
  }

  protected function redirectToNextItem(){
  	return !$this->getRoute()->getObject()->getContent();
  }

  protected function activeItem(){
  	return $this->getCurrentStructureNode();
  }

}
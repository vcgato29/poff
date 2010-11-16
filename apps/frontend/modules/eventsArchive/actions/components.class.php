<?php
require_once dirname(__FILE__).'/../../eventsSchedule/actions/components.class.php';
require_once dirname(__FILE__).'/../../rightMenuArchiveWidget/lib/RightMenuArchiveHelper.class.php';

class eventsArchiveComponents extends eventsScheduleComponents{

	public function executeRender(){

		$this->fillSlotsBeforeRender();
		return parent::executeRender();
		
	}

	public function getHelper(){
		return new RightMenuArchiveHelper();
	}

	protected function  fillSlotsBeforeRender() {
		$this->getAction()->getComponent('rightMenuArchiveWidget', 'render');


//		print_r($this->getAction()->getRoute()->getObject()->getParent()->toArray());
//		exit;

		$this->getAction()->getPartial('eventsArchive/hooaeg', array(
					'hooajad' => $this->getHelper()->getItemChildren(
							$this->getAction()->getRoute()->getObject()->getParent(), array()),
					'node' => $this->getAction()->getRoute()->getObject(),
					'section' => $this->getSection()
						)
		);
	}

}
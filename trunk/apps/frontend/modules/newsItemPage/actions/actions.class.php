<?php

class newsItemPageActions extends myFrontendAction{


    public function executeIndex(sfWebRequest $request){
		$this->setLayout('layout_widgets_off');

		$this->new = $this->getRoute()->getNewsItemObject();
    }

	
	public function executeArchive(sfWebRequest $request){
		
	}

	public function executePrintView(sfWebRequest $request){
		$this->setLayout(false);
		$this->new = $this->getRoute()->getNewsItemObject();
	}


}
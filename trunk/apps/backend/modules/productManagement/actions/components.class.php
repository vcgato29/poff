<?php 
class productManagementComponents extends sfComponents
{
	public function executePopuptabs(){
		
		$this->tabs = array(
				'Information' => array( 'route' => '@product_management_edit?id=' . $this->getRequestParameter('id'),
												'action' => 'edit',
												'selected' => $this->getRequestParameter('action') == 'edit' ),

				'Pictures' => array( 'route' => '@admin_page?module=productManagement&action=productpics&id=' . $this->getRequestParameter('id'),
												'action' => 'productpics',
												'selected' => $this->getRequestParameter('action') == 'productpics' ),
			
		   		'Common parameters' => array( 'route' => '@admin_page?module=productManagement&action=parameters&multilang=0&id=' . $this->getRequestParameter('id'),
															'action' => 'parameters',
															'selected' => $this->getRequestParameter('action') == 'parameters' &&
																$this->getRequestParameter('multilang') == 0 ),
				'Parameters (transl)' => array( 'route' => '@admin_page?module=productManagement&multilang=1&action=parametersLanguageSelect&id=' . $this->getRequestParameter('id'),
															'action' => 'parameters',
															'selected' =>
							( $this->getRequestParameter('action') == 'parameters' &&
								$this->getRequestParameter('multilang') == 1 ) || $this->getRequestParameter('action') == 'parametersLanguageSelect' ),
		);
	}
}
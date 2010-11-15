<?php 
class productComponents extends sfComponents
{
	public function executePopuptabs(){
		
		$this->tabs = array( 	'Information' => array( 'route' => '@product_edit?id=' . $this->getRequestParameter('id'),
												'action' => 'edit',
												'selected' => $this->getRequestParameter('action') == 'edit' ),
		
								'Pictures' => array( 'route' => '@admin_page?module=product&action=productpics&id=' . $this->getRequestParameter('id'),
												'action' => 'productpics',
												'selected' => $this->getRequestParameter('action') == 'productpics' ),

								'Files' => array( 'route' => '@admin_page?module=product_file&action=index&id=' . $this->getRequestParameter('id'),
												'action' => 'index',
												'selected' => $this->getRequestParameter('action') == 'index' && $this->getRequestParameter('module') == 'product_file'  ),
		
		
								'Comments' => array( 'route' => '@admin_page?module=product&action=productComments&id=' . $this->getRequestParameter('id'),
														 'action' => 'productComments',
														 'selected' => $this->getRequestParameter('action') == 'productComments' ),
		
								'Common parameters' => array( 'route' => '@admin_page?module=product&action=parameters&multilang=0&id=' . $this->getRequestParameter('id'),
															'action' => 'parameters',
															'selected' => $this->getRequestParameter('action') == 'parameters' &&
																$this->getRequestParameter('multilang') == 0 ),

								'Parameters (transl)' => array( 'route' => '@admin_page?module=product&multilang=1&action=parametersLanguageSelect&id=' . $this->getRequestParameter('id'),
															'action' => 'parameters',
															'selected' => 
				( $this->getRequestParameter('action') == 'parameters' && 
							$this->getRequestParameter('multilang') == 1 ) || $this->getRequestParameter('action') == 'parametersLanguageSelect' ),
		);
	}
}
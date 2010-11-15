<?php

require_once dirname(__FILE__).'/../lib/ordersGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ordersGeneratorHelper.class.php';

/**
 * orders actions.
 *
 * @package    jobeet
 * @subpackage orders
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ordersActions extends autoOrdersActions
{
	
	public function executeBatchArchive( sfWebRequest $request ){
		$ids = array_merge( $request->getParameter('ids'), array(-1) );
		
		$orders = Doctrine::getTable('ProductOrder')->createQuery()
			->select('po.*')
			->from('ProductOrder po')
			->whereIn('po.id', $ids)
			->execute();
			
		foreach( $orders as $order ){
			$order->setIsArchived( !$order->getIsArchived() );
			$order->save();	
		}
		
	}
	
	
	public function executeInvoice( $request ){
		$order = $this->getRoute()->getObject();
		
		if(!file_exists($order->getInvoiceAbsolutePath('pdf'))){ 
			// init invoice generation task
			$arguments = array('orderID' => $order['id'] );
			$options = array('host' => $request->getHost(), 'culture' => $this->getUser()->getCulture(), 'application' => 'backend');
			
			$invoiceGenTask = new sfInvoiceGenerationTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
			chdir(sfConfig::get('sf_root_dir')); // hack to start task from Action
			$invoiceGenTask->run($arguments, $options);
		}
		
		// We'll be outputting a PDF
		header('Content-type: application/pdf');
		
		// It will be called
		header('Content-Disposition: attachment; filename="' . $order->getInvoiceFilename('pdf') . '"');
		
		// The PDF source
		readfile($order->getInvoiceAbsolutePath('pdf'));
		
		return sfView::NONE;
	}
	
}

<?php

class sfInvoiceGenerationActions extends sfActions
{

	public function preExecute(){
		$this->setLayout(false); # to provice pure invoice HTML code
	}
	
	
	public function executePdf( sfWebRequest $request ){
		// TODO: authenticate
		
		// render invoice HTML
		$htmlString = $this->getPartial('sfInvoiceGeneration/invoice', array('order' => $this->getOrder()));
		
		// convert HTML string to PDF string
		//echo $htmlString;
		$pdfString = $this->convertHTML2PDF( $htmlString );
		
		// send to PDF string to user
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$this->getInvoiceFilename().'"');
		echo $pdfString;
		
		return sfVIEW::NONE;
	}
	
	
	protected function convertHTML2PDF( $html ){
		# invoice relative and absolute paths
		$relativeInvoicePath = sfConfig::get('app_sfInvoiceGenerationPlugin_invoice_dir') . $this->getInvoiceFilename('html');
		$absoluteInvoicePath = sfConfig::get('sf_web_dir') . '/' . $relativeInvoicePath;
		
		# put html in file
		file_put_contents($absoluteInvoicePath, $html);
		
		# assign $site variable
		$site = $this->getRequest()->getHost() . '/' . $relativeInvoicePath;
//		echo $site;
//		exit;

		
		# ask html2pdf converter to convert HTML to PDF
		$url = "http://" . $this->getRequest()->getHost() . "/html2pdf/demo/html2ps.php?process_mode=single&URL=".$site."&proxy=&pixels=1024&scalepoints=1&renderimages=1&renderlinks=1&renderfields=1&media=Letter&cssmedia=Screen&leftmargin=30&rightmargin=15&topmargin=15&bottommargin=15&encoding=&headerhtml=&footerhtml=&watermarkhtml=&toc-location=before&smartpagebreak=1&pslevel=3&method=fpdf&pdfversion=1.3&output=0&convert=Convert+File";
		
		return file_get_contents($url);
		
	}
	
	protected function getInvoiceFilename( $ext = 'pdf' ){
		return 'invoice_' . $this->getOrder()->getOrderNumber() . '.' . $ext; 
	}
	
	protected function getOrder(){
		return Doctrine::getTable('ProductOrder')->find( $this->getRequest()->getParameter('id') );
	}
}
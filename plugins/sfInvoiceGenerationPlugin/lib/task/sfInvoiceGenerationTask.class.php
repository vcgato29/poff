<?php

class sfInvoiceGenerationTask extends sfBaseTask
{
	
	protected $i18n = false;
	
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('orderID', sfCommandArgument::REQUIRED, 'order identificator'),
      //new sfCommandArgument('filename', sfCommandArgument::REQUIRED, 'invoice filename'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('culture', null, sfCommandOption::PARAMETER_REQUIRED, 'The culture', 'en'),
      new sfCommandOption('host', null, sfCommandOption::PARAMETER_REQUIRED, 'Current host'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace = 'invoice';
    $this->name = 'generate-invoice';
    $this->briefDescription = 'generate PDF invoice from ProductOrder object';

    $this->detailedDescription = <<<EOF
		todo
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
  	
  		# setup
    	$databaseManager = new sfDatabaseManager($this->configuration);	// databaseManager
    	$context = sfContext::createInstance($this->configuration);
    	$this->logSection('invoice', 'Enviroment initialized');
    
		# render invoice HTML
		$this->logSection('invoice', sprintf('Starting HTML generation for order ID:%s', $this->getOrder()->getId()));
		
		$htmlString = 	$context
							->getController()
							->getAction('sfInvoiceGeneration','pdf')
							->getPartial('sfInvoiceGeneration/invoice', array( 'order' => $this->getOrder(), 'i18n' => $this->getI18N(), 'basketCheckedOut' => BasketCheckedOut::getInstance($this->getOrder()->getId()) ) );
							
		$this->logSection('invoice', sprintf('invoice HTML generated for order ID:%s', $this->getOrder()->getId()));

		# convert HTML string to PDF string
		$this->logSection('invoice', sprintf('Starting HTML2PDF conversion for order ID:%s', $this->getOrder()->getId()));
		$pdfString = $this->convertHTML2PDF( $htmlString );
		$this->logSection('invoice', sprintf('PDF generated for order ID:%s', $this->getOrder()->getId()));
    	
		# PDF file saving
		$this->logSection('invoice', sprintf('PDF file saving for order ID:%s', $this->getOrder()->getId()));
		file_put_contents( $this->getInvoiceAbsolutePath('pdf'), $pdfString );
		$this->logSection('invoice', sprintf('PDF file saved (%s) for order ID:%s', $this->getInvoiceAbsolutePath('pdf') ,$this->getOrder()->getId()));
  }
  
  
	protected function convertHTML2PDF( $html ){
		# put html in file
		file_put_contents($this->getInvoiceAbsolutePath('html'), $html);
		$this->logSection('invoice', sprintf('HTML file saved (%s) for order ID:%s', $this->getInvoiceAbsolutePath('html') ,$this->getOrder()->getId()));
		
		# assign $site variable
		$site = urlencode( $this->getHost()  . '/' . $this->getInvoiceRelativePath('html'));
		$this->logSection('invoice', sprintf('generating URL for HTML file - %s', $site ));
		
		# ask html2pdf converter to convert HTML to PDF
		$url = "http://" . $this->getHost()  .  "/html2pdf/demo/html2ps.php?process_mode=single&URL=".$site."&proxy=&pixels=1024&scalepoints=1&renderimages=1&renderlinks=1&renderfields=1&media=Letter&cssmedia=Screen&leftmargin=0&rightmargin=0&topmargin=0&bottommargin=0&encoding=utf-8&headerhtml=&footerhtml=&watermarkhtml=&toc-location=before&smartpagebreak=1&pslevel=3&method=fpdf&pdfversion=1.3&output=0&convert=Convert+File";

		$this->logSection('invoice', sprintf('PDF content saving'));
		return file_get_contents($url);
	}
	
	
  protected function getInvoiceRelativePath( $ext ){
	return $this->getOrder()->getInvoiceRelativePath($ext);
  }
  
  protected function getInvoiceAbsolutePath( $ext ){
  	return $this->getOrder()->getInvoiceAbsolutePath($ext);
  }
	
	protected function getInvoiceFilename( $ext = 'pdf' ){
		return $this->getOrder()->getInvoiceFilename($ext); 
	}
	
	protected function getHost(){
		return $this->commandManager->getOptionValue('host');
	}
	
	protected function getOrder(){
		return Doctrine::getTable('ProductOrder')->find( $this->commandManager->getArgumentValue('orderID') );
	}
	
	protected function getI18N()
	{
	  if (!$this->i18n)
	  {
	    $config = sfFactoryConfigHandler::getConfiguration($this->configuration->getConfigPaths('config/factories.yml'));
	    $class  = $config['i18n']['class'];
	 
	    $this->i18n = new $class($this->configuration, null, $config['i18n']['param']);
	  }
	 
	  $this->i18n->setCulture($this->commandManager->getOptionValue('culture'));
	 
	  return $this->i18n;
	}
	
	protected function process(sfCommandManager $commandManager, $options)
	{
	  parent::process($commandManager, $options);
	  $this->commandManager = $commandManager;
	}
	
	

}
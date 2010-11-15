<?php

class sfInvoiceMailerTask extends sfBaseTask
{
	
	protected $i18n = false;
	
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('host', sfCommandArgument::REQUIRED, 'current host'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('culture', null, sfCommandOption::PARAMETER_REQUIRED, 'The culture', 'en'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace = 'invoice';
    $this->name = 'mail-invoices';
    $this->briefDescription = 'mail invoices';

    $this->detailedDescription = <<<EOF
		todo
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array()){
  		# setup
    	$databaseManager = new sfDatabaseManager($this->configuration);	// databaseManager
    	$context = sfContext::createInstance($this->configuration);
    	sfProjectConfiguration::getActive()->loadHelpers(array('Variable'));
    	
    	$this->logSection('mailer', 'Enviroment initialized');
    	
    	# find ProductOrders with "invoice_mailed = false"
    	$this->logSection('mailer', 'Fetching ProductOrders');
    	$q = Doctrine::getTable('ProductOrder')->createQuery('')
    			->from('ProductOrder po')
    			->where('po.invoice_mailed = ?', false)
    			->andWhere('po.status = ?', ProductOrderTable::STATUS_PAID)
    			->limit(2);
    			
    	$orders = $q->execute();
    	
    	if($orders->count() > 0){
	    	foreach($orders as $order){
	    		# generate invoice
	    		if(!file_exists($order->getInvoiceAbsolutePath('pdf'))){
	    			$this->logSection('mailer', sprintf('generating invoice for order ID:%s', $order['id']));
					$this->commandApplication->getTask('invoice:generate-invoice')->run(array('orderID' => $order['id']), 
							array('culture' => $order['user_culture'], 'host' => $this->commandManager->getArgumentValue('host')));
					$this->logSection('mailer', sprintf('invoice generated for order ID:%s', $order['id']));
	    		}else{
	    			$this->logSection('mailer', sprintf('invoice already generated for order ID:%s', $order['id']));
	    		}
	    		
	    		# send invoice
	    		$this->logSection('mailer', sprintf('composing email for order ID:%s', $order['id']));
				$message = $this->getMailer()->compose(
				  array(variable('invoicer email', 'aneto1@gmail.com') => 'FAYE' ),
						$order->BillingAddress['email'],
						$this->getI18N($order['user_culture'])->__('Faye.ee invoice'),
						$this->getI18N($order['user_culture'])->__('Faye invoice'));
	
				$this->logSection('mailer', sprintf('attaching PDF file (%s) to email for order ID:%s', $order->getInvoiceAbsolutePath('pdf') ,$order['id']));
				$message->attach(Swift_Attachment::fromPath($order->getInvoiceAbsolutePath('pdf')));
				$this->getMailer()->send($message);
				$this->logSection('mailer', sprintf('email sent for order ID:%s',$order['id']));
	    		
				
				# change status
				$this->logSection('mailer', sprintf('order ID:%s status changed to invoice_mailed ID:%s',$order['id'], $order['id'])); 
				$order->setInvoiceMailed(true);
				$order->save();
	    	}
    	}else{
    		$this->logSection('mailer', 'ProductOrders not found');
    	}
    	
  }
  
	protected function getI18N($culture = 'en'){
	  if (!$this->i18n)
	  {
	    $config = sfFactoryConfigHandler::getConfiguration($this->configuration->getConfigPaths('config/factories.yml'));
	    $class  = $config['i18n']['class'];
	 
	    $this->i18n = new $class($this->configuration, null, $config['i18n']['param']);
	  }
	 
	  $this->i18n->setCulture($culture);
	 
	  return $this->i18n;
	}
	
	protected function process(sfCommandManager $commandManager, $options){
	  parent::process($commandManager, $options);
	  $this->commandManager = $commandManager;
	}
	
	

}
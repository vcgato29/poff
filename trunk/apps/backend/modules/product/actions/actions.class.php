<?php
require_once dirname(__FILE__).'/../lib/actions.class.php';
require_once dirname(__FILE__).'/../lib/productGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productGeneratorHelper.class.php';



/**
 * product actions.
 *
 * @package    jobeet
 * @subpackage product
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productActions extends autoProductActions
{


	public function executeIndex(sfWebRequest $request){
		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.list', array()));
	    parent::executeIndex($request);
	}
	public function executeNew( sfWebRequest $request )
	{
		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.new', array()));
		$this->setLayout( 'popuplayout' );
		parent::executeNew($request);
	}
	
	

	
	
	public function executeCreate( sfWebRequest $request )
	{
		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.create', array()));

		$this->setLayout( 'popuplayout' );
		parent::executeCreate( $request ); 
	}
	
	
	public function executeEdit( sfWebRequest $request )
	{

		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.edit', array('product' => $this->getRoute()->getObject())));
		
		$this->setLayout( 'popuplayout' );
		$this->product = $this->getRoute()->getObject();
		
    	$this->form = $this->configuration->getForm($this->product);
	}
	
	
	public function executeUpdate( sfWebRequest $request )
	{

		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.update', array('product' => $this->getRoute()->getObject())));
		
	    $this->product = $this->getRoute()->getObject();
		$this->form = $this->configuration->getForm($this->product);
		
	    $this->processForm($request, $this->form);
	    
		$this->setLayout( 'popuplayout' );
	    $this->setTemplate('edit');
	}
	
	
	// method used by SWFupload
	public function executeSwfupload( sfWebRequest $request )
	{
		
		$this->form = new ProductPicturesForm(array(),array(),false); # disabled "_csrf_token"
		$this->form->processForm( $this, $request );
		
		
		exit('done');	# "Complete" status in SWFuploader
		//exit;
	}
	
	
	public function executeProductpics( sfWebRequest $request )
	{

		$this->setLayout( 'popuplayout' );
		$this->product = Doctrine::getTable('Product')->find( $request->getParameter('id') );

		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.pics.edit', array('product' => $this->product)));
		
		$this->productPictures = Doctrine::getTable('Product')->createQuery('pics')
			->from('ProductPictures as pp')
			->innerJoin('pp.Product p WITH p.id = ?', $request->getParameter('id'))
			->orderBy('pp.pri asc')
			->execute();
			
		$this->form = new ProductPicturesContainerForm( $this->product );
	}
	
	public function executeProductpicspriority( sfWebRequest $request )
	{
		
		switch( $request->getParameter('order') ){
			case 'up':
				Doctrine::getTable('ProductPictures')->increasePriority( $request->getParameter('id') );
				break;
			case 'down':
				Doctrine::getTable('ProductPictures')->decreasePriority( $request->getParameter('id') );
				break;
		}
		
		$this->redirect( $request->getReferer() );
	}
	
	public function executeProductpicsupdate( sfWebRequest $request )
	{
		$this->setLayout( 'popuplayout' );

		$this->product = Doctrine::getTable('Product')->find( $request->getParameter('id'));

		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.pics.edit', array('product' => $this->product)));

		$this->form = new ProductPicturesContainerForm( $this->product   );
		$this->form->processForm( $this, $request );
		
		if( $request->hasParameter('deletepics') )
			foreach( $request->getParameter('deletepics') as $picId ){
				Doctrine::getTable('ProductPictures')->find($picId)->delete();
			}
		
		$this->redirect( $request->getReferer() );
	}
	

	
	
	public function executeParameters( sfWebRequest $request )
	{

		$this->setLayout( 'popuplayout' );
		$this->product = Doctrine::getTable('Product')->find( $request->getParameter('id') );

		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.parameters.edit', array('product' => $this->product)));
		
		# contains all PARAMETER VALUE forms as embeded ones
		$this->form = new ProductParametersContainerForm( $this->product );

		
		if( $request->getParameter('multilang') ){
			$this->langs = $this->getUser()->getAttribute('product.parameters.langs');
			$this->form->setLangs( $this->langs );
		}
		
		 # getting all Product parameters ( multilang or not )
		 $this->form->setParams( Doctrine::getTable('Product')
									->getProductParameters( $request->getParameter('id'), $request->getParameter('multilang') ) );
									


		# re-configuring form
		$this->form->configure();

	}
	
	public function executeParametersUpdate( sfWebRequest $request )
	{
		$this->setLayout( 'popuplayout' );
		$this->setTemplate( 'parameters' );

		$this->product = Doctrine::getTable('Product')->find( $request->getParameter('id') );
		
		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.parameters.edit', array('product' => $this->product)));
		
		
		$this->form = new ProductParametersContainerForm( $this->product );
		
		if( $request->getParameter('multilang') ){
			$this->langs = $this->getUser()->getAttribute('product.parameters.langs');
			$this->form->setLangs( $this->langs );
		}
		
		 $this->form->setParams( Doctrine::getTable('Product')
			->getProductParameters( $request->getParameter('id'), $request->getParameter('multilang') ) );

			
		$this->form->configure();
		
		
		$this->form->processForm( $this, $request );
		
	}
	
	
	
	public function executeParametersLanguageSelect( sfWebRequest $request )
	{
		$this->setLayout( 'popuplayout' );
		
		
		
		switch( $request->getMethod() ){
			case sfWebRequest::GET:
				$this->langs = Doctrine::getTable('Language')->findAll();
				break;
			case sfWebRequest::POST:
				
				$this->getUser()->setAttribute( 'product.parameters.langs', 	Doctrine::getTable('Language')->createQuery()
																				->select('l.*')
																				->from('Language l')
																				->whereIn('id', $request->getParameter('langs') )
																				->execute()->toArray() );
																				
				$this->redirect( $this->getModuleName().'/parameters?id=' . $request->getParameter('id') . '&multilang=1' );

				break;
		}
		
		
		
	}
	
	public function executeDeleteConnectedProduct( $request )
	{

		$this->product = Doctrine::getTable('Product')->find( $request->getParameter('id') );
		$this->context->getEventDispatcher()->notify(new sfEvent($this, 'product.connected.edit', array('product' => $this->product)));
		
		Doctrine::getTable('Product')->find( $request->getParameter('id') )
			->unlink( 'ConnectedProducts', array( $request->getParameter('conprod') ), true );
		
		$this->redirect( $request->getReferer() );
	}
	
	
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
	
    if ( (!$ids = $request->getParameter('ids')) && $request->getParameter('batch_action') != 'batchPriority'  )
    {

      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@product');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@product');
    }
    


    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {

      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }
    


    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }
    
    

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Product'));
    try
    {

      // validate ids
      if( $ids )
      	$ids = $validator->clean($ids);
    
		
      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@product');
  }
  
  public function executeBatchPriority( sfWebRequest $request )
  {
  	
  	foreach( $request->getParameter('product_pri') as $prodID => $prodPri ){

  		$prod = Doctrine::getTable('Product')->find($prodID); 
  		$prod->setPri( $prodPri );
  		$prod->save();	
  	}	
  	
  	
  	$this->redirect( $request->getReferer() );
  }
  
  
  
  
	public function executeProductComments( sfWebRequest $request ){
		$this->setLayout( 'popuplayout' );
		
		$this->comments = Doctrine::getTable('Product')
							->find( $request->getParameter('id') )
							->Comments;
							
	}
	
	public function executeProductCommentDelete($request){
		Doctrine::getTable('ProductComment')
							->find( $request->getParameter('commID') )
							->delete();
							
		$this->redirect( $request->getReferer() );
	}


	public function executeCopyProduct($request){
	    $product = $this->getRoute()->getObject();

	    # copy product main information
	    $newProduct = $product->copy();
	    $newProduct['code'] = $product['code'] . '_new_' . rand(1,100000);

	    ## copy product Translations
	    $transArr = $product->Translation->toArray();
	    foreach($transArr as $index => &$transVal)
		unset($transVal['id']);

	    $newProduct->Translation->fromArray($transArr);
	    
	    $newProduct->save();


	    
	    # copy product connections with ProductGroups
	    foreach($product->ProductGroups as $prodGroup){
		$rel = new ProductVsProductGroup();
		$rel['group_id'] = $prodGroup['group_id'];
		$rel['product_id'] = $newProduct['id'];
		$rel->save();
	    }

	    # copy product connections with ParameterProductOptions
	    foreach($product->ParameterProductOptions as $prodGroup){
		$rel = new ParameterProductOption();
		$rel['option_id'] = $prodGroup['option_id'];
		$rel['product_id'] = $newProduct['id'];
		$rel->save();
	    }

	    # copy product connections with ParameterProductValues and their Translations
	    foreach($product->ParameterProductValues as $prodValue){
		$rel = new ParameterProductValue();
		$arr = $prodValue->toArray();
		$arr['Translation'] = $prodValue->Translation->toArray();
		foreach($arr['Translation'] as $lang => &$transArr)
		    unset($transArr['id']);
		unset($arr['id']);

		$rel->fromArray($arr);
		$rel['product_id'] = $newProduct['id'];
		$rel->save();
	    }
	    

	    $this->redirect(array('sf_route' => $this->helper->getEditRoute(), 'sf_subject' => $newProduct));
	}

	

	

	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
	$this->dispatcher->connect('admin.save_object', array('productActions', 'listenToProductSaved'));
	parent::processForm($request, $form);  		
  }
  
  static public function listenToProductSaved( sfEvent $event )
  {
	$event['object']->updateProductGroupConnections( $event->getSubject()->getRequestParameter('connections') );

	$arr = array();
	foreach( explode( ',', $event->getSubject()->getRequestParameter('connected_products') ) as $conProd )
		if( $prod = Doctrine::getTable('Product')->findOneByCode( $conProd ) )
			$arr[] = $prod->getId();


	$event['object']->link( 'ConnectedProducts', $arr, true );
  }
	
}

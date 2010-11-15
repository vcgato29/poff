<?php

require_once dirname(__FILE__).'/../lib/translationsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/translationsGeneratorHelper.class.php';

/**
 * translations actions.
 *
 * @package    jobeet
 * @subpackage translations
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class translationsActions extends autoTranslationsActions
{
	
	public function preExecute(){
		parent::preExecute();
		
		$this->langs = $this->getAllLanguages();
		$this->activeLangs = $this->getActiveLanguages();
	}
	
	public function executeIndex(sfWebRequest $request){
		parent::executeIndex($request);
		
		$this->quickForm = new TranslationForm(array(), array());
		foreach($this->getPager()->getResults() as $item){
			$this->quickForm->embedTransUnitQuickTranslation($item['source'], $this->activeLangs);
		}

 
		
		
		
	}
	
	public function executeBatchSetLanguages(sfWebRequest $request){
		
		$this->getUser()->setAttribute('translations.langs', $request->getParameter('selected_langs'));
		$this->redirect($request->getReferer());
	}
	
	public function executeBatchSave(sfWebRequest $request){
		$this->quickForm = new TranslationForm();
		
		$sources = array_unique($request->getParameter('curtransunit'));
		foreach($sources as $source)
			$this->quickForm->embedTransUnitQuickTranslation($source, $this->activeLangs);
		
		
		$bindArray = $request->getParameter($this->quickForm->getName());
		$this->quickForm->bind($bindArray);
		
		
		if($this->quickForm->isValid()){
			
			foreach($this->quickForm->getEmbeddedForms() as $index => $embForm){
				$embForm->bind($bindArray[$index]);
				
				if($embForm->isValid()){
					$embForm->save();
				}else{
					echo $embForm->getErrorSchema();
				}
			}
			
			$this->getUser()->setFlash('notice', 'Items have been saved successfully.');
		}else{
			echo $this->quickForm->getErrorSchema();
		}

		$this->clearCache();
	}
	
	public function executeUpdate(sfWebRequest $request){
		$this->clearCache();
		return parent::executeUpdate($request);
	}
	
	public function executeDelete(sfWebRequest $request){
		$vars = Doctrine::getTable('TransUnit')->createQuery()
					->from('TransUnit tu')
					->where('tu.source = ?', $this->getRoute()->getObject()->getSource() )
					->andWhere('tu.variable_id IS NULL')->execute();
					

		$this->getUser()->setFlash('notice', 'Translation deleted.');
		$vars->delete();
		$this->redirect($request->getReferer());
	}
	
	public function executeCreate(sfWebRequest $request){
		$params = $request->getParameter($this->configuration->getForm()->getName());
		$vars = Doctrine::getTable('TransUnit')->createQuery()
					->from('TransUnit tu')
					->where('tu.source = ?', $params['source'] )
					->andWhere('tu.variable_id IS NULL')->execute();
					
		if($vars->count() > 0){
			$this->redirect(array('sf_route' => 'trans_unit_edit', 'sf_subject' => $vars->getFirst()));
		}else{
			return parent::executeCreate($request);
		}
		
	}
	
	
  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    
    if (!($ids = $request->getParameter('ids')) && $request->getParameter('batch_action') != 'batchSave' && $request->getParameter('batch_action') != 'batchSetLanguages' )
    {
    	
    
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@trans_unit');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@trans_unit');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'TransUnit'));
    try
    {
      // validate ids
      //$ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@trans_unit');
  }
	
	
  
   protected function getActiveLanguages(){
   		return $this->getUser()->getAttribute('translations.langs') ? $this->getUser()->getAttribute('translations.langs') : $this->helper->getDefaultLanguages();
   }
   
   protected function getAllLanguages(){
   	$form = new TranslationForm();
   	 return $form->getLangs();
   }
	protected function buildQuery(){
		$q = parent::buildQuery();
		$q->andWhere('variable_id IS NULL');
		return $q->groupBy('source');
	}
	
	protected function clearCache(){
		 sfToolkit::clearDirectory( sfConfig::get( 'sf_cache_dir' )  );
	}
}

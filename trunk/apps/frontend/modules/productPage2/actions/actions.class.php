<?php
require_once dirname(__FILE__).'/../lib/ProductPageHelper.class.php';

class productPageActions extends myFrontendAction{


        private $addActions = array( array('title' => 'Info', 'action' => 'index'),
                                     array('title' => 'Gallery', 'action' => 'gallery'),
                                     array('title' => 'Files', 'action' => 'files'));
        

	public function preExecute(){
		parent::preExecute();


		$this->helper = new ProductPageHelper();
		$this->configuration = new productPageConfiguration();

		$this->setLayout('layout_widgets_off');
		
		$this->product = $this->getRoute()->getProductObject();
		$this->category = $this->getRoute()->getCategoryObject();

		$this->additionalActions = $this->addActions;
	}


	/* product page */
	public function executeIndex(sfWebRequest $request){
		# show comment submitting form or not ?
                $this->parameters = $this->parseProductParameters();
	}


        public function executePrintView(sfWebRequest $request){

            $this->setLayout(false);
            $this->parameters = $this->parseProductParameters();
        }


        public function executeGallery(sfWebRequest $request){
		$this->pictures = $this->parseProductPictures();
        }

        
        public  function executeFiles(sfWebRequest $request){
            $this->files = $this->parseProductFiles();
        }

		public function executeCalc(sfWebRequest $request){
			$this->form = $this->configuration->getCalculatorForm();

			$this->data = $this->configuration->getCalculatorData();

			
		}


		public function executeCalcSubmit(sfWebRequest $request){
			$this->setLayout(false);

			$this->form = $this->configuration->getCalculatorForm();

			$this->form->bind($request->getParameter($this->form->getName()));

			if($this->form->isValid()){
				return $this->renderPartial('productPage/calculatorResponse',
						array(
							'helper' => $this->helper,
							'values' => $this->form->getValues()
						)
				);
			}else{
				return $this->renderPartial('productPage/calculatorResponseError',
						array(

						)
				);
			}
			
		


		}

        public function executeParamArticle(sfWebRequest $request){
            $this->param = Doctrine::getTable('ParameterProductValue')->find($request->getParameter('id'));
        }


        private function parseProductFiles(){
            return Doctrine::getTable('Product')->createQuery()
                                                            ->from('ProductFile pf')
                                                            ->innerJoin('pf.Product p WITH p.id = ?', $this->product['id'])
                                                            ->innerJoin('pf.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                                            ->where("t.name != ''")
                                                            ->orderBy('pf.pri')
                                                            ->execute();
        }

        private function parseProductPictures(){
            return Doctrine::getTable('Product')->createQuery()
                                                            ->from('ProductPictures pp')
                                                            ->innerJoin('pp.Product p WITH p.id = ?', $this->product['id'])
                                                            ->leftJoin('pp.Translation t')
                                                            ->orderBy('pp.pri')
                                                            ->execute();
        }

        private function parseProductParameters(){
            return $this->helper->getProductParameters($this->product);
        }
	  
}
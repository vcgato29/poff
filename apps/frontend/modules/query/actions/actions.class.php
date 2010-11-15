<?php

class queryActions extends myFrontendAction{

    public function preExecute(){
        parent::preExecute();

        $this->setLayout('layout_widgets_off');
        $this->configuration = new queryConfiguration();

		$this->helper = new queryHelper();
    }


	###############
	# INDEX FORM  #
	###############

	public function executePureIndex(sfWebRequest $request){
		DataHolder::clear();

		$this->redirect($this->helper->link('simple'));
	}


	###############
	# SIMPLE FORM #
	###############

    public function executeSimple(sfWebRequest $request){

		if(!$this->getRoute()->getProductObject()){
			$this->setLayout ('layout_query');
			$this->setTemplate ('index');
		}

		$this->product = $this->getRoute()->getProductObject();

        $this->form = $this->configuration->getSimpleContactForm();

        $processor = new ContactFormRequestProcessor($this->getUser(),
            $this->configuration->getSimpleContactForm(), $this->getRequest());


        foreach($processor->getSavedFormValues() as $var => $val){
            $this->form->setDefault($var, $val);
        }


		$this->attachments = DataHolder::getInstance('attachments')->getSavedFormValues();


        
    }
    

    public function executeProcessContactForm(sfWebRequest $request){
        $this->setLayout(false);
        sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
        
        
        $processor = new ContactFormRequestProcessor($this->getUser(),
                $this->configuration->getSimpleContactForm(), $this->getRequest());

        try{
            $processor->processForm();
        }catch(QueryInputException $e){
            $this->renderPartial('global/json', array('item' =>
                array(  'code' => 500,
                        'errors' => $processor->getErrors())
                ));

            return sfView::NONE;
        }


		$this->postSubmitActions();

        $this->renderPartial('global/json', array('item' => array('code' => 200,
                'message' => __('Täname teid! Päring on edukalt edastatud'),
                'link' => '#') ));
        
        return sfView::NONE;

    }

    public function executeProcessContactFormAndNext(sfWebRequest $request){
        $this->setLayout(false);

        $processor = new ContactFormRequestProcessor($this->getUser(),
                $this->configuration->getSimpleContactForm(), $this->getRequest());


        if(!$processor->validateForm()){
            $this->renderPartial('global/json', array('item' =>
                array(  'code' => 500,
                        'errors' => $processor->getErrors())
                ));

            return sfView::NONE;
        }


        $processor->saveFormValues();
        
        $this->renderPartial('global/json', array('item' => array('code' => 301,
                'link' => $this->helper->link('dimensions') ) ) );
        return sfView::NONE;
    }



	###################
	# ATTACH PICTURES #
	###################

    public function executeAttachPictures(sfWebRequest $request){
        $this->setLayout(false);

        $this->form = $this->configuration->getFileAttachmentsForm();

    }


    public function executeAttachPicturesSubmit(sfWebRequest $request){
        $this->setLayout(false);

        $this->form = $this->configuration->getFileAttachmentsForm();

        $processor = new AttachmentsFormRequestProcessor($this->getUser(),
                $this->form, $this->getRequest());

		
        
        
        if($processor->processForm()){
            $processor->saveFormValues();
			
            $this->files = DataHolder::getInstance('attachments')->getSavedFormValues();

            $this->setTemplate('filesUploaded');
        }else{
            $this->getUSer()->setFlash('attachmentNotice', 'piltide üleslaadimine ebaõnnestus, proovige uuesti');
            $this->executeAttachPictures($request);
            $this->setTemplate('attachPictures');
        }
        

    }



	##############
	# DIMENSIONS #
	##############

    public function executeDimensions(sfWebRequest $request){
        $this->setLayout('layout_query');


        $data = DataHolder::getInstance('dimensions')->getSavedFormValues();

        
        $this->data = $this->configuration->getDimensionsInfo();
        $this->activeElementIndex = isset($data['katuse tüüp']) && $data['katuse tüüp']  ? $data['katuse tüüp'] : 0; // start from 0
        $this->form = $this->configuration->getDimensionsForm($this->activeElementIndex);
        $this->form->setDefaults($data);
        

    }


    public function executeGetRoofInfo(){
        $this->setLayout(false);


        $data = $this->configuration->getDimensionsInfo();
        $schema = '';
        $formHTML = '';


        foreach($data as $index => $info){
            if($index == $this->getRequestParameter('roofID')){
                $schema = $info['big_picture_url'];
                $form = $this->configuration->getDimensionsForm($index);
                $formHTML = $this->getPartial('query/dimensionFieldsForm', array('form' => $form));
            }
        }
        
        
        $this->renderPartial('global/json', array('item' => array(
                    'schema' => $schema,
                    'formHTML' => $formHTML
                ) ) );
        return sfView::NONE;
    }


    public function executeDimensionsSubmit(sfWebRequest $request){
        $this->setLayout(false);

        $processor = new DimensionsFormRequestProcessor($this->getUser(),
                $this->configuration->getDimensionsForm($request->getParameter('roofID')), $this->getRequest());



        if(!$processor->validateForm()){
            print_r($processor->getErrors());
        }

        $processor->processForm();

        $processor->saveFormValues();

		$this->redirect($this->helper->link('profile'));

    }



    #############
    #  PROFILE  #
    #############


    public function executeProfile(){
        $this->setLayout('layout_query');
		
        $this->data = $this->configuration->getProfilesInfo();

        $this->form = $this->configuration->getProfilesForm();
		$this->form->setDefaults( // retrieve saved info
					DataHolder::getInstance('profiles')->getSavedFormValues());
        
    }


	public function executeProfilesSubmit(){
		$this->setLayout(false);

        $processor = new ProfilesFormRequestProcessor($this->getUser(),
                $this->configuration->getProfilesForm(), $this->getRequest());

		
        if(!$processor->validateForm()){
            print_r($processor->getErrors());
        }

        $processor->processForm();
        $processor->saveFormValues();

		$this->redirect($this->helper->link('products'));
	}



	##############
    #  PRODUCTS  #
    ##############

	public function executeProducts(){
		$this->setLayout('layout_query');


        $this->product = $this->getRoute()->getProductObject();
        $this->category = $this->getRoute()->getCategoryObject();

		$this->form = $this->configuration->getProductsForm();

		$this->productGroups = array();

		$this->data = DataHolder::getInstance('products')->getSavedFormValues();

		$prodQuery = Doctrine::getTable('ProductGroup')->createQuery('asd')
				->select('pg.*, t.*')
				->from('ProductGroup pg')
				->innerJoin('pg.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
				->where('pg.parameter = ?', 'on_query_page')
				->orderBy('pg.lft asc');

		foreach($prodQuery->execute() as $group){


			$q = Doctrine::getTable('Product')->addProductTranslationJoin($group->getAssociatedProductsQuery());
			$q = Doctrine::getTable('Product')->addProductPicturesJoin($q);
			$this->productGroups[$group['name']] = $q->execute();
		}


	}


	public function executeProductsSubmit(sfWebRequest $request){
		$this->setLayout(false);

        $processor = new ProductsFormRequestProcessor($this->getUser(),
                $this->configuration->getProductsForm(), $this->getRequest());


        if(!$processor->validateForm()){
            print_r($processor->getErrors());
        }




        $processor->processForm();
        $processor->saveFormValues();

		$this->redirect($this->helper->link('simple'));
	}



	##################
	# PDF GENERATION #
    ##################

	protected function postSubmitActions(){


		# generate HTML content from submitted data


		$prods = DataHolder::getInstance('products')->getSavedFormValues();
		$prods = isset($prods['valitud tooted']) ? $prods['valitud tooted'] : array(-1);



		$htmlContent =
			$this->getPartial('query/pdfView', array(
				'contact' => DataHolder::getInstance('contact')->getSavedFormValues(),
				'dimensions' => DataHolder::getInstance('dimensions')->getSavedFormValues(),
				'profiles' => DataHolder::getInstance('profiles')->getSavedFormValues(),
				'attachments' => DataHolder::getInstance('attachments')->getSavedFormValues(),
				'configuration' => $this->configuration,
				'products' => array(
						'savedValues' =>  DataHolder::getInstance('products')->getSavedFormValues(),
						'products' => Doctrine::getTable('Product')->createQuery()->from('Product')->whereIn('id',$prods)->execute()
				)
		));

//				echo $htmlContent;
//		exit;


		# create TMP HTML file
		$absoluteInvoicePath = tempnam(sfConfig::get('sf_web_dir') . '/queries', 'query_') . '.html';
		@mkdir(dirname($absoluteInvoicePath),0777,true);

		// put html in file
		file_put_contents($absoluteInvoicePath, $htmlContent);


		# generate pdf file
		$site = $this->getRequest()->getHost() . '/queries/' . basename($absoluteInvoicePath);


		# ask html2pdf converter to convert HTML to PDF
		$url = "http://" . $this->getRequest()->getHost() . "/html2pdf/demo/html2ps.php?process_mode=single&URL=".$site."&proxy=&pixels=1024&scalepoints=1&renderimages=1&renderlinks=1&renderfields=1&media=Letter&cssmedia=Screen&leftmargin=30&rightmargin=15&topmargin=15&bottommargin=15&encoding=&headerhtml=&footerhtml=&watermarkhtml=&toc-location=before&smartpagebreak=1&pslevel=3&method=fpdf&pdfversion=1.3&output=0&convert=Convert+File";
		$pdfContent = file_get_contents($url);

		# mail PDF fail to site admin and user
		sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Variable'));

		//send site administrator an email of query
		$this->sendMail(variable('system email','aneto1@gmail.com'), $pdfContent);
		
		// send user email if he wants it
		if(DataHolder::getInstance('contact')->sendCopyToUser())
			$this->sendMail(DataHolder::getInstance('contact')->getUserEmail(), $pdfContent);

	}


	protected function sendMail($mail, $pdfContent){
		$message = $this->getMailer()->compose(
		  array( variable('system email','aneto1@gmail.com') => 'Olly'),
		  $mail,
			__('Olly.ee hinnapäring'),
			__('Olly.ee hinnapäringu koopia manuses')
		);


		$message->attach(new Swift_Attachment(
		  $pdfContent, "hinnaparing.pdf", "application/pdf")
		);

		$this->getMailer()->send($message);
	}
	
	
}

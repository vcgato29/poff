<?php

class ImportEventivalXMLTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'ImportEventivalXML';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [ImportEventivalXML|INFO] task does things.
Call it with:

  [php symfony ImportEventivalXML|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

	$request = new FetchEventivalXMLWebRequest(array('url' =>'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/sections.xml'));
	$xmlObj = $request->send();
	$xmlObj->requestType = 'Sections';
	$xmlObj->mapObjects();

	//$request = new FetchEventivalXMLWebRequest(array('url' =>'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/cinemas.xml'));
	//$xmlObj = $request->send();
	//$xmlObj->requestType = 'Cinema';
	//$xmlObj->mapObjects();

	$request = new FetchEventivalXMLWebRequest(array('url' =>'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/10/publications-locked.xml'));
	$xmlObj = $request->send();
	$xmlObj->requestType = 'Films';
	$xmlObj->mapObjects();

	$request = new FetchEventivalXMLWebRequest(array('url' =>'http://www.eventival.eu/poff/14/en/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/categories/9/publications-locked.xml'));
	$xmlObj = $request->send();
	$xmlObj->requestType = 'Films';
	$xmlObj->mapObjects();

	//$request = new FetchEventivalXMLWebRequest(array('url' =>'http://www.eventival.eu/poff/14/et/ws/2ae44138cee5011f9cd2d474f11bfbd9/films/screenings.xml'));
	//$xmlObj = $request->send();
	//$xmlObj->requestType = 'Screenings';
	//$xmlObj->mapObjects();
  }
}

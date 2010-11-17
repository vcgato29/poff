<?php
set_time_limit(0);
ini_set("max_execution_time",0);

class ImportADXmlTask extends sfBaseTask
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
      new sfCommandOption('cinema', null, sfCommandOption::PARAMETER_NONE, 'Import OR Update Cinema & Cinema Halls'),
	  new sfCommandOption('section', null, sfCommandOption::PARAMETER_NONE, 'Import OR Update Section (Product Group)'),
	  new sfCommandOption('film', null, sfCommandOption::PARAMETER_NONE, 'Import OR Update Film (ProductFilm & ProductPackageFilm)'),
	  new sfCommandOption('package', null, sfCommandOption::PARAMETER_NONE, 'Import OR Update Package (ProductPackage)'),
	  new sfCommandOption('screening', null, sfCommandOption::PARAMETER_NONE, 'Import OR Update Screening'),
	  new sfCommandOption('all', null, sfCommandOption::PARAMETER_NONE, 'Import OR Update All info (not recommended)'),
		));

    $this->namespace        = '';
    $this->name             = 'ImportADXml';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [ImportADXml|INFO] task does things.
Call it with:

  [php symfony ImportADXml|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
	if ($options['cinema']) {
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::CINEMAS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::CINEMA);
		$xmlObj->mapCinemas();
	} else if ($options['section']) {
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::SECTIONS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::SECTION);
		$xmlObj->mapSections();
	} else if ($options['film']) {
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::FILMS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::FILM);
		$xmlObj->mapFilms();
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::FILMS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::FILM);
		$xmlObj->mapFilms();
	} else if ($options['package']) {
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::PACKAGES_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::PACKAGE);
		$xmlObj->mapPackages();
	} else if ($options['screening']) {
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::SCREENINGS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::SCREENING);
		$xmlObj->mapScreenings();
	} else if ($options['all']) {
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::CINEMAS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::CINEMA);
		$xmlObj->mapCinemas();
		sleep(1);
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::SECTIONS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::SECTION);
		$xmlObj->mapSections();
		sleep(1);
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::FILMS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::FILM);
		$xmlObj->mapFilms();
		sleep(1);
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::PACKAGES_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::PACKAGE);
		$xmlObj->mapPackages();
		sleep(1);
		$request = new FetchAdXmlRequest(FetchAdXmlRequest::SCREENINGS_URL);
		$xmlObj = $request->send(FetchAdXmlRequest::SCREENING);
		$xmlObj->mapScreenings();
	}
	echo 'Task succesfully completed';
  }
}

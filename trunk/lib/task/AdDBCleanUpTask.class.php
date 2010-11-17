<?php

class AdDBCleanUpTask extends sfBaseTask
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
    $this->name             = 'AdDBCleanUp';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [AdDBCleanUp|INFO] task does things.
Call it with:

  [php symfony AdDBCleanUp|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

	$cleanDb = new ADCleanDBRequest(ADCleanDBRequest::CINEMAS_URL);
	$cleanDb->send();
	$cleanDb->cleanCinemasTables();
	sleep(1);
	$cleanDb = new ADCleanDBRequest(ADCleanDBRequest::SECTIONS_URL);
	$cleanDb->send();
	$cleanDb->cleanSectionsTables();
	sleep(1);
	$cleanDb = new ADCleanDBRequest(ADCleanDBRequest::FILMS_URL);
	$cleanDb->send();
	$cleanDb->cleanFilmsTables();
	sleep(1);
	$cleanDb = new ADCleanDBRequest(ADCleanDBRequest::PACKAGES_URL);
	$cleanDb->send();
	$cleanDb->cleanPackagesTables();
	sleep(1);
	$cleanDb = new ADCleanDBRequest(ADCleanDBRequest::SCREENINGS_URL);
	$cleanDb->send();
	$cleanDb->cleanScreeningsTables();

	echo 'DB clean up succesful';
  }
}

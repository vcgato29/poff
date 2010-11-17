<?php

class PiletileviXmlSyncTask extends sfBaseTask
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
    $this->name             = 'PiletileviXmlSync';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [PiletileviXmlSync|INFO] task does things.
Call it with:

  [php symfony PiletileviXmlSync|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

	$request = new FetchAdXmlRequest(FetchAdXmlRequest::PILETILEVI_URL);
	$piletileviArray = $request->send()->getResponseArray();
	$concertsArr = array();
	foreach($piletileviArray['concerts']['concert'] as $index => $concert) {
		$concertsArr[$index]['code'] = substr($concert['title'], 0, strpos($concert['title'], " /"));
		$concertsArr[$index]['piletilevi_id'] = $concert['id'];
		$concertsArr[$index]['availability'] = $concert['status'];
		if ((@is_array($concert['deliveries']['zebra']))) {
			$concertsArr[$index]['web_sales'] = 1;
		} else {
			$concertsArr[$index]['web_sales'] = 0;
		}
	}
	$screenings = ScreeningTable::getScreeningsForSync()->fetchArray();
	foreach($screenings as $screening) {
		foreach($concertsArr as $concert) {
			if ($concert['code'] == $screening['code']) {
				$obj = Doctrine_Query::create()
						->select('data.*')
						->from('Screening' . ' data')
						->where('id = ?', $screening['id'])
						->fetchOne();
				$obj->synchronizeWithArray($concert);
				$obj->save();
				break;
			}
		}
	}
	echo 'Sync succesful';
  }
}

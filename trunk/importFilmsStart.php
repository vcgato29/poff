<?php
set_time_limit(0);
ini_set("max_execution_time",0);

require_once(dirname(__FILE__).'/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'dev', true);

$task = new ImportAdXmlTask($configuration->getEventDispatcher(), new sfFormatter());
$task->run(array() , array('film'));
echo 'ok';

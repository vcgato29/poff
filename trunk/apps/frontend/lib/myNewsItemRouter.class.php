<?php

class myNewsItemRouter extends myCategoryRouter{

	protected $newsItem = false;

        public function getNewsItemObject(){
			$params = $this->getParameters();
            return Doctrine::getTable('NewItem')->findOneBySlug($params['slug']);
        }

}
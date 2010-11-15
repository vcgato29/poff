<?php

class ProductPicturesTable extends PriorityTable
{

	public function getSameLevelNodes()
	{
		return $this->findAll();
	}
}
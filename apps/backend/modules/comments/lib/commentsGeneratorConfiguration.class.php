<?php

/**
 * comments module configuration.
 *
 * @package    jobeet
 * @subpackage comments
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commentsGeneratorConfiguration extends BaseCommentsGeneratorConfiguration
{
  public function getDefaultSort()
  {
    return array('created_at', 'desc');
  }
}
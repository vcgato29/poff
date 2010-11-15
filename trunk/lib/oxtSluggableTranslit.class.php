<?php
class oxtSluggableTranslit
{
  /**
   * Convert any passed string to a url friendly string. Converts 'My first blog post' to 'my-first-blog-post'
   *
   * @param  string $text  Text to urlize
   * @return string $text  Urlized text
   */
  static public function urlize($text){
    return Doctrine_Inflector::urlize(self::slugify($text));
  }
  

	static public function slugify($text){
		
	    // replace non letter or digits by -
	    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	    
	    // trim
	    $text = trim($text, '-');
		
	    // transliterate
	    if (function_exists('iconv')){
	        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	    }
		
	    // lowercase
	    $text = strtolower($text);
	    
	    // remove unwanted characters
	    $text = preg_replace('~[^-\w]+~', '', $text);
	
	    if (empty($text)){
	        return '';
	    }
	 
	    return $text;
	
	}
 
}
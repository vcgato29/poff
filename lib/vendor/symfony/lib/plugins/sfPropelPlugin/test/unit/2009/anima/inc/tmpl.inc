<?php 
class Template {

	var $title;
	var $files;
	var $templates;
	
	function Template($f){
		$this->load_templates($f);
		$files{$f} = 1;
	}

	function get($name,$vals = array()){
		return preg_replace("/\\$ _(\d{2})/ex",'$vals[$1 - 1]',$this->templates{$name});
	}
	
	function load_templates($fn){
		$file = file($fn);	
		$content = implode("", $file);
		preg_match_all("/(^\w+)=\015?\012~([^~]*)~/m", $content, $matches);
		
		$c = 0;
		foreach ( $matches[1] as $key ){
			$this->templates{$key} = $matches[2][$c++];
		}		
	}

}

//$t = new Template('list.tmpls');
////$t->load_templates('list.tmpls');
//$a = array (1,'koll',3);
//print $t->get('test',$a);

?>
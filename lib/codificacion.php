<?php
	function encripta($texto,$key){
		$res="";
		for ($i=0;$i<strlen($texto);$i++){
			$char=substr($texto,$i,1);
			$keyChar=substr($key,$i%strlen($key),1);
			$char=chr(ord($char)+ord($keyChar));
			$res=$res.$char;
		}
		return  base64_encode($res);
	}
	function desEncripta($codificado,$key){
		$res="";
		$codificado=base64_decode($codificado);
		for ($i=0;$i<strlen($codificado);$i++){
			$char=substr($codificado,$i,1);
			$keyChar=substr($key,$i%strlen($key),1);
			$char=chr(ord($char)-ord($keyChar));
			$res=$res.$char;
		}
		return  $res;
	}
?>
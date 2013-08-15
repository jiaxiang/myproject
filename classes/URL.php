<?php
	Class URL {
		function replaceURL($key,$var) {
			//$s=$_SERVER["QUERY_STRING"];
			$s = getRequestUri();
			$s=explode('&',$s);
			$new='';
			$found=false;
			for ($i=0;$i<count($s);$i++) {
				if (substr($s[$i],0,strlen($key)+1)==$key.'=') {
					$new.=(($new=='')?'':'&').$key.'='.$var;
					$found=true;
				}
				else $new.=(($new=='')?'':'&').$s[$i];
			}
			if (!$found) $new.=(($new=='')?'':'&').$key.'='.$var;
			//$new=$_SERVER['ORIG_PATH_INFO'].'?'.$new;
			//$new=$_SERVER['SCRIPT_NAME'].'?'.$new;
			foreach ($_POST as $key => $val) $new.='&'.$key.'='.$val;
			return $new;
		}
		function delfromURL($key,$querystring=false) {
			$s=$_SERVER["QUERY_STRING"];
			$s=explode('&',$s);
			$new='';
			for ($i=0;$i<count($s);$i++) if (substr($s[$i],0,strlen($key)+1)!=$key.'=') $new.=(($new=='')?'':'&').$s[$i];
			if ($querystring) return $new;
			return $_SERVER['ORIG_PATH_INFO'].(($new=='')?'':'?').$new;
		}
		function postURL($except='') {
			$s=$_SERVER["QUERY_STRING"];
			$s=explode('&',$s);
			$new='';
			for ($i=0;$i<count($s);$i++) $new.=(($new=='')?'':'&').$s[$i];
			foreach ($_POST as $key => $val) if ($except==''||substr($key,0,strlen($except))!=$except) $new.=(($new=='')?'':'&').$key.'='.$val;
			if ($new=='') $new=$_SERVER['ORIG_PATH_INFO']; else $new=$_SERVER['ORIG_PATH_INFO'].'?'.$new;
			return $new;
		}
		
		public static function redirect($url = '', $method = '302') {
			$codes = array
			(
					'refresh' => 'Refresh',
					'300' => 'Multiple Choices',
					'301' => 'Moved Permanently',
					'302' => 'Found',
					'303' => 'See Other',
					'304' => 'Not Modified',
					'305' => 'Use Proxy',
					'307' => 'Temporary Redirect'
			);
			$method = isset($codes[$method]) ? (string) $method : '302';
			
			if ($method === 'refresh')
			{
				header('Refresh: 0; url='.$url);
			}
			else
			{
				header('HTTP/1.1 '.$method.' '.$codes[$method]);
				header('Location: '.$url);
			}
			exit('<h1>'.$method.' - '.$codes[$method].'</h1>');
		}
	
	}
?>
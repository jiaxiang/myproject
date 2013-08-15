<?php
	if (isset($_SERVER['PHP_SELF'])) {
		$_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF']);
	}
	
	if (!isset($CLI)) {
		header('Cache-Control: no-cache');
		header('Content-Type: text/html; charset=UTF-8');
		session_start();
	}
	
	function __autoload($class_name) { 
		global $init;
		include_once (BASEPATH."classes/".$class_name.".php"); 
	}
	
	function getRequest($key,$type='') {
		if (isset($_REQUEST["$key"])) {
			if ($type!='int') {
				if (get_magic_quotes_gpc()||is_array($_REQUEST["$key"])==true) return $_REQUEST["$key"];
				else return addslashes($_REQUEST["$key"]);
			} else {
				isint($_REQUEST["$key"],'!非法操作');
				return $_REQUEST["$key"];
			}
		}
		else return ($type=='int')?0:false;
	}

	function getCookie($key,$type='') {
		if (isset($_COOKIE["$key"])) {
			if (get_magic_quotes_gpc()||is_array($_COOKIE["$key"])==true) return $_COOKIE["$key"];
			else return addslashes($_COOKIE["$key"]);
		}
		else return ($type=='int')?0:false;
	}

	function set_Cookie($key,$val='') {
		setcookie($key,$val,0,'/');
	}

	function getRC($req,$coo,$set=0) {
		if (isset($_REQUEST["$req"])) {
			if ($set) set_Cookie($coo,$_REQUEST["$req"]);
			return getRequest($req);
		}
		if (isset($_COOKIE["$coo"])) return getCookie($coo);
		return false;
	}
	
	function getRequestUri() {
		if (isset($_SERVER['HTTP_X_REWRITE_URL']))         {
			$request_uri = $_SERVER['HTTP_X_REWRITE_URL'];
		}
		elseif (isset($_SERVER['REQUEST_URI']))
		{
			$request_uri = $_SERVER['REQUEST_URI'];
		}
		elseif (isset($_SERVER['ORIG_PATH_INFO']))         {
			$request_uri = $_SERVER['ORIG_PATH_INFO'];
			if (!empty($_SERVER['QUERY_STRING']))
			{
				$request_uri .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
		else
		{
			$request_uri = null;
		}
		return $request_uri;
	}
	
	function nowtime() {
		return date("Y-m-d H:i:s");
	}
	
	function stotime($atime){
		$a = strtotime(nowtime()) - strtotime($atime);
		if ( $a < 40 ) {
		    return "半分钟前";
		} elseif ( $a < 60 ) {
		    return "1分钟前";
		} elseif ( $a < 3600 ) {
		    $s = floor( $a / 60 );
		    return $s."分钟前";
		} elseif ( $a < 86400 ) {
		    $s = floor( $a / 3600 );
		    return $s."小时前";
		} elseif ($a<172800) {
		    $s = floor( $a / 86400 );
		    return $s."天前";
		}else return substr($atime,0,-3);
	}

	function toBin($val,$bits=8) {
		return str_pad(decbin($val),$bits,0,STR_PAD_LEFT);
	}

	function globalConfig($name) {
		global ${$name};
		global $init;
		if (!isset(${$name})) require (BASEPATH."config/".$name.".php");
	}

	function globalClass($name) {
		global ${$name};
		if (!isset(${$name})) ${$name}=new $name();
		return ${$name};
	}

	function isint($val,$word="") {
		if (substr($word,0,1)=='!') $word=substr($word,1); else $word.="必须是整数";
		if (substr($word,0,1)=='?') return (preg_match("/^([0-9]+)$/",$val));
		if (!preg_match("/^([0-9]+)$/",$val)) die($word);
		if (strlen(strval($val))>9) die($word);
	}

	function html2txt($string) {
		return str_replace(array("&",">","<","\"","'","\t"), array("&amp;","&gt;","&lt;","&quot;","&#039;"," "), $string);
	}

	function txt2db($string,$admin=false) {
		if (!$admin) $string=html2txt($string,ENT_QUOTES);
		$string=str_replace("\n ","\n&nbsp;",$string);
		$string=nl2br($string);
		$string=str_replace("  ","&nbsp; ",$string);
		$string=str_replace("  ","&nbsp; ",$string);
		return $string;
	}

	function db2txt($string) {
		$string=str_replace(array("<br>","<br />"),"",$string);
		$string=str_replace("&nbsp;"," ",$string);
		return $string;
	}
	
	function collectEchoS() {
		ob_start();
	}
	function collectEchoE() {
		$html_echo=ob_get_contents();
		ob_end_clean();
		return $html_echo;
	}
	function timeDiff($date1,$date2) {
		$from = mktime(0,0,0,date("m",strtotime($date1)),date("d",strtotime($date1)),date("Y",strtotime($date1))); 
		$to = mktime(0,0,0,date("m",strtotime($date2)),date("d",strtotime($date2)),date("Y",strtotime($date2))); 
		$datediff = ($to - $from)/86400;
		return intval($datediff);
	}
	
	function insert_into_fix_array($array,$val,$max) {
		if ($array==false) return array(0=>$val);
		$array_len=count($array);
		$array_head=0;
		if ($array_len>=$max) $array_head=$array_len-$max+1;
		$new_array=array();
		for ($i=$array_head;$i<$array_len;$i++) {
			if (isset($array[$i])) $new_array[]=$array[$i];	
		}
		$new_array[]=$val;
		return $new_array;
	}
	
	function to_json($s) {
		$s = (string)$s;
		$sb='';$c='';
	    for ($i=0,$len=strlen($s); $i<$len; ++$i){
	        $c = $s[$i]; 
	        switch ($c) {
	        case "\"": 
	            $sb.="\\\""; 
	            break; 
	        case "\\":
	            $sb.="\\\\"; 
	            break;
	        case "/": 
	            $sb.="\\/"; 
	            break; 
	        case "\b":
	            $sb.="\\b"; 
	            break;
	        case "\f":
	            $sb.="\\f"; 
	            break;
	        case "\n": 
	            $sb.="\\n"; 
	            break;
	        case "\r":
	            $sb.="\\r"; 
	            break;
	        case "\t": 
	            $sb.="\\t";
	            break;
	        default:
	            $sb.=$c; 
	        }
	    }
	    return $sb;
	}

	function getmicrotime(){ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	} 

	if (!isset($CLI)) {
		
		class pageTime {
			function __construct() {
				global $PAGE_time_start;
				$PAGE_time_start = getmicrotime();
			}
			function __destruct() {
				global $DEBUG_MODE;
				global $PAGE_time_start,$Queries_P,$Queries_P_Mem,$Queries_P_MemDB;
				$PAGE_time_end = getmicrotime();
				$PAGE_time = $PAGE_time_end - $PAGE_time_start;
				$PAGE_time=intval($PAGE_time*1000);
				if (!$Queries_P_Mem) $Queries_P_Mem=0;
				if (!$Queries_P_MemDB) $Queries_P_MemDB=0;
				echo "<br /><p align=center><font size=1>".$Queries_P." Quer(ies)_Total, ".($Queries_P-$Queries_P_Mem-$Queries_P_MemDB)." Quer(ies), ".$Queries_P_Mem." Quer(ies)_Mem, ".$Queries_P_MemDB." Quer(ies)_MemDB, Process in ".$PAGE_time." ms</p>";
				if (isset($DEBUG_MODE) && $DEBUG_MODE) {
					echo 'SESSION:<br />';
					echo '<pre>';
					echo print_r($_SESSION, TRUE);
					echo '</pre>';
					echo 'REQUEST:<br />';
					echo '<pre>';
					echo print_r($_REQUEST, TRUE);
					echo '</pre>';
				}
			}
		}
		if ((isset($DEBUG_MODE) && $DEBUG_MODE)) {
			$pageTime = new pageTime();
		}
		
		class SqlQueries {
			function __destruct() {
				global $Queries;
				if (!isset($Queries)) return;
				foreach ($Queries as $key => $val) echo $val[0]." ".$val[1]." ".$val[2]."<br />\r\n";
			}
		}
		if ((isset($DEBUG_MODE) && $DEBUG_MODE)) {
			$SqlQueries = new SqlQueries();
		}
		
	}
?>
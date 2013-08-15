<?php
	class SQL {

		private $resultHandler;
		private $result;
		private $connectServer;
		private $server_info;
		private $table_location;
		function __construct($tablename = '', $keyfield = 0) {
			$this->initMySQL();
			$this->connect($tablename, $keyfield);
		}
		
		private function initMySQL() {
			globalConfig('database');
			global $database;
			foreach ($database as $key => $val) {
				$conn_info = $val['connection'];
				$charset = $val['character_set'];
				$this->table_location[$key] = $conn_info['host'];
				$this->server_info[$conn_info['host']] = array(
						'user' => $conn_info['user'], 
						'pass' => $conn_info['pass'], 
						'database' => $conn_info['database'],
						'charset' => $charset
						);
			}
		}
		
		private function connect($tablename = '', $keyfield = 0) {
			if (!isset($this->table_location[$tablename])) {
				$server = 'default';
			}
			else {
				$server = $this->table_location[$tablename];
			}
			$this->connectServer = $this->table_location[$server];
			global $MySQL_Connection_Handle;
			if (!isset($MySQL_Connection_Handle[$this->connectServer])) {
				$MySQL_Connection_Handle[$this->connectServer] = @mysql_connect($this->connectServer,$this->server_info[$this->connectServer]['user'],$this->server_info[$this->connectServer]['pass']) or die ("系统忙，请稍候再试。");
				mysql_query('set character_set_connection='.$this->server_info[$this->connectServer]['charset'].', 
						character_set_results='.$this->server_info[$this->connectServer]['charset'].', 
						character_set_client=binary',$MySQL_Connection_Handle[$this->connectServer]);
				mysql_select_db($this->server_info[$this->connectServer]['database'], $MySQL_Connection_Handle[$this->connectServer]);
			}
		}

		function query($query) {
			global $DEBUG_MODE,$Queries_P;
			global $MySQL_Connection_Handle;
			if (!isset($Queries_P)) $Queries_P=0;
			$this->resultHandler = mysql_query($query,$MySQL_Connection_Handle[$this->connectServer]);
			if (isset($DEBUG_MODE) && $DEBUG_MODE==1) {
				global $Queries;
				global $PAGE_time_start;
				if (!isset($Queries)) $Queries=array();
				$Queries[$Queries_P][0]=$this->connectServer.': '.$query;
				$Queries[$Queries_P][1]=self::error();
				$Queries[$Queries_P][2]=getmicrotime() - $PAGE_time_start;
			}
			$Queries_P++;
			return $this->resultHandler;
		}

		function fetch_array($both=0) {
			if ($this->resultHandler) {
				if ($both==0) {
					$this->result = @mysql_fetch_assoc($this->resultHandler);
				}
				else {
					$this->result = @mysql_fetch_array($this->resultHandler);
				}
				return $this->result;
			} 
			else {
				return false;
			}
		}
		/**
		 *返回当前结果集中所有数据
		 *@param: null
		 *@return array 所有数据集
		 *@last-edit: tiger(2009-8-26)
		 */
		function fetch_all()
		{
			if (!$this->resultHandler)
				return false;
			$arr_ret = array();
			while(($arr_row = mysql_fetch_assoc($this->resultHandler)))
				$arr_ret[] = $arr_row;
			return $arr_ret;
		}
		
		function num_rows() {
			if ($this->resultHandler===null || $this->resultHandler===false) return 0;
			return mysql_num_rows($this->resultHandler);
		}

		function affected_rows() {
			global $MySQL_Connection_Handle;
			return mysql_affected_rows($MySQL_Connection_Handle[$this->connectServer]);
		}

		function insert_id() {
			global $MySQL_Connection_Handle;
			return mysql_insert_id($MySQL_Connection_Handle[$this->connectServer]);
		}

		function error() {
			global $MySQL_Connection_Handle;
			return mysql_error($MySQL_Connection_Handle[$this->connectServer]);
		}

		function __get($var) {
			 if ($this->result[$var]) return $this->result[$var];
			 else return null;
		}
	}

?>
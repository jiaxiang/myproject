<?php

	Class Page_SQL {
		
		public $page;
		public $begin = 0;
		public $offset = 50;
		public $total = 0;
		public $totalpage = 0;
		public $nextpage = '';
		public $prepage = '';
		public $pagelink = '';
		public $pageinput = '';
		public $keyword = '';
		public $keyword_field = '';
		public $page_style = 0;
		public $page_describe = '页';
		//装有页码的数字数组
		public $NumArray = array();
		
		
		function __construct() {
			$this->run = true;
			if (getRequest('page') !== false) {
				$this->page = getRequest('page');
			}
			else {
				$this->page = 1;
			}
		}

		function setTotal($total) {
			$this->total = $total;
			if ($this->offset == 0) {
				$this->offset = 50;
			}
			$this->NumArray['total'] = intval($this->total);
			$this->totalpage = intval($total / $this->offset) + 1;
			if ($total && $total % $this->offset == 0) {
				$this->totalpage--;
			}
			$this->NumArray['totalpage'] = intval($this->totalpage);
			if ($this->page <= 0) {
				$this->page = 1;
			}
			if ($this->page > $this->totalpage) {
				$this->page = $this->totalpage;
			}
			$this->NumArray['page'] = intval($this->page);
			$this->begin = ($this->page - 1) * $this->offset;
			$URL = new URL();
			if ($this->page_style == 0) {
				if ($this->page < $this->totalpage) {
					$this->NumArray['nextpage'] = intval($this->page+1);
					$this->nextpage = '&nbsp; <a href="'.$URL->replaceURL('page',$this->page+1).'">下一页</a>'; 
				}
				else {
					$this->NumArray['nextpage'] = 0;
					$this->nextpage = '';
				}
				if ($this->page > 1) {
					$this->NumArray['prepage'] = intval($this->page-1);
					$this->prepage = '&nbsp; <a href="'.$URL->replaceURL('page',$this->page-1).'">上一页</a>'; 
				}
				else {
					$this->NumArray['prepage'] = 0;
					$this->prepage = '';
				}
			} 
			if ($this->page_style == 2)
			{
				self::NumPageLink();
			}
			else {
				self::fullPageLink_new();
			}
			if ($this->totalpage > 1) {
				$this->pageinput = '';
			}
		}
		
		function NumPageLink()
		{
			$URL=new URL();
			$string='<div class="pages">';
			$string.=($this->page>1)?'<a class="page" href="'.$URL->replaceURL('page',$this->page-1).'" title="上一页">&lt;</a><a class="page" href="'.$URL->replaceURL('page',1).'">1</a>':'';
			$string.=($this->page>5)?'<a href="#" class="ellipsis">&hellip;</a>':'';
			$MinShowNum=$this->page-3;
			$MaxShowNum=$this->page+3;
			if($this->page<=5) $MaxShowNum=9;
			elseif ($this->page>=($this->totalpage-5)) {$MaxShowNum=$this->totalpage;	$MinShowNum=$this->totalpage-8;}		
			for($i=$MinShowNum;$i<$this->page;$i++)
			{
				if($i<=1)	continue;
				$string.='<a class="page" href="'.$URL->replaceURL('page',$i).'">'.$i.'</a>';
			}
			$string.='<a class="active" href="'.$URL->replaceURL('page',$this->page).'">'.$this->page.'</a>';
			
			for($i=$this->page+1;$i<=$MaxShowNum;$i++)
			{
				if($i>=$this->totalpage) break;
				//if($i<=5||$i>=($this->totalpage-5)) $MaxShowNum++;
				$string.='<a class="page" href="'.$URL->replaceURL('page',$i).'">'.$i.'</a>';
			}
			$string.=($this->page<$this->totalpage-5)?'<a href="#" class="ellipsis">&hellip;</a>':'';
			$string.=($this->page<$this->totalpage)?'<a class="page" href="'.$URL->replaceURL('page',$this->totalpage).'">'.$this->totalpage.'</a><a class="page" href="'.$URL->replaceURL('page',$this->page+1).'" title="下一页">&gt;</a>':'';
			$string.='</div>';
			if($this->totalpage==1) $string='';
			$this->pagelink = $string;
		}
		
		function fullPageLink_new()
		{
			$URL = new URL();
			$string='<div class="page">';
			$offset=intval(($this->page-1)/10)*10+1;
			//$offset=$page;
			//if ($offset==5) $offset=1;
			if ($offset>10) {
				$string.='<a href="'.$URL->replaceURL('page',1).'">第一'.$this->page_describe.'</a>';
				$string.='<a href="'.$URL->replaceURL('page',$offset-10).'">前十'.$this->page_describe.'</a>';
			}
			for ($i=$offset;$i<$offset+10;$i++) {
				if ($i>$this->totalpage) break;
				if ($i!=$this->page) $string.='<a href="'.$URL->replaceURL('page',$i).'">'.$i."</a>";
				else $string.='<span class="current skin_page_current">'.$i.'</span>';
			}
			if ($offset+10<=$this->totalpage) {
				$string.='<a href="'.$URL->replaceURL('page',$offset+10).'">下十页</a>';
				$string.='<a href="'.$URL->replaceURL('page',$this->totalpage).'">最后一页</a>';
			}
			$string.='</div>';
			if ($string=='<div class="page"><span class="current skin_page_current">1</span></div>') $string=''; else $string.='<div class="clear"></div>';
			$this->pagelink = $string;
		}
		
		function fullPageLink() {
			$URL = new URL();
			$string = '<div class="page">';
			//$offset=intval(($this->page-1)/10)*10+1;
			$offset = $this->page;
			if ($offset > 5) {
				$string .= '<a href="'.$URL->replaceURL('page',1).'">第一'.$this->page_describe.'</a>';
				if ($offset > 9) {
					$string .= '<a href="'.$URL->replaceURL('page',$offset-9).'">前十'.$this->page_describe.'</a>';
				}
			}
			$b1 = $offset - 4;
			if ($b1 <= 0) {
				$b1 = 1;
			}
			$b2 = $offset + 4;
			if ($b2 > $this->totalpage) {
				$b2 = $this->totalpage;
			}
			if ($b2 - $b1 < 8) {
				$b1 = $b2 - 8;
				if ($b1 <= 0) {
					$b1 = 1;
				}
			}
			for ($i = $b1; $i < $b1 + 9; $i++) {
				if ($i > $this->totalpage) {
					break;
				}
				if ($i != $this->page) {
					$string .= '<a href="'.$URL->replaceURL('page',$i).'">'.$i."</a>";
				}
				else {
					$string .= '<span class="current skin_page_current">'.$i.'</span>';
				}
			}
			if ($offset + 9 <= $this->totalpage) {
				$string .= '<a href="'.$URL->replaceURL('page',$offset+9).'">下十'.$this->page_describe.'</a>';
			}
			if ($b2 < $this->totalpage) {
				$string .= '<a href="'.$URL->replaceURL('page',$this->totalpage).'">最后一'.$this->page_describe.'</a>';
			}
			$string .= '</div>';
			if ($string == '<div class="page"><span class="current skin_page_current">1</span></div>') {
				$string = '';
			}
			$this->pagelink = $string;
		}
		
		function fullPageLinkAjax($function,$args)
		{
			$string = '<div class="page">';
			//$offset=intval(($this->page-1)/10)*10+1;
			$offset = $this->page;
			if ($offset > 5) {
				$string .= '<a href="javascript:;" onclick="'.$function.'('.$args.',1)" >第一'.$this->page_describe.'</a>';
				if ($offset > 9) {
					$string .= '<a href="javascript:;" onclick="'.$function.'('.$args.','.($offset-9).')">前十'.$this->page_describe.'</a>';
				}
			}
			$b1 = $offset - 4;
			if ($b1 <= 0) {
				$b1 = 1;
			}
			$b2 = $offset + 4;
			if ($b2 > $this->totalpage) {
				$b2 = $this->totalpage;
			}
			if ($b2 - $b1 < 8) {
				$b1 = $b2 - 8;
				if ($b1 <= 0) {
					$b1 = 1;
				}
			}
			for ($i = $b1; $i < $b1 + 9; $i++) {
				if ($i > $this->totalpage) {
					break;
				}
				if ($i != $this->page) {
					$string .= '<a href="javascript:;" onclick="'.$function.'('.$args.','.$i.')" >'.$i."</a>";
				}
				else {
					$string .= '<span class="current skin_page_current">'.$i.'</span>';
				}
			}
			if ($offset + 9 <= $this->totalpage) {
				$string .= '<a href="javascript:;" onclick="'.$function.'('.$args.','.($offset+9).')" >下十'.$this->page_describe.'</a>';
			}
			if ($b2 < $this->totalpage) {
				$string .= '<a href="javascript:;" onclick="'.$function.'('.$args.','.$this->totalpage.')" >最后一'.$this->page_describe.'</a>';
			}
			$string .= '</div>';
			if ($string == '<div class="page"><span class="current skin_page_current">1</span></div>') {
				$string = '';
			}
			$this->pagelink = $string;			
		}
		
		
		function runSQL($table, $field = '*', $where = '', $order = '', $table_flag='') {
			if ($order != '') {
				$order = ' '.$order;
			}
			if ($this->keyword != '') {
				if ($where == '') {
					$where = 'where 1';
				}
				$where .= $this->keyword;
			}
			if ($table_flag == '') {
				$sql = new SQL($table);
			}
			else {
				$sql = new SQL($table_flag);
			}
			//$sql->query("select count(*) as n,".$field." from ".$table." ".$where.$order);
			$sql->query("select count(*) as n from ".$table." ".$where. " ". $order);
			$tmp = $sql->fetch_array();
			$tmp1 = $sql->fetch_array();
			if ($tmp1 == false) {
				//$tmp['n']
				$this->setTotal($tmp['n']);
			}
			else {
				//$sql->num_rows()
				$this->setTotal($sql->num_rows());
			}
			$sql->query("select ".$field." from ".$table." ".$where.$order." limit ".$this->begin.",".$this->offset);
			$result = array();
			while ($re = $sql->fetch_array()) {
				$result[] = $re;
			}
			return $result;
		}
		
		function getArray() {
			return array('page'=>$this->page,'total'=>$this->total,'totalpage'=>$this->totalpage,'nextpage'=>$this->nextpage,'prepage'=>$this->prepage,'pagelink'=>$this->pagelink);
		}
		
		function getTotalPage($total){
			$this->totalpage = $total;
			//$this->totalpage=intval($total/$this->offset)+1;
			//if ($total&&$total%$this->offset==0) $this->totalpage--;
			if ($this->page <= 0) {
				$this->page = 1;
			}
			if ($this->page > $this->totalpage) {
				$this->page = $this->totalpage;
			}
			//$this->begin=($this->page-1)*$this->offset;
			$URL = new URL();
			if ($this->page_style == 0) {
				if ($this->page < $this->totalpage) {
					$this->nextpage = '<a href="'.$URL->replaceURL('page',$this->page+1).'">下一页</a>'; 
				}
				else {
					$this->nextpage = '';
				}
				if ($this->page > 1) {
					$this->prepage = '<a href="'.$URL->replaceURL('page',$this->page-1).'">上一页</a>&nbsp;'; 
				}
				else {
					$this->prepage = '';
				}
			} 
			else {
				self::fullPageLink();
			}
			return $this->prepage.$this->nextpage;
			//if ($this->totalpage>1) $this->pageinput='';
		}
	
	}
?>
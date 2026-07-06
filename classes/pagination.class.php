<?php
/* Version 3: show some number of page links and takes care of query string*/
class pagination {
	var $full_sql, $per_page, $cur_page, $tot_pages, $offset, $refresh_div, $ajax_form;
	
	function __construct($full_sql, $per_page, $cur_page, $refresh_div, $ajax_form) {
		global $dbPagination; //get db connection
		$this->full_sql = $full_sql;
		$this->per_page = $per_page;
		$this->cur_page = $cur_page;
		$this->refresh_div = $refresh_div;
		$this->ajax_form = !$ajax_form ? 'null' : $ajax_form;
		
		$sqlt = $full_sql;
		$rsdt = $dbPagination->query($sqlt);
		$total = $dbPagination->num_rows();
		$this->tot_pages = ceil($total/$per_page);
	}
	
	function get_query() {
		$this->offset = ($this->cur_page - 1) * $this->per_page;
		return $this->full_sql." limit $this->offset,$this->per_page";
	}
	
	function get_links($display=10) {
		//check for query string, if nothing add ? at the end, if exists remove page and add & at end
		$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
		$nextimg = '<img src="images/btn-next.png" border="0" />';
		$previmg = '<img src="images/btn-prev.png" border="0" />';
		
		//$link = $self;
		if(count($_GET))
		{
			$link .= "?";
			foreach($_GET as $param => $value)
			{
				if($param != "page")
					$link .= "$param=$value&";
			}
		}
		else
		{
			$link .= "?";
		}
		if($this->refresh_div=="") {
			$page_link = "<ul>";
			
			//if display is not odd make it odd
			if(!$display&1)
				$display++;
			
			//previous link - if current page is first page: no link
			if ($this->cur_page > 1) {
				$prev  = $this->cur_page - 1;
				$page_link .= "<li> <a href='".$link."start=$prev'>".$previmg."</a> </li>";
			}
			else {
				//$page_link .= "<li><a>[Prev] </a><li>";
			}
			
			//define the starting page no link and end
			$side_display = floor($display/2);
			$start = 1;
			$end = $this->tot_pages;
			if($this->tot_pages > $display)
			{
				if($this->cur_page > $side_display)
					$start = $this->cur_page - $side_display;
				else
					$end = $display;
				
				if(($this->cur_page + $side_display) < $this->tot_pages)
				{
					if($this->cur_page > $side_display)
						$end = $this->cur_page + $side_display;
				}
				else
					$start = ($this->tot_pages - $display) + 1;
			}
				
			//page links with number - current page number: no link
			for($i = $start; $i <= $end; $i++) {
				if ($i == $this->cur_page)
					$page_link .= "<li> <a class='active'> $i </a></li>";
				else
					$page_link .= "<li> <a href='".$link."start=$i'>$i</a> </li>";
			}
			
			//next link - if current page is last page: no link
			if ($this->cur_page < $this->tot_pages) {
				$next = $this->cur_page + 1;
				$page_link .= "<li> <a href='".$link."start=$next'>".$nextimg."</a> </li>";
			}
			else {
				//$page_link .= "<span> [Next]</span>";
				//$page_link .= "<li><a> [Next]</a></li>";
			}
			$page_link .= "</ul>";
			return $page_link;
		}
		else {
			$page_link = "<ul>";
			
			//if display is not odd make it odd
			if(!$display&1)
				$display++;
			
			//previous link - if current page is first page: no link
			if ($this->cur_page > 1) {
				$prev  = $this->cur_page - 1;
				$page_link .= "<li> <a onclick=\"SimpleAjax('".$link."start=$prev','".$this->ajax_form."','".$this->refresh_div."');\" style='padding:0px'>".$previmg."</a> </li>";
			}
			else {
				$page_link .= "<li>".$previmg."</li>";
			}
			
			//define the starting page no link and end
			$side_display = floor($display/2);
			$start = 1;
			$end = $this->tot_pages;
			if($this->tot_pages > $display)
			{
				if($this->cur_page > $side_display)
					$start = $this->cur_page - $side_display;
				else
					$end = $display;
				
				if(($this->cur_page + $side_display) < $this->tot_pages)
				{
					if($this->cur_page > $side_display)
						$end = $this->cur_page + $side_display;
				}
				else
					$start = ($this->tot_pages - $display) + 1;
			}
				
			//page links with number - current page number: no link
			for($i = $start; $i <= $end; $i++) {
				if ($i == $this->cur_page)
					$page_link .= "<li> <a class='active'> $i </a></li>";
				else
					$page_link .= "<li> <a onclick=\"SimpleAjax('".$link."start=$i','".$this->ajax_form."','".$this->refresh_div."');\">$i</a> </li>";
			}
			
			//next link - if current page is last page: no link
			if ($this->cur_page < $this->tot_pages) {
				$next = $this->cur_page + 1;
				$page_link .= "<li><a onclick=\"SimpleAjax('".$link."start=$next','".$this->ajax_form."','".$this->refresh_div."');\" style='padding:0px'>".$nextimg."</a> </li>";
			}
			else {
				//$page_link .= "<span> [Next]</span>";
				$page_link .= "<li>".$nextimg."</li>";
			}
			$page_link .= "</ul>";
			return $page_link;	
		}
		
	}
	
	function get_links1($display=10) {
		//check for query string, if nothing add ? at the end, if exists remove page and add & at end
		//$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
		//$link = $self;
		$link = $_SERVER['SCRIPT_NAME'];
		if(count($_GET))
		{
			$link .= "?";
			if(!isset($_GET['start']))
			{
				foreach($_GET as $param => $value)
				{
					if($param != "page")
						$link .= "$param=$value&";
				}
			}
		}
		else
		{
			$link .= "?";
		}
		
		
		if($this->refresh_div=="") {
			$page_link = "<ul class='pagination'>";
			
			//if display is not odd make it odd
			if(!$display&1)
				$display++;
			
			//previous link - if current page is first page: no link
			if ($this->cur_page > 1) {
				$prev  = $this->cur_page - 1;
				$page_link .= "<li> <a href='".$link."start=$prev'>&laquo;</a> </li>";
			}
			else {
				//$page_link .= "<li><a>[Prev] </a><li>";
			}
			
			//define the starting page no link and end
			$side_display = floor($display/2);
			$start = 1;
			$end = $this->tot_pages;
			if($this->tot_pages > $display)
			{
				if($this->cur_page > $side_display)
					$start = $this->cur_page - $side_display;
				else
					$end = $display;
				
				if(($this->cur_page + $side_display) < $this->tot_pages)
				{
					if($this->cur_page > $side_display)
						$end = $this->cur_page + $side_display;
				}
				else
					$start = ($this->tot_pages - $display) + 1;
			}
				
			//page links with number - current page number: no link
			for($i = $start; $i <= $end; $i++) {
				if ($i == $this->cur_page)
					$page_link .= "<li> <a class='active'> $i </a></li>";
				else
					$page_link .= "<li> <a href='".$link."start=$i'>$i</a> </li>";
			}
			
			//next link - if current page is last page: no link
			if ($this->cur_page < $this->tot_pages) {
				$next = $this->cur_page + 1;
				$page_link .= "<li> <a href='".$link."start=$next'>&raquo;</a> </li>";
			}
			else {
				//$page_link .= "<span> [Next]</span>";
				//$page_link .= "<li><a> [Next]</a></li>";
			}
			$page_link .= "</ul>";
			return $page_link;
		}
		else {
			$page_link = "<ul class='pagination'>";
			
			//if display is not odd make it odd
			if(!$display&1)
				$display++;
			
			//previous link - if current page is first page: no link
			if ($this->cur_page > 1) {
				$prev  = $this->cur_page - 1;
				$page_link .= "<li> <a onclick=\"SimpleAjax('".$link."start=$prev','".$this->ajax_form."','".$this->refresh_div."');\">&laquo;</a> </li>";
			}
			else {
				$page_link .= "<li><a href='#'>&laquo;</a></li>";
			}
			
			//define the starting page no link and end
			$side_display = floor($display/2);
			$start = 1;
			$end = $this->tot_pages;
			if($this->tot_pages > $display)
			{
				if($this->cur_page > $side_display)
					$start = $this->cur_page - $side_display;
				else
					$end = $display;
				
				if(($this->cur_page + $side_display) < $this->tot_pages)
				{
					if($this->cur_page > $side_display)
						$end = $this->cur_page + $side_display;
				}
				else
					$start = ($this->tot_pages - $display) + 1;
			}
				
			//page links with number - current page number: no link
			for($i = $start; $i <= $end; $i++) {
				if ($i == $this->cur_page)
					$page_link .= "<li> <a class='active'> $i </a></li>";
				else
					$page_link .= "<li> <a onclick=\"SimpleAjax('".$link."start=$i','".$this->ajax_form."','".$this->refresh_div."');\">$i</a> </li>";
			}
			
			//next link - if current page is last page: no link
			if ($this->cur_page < $this->tot_pages) {
				$next = $this->cur_page + 1;
				$page_link .= "<li><a onclick=\"SimpleAjax('".$link."start=$next','".$this->ajax_form."','".$this->refresh_div."');\">&raquo;</a> </li>";
			}
			else {
				//$page_link .= "<span> [Next]</span>";
				$page_link .= "<li><a href='#'>&raquo;</a></li>";
			}
			$page_link .= "</ul>";
			return $page_link;	
		}
		
	}
	
	
	function get_linksDashoard($UrlData,$display=10) {
		//check for query string, if nothing add ? at the end, if exists remove page and add & at end
		//$link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
		//$link = $self;
		//echo $_SERVER['SCRIPT_NAME'];
		//exit;/khorfakkan/dashboard/ajax/ajax_itsupportrequest.php
		//echo '/'.str_replace('http://'DOMAINNAME.'/dashboard/';
		
		$domainonly = str_replace("http://".$_SERVER['HTTP_HOST'].'/','',DOMAINNAME); 
		
		$link = "http://".$_SERVER['HTTP_HOST'].str_replace('/'.$domainonly.'/ajax/','',$_SERVER['SCRIPT_NAME']);
		
		$link = $UrlData;
		 
		// $urlParam = $_SERVER['QUERY_STRING'];
		// //check url is encrypted
		// if (CheckIsBase64($urlParam))
		// {
		// 				$urlParam = decodeencriptstring($urlParam);
		// }
		// $link .= "?".$urlParam.'&';
	   
		/*if(count($_SERVER['QUERY_STRING']))
		{
						$link .= "?";
						//if(!isset($_GET['start']))
						{
										foreach($_SERVER['QUERY_STRING'] as $param => $value)
										{
														if($param != "page")
														{
																		$link .= "$param=$value&";
														}
										}
						}
		}
		else
		{
						$link .= "?";
		}*/
		
		
		
		if($this->refresh_div=="") {
			$page_link = "<ul class='pagination'>";
			
			//if display is not odd make it odd
			if(!$display&1)
				$display++;
			
			//previous link - if current page is first page: no link
			if ($this->cur_page > 1) {
				$prev  = $this->cur_page - 1;
				$page_link .= "<li class='paginate_button page-item'> <a href='".$link."start=$prev'>&laquo;</a> </li>";
			}
			else {
				//$page_link .= "<li><a>[Prev] </a><li>";
			}
			
			//define the starting page no link and end
			$side_display = floor($display/2);
			$start = 1;
			$end = $this->tot_pages;
			if($this->tot_pages > $display)
			{
				if($this->cur_page > $side_display)
					$start = $this->cur_page - $side_display;
				else
					$end = $display;
				
				if(($this->cur_page + $side_display) < $this->tot_pages)
				{
					if($this->cur_page > $side_display)
						$end = $this->cur_page + $side_display;
				}
				else
					$start = ($this->tot_pages - $display) + 1;
			}
				
			//page links with number - current page number: no link
			for($i = $start; $i <= $end; $i++) {
				if ($i == $this->cur_page)
					$page_link .= "<li> <a class='active'> $i </a></li>";
				else
					$page_link .= "<li> <a href='".$link."start=$i'>$i</a> </li>";
			}
			
			//next link - if current page is last page: no link
			if ($this->cur_page < $this->tot_pages) {
				$next = $this->cur_page + 1;
				$page_link .= "<li> <a href='".$link."start=$next'>&raquo;</a> </li>";
			}
			else {
				//$page_link .= "<span> [Next]</span>";
				//$page_link .= "<li><a> [Next]</a></li>";
			}
			$page_link .= "</ul>";
			return $page_link;
		}
		else {
			$page_link = "<ul class='pagination'>";
			
			//if display is not odd make it odd
			if(!$display&1)
				$display++;
			
			//previous link - if current page is first page: no link
			if ($this->cur_page > 1) {
				$prev  = $this->cur_page - 1;
				$page_link .= "<li class='paginate_button page-item'> <a onclick=\"SimpleAjax('".$link."start=$prev','".$this->ajax_form."','".$this->refresh_div."');\" class='page-link'>&laquo;</a> </li>";
			}
			else {
				$page_link .= "<li class='paginate_button page-item'><a href='#' class='page-link'>&laquo;</a></li>";
			}
			
			//define the starting page no link and end
			$side_display = floor($display/2);
			$start = 1;
			$end = $this->tot_pages;
			if($this->tot_pages > $display)
			{
				if($this->cur_page > $side_display)
					$start = $this->cur_page - $side_display;
				else
					$end = $display;
				
				if(($this->cur_page + $side_display) < $this->tot_pages)
				{
					if($this->cur_page > $side_display)
						$end = $this->cur_page + $side_display;
				}
				else
					$start = ($this->tot_pages - $display) + 1;
			}
				
			//page links with number - current page number: no link
			for($i = $start; $i <= $end; $i++) {
				if ($i == $this->cur_page)
					$page_link .= "<li class='paginate_button page-item active'> <a class=' page-link'  > $i </a></li>";
				else
					$page_link .= "<li class='paginate_button page-item'> <a onclick=\"SimpleAjax('".$link."start=$i','".$this->ajax_form."','".$this->refresh_div."');\" class='page-link'>$i</a> </li>";
			}
			
			//next link - if current page is last page: no link
			if ($this->cur_page < $this->tot_pages) {
				$next = $this->cur_page + 1;
				$page_link .= "<li class='paginate_button page-item'><a onclick=\"SimpleAjax('".$link."start=$next','".$this->ajax_form."','".$this->refresh_div."');\" class='page-link'>&raquo;</a> </li>";
			}
			else {
				//$page_link .= "<span> [Next]</span>";
				$page_link .= "<li class='paginate_button page-item'><a href='#' class='page-link'>&raquo;</a></li>";
			}
			$page_link .= "</ul>";
			return $page_link;	
		}
		
	}
}
?>

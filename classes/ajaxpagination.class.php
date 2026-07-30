<?php
class PerPage {
	public $perpage;
	public $perpagesearch; 
	
	function __construct() {
		$this->perpage = PAGINATION_COUNT;
		$this->perpagesearch = PAGINATION_COUNT_SEARCH;
	}
	
	function getAllPageLinks($count,$url,$formId,$divId) {
		$output = '';
		$pageCounts = 1;
		$urlFunc = RESOURCES_DOMAIN.'/ajax_functions.php?actions=news_listing&page=';
		if(!isset($_REQUEST["page"])) $_REQUEST["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {

			
				$output = $output.'<ul class="pagination pagination-lg ">';
				$output .= '<li onclick="SimpleAjax(\'' .RESOURCES_DOMAIN.$url. ($_REQUEST["page"]-1) . '\',\'' .$formId . '\',\''. $divId . '\')"><a href="#"> <i class="fa fa-arrow-left"></i> </a></li>';
			
			if(($_REQUEST["page"]-3)>0) {
				if($_REQUEST["page"] == 1)
				
					$output = $output . '<li class="active"><a href="#" id=1 class="active">1</a></li>';
				else				
					$output = $output . '<li><a class="link" onclick="SimpleAjax(\'' .RESOURCES_DOMAIN.$url.$pageCounts . '\',\'' .$formId . '\',\''. $divId . '\')" >1</a></li>';
			}
			if(($_REQUEST["page"]-3)>1) {
					$output = $output . '<li>...</li>';
			}
			
			for($i=($_REQUEST["page"]-2); $i<=($_REQUEST["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_REQUEST["page"] == $i)
					$output = $output . '<li class="active"><a id='.$i.' href="#" class="active" >'.$i.'</a></li>';
				else				
					$output = $output . '<li><a class="link" href="#"  onclick="SimpleAjax(\'' .RESOURCES_DOMAIN.$url.$i . '\',\'' .$formId . '\',\''. $divId . '\')"  >'.$i.'</a></li>';
			}
			
			if(($pages-($_REQUEST["page"]+2))>1) {
				$output = $output . '<li>...</li>';
			}
			if(($pages-($_REQUEST["page"]+2))>0) {
				if($_REQUEST["page"] == $pages)
					$output = $output . '<li class="active"><a id=' . ($pages) .' href="#"  class="active">' . ($pages) .'</a></li>';
				else				
					$output = $output . '<li><a class="link" href="#"  onclick="SimpleAjax(\'' .RESOURCES_DOMAIN.$url.$pages . '\',\'' .$formId . '\',\''. $divId . '\')" >' . ($pages) .'</a></li>';
			}
            $output .= '<li><a href="#" onclick="SimpleAjax(\'' .RESOURCES_DOMAIN.$url. ($_REQUEST["page"]+1) . '\',\'' .$formId . '\',\''. $divId . '\')"> <i class="fa fa-arrow-right"></i> </a></li>';
			$output = $output.'</ul>';
			if($_REQUEST["page"] < $pages) {
//                $output = $output . '<a href="#0" class="control next" title="next page" onclick="SimpleAjax(\'' . RESOURCES_DOMAIN . $url . ($_REQUEST["page"] + 1) . '\',\'' . $formId . '\',\'' . $divId . '\')" >' . TXT_PAGINATION_NEXT . '<i class="fa fa-long-arrow-right"></i></a>';
            }
			else {
//                $output = $output . '<a href="#0" class="control next" title="next page" >' . TXT_PAGINATION_NEXT . '<i class="fa fa-long-arrow-right"></i></a>';
            }
			
		}
		 return $output;
	}


	function getAllPageLinksNews($count) {
		$output = '';
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_POST["page"] == 1)
				$output = $output . '<li><a href="#0" class="prev" title="previous page">&#10094;</a></li>';
			else
				$output = $output . '<li><a href="#0" class="prev" title="previous page" onclick="getNewsListing(\'' . ($_POST["page"]-1) . '\')" >&#10094;</a></li>';


			if(($_POST["page"]-3)>0) {
				if($_POST["page"] == 1)
					$output = $output . '<li class="active"><a id=1 class="active">1</a></li>';
				else
					$output = $output . '<li><a class="link" onclick="getNewsListing(\'' . '1\')" >1</a></li>';
			}
			if(($_POST["page"]-3)>1) {
					$output = $output . '<li><span class="dot">...</span></li>';
			}

			for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_POST["page"] == $i)
					$output = $output . '<li class="active"><a id='.$i.' class="active">'.$i.'</a></li>';
				else
					$output = $output . '<li><a class="link" onclick="getNewsListing(\'' . $i . '\')" >'.$i.'</a></li>';
			}

			if(($pages-($_POST["page"]+2))>1) {
				$output = $output . '<li><span class="dot">...</span></li>';
			}
			if(($pages-($_POST["page"]+2))>0) {
				if($_POST["page"] == $pages)
					$output = $output . '<li class="active"><a id=' . ($pages) .' class="active">' . ($pages) .'</a></li>';
				else
					$output = $output . '<li><a class="link" onclick="getNewsListing(\'' .  ($pages) .'\')" >' . ($pages) .'</a></li>';
			}

			if($_POST["page"] < $pages)
				$output = $output . '<li><a href="#0" class="next" title="next page" onclick="getNewsListing(\'' . ($_POST["page"]+1) . '\')" >&#10095;</a></li>';
			else
				$output = $output . '<li><a href="#0" class="next" title="next page">&#10095;</a></li>';


		}
		 return $output;
	}

	function getAllPageLinksSearch($count) {
		$output = '';
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if($this->perpagesearch != 0)
			$pages  = ceil($count/$this->perpagesearch);
		if($pages>1) {
			if($_POST["page"] == 1) 
				$output = $output . '<li><a href="#0" class="prev" title="previous page">&#10094;</a></li>';
			else	
				$output = $output . '<li><a href="#0" class="prev" title="previous page" onclick="getproductbySearch(\'' . ($_POST["page"]-1) . '\')" >&#10094;</a></li>';
			
			
			if(($_POST["page"]-3)>0) {
				if($_POST["page"] == 1)
					$output = $output . '<li class="active"><a id=1 class="active">1</a></li>';
				else				
					$output = $output . '<li><a class="link" onclick="getproductbySearch(\'' . '1\')" >1</a></li>';
			}
			if(($_POST["page"]-3)>1) {
					$output = $output . '<li><span class="dot">...</span></li>';
			}
			
			for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_POST["page"] == $i)
					$output = $output . '<li class="active"><a id='.$i.' class="active">'.$i.'</a></li>';
				else				
					$output = $output . '<li><a class="link" onclick="getproductbySearch(\'' . $i . '\')" >'.$i.'</a></li>';
			}
			
			if(($pages-($_POST["page"]+2))>1) {
				$output = $output . '<li><span class="dot">...</span></li>';
			}
			if(($pages-($_POST["page"]+2))>0) {
				if($_POST["page"] == $pages)
					$output = $output . '<li class="active"><a id=' . ($pages) .' class="active">' . ($pages) .'</a></li>';
				else				
					$output = $output . '<li><a class="link" onclick="getproductbySearch(\'' .  ($pages) .'\')" >' . ($pages) .'</a></li>';
			}
			
			if($_POST["page"] < $pages)
				$output = $output . '<li><a href="#0" class="next" title="next page" onclick="getproductbySearch(\'' . ($_POST["page"]+1) . '\')" >&#10095;</a></li>';
			else				
				$output = $output . '<li><a href="#0" class="next" title="next page">&#10095;</a></li>';
			
			
		}
		 return $output;
	}

}
?>
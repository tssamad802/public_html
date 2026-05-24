<?php 
include_once("../classes/commonfunctions.php");
include_once("../classes/ajaxpagination.class.php");
include_once("ajax.php");
$whereCond = '';
$q = $_REQUEST['q'];
$Active = $_REQUEST['Active'];


if($q!='' && $q != 'Text')
{
	$whereCond .= ' and (Title like "%'.$q.'%" OR TitleAr like "%'.$q.'%")';
}

if($Active != '')
{
	$whereCond .= ' and Active="'.$Active.'"';
}
if($_REQUEST['actions'] == "book_categories_listing")
{
	$perPage = new PerPage();
	$page = 1;
	if(!empty($_REQUEST["page"])) {
	$page = $_REQUEST["page"];
	}
	$start = ($page-1)*$perPage->perpage;
	if($start < 0) $start = 0;
	$queryproduct = "select * from tblbookcategory where 1 ".$whereCond." order by Sequence asc";
	$db->query($queryproduct);
	$rowcount = $db->num_rows();
	$queryproduct =  $queryproduct . " limit " . $start . "," . $perPage->perpage; 
	$db1->query($queryproduct);
	// $RecordCount=$pagelimit * ($start - 1);
	
	$perpageresult = $perPage->getAllPageLinks($rowcount,'/ajax/ajax_book_categories_listing.php?actions=book_categories_listing&page=','searchfrm','resultDiv');
	$Counterlisting = 0;
	if($db1->num_rows() > 0)
	{ 
		while($db1->next_record())
		{
			$Counterlisting++;
			if(file_exists('../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/'.TXT_THUMBNAIL_IMAGE_PATH.$db1->f("ThumbnailImage"))){
				$ThumbnailImage = RESOURCES_DOMAIN.'/'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/'.TXT_THUMBNAIL_IMAGE_PATH.$db1->f("ThumbnailImage");
			   }else{
				$ThumbnailImage = RESOURCES_DOMAIN.'/'.DEFAULT_IMAGES_FOLDER.'/default_news.jpg';
			   }
			$urlPath = RESOURCES_DOMAIN.'/'.BOOK_CATEGORIES_URL.'/'.$db1->f('URLKeyword');
			$output .= '<div class="col-md-4 col-sm-6">
							<div class="box-new">
                            <div class="post-item ver3 overlay space-20">
								<div class="wrap-images">
									<a class="images" href="'.$urlPath.'" title="'.clearTextForField($db1->f("Title".LANG_SEP_DB)).'">
										<img src="'.$ThumbnailImage.'" alt="" class="img-responsive">
									</a>
								</div>
								<div class="text">
									<h2><a href="'.$urlPath.'" title="'.clearTextForField($db1->f("Title".LANG_SEP_DB)).'">'.clearTextForField($db1->f("Title".LANG_SEP_DB)).'</a></h2>
								</div>
							</div>
                        </div>
						</div>
						';
			$output .= ($Counterlisting%3==0)?'<div class="clearfix"></div>':'';
						
		}
	}
	else
	{
		 $output .= '<div class="col-sm-12 text-center"><span class="norecordFound">'.DSB_NO_RECORDS.'</span></div>';
	}
	
	
	$output .= '<div class="box center float-left space-30">
					<nav class="pagination paginationNew">' . $perpageresult . '</nav>
				</div>';

	echo $output;
}

if($_REQUEST['actions'] == "leftmenu")
{
	$sql="select * from tblnews where Active='".ACTIVE."'  order by NewsDate DESC, TableID DESC"; 
	$db->query($sql);
	
	if($db->num_rows() > 0)
	{ 
		
		$finalstring .= '<ul class="sideBarList">';
		
		while($db->next_record())
		{
			$urlPath = RESOURCES_DOMAIN.'/'.NEWS_URL.'/'.$db->f('URLKeyword');
			
			$finalstring .= '<li class="'.$class.'"><a href="'.$urlPath.'">'.clearTextForField($db->f("Title".LANG_SEP_DB)).'</a></li>'; 
		} 
		
			$finalstring .= '</ul>';
			
		echo  $finalstring;
	}
	
}
?>
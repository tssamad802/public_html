<?php
// add master form


else if($ActionFlag == 'AddEditNews')
{
	$TableName =  "tblnews";
	if(isset($_POST['URLKeyword']))
    	$URLKeywordDublicate = getFieldDataByID("TableID","URLKeyword",$_POST['URLKeyword'],$TableName);
	
    
	if(in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $BannerImageWidth = getWidth($_FILES['BannerImage']['tmp_name']);
        $BannerImageHeight = getHeight($_FILES['BannerImage']['tmp_name']);
    }
  
    if($URLKeywordDublicate  > 0 && $RecordID!=$URLKeywordDublicate && $Trigger == 'edit')
    {
        $result['error'] = ERROR_PAGE_URL;
    } 
    else if(!in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $result['error'] = ERROR_PAGE_BANNER_CHOOSE;
    } 
    else if(!in_array($_FILES['ThumbnailImage']['type'],$AllowedImageExtension) && $_FILES['ThumbnailImage']['type']!='')
    {
        $result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
    } 
    else if($BannerImageWidth > 0 && ($BannerImageWidth!=INNER_PAGE_BANNER_WIDTH || $BannerImageHeight!=INNER_PAGE_BANNER_HEIGHT))
    {
       // $result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
    }  
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
            $Query = "insert into $TableName set   ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle']=="")?$_POST['Title']:$_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = ($_POST['MetaTitleAr']=="")?$_POST['TitleAr']:$_POST['MetaTitleAr'];
        }
         
        $Query .=  "Title='".secureTextForDb($_POST['Title'])."',
					TitleAr='".secureTextForDb($_POST['TitleAr'])."', 
					BriefDescription='".secureTextForDb($_POST['BriefDescription'])."', 
					BriefDescriptionAr='".secureTextForDb($_POST['BriefDescriptionAr'])."' ,  
					Description='".secureTextForDb($_POST['Description'])."' ,  
					DescriptionAr='".secureTextForDb($_POST['DescriptionAr'])."' ,  
					NewsDate='".secureTextForDb($_POST['NewsDate'])."' ,  
					Active='".secureTextForDb($_POST['Active'])."' ,  
					ShowHome='".secureTextForDb($_POST['ShowHome'])."' ,  
					MetaTitle='".secureTextForDb($_POST['MetaTitle'])."' ,  
					MetaTitleAr='".secureTextForDb($_POST['MetaTitleAr'])."' , 
					MetaKeywords='".secureTextForDb($_POST['MetaKeywords'])."' ,  
					MetaKeywordsAr='".secureTextForDb($_POST['MetaKeywordsAr'])."' ,  
					MetaDescription='".secureTextForDb($_POST['MetaDescription'])."' , 
					MetaDescriptionAr='".secureTextForDb($_POST['MetaDescriptionAr'])."' , 
					MetaOthers='".secureTextForDb($_POST['MetaOthers'])."' ,  
					MetaOthersAr='".secureTextForDb($_POST['MetaOthersAr'])."'    
				   ";

        if($_POST['URLKeyword'] == '')
        {
            $URLKeyword = SEOFriendlyURL($_POST['Title']); 

            $URLKeyword = SEOFriendlyPageURL($URLKeyword,$URLKeyword,$TableName); 
        }
        else
        {
            $URLKeyword = $_POST['URLKeyword'];
        }
		
        if($URLKeyword != '')
            $Query .= " , URLKeyword = '".secureTextForDb($URLKeyword)."' ";

        $tmpBannerImage = $_FILES['BannerImage']['tmp_name'];
		$FileNameBanner = date("YmdHis").'-'.rand(0,1000);
        $UploadBannerImage = $FileNameBanner.makeExtention($_FILES['BannerImage']['type']);
        $FileNameBannerImage= '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/'.$UploadBannerImage; 
        $FileNameBannerImageCrop = '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$UploadBannerImage; 
        if(move_uploaded_file($tmpBannerImage, $FileNameBannerImage))
        {
            $Query .= " , BannerImage = '".secureTextForDb($UploadBannerImage)."' ";
			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
        }
		
		
        $tmpThumbnailImage = $_FILES['ThumbnailImage']['tmp_name'];
        $FileNameThumbnail = date("YmdHis").'-'.rand(0,1000); 
        $ThumbnailImageName = $FileNameThumbnail.makeExtention($_FILES['ThumbnailImage']['type']); 
        $FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$ThumbnailImageName;
        $UploadThumbnailImageSmall= '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$ThumbnailImageName;
        $UploadThumbnailImageCrop = '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$ThumbnailImageName;
        if(move_uploaded_file($tmpThumbnailImage, $FileNameThumbnailImage))
        {
			
			$resizeObj = new resize($FileNameThumbnailImage);
			$resizeObj -> resizeImage(HOME_PAGE_THUMBNAIL_WIDTH, HOME_PAGE_THUMBNAIL_HEIGHT, 'crop');
			$resizeObj -> saveImage($UploadThumbnailImageSmall, 100);
            $Query .= " , ThumbnailImage = '".secureTextForDb($ThumbnailImageName)."' ";
			CropimageSave($_POST['ImageCropData2'],$UploadThumbnailImageCrop);
        }
 
		
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?NEWS_EDIT_SUCESSFULLY:NEWS_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }


    echo json_encode($result);
}

else if($ActionFlag == 'AddEditSystemImages')
{
	$TableName =  "tblsystemimages";  
	$tmpThumbnailImage = $_FILES['file']['tmp_name'];
	$ThumbnailImageName = date("YmdHis").'-'.rand(0,1000).makeExtention($_FILES['file']['type']); 
	$FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$ThumbnailImageName;
	$UploadThumbnailImageSmall= '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$ThumbnailImageName;
	if(move_uploaded_file($tmpThumbnailImage, $FileNameThumbnailImage))
	{
		
		$resizeObj = new resize($FileNameThumbnailImage);
		$resizeObj -> resizeImage(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, 'crop');
		$resizeObj -> saveImage($UploadThumbnailImageSmall, 100);
		 if($Trigger == 'edit')
		{
			$Query = "update $TableName set ";
			$logaction = 2;
		}
		else
		{ 
			$Sequence = maxID("Sequence", $TableName, 1);
			$Query = "insert into $TableName set  Sequence='".$Sequence."', ";
			$logaction = 1; 
		}
		 
		$Query .=  "ParentID='".secureTextForDb($ParentID)."',
					TypeID='".secureTextForDb($TypeID)."', 
					FileName='".secureTextForDb($ThumbnailImageName)."' 
				   ";
				   
				   
		if($Trigger == 'edit')
			$Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
		else
			$Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
		$db->query($Query);
		$InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction); 
	}
}
else if($ActionFlag == 'AddEditVideo')
{
	$TableName =  "tblsystemvideos";
	$valid = preg_match("/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/watch\?v\=\w+$/", $_POST['FileName']); 
	if($valid== false && $_POST['VideoType']==1)
	{ 
        $result['error'] = ERROR_YOUTUBE_LINK;
	} 
    else if($_FILES['Video']['type']!='' && $_POST['VideoType']==2 && $_FILES['Video']['size'] > (VIDEO_UPLOAD_SIZE*1000000) )
    {
        $result['error'] = str_replace("{mb}",VIDEO_UPLOAD_SIZE,ERROR_VIDEO_SIZE);
    } 
    else if(!in_array($_FILES['Video']['type'],$AllowedVideoExtension) && $_FILES['Video']['type']!='' && $_POST['VideoType']==2)
    {
        $result['error'] = ERROR_VIDEO_FORMAT;
    }  
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
			$Sequence = maxID("Sequence", $TableName, 1);
			$Query = "insert into $TableName set  Sequence='".$Sequence."', ";
			$logaction = 1; 
        }
         
        $Query .=  "ParentID='".secureTextForDb($ParentID)."',
					VideoType='".secureTextForDb($_REQUEST['VideoType'])."',   
					TypeID='".secureTextForDb($TypeID)."'   
				   ";

        if($_POST['VideoType']==1)
        {
            $Query .= " , FileName = '".secureTextForDb($_REQUEST['FileName'])."' ";
        } 
		 
		if($_POST['VideoType']==2)
		{ 
			$tmpBannerImage = $_FILES['Video']['tmp_name'];
			$UploadBannerImage = date("YmdHis").'-'.rand(0,1000).makeExtention($_FILES['Video']['type']);
			$FileNameBannerImage= '../'.FILES_FOLDER.'/'.UPLOAD_VIDEOS.'/'.$UploadBannerImage;
			if(move_uploaded_file($tmpBannerImage, $FileNameBannerImage))
			{
				$Query .= " , FileName = '".secureTextForDb($UploadBannerImage)."' ";
			}
		}
		 
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['selfredirect'] = 1;
        $_SESSION['Message']['Msg'] = MSG_SUCESSFULLY_ADDED;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}
else if($ActionFlag == 'AddEditAnnouncement')
{
	$TableName =  "tblannouncement";
	if(isset($_POST['URLKeyword']))
    	$URLKeywordDublicate = getFieldDataByID("TableID","URLKeyword",$_POST['URLKeyword'],$TableName);
	
    
	if(in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $BannerImageWidth = getWidth($_FILES['BannerImage']['tmp_name']);
        $BannerImageHeight = getHeight($_FILES['BannerImage']['tmp_name']);
    }
  	if($_POST['AnnouncementDate']=="")
    {
        $result['error'] = ERROR_ANNOUNCEMENT_DATE;
    } 
  	else if($_POST['FromDate']=="")
    {
        $result['error'] = ERROR_FROM_DATE;
    } 
  	else if(strtotime($_POST['FromDate']) > strtotime($_POST['ToDate']) && $_POST['ToDate']!='')
    {
        $result['error'] = ERROR_TO_DATE_GREATER;
    } 
    else if($URLKeywordDublicate  > 0 && $RecordID!=$URLKeywordDublicate && $Trigger == 'edit')
    {
        $result['error'] = ERROR_PAGE_URL;
    } 
    else if(!in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $result['error'] = ERROR_PAGE_BANNER_CHOOSE;
    }
    else if($BannerImageWidth > 0 && ($BannerImageWidth!=INNER_PAGE_BANNER_WIDTH || $BannerImageHeight!=INNER_PAGE_BANNER_HEIGHT))
    {
        //$result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
    }  
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
            $Query = "insert into $TableName set   ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle']=="")?$_POST['Title']:$_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = ($_POST['MetaTitleAr']=="")?$_POST['TitleAr']:$_POST['MetaTitleAr'];
        }
         
        $Query .=  "Title='".secureTextForDb($_POST['Title'])."',
					TitleAr='".secureTextForDb($_POST['TitleAr'])."', 
					BriefDescription='".secureTextForDb($_POST['BriefDescription'])."', 
					BriefDescriptionAr='".secureTextForDb($_POST['BriefDescriptionAr'])."' ,  
					Description='".secureTextForDb($_POST['Description'])."' ,  
					DescriptionAr='".secureTextForDb($_POST['DescriptionAr'])."' ,  
					AnnouncementDate='".secureTextForDb($_POST['AnnouncementDate'])."' ,  
					FromDate='".secureTextForDb($_POST['FromDate'])."' ,  
					ToDate='".secureTextForDb($_POST['ToDate'])."' ,  
					Active='".secureTextForDb($_POST['Active'])."' ,  
					ShowHome='".secureTextForDb($_POST['ShowHome'])."' ,  
					MetaTitle='".secureTextForDb($_POST['MetaTitle'])."' ,  
					MetaTitleAr='".secureTextForDb($_POST['MetaTitleAr'])."' , 
					MetaKeywords='".secureTextForDb($_POST['MetaKeywords'])."' ,  
					MetaKeywordsAr='".secureTextForDb($_POST['MetaKeywordsAr'])."' ,  
					MetaDescription='".secureTextForDb($_POST['MetaDescription'])."' , 
					MetaDescriptionAr='".secureTextForDb($_POST['MetaDescriptionAr'])."' , 
					MetaOthers='".secureTextForDb($_POST['MetaOthers'])."' ,  
					MetaOthersAr='".secureTextForDb($_POST['MetaOthersAr'])."'    
				   ";

        if($_POST['URLKeyword'] == '')
        {
            $URLKeyword = SEOFriendlyURL($_POST['Title']); 

            $URLKeyword = SEOFriendlyPageURL($URLKeyword,$URLKeyword,$TableName); 
        }
        else
        {
            $URLKeyword = $_POST['URLKeyword'];
        }
		
        if($URLKeyword != '')
            $Query .= " , URLKeyword = '".secureTextForDb($URLKeyword)."' ";

        $tmpBannerImage = $_FILES['BannerImage']['tmp_name'];
		$FileNameBanner = date("YmdHis").'-'.rand(0,1000);
        $UploadBannerImage = $FileNameBanner.makeExtention($_FILES['BannerImage']['type']);
        $FileNameBannerImage= '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/'.$UploadBannerImage;
        $FileNameBannerImageCrop = '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$UploadBannerImage; 
        if(move_uploaded_file($tmpBannerImage, $FileNameBannerImage))
        {
            $Query .= " , BannerImage = '".secureTextForDb($UploadBannerImage)."' ";
			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
        }
		 
		 
		 
  
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModificationDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreationDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?ANNOUNCEMENT_EDIT_SUCESSFULLY:ANNOUNCEMENT_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}
else if($ActionFlag == 'AddEditEvents')
{
	$TableName =  "tblevents";
	if(isset($_POST['URLKeyword']))
    	$URLKeywordDublicate = getFieldDataByID("TableID","URLKeyword",$_POST['URLKeyword'],$TableName);
	
    
	if(in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $BannerImageWidth = getWidth($_FILES['BannerImage']['tmp_name']);
        $BannerImageHeight = getHeight($_FILES['BannerImage']['tmp_name']);
    }
  	if($_POST['ToDate']=="")
    {
        $result['error'] = ERROR_TO_DATE;
    } 
  	else if($_POST['FromDate']=="")
    {
        $result['error'] = ERROR_FROM_DATE;
    } 
  	else if(strtotime($_POST['FromDate']) > strtotime($_POST['ToDate']) && $_POST['ToDate']!='')
    {
        $result['error'] = ERROR_TO_DATE_GREATER;
    } 
    else if($URLKeywordDublicate  > 0 && $RecordID!=$URLKeywordDublicate && $Trigger == 'edit')
    {
        $result['error'] = ERROR_PAGE_URL;
    } 
    else if(!in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $result['error'] = ERROR_PAGE_BANNER_CHOOSE;
    } 
    else if(!in_array($_FILES['ThumbnailImage']['type'],$AllowedImageExtension) && $_FILES['ThumbnailImage']['type']!='')
    {
        $result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
    } 
    else if($BannerImageWidth > 0 && ($BannerImageWidth!=INNER_PAGE_BANNER_WIDTH || $BannerImageHeight!=INNER_PAGE_BANNER_HEIGHT))
    {
        //$result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
    }  
	 
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
		
			$Sequence = maxID("Sequence", $TableName, 1);
            $Query = "insert into $TableName set  Sequence=$Sequence , ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle']=="")?$_POST['Title']:$_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = ($_POST['MetaTitleAr']=="")?$_POST['TitleAr']:$_POST['MetaTitleAr'];
        }
         
        $Query .=  "Title='".secureTextForDb($_POST['Title'])."',
					TitleAr='".secureTextForDb($_POST['TitleAr'])."', 
					BriefDescription='".secureTextForDb($_POST['BriefDescription'])."', 
					BriefDescriptionAr='".secureTextForDb($_POST['BriefDescriptionAr'])."' ,  
					Description='".secureTextForDb($_POST['Description'])."' ,  
					DescriptionAr='".secureTextForDb($_POST['DescriptionAr'])."' ,  
					Active='".secureTextForDb($_POST['Active'])."' ,  
					ShowHome='".secureTextForDb($_POST['ShowHome'])."' , 
					ShowMenu='".secureTextForDb($_POST['ShowMenu'])."' ,  
					FromDate='".secureTextForDb($_POST['FromDate'])."' ,  
					ToDate='".secureTextForDb($_POST['ToDate'])."' ,  
					MetaTitle='".secureTextForDb($_POST['MetaTitle'])."' ,  
					MetaTitleAr='".secureTextForDb($_POST['MetaTitleAr'])."' , 
					MetaKeywords='".secureTextForDb($_POST['MetaKeywords'])."' ,  
					MetaKeywordsAr='".secureTextForDb($_POST['MetaKeywordsAr'])."' ,  
					MetaDescription='".secureTextForDb($_POST['MetaDescription'])."' , 
					MetaDescriptionAr='".secureTextForDb($_POST['MetaDescriptionAr'])."' , 
					MetaOthers='".secureTextForDb($_POST['MetaOthers'])."' ,  
					MetaOthersAr='".secureTextForDb($_POST['MetaOthersAr'])."'    
				   ";

        if($_POST['URLKeyword'] == '')
        {
            $URLKeyword = SEOFriendlyURL($_POST['Title']); 

            $URLKeyword = SEOFriendlyPageURL($URLKeyword,$URLKeyword,$TableName); 
        }
        else
        {
            $URLKeyword = $_POST['URLKeyword'];
        }
		
        if($URLKeyword != '')
            $Query .= " , URLKeyword = '".secureTextForDb($URLKeyword)."' ";

        $tmpBannerImage = $_FILES['BannerImage']['tmp_name'];
		$FileNameBanner = date("YmdHis").'-'.rand(0,1000);
        $UploadBannerImage = $FileNameBanner.makeExtention($_FILES['BannerImage']['type']);
        $FileNameBannerImage= '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/'.$UploadBannerImage; 
        $FileNameBannerImageCrop = '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$UploadBannerImage; 
        if(move_uploaded_file($tmpBannerImage, $FileNameBannerImage))
        {
            $Query .= " , BannerImage = '".secureTextForDb($UploadBannerImage)."' ";
			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
        }
		
		
        $tmpThumbnailImage = $_FILES['ThumbnailImage']['tmp_name'];
        $FileNameThumbnail = date("YmdHis").'-'.rand(0,1000); 
        $ThumbnailImageName = $FileNameThumbnail.makeExtention($_FILES['ThumbnailImage']['type']); 
        $FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$ThumbnailImageName;
        $UploadThumbnailImageSmall= '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$ThumbnailImageName;
        $UploadThumbnailImageCrop = '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$ThumbnailImageName;
        if(move_uploaded_file($tmpThumbnailImage, $FileNameThumbnailImage))
        {
			
			$resizeObj = new resize($FileNameThumbnailImage);
			$resizeObj -> resizeImage(THUMBNAIL_EVENT_WIDTH, THUMBNAIL_EVENT_HEIGHT, 'crop');
			$resizeObj -> saveImage($UploadThumbnailImageSmall, 100);
            $Query .= " , ThumbnailImage = '".secureTextForDb($ThumbnailImageName)."' ";
			CropimageSave($_POST['ImageCropData2'],$UploadThumbnailImageCrop);
        }
 
		
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?EVENT_EDIT_SUCESSFULLY:EVENT_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}

else if($ActionFlag == 'AddEditPublication')
{
	$TableName =  "tblpublications";
	if(isset($_POST['URLKeyword']))
    	$URLKeywordDublicate = getFieldDataByID("TableID","URLKeyword",$_POST['URLKeyword'],$TableName);
	
    
	if(in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $BannerImageWidth = getWidth($_FILES['BannerImage']['tmp_name']);
        $BannerImageHeight = getHeight($_FILES['BannerImage']['tmp_name']);
    }
  	if($Trigger != 'edit' && $_FILES['FileName']['name'] == '')
	{
		$result['error'] = ERROR_SELECT_FILE;
	}
	else if($Trigger != 'edit' && $_FILES['FileNameAr']['name'] == '')
	{
		$result['error'] = ERROR_SELECT_FILE_ARABIC;
	}
	else if(!in_array($_FILES['FileName']['type'],$AllowedFileExtension) && $_FILES['FileName']['type']!='')
	{
		$result['error'] = ERROR_PAGE_FILE_CHOOSE;
	}
	else if($_FILES['FileName']['size'] > (MAX_FILE_SIZE_FOR_BOOK*1000000))
	{
		$result['error'] = ERROR_UPLOADSIZE;
	}
	else if(!in_array($_FILES['FileNameAr']['type'],$AllowedFileExtension) && $_FILES['FileNameAr']['type']!='')
	{
		$result['error'] = ERROR_PAGE_FILE_CHOOSE;
	}
	else if($_FILES['FileNameAr']['size'] > (MAX_FILE_SIZE_FOR_BOOK*1000000))
	{
		$result['error'] = ERROR_UPLOADSIZE;
	}
    else if($URLKeywordDublicate  > 0 && $RecordID!=$URLKeywordDublicate && $Trigger == 'edit')
    {
        $result['error'] = ERROR_PAGE_URL;
    } 
    else if(!in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $result['error'] = ERROR_PAGE_BANNER_CHOOSE;
    } 
    else if(!in_array($_FILES['ThumbnailImage']['type'],$AllowedImageExtension) && $_FILES['ThumbnailImage']['type']!='')
    {
        $result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
    } 
    else if($BannerImageWidth > 0 && ($BannerImageWidth!=INNER_PAGE_BANNER_WIDTH || $BannerImageHeight!=INNER_PAGE_BANNER_HEIGHT))
    {
       // $result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
    }  
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
		
			$Sequence = maxID("Sequence", $TableName, 1);
            $Query = "insert into $TableName set Sequence = $Sequence , ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle']=="")?$_POST['Title']:$_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = ($_POST['MetaTitleAr']=="")?$_POST['TitleAr']:$_POST['MetaTitleAr'];
        }
         
        $Query .=  "Title='".secureTextForDb($_POST['Title'])."',
					TitleAr='".secureTextForDb($_POST['TitleAr'])."', 
					CategoryID='".secureTextForDb($_POST['CategoryID'])."', 
					BriefDescription='".secureTextForDb($_POST['BriefDescription'])."', 
					BriefDescriptionAr='".secureTextForDb($_POST['BriefDescriptionAr'])."' ,  
					Description='".secureTextForDb($_POST['Description'])."' ,  
					DescriptionAr='".secureTextForDb($_POST['DescriptionAr'])."' ,  
					Active='".secureTextForDb($_POST['Active'])."' ,  
					ShowHome='".secureTextForDb($_POST['ShowHome'])."' ,  
					MetaTitle='".secureTextForDb($_POST['MetaTitle'])."' ,  
					MetaTitleAr='".secureTextForDb($_POST['MetaTitleAr'])."' , 
					MetaKeywords='".secureTextForDb($_POST['MetaKeywords'])."' ,  
					MetaKeywordsAr='".secureTextForDb($_POST['MetaKeywordsAr'])."' ,  
					MetaDescription='".secureTextForDb($_POST['MetaDescription'])."' , 
					MetaDescriptionAr='".secureTextForDb($_POST['MetaDescriptionAr'])."' , 
					MetaOthers='".secureTextForDb($_POST['MetaOthers'])."' ,  
					MetaOthersAr='".secureTextForDb($_POST['MetaOthersAr'])."'    
				   ";

        if($_POST['URLKeyword'] == '')
        {
            $URLKeyword = SEOFriendlyURL($_POST['Title']); 

            $URLKeyword = SEOFriendlyPageURL($URLKeyword,$URLKeyword,$TableName); 
        }
        else
        {
            $URLKeyword = $_POST['URLKeyword'];
        }
		
        if($URLKeyword != '')
            $Query .= " , URLKeyword = '".secureTextForDb($URLKeyword)."' ";
		
		$tmpBannerImage = $_FILES['BannerImage']['tmp_name'];
		$FileNameBanner = date("YmdHis").'-'.rand(0,1000);
        $UploadBannerImage = $FileNameBanner.makeExtention($_FILES['BannerImage']['type']);
        $FileNameBannerImage= '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/'.$UploadBannerImage; 
        $FileNameBannerImageCrop = '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/cropthumb_'.$UploadBannerImage; 
        if(move_uploaded_file($tmpBannerImage, $FileNameBannerImage))
        {
            $Query .= " , BannerImage = '".secureTextForDb($UploadBannerImage)."' ";
			CropimageSave($_POST['ImageCropData1'],$FileNameBannerImageCrop);
        }
		
		
        $tmpThumbnailImage = $_FILES['ThumbnailImage']['tmp_name'];
        $FileNameThumbnail = date("YmdHis").'-'.rand(0,1000); 
        $ThumbnailImageName = $FileNameThumbnail.makeExtention($_FILES['ThumbnailImage']['type']); 
        $FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$ThumbnailImageName;
        $UploadThumbnailImageSmall= '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$ThumbnailImageName;
        $UploadThumbnailImageCrop = '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$ThumbnailImageName;
        if(move_uploaded_file($tmpThumbnailImage, $FileNameThumbnailImage))
        {
			$resizeObj = new resize($FileNameThumbnailImage);
			$resizeObj -> resizeImage(HOME_PAGE_THUMBNAIL_WIDTH, HOME_PAGE_THUMBNAIL_HEIGHT, 'crop');
			$resizeObj -> saveImage($UploadThumbnailImageSmall, 100);
            $Query .= " , ThumbnailImage = '".secureTextForDb($ThumbnailImageName)."' ";
			CropimageSave($_POST['ImageCropData2'],$UploadThumbnailImageCrop);
        }
 
		
		if($_FILES['FileName']['name'] != '')
		{
			$tmpFile = $_FILES['FileName']['tmp_name'];
			$UploadFile = date("YmdHis").'-'.rand(0,1000).makeExtention($_FILES['FileName']['type']);
			$FileNameFile= '../'.FILES_FOLDER.'/'.DOCUMENT_FOLDER.'/'.$UploadFile;
			if(move_uploaded_file($tmpFile, $FileNameFile))
			{
				$Query .= " , FileName = '".secureTextForDb($UploadFile)."' ";
			}
		}
		if($_FILES['FileNameAr']['name'] != '')
		{
			$tmpFileAr = $_FILES['FileNameAr']['tmp_name'];
			$UploadFileAr = date("YmdHis").'-'.rand(0,1000).makeExtention($_FILES['FileNameAr']['type']);
			$FileNameArFile= '../'.FILES_FOLDER.'/'.DOCUMENT_FOLDER.'/'.$UploadFileAr;
			if(move_uploaded_file($tmpFileAr, $FileNameArFile))
			{
				$Query .= " , FileNameAr = '".secureTextForDb($UploadFileAr)."' ";
			}
		}
 
		
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?PUBLICATION_EDIT_SUCESSFULLY:PUBLICATION_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}
else if($ActionFlag == 'AddEditCourse')
{
	$TableName =  "tblcourses";
	if(isset($_POST['URLKeyword']))
    	$URLKeywordDublicate = getFieldDataByID("TableID","URLKeyword",$_POST['URLKeyword'],$TableName);
	
    
	if(in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $BannerImageWidth = getWidth($_FILES['BannerImage']['tmp_name']);
        $BannerImageHeight = getHeight($_FILES['BannerImage']['tmp_name']);
    }
  	if($URLKeywordDublicate  > 0 && $RecordID!=$URLKeywordDublicate && $Trigger == 'edit')
    {
        $result['error'] = ERROR_PAGE_URL;
    } 
    else if(!in_array($_FILES['BannerImage']['type'],$AllowedImageExtension) && $_FILES['BannerImage']['type']!='')
    {
        $result['error'] = ERROR_PAGE_BANNER_CHOOSE;
    } 
    else if(!in_array($_FILES['ThumbnailImage']['type'],$AllowedImageExtension) && $_FILES['ThumbnailImage']['type']!='')
    {
        $result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
    } 
    else if($BannerImageWidth > 0 && ($BannerImageWidth!=INNER_PAGE_BANNER_WIDTH || $BannerImageHeight!=INNER_PAGE_BANNER_HEIGHT))
    {
        $result['error'] = ERROR_PAGE_BANNER_WIDTH_HEIGHT.INNER_PAGE_BANNER_WIDTH."x".INNER_PAGE_BANNER_HEIGHT;
    }  
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
		
			$Sequence = maxID("Sequence", $TableName, 1);
            $Query = "insert into $TableName set Sequence = $Sequence , ";
			$logaction = 1;
			$_POST['MetaTitle'] = ($_POST['MetaTitle']=="")?$_POST['Title']:$_POST['MetaTitle'];
			$_POST['MetaTitleAr'] = ($_POST['MetaTitleAr']=="")?$_POST['TitleAr']:$_POST['MetaTitleAr'];
        }
         
        $Query .=  "Title='".secureTextForDb($_POST['Title'])."',
					TitleAr='".secureTextForDb($_POST['TitleAr'])."', 
					CategoryID='".secureTextForDb($_POST['CategoryID'])."', 
					BriefDescription='".secureTextForDb($_POST['BriefDescription'])."', 
					BriefDescriptionAr='".secureTextForDb($_POST['BriefDescriptionAr'])."' ,  
					Description='".secureTextForDb($_POST['Description'])."' ,  
					DescriptionAr='".secureTextForDb($_POST['DescriptionAr'])."' ,  
					PassPercentage='".secureTextForDb($_POST['PassPercentage'])."' ,   
					Active='".secureTextForDb($_POST['Active'])."' ,  
					ShowHome='".secureTextForDb($_POST['ShowHome'])."' ,  
					MetaTitle='".secureTextForDb($_POST['MetaTitle'])."' ,  
					MetaTitleAr='".secureTextForDb($_POST['MetaTitleAr'])."' , 
					MetaKeywords='".secureTextForDb($_POST['MetaKeywords'])."' ,  
					MetaKeywordsAr='".secureTextForDb($_POST['MetaKeywordsAr'])."' ,  
					MetaDescription='".secureTextForDb($_POST['MetaDescription'])."' , 
					MetaDescriptionAr='".secureTextForDb($_POST['MetaDescriptionAr'])."' , 
					MetaOthers='".secureTextForDb($_POST['MetaOthers'])."' ,  
					MetaOthersAr='".secureTextForDb($_POST['MetaOthersAr'])."'    
				   ";

        if($_POST['URLKeyword'] == '')
        {
            $URLKeyword = SEOFriendlyURL($_POST['Title']); 

            $URLKeyword = SEOFriendlyPageURL($URLKeyword,$URLKeyword,$TableName); 
        }
        else
        {
            $URLKeyword = $_POST['URLKeyword'];
        }
		
        if($URLKeyword != '')
            $Query .= " , URLKeyword = '".secureTextForDb($URLKeyword)."' ";

        $tmpBannerImage = $_FILES['BannerImage']['tmp_name'];
        $UploadBannerImage = date("YmdHis").'-'.rand(0,1000).makeExtention($_FILES['BannerImage']['type']);
        $FileNameBannerImage= '../'.FILES_FOLDER.'/'.BANNER_FOLDER.'/'.$UploadBannerImage;
		$UploadBannerCrop = '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$UploadBannerImage;
        if(move_uploaded_file($tmpBannerImage, $FileNameBannerImage))
        {
            $Query .= " , BannerImage = '".secureTextForDb($UploadBannerImage)."' ";
			CropimageSave($_POST['ImageCropData1'],$UploadBannerCrop);
        }
		
		
		 
		
		
		
        $tmpThumbnailImage = $_FILES['ThumbnailImage']['tmp_name'];
        $ThumbnailImageName = date("YmdHis").'-'.rand(0,1000).makeExtention($_FILES['ThumbnailImage']['type']); 
        $FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$ThumbnailImageName;
        $UploadThumbnailImageSmall= '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$ThumbnailImageName;
		$UploadThumbnailImageCrop = '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$ThumbnailImageName;
        if(move_uploaded_file($tmpThumbnailImage, $FileNameThumbnailImage))
        {
			$resizeObj = new resize($FileNameThumbnailImage);
			$resizeObj -> resizeImage(HOME_PAGE_COURSE_THUMBNAIL_WIDTH, HOME_PAGE_COURSE_THUMBNAIL_HEIGHT, 'crop');
			$resizeObj -> saveImage($UploadThumbnailImageSmall, 100);
            $Query .= " , ThumbnailImage = '".secureTextForDb($ThumbnailImageName)."' ";
			CropimageSave($_POST['ImageCropData2'],$UploadThumbnailImageCrop);
        }
		
 
		
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?COURSE_EDIT_SUCESSFULLY:COURSE_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}

else if($ActionFlag == 'AddEditAssessmentTest')
{
	$TableName =  "tblcoursequestion";
	if(isset($_POST['Title']))
    	$TitleDublicate = getFieldDataByID("TableID","Title",$_POST['Title'],$TableName);
	if(isset($_POST['TitleAr']))
    	$TitleArDublicate = getFieldDataByID("TableID","TitleAr",$_POST['TitleAr'],$TableName); 
   
  	if($TitleDublicate  > 0 && $RecordID!=$TitleDublicate)
    {
		$result['error'] = $_POST['Title']." ".ERROR_ALREADY_EXISTS;
    } 
    else if($TitleArDublicate  > 0 && $RecordID!=$TitleArDublicate)
    {
		$result['error'] = $_POST['TitleAr']." ".ERROR_ALREADY_EXISTS;
    }
    else if(count($_POST['CorrectAnswer'])==0)
    {
		$result['error'] = ERROR_CHOOSE_CORRECT_ANSWER;
    } 
   
    if($result['error']=='')
    { 
        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
		
			$Sequence = maxID("Sequence", $TableName, 1);
            $Query = "insert into $TableName set Sequence = $Sequence , ";
			$logaction = 1;
        }
         
        $Query .=  "Title='".secureTextForDb($_POST['Title'])."',
					TitleAr='".secureTextForDb($_POST['TitleAr'])."', 
					CourseID='".secureTextForDb($ParentID)."',
					Active='".secureTextForDb($_POST['Active'])."'      
				   ";

        
 
		
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
		
		if(count($_POST['OptionTitle']) > 0)
		{
			foreach($_POST['OptionTitle'] as $key => $values)
			{
				$TableID = decodeencriptstring($_POST['OptionID'][$key]);
				if($TableID > 0)
				{ 
					$QueryOption = "update tblcoursequestionoption set ";
					$logaction = 2;
				}
				else
				{
					$Sequence = maxID("Sequence", "tblcoursequestionoption", 1);
					$QueryOption = "insert into tblcoursequestionoption set Sequence = $Sequence ,  Active='1', ";
					$logaction = 1;
				}
				
				
					$QueryOption .=  " Title='".secureTextForDb($values)."',
								TitleAr='".secureTextForDb($_POST['OptionTitleAr'][$key])."', 
								CourseID='".secureTextForDb($ParentID)."' , 
								QuestionID='".secureTextForDb($InsertRecordID)."',   
								CorrectAnswer='".secureTextForDb($_POST['CorrectAnswer'][$key])."'      
							   ";
				
				if($TableID > 0)
					$QueryOption .= ", Active='".secureTextForDb($_POST['OptionActive'][$key])."' , 
								ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
								ModifiedDateTime=NOW()
								Where TableID='".$TableID."'
							  ";
				else
					$QueryOption .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
								CreatedDateTime=NOW()
							  ";
				
        		$db1->query($QueryOption);
        		$InsertOptionRecordID = $TableID > 0?$TableID:$db1->MysqlInsertID();  
				insertlogTable("tblcoursequestionoption",$InsertOptionRecordID,$logaction);			  
			}
		}
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID."&PageType=AssessmentTest&ParentID=".$ParentID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?ASESSMENT_TEST_EDIT_SUCESSFULLY:ASESSMENT_TEST_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}

else if($ActionFlag == 'AddEditLibrary')
{
	$TableName =  "tblbooklibrary"; 
	
	$Book = getFieldDataByID("TableID","Book",secureTextForDb($_POST['Book']),$TableName);   
	$BookAr = getFieldDataByID("TableID","BookAr",secureTextForDb($_POST['BookAr']),$TableName);    
	if($Book != $RecordID && $Book > 0)
	{
		$result['error'] = $_POST['Book'][$i]." ".ERROR_ALREADY_EXISTS;
	}  
	else if($BookAr != $RecordID && $BookAr > 0)
	{
		$result['error'] = $_POST['BookAr'][$i]." ".ERROR_ALREADY_EXISTS;
	}  
	else if(!in_array($_FILES['ThumbnailImage']['type'],$AllowedImageExtension) && $_FILES['ThumbnailImage']['type']!='')
    {
        $result['error'] = ERROR_THUMBNAIL_IMAGE_CHOOSE;
    }  
    if($result['error']=='')
    {

        if($Trigger == 'edit')
		{
            $Query = "update $TableName set ";
			$logaction = 2;
		}
        else
        { 
		
			//$Sequence = maxID("Sequence", $TableName, 1);
            $Query = "insert into $TableName set  ";
			$logaction = 1; 
        }
         
        $Query .=  "BookName='".secureTextForDb($_POST['BookName'])."',
					BookNameAr='".secureTextForDb($_POST['BookNameAr'])."', 
					CategoryID='".secureTextForDb($_POST['CategoryID'])."', 
					AuthorName='".secureTextForDb($_POST['AuthorName'])."', 
					AuthorNameAr='".secureTextForDb($_POST['AuthorNameAr'])."' ,  
					AuditorName='".secureTextForDb($_POST['AuditorName'])."' ,  
					AuditorNameAr='".secureTextForDb($_POST['AuditorNameAr'])."' ,  
					PublisherName='".secureTextForDb($_POST['PublisherName'])."' ,  
					PublisherNameAr='".secureTextForDb($_POST['PublisherNameAr'])."' ,  
					EditionNumber='".secureTextForDb($_POST['EditionNumber'])."' ,  
					Active='".secureTextForDb($_POST['Active'])."'     
				   ";
  
        $tmpThumbnailImage = $_FILES['ThumbnailImage']['tmp_name'];
        $FileNameThumbnail = date("YmdHis").'-'.rand(0,1000); 
        $ThumbnailImageName = $FileNameThumbnail.makeExtention($_FILES['ThumbnailImage']['type']); 
        $FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$ThumbnailImageName;
        $UploadThumbnailImageSmall= '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/thumbnail_'.$ThumbnailImageName;
        $UploadThumbnailImageCrop = '../'.FILES_FOLDER.'/'.THUMBNAIL_IMAGES.'/cropthumb_'.$ThumbnailImageName;
        if(move_uploaded_file($tmpThumbnailImage, $FileNameThumbnailImage))
        {
			
			$resizeObj = new resize($FileNameThumbnailImage);
			$resizeObj -> resizeImage(HOME_PAGE_THUMBNAIL_WIDTH, HOME_PAGE_THUMBNAIL_HEIGHT, 'crop');
			$resizeObj -> saveImage($UploadThumbnailImageSmall, 100);
            $Query .= " , ThumbnailImage = '".secureTextForDb($ThumbnailImageName)."' ";
			CropimageSave($_POST['ImageCropData2'],$UploadThumbnailImageCrop);
        }
		
 
		
        if($Trigger == 'edit')
            $Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						ModifiedDateTime=NOW()
						Where TableID='".$RecordID."'
					  ";
        else
            $Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()
					  ";
	
        $db->query($Query);
        $InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
		insertlogTable($TableName,$InsertRecordID,$logaction);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = $Trigger == 'edit'?LIBRARY_BOOK_EDIT_SUCESSFULLY:LIBRARY_BOOK_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}

else if($ActionFlag == 'AddEditSportsComplex')
{
    if($result['error']=='')
    {

        
       $Query = "insert into  tblsportcomplexremarks set 
	   				RequestID='".secureTextForDb($RecordID)."',
					Remarks='".secureTextForDb($_POST['Remarks'])."',
					StatusID='".secureTextForDb($_POST['StatusID'])."', 
					CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					CreatedDateTime=NOW()
					  "; 
        $db->query($Query); 
		
		
       $Query2 = "update tblsportscomplex set  
					Status='".secureTextForDb($_POST['StatusID'])."', 
					ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					ModifiedDateTime=NOW()
					where TableID='".secureTextForDb($RecordID)."'
					  "; 
        $db->query($Query2);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = REQUEST_REMARKS_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}
else if($ActionFlag == 'AddEditPublicationForm')
{
    if($result['error']=='')
    {

        
       $Query = "insert into  tblpublicationremarks set 
	   				RequestID='".secureTextForDb($RecordID)."',
					Remarks='".secureTextForDb($_POST['Remarks'])."',
					StatusID='".secureTextForDb($_POST['StatusID'])."', 
					CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					CreatedDateTime=NOW()
					  "; 
        $db->query($Query); 
		
		
       $Query2 = "update tblpublicationsubmission set  
					Status='".secureTextForDb($_POST['StatusID'])."', 
					ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					ModifiedDateTime=NOW()
					where TableID='".secureTextForDb($RecordID)."'
					  "; 
        $db->query($Query2);
		
        $result['success'] = 1;
        $result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
        $_SESSION['Message']['Msg'] = REQUEST_REMARKS_ADDED_SUCESSFULLY;
        $_SESSION['Message']['Type'] = 2;
    }

    echo json_encode($result);
}

else if($ActionFlag == 'AddEditNewsContact')
{
	if($_REQUEST['ImportData']==1)
	{
		
	   if(!in_array($_FILES['FileUpload']['type'],$AllowedExcel))
		{
			$result['error'] = ERROR_IMPORT_CONTACT;
		}
		if($result['error']=="")
		{ 
			$tmpFileUpload = $_FILES['FileUpload']['tmp_name'];
			$FileName = date("YmdHis").'-'.rand(0,1000); 
			$UploadImageName = $FileName.makeExtention($_FILES['FileUpload']['type']); 
			$FileNameThumbnailImage= '../'.FILES_FOLDER.'/'.ORIGINAL_IMAGES.'/'.$UploadImageName;
			if(move_uploaded_file($tmpFileUpload, $FileNameThumbnailImage))
			{
				 $Query = "insert into tblnewsletterfilelog set  
						CategoryID='".secureTextForDb($_POST['CategoryID'])."', 
						FileName = '".secureTextForDb($UploadImageName)."',
						CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
						CreatedDateTime=NOW()";
				$db->query($Query);
				   
				$result['success'] = 1;
				$result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
				$_SESSION['Message']['Msg'] = CONTACT_ADDED_SUCESSFULLY_FILES;
				$_SESSION['Message']['Type'] = 2;
			}
			else
			{
				$result['error'] = ERROR_IMPORT_CONTACT;
			}
		
			
		}
	}
	else
	{
		$TableName =  "tblnewslettercontact";  
		$EmailCheck = getFieldDataBycustomeCondition("TableID","Email='".secureTextForDb($_POST['Email'])."' AND FullName='".secureTextForDb($_POST['FullName'])."'",$TableName);
		$MobileCheck = getFieldDataBycustomeCondition("TableID","MobileNumber='".secureTextForDb($_POST['MobileNumber'])."' AND FullName='".secureTextForDb($_POST['FullName'])."'",$TableName);
		if($EmailCheck != $RecordID && $EmailCheck > 0)
		{
			$result['error'] = $_POST['Email']." ".ERROR_ALREADY_EXISTS;
		}  
		else if($MobileCheck != $RecordID && $MobileCheck > 0)
		{
			$result['error'] = $_POST['MobileNumber']." ".ERROR_ALREADY_EXISTS;
		}   
		if($result['error']=='')
		{
	
			if($Trigger == 'edit')
			{
				$Query = "update $TableName set ";
				$logaction = 2;
			}
			else
			{  
				$Query = "insert into $TableName set IsWebsite=0 , ";
				$logaction = 1; 
			}
			 
			$Query .=  "CategoryID='".secureTextForDb($_POST['CategoryID'])."',
						FullName='".secureTextForDb($_POST['FullName'])."',  
						Email='".secureTextForDb($_POST['Email'])."', 
						MobileNumber='".secureTextForDb($_POST['MobileNumber'])."' 
					   ";
		
			if($Trigger == 'edit')
				$Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
							ModifiedDateTime=NOW()
							Where TableID='".$RecordID."'
						  ";
			else
				$Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
							CreatedDateTime=NOW()
						  ";
		
			$db->query($Query);
			$InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
			insertlogTable($TableName,$InsertRecordID,$logaction);
			
			$result['success'] = 1;
			$result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID);
			$_SESSION['Message']['Msg'] = $Trigger == 'edit'?CONTACT_EDIT_SUCESSFULLY:CONTACT_ADDED_SUCESSFULLY;
			$_SESSION['Message']['Type'] = 2;
		}
	}

    echo json_encode($result);
}
//update or add news letter
else if($ActionFlag == 'AddEditNewsLetter')
{ 
	$TableName = "tblnewsletters";
	if($Trigger == 'edit')
	{
		$Query = "update $TableName set ";
		$logaction = 2;
	}
	else
	{  
		$Query = "insert into $TableName set ";
		$logaction = 1; 
	}
	
	$Query .=  "Title='".secureTextForDb($_POST['Title'])."', 
				Active='".secureTextForDb($_POST['Active'])."', 
				EmailContent='".secureTextForDb($_POST['EmailContent'])."' 
			   ";	
			   
	if($Trigger == 'edit')
		$Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					ModifiedDateTime=NOW()
					Where TableID='".$RecordID."'
				  ";
	else
		$Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					CreatedDateTime=NOW()
				  ";
	$db->query($Query);
	$InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
	insertlogTable($TableName,$InsertRecordID,$logaction);
	 	
	$result['success'] = 1;
	$result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID); 
	$_SESSION['Message']['Msg'] = $Trigger == 'edit'?NEWSLETTER_EDIT_SUCESSFULLY:NEWSLETTER_ADDED_SUCESSFULLY;
	$_SESSION['Message']['Type'] = 2;
	
	echo json_encode($result);
}
//update or add news letter
else if($ActionFlag == 'AddEditCampaign')
{ 
	$TableName = "tblnewslettercampaigns";
	if($Trigger == 'edit')
	{
		$Query = "update $TableName set ";
		$logaction = 2;
	}
	else
	{  
		$Query = "insert into $TableName set ";
		$logaction = 1; 
	}
	
	$Query .=  "Title='".secureTextForDb($_POST['Title'])."', 
					ContactCategoryID='".secureTextForDb($_POST['ContactCategoryID'])."', 
					NewsLetterID='".secureTextForDb($_POST['NewsLetterID'])."', 
					Subject='".secureTextForDb($_POST['Subject'])."', 
					CampaignStartDate='".secureTextForDb($_POST['CampaignStartDate'])."', 
					ExceptionDays='".secureTextForDb(implode(",",$_POST['ExceptionDays']))."', 
					FromTime='".secureTextForDb($_POST['FromTime'])."', 
					ToTime='".secureTextForDb($_POST['ToTime'])."',  
					ReplyToEmail='".secureTextForDb($_POST['ReplyToEmail'])."',  
					SenderName='".secureTextForDb($_POST['SenderName'])."',  
					EveryHourEmail='".secureTextForDb($_POST['EveryHourEmail'])."' 
				   ";	
		
	if($Trigger != 'edit')
	{
		$TotalContact = getCountRecord2("tblnewslettercontact","CategoryID",$_POST['ContactCategoryID']." AND Subscribe=0");	
		$Query .= " , TotalContact = '".$TotalContact."' 
				  ";
	}
			   
			   
	if($Trigger == 'edit')
		$Query .= " , ModifiedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					ModifiedDateTime=NOW()
					Where TableID='".$RecordID."'
				  ";
	else
		$Query .= " ,CreatedBy = '".$_SESSION[WEB_SESSION.'_userid']."',
					CreatedDateTime=NOW()
				  ";
	$db->query($Query);
	$InsertRecordID = $Trigger != 'edit'?$db->MysqlInsertID():$RecordID;  
	insertlogTable($TableName,$InsertRecordID,$logaction);
	 	
	$result['success'] = 1;
	$result['redirect']= 'index.php?'.EncodeUrl('action='.$action.'&SubLinkID='.$SubLinkID); 
	$_SESSION['Message']['Msg'] = $Trigger == 'edit'?NEWSLETTER_EDIT_SUCESSFULLY:NEWSLETTER_ADDED_SUCESSFULLY;
	$_SESSION['Message']['Type'] = 2;
	
	echo json_encode($result);
}
//update or add news letter
else if($_REQUEST['SetTime'] == 'ShowTime')
{
	if($_REQUEST['Type']==1)
	{
		echo '<option value="">'.TXT_END_TIME.'</option>';
		foreach($Time  as $key => $TimeData)
		{
			if($_REQUEST['Time']>=$key)
			continue;
			
			$Seleted = ($_REQUEST['ToTime']==$key)?'selected="selected"':'';
			 
			echo '<option value="'.$key.'" '.$Seleted.'>'.$TimeData.'</option>';
		}
	}
	if($_REQUEST['Type']==2)
	{
		echo '<option value="">'.TXT_START_TIME.'</option>';
		foreach($Time  as $key => $TimeData)
		{
			if($_REQUEST['Time']<=$key)
			continue;
			 
			$Seleted = ($_REQUEST['FromTime']==$key)?'selected="selected"':'';
			
			echo '<option value="'.$key.'" '.$Seleted.'>'.$TimeData.'</option>';
		}
	}
}
?>
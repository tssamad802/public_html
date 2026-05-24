<?php
class pagesmanagementclass
{
    private function deletePageFromCms($TableID)
    {
        $db = new DB_Sql();

        //deletePageTab
        $RecordInfo = FetchRecordByID($TableID,"TableID","tblpages");

        if($RecordInfo['TableID'] > 0)
        {
            $this->DeleteChildPagesAndSelf($RecordInfo['TableID'],'ParentTableID');
        }
    }

    private function DeleteChildPagesAndSelf($PageID,$ConditionColmn='ParentTableID')
    {
        $db = new DB_Sql();

        $db->query("select * from tblpages where ".$ConditionColmn."='".$PageID."'");

        if($db->num_rows() > 0)
        {
            while($db->next_record())
            {
                $this->DeleteDocuments($db->f("TableID"),'article');//delete documents
                $this->deletePagesTabs($db->f("TableID"));//delete tabs

                //check more child
                $this->DeleteChildPagesAndSelf($db->f("TableID"),'ParentTableID');
            }
        }

        //now delete page
        if($PageID > 0)
        {
            $this->DeleteDocuments($PageID,'article');//delete documents
            $this->deletePagesTabs($PageID);//delete page tab
            //log table
            $object = FetchRecordByID($PageID,'TableID','tblpages');
            $logquery =    "PageType = '".$object['PageType']."',
							Title = '".clearTextForDb($object['Title'])."',
							TitleAr = '".clearTextForDb($object['TitleAr'])."',
							MenuTitle = '".clearTextForDb($object['MenuTitle'])."',
							MenuTitleAr = '".clearTextForDb($object['MenuTitleAr'])."',
							BannerTitle = '".clearTextForDb($object['BannerTitle'])."',
							BannerTitleAr = '".clearTextForDb($object['BannerTitleAr'])."',
							Active = '".$object['Active']."',
							ApplyOnlineFormID = '".$object['ApplyOnlineFormID']."',
							ParentTableID = '".$object['ParentTableID']."',
							ExternalLink = '".$object['ExternalLink']."',
							ExternalLinkAr = '".$object['ExternalLinkAr']."',
							Description = '".clearTextForDb($object['Description'])."',
							DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
							BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			                BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
							EnquiryInfo = '".$object['EnquiryInfo']."',
							EnquiryInfoAr = '".$object['EnquiryInfoAr']."',
							MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
							MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
							MetaTitle = '".clearTextForDb($object['MetaTitle'])."',
							MetaTitleAr = '".clearTextForDb($object['MetaTitleAr'])."',
							MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
							MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
							MetaOthers = '".clearTextForDb($object['MetaOthers'])."',
							MetaOthersAr = '".clearTextForDb($object['MetaOthersAr'])."',
							ShowInNav = '".$object['ShowInNav']."',
							ShowInTopNav = '".$object['ShowInTopNav']."',
							ShowInLeftNav = '".$object['ShowInLeftNav']."',
							ShowInFooterNav1 = '".$object['ShowInFooterNav1']."',
							ShowInFooterNav2 = '".$object['ShowInFooterNav2']."',
							ShowEmailForm = '".$object['ShowEmailForm']."',
							FormEmailTo = '".clearTextForDb($object['FormEmailTo'])."',
							EmailThanksMessage = '".clearTextForDb($object['EmailThanksMessage'])."',
							EmailThanksMessageAr = '".clearTextForDb($object['EmailThanksMessageAr'])."',
							ShowPopUp = '".$object['ShowPopUp']."',
							PopupStyle = '".$object['PopupStyle']."',
							PopUpButtonTitle = '".clearTextForDb($object['PopUpButtonTitle'])."',
							PopUpButtonTitleAr = '".clearTextForDb($object['PopUpButtonTitleAr'])."',
							PopUpText = '".clearTextForDb($object['PopUpText'])."',
							PopUpTextAr = '".clearTextForDb($object['PopUpTextAr'])."',
							URLKeyword = '".$object['URLKeyword']."'
							";
            logTableInsertQuery('tblpages',$PageID , $logquery, 3);

            $db->query("delete from tblpages where TableID='".$PageID."'");
        }
    }

    private function deletePagesTabs($PageID)
    {
        //delete tabs
        if($PageID > 0)
        {
            $db1 = new DB_Sql();
            $db1->query("select * from tbltabs where ParentTableID='".$PageID."'");

            while($db1->next_record())
            {
                $this->deletePageTab($db1->f("TableID"));
            }
            //end
        }
    }

    private function DeleteDocuments($TableID,$DocumentType)
    {
        $db = new DB_Sql();

        $db->query("select * from tbldocuments where ParentTableID='".$TableID."' and DocumentType='".$DocumentType."'");

        while($db->next_record())
        {
            $filedate = strtotime($db->f("CreationDateTime"));
            if($db->f("FileName") != '')
            {
                $path = '../'.FILES_FOLDER."/".DOCUMENTS_FOLDER."/".date("Y",$filedate).'/'.date("m",$filedate).'/'.$db->f("FileName");
                @unlink($path);
            }

            if($db->f("FileNameAr") != '')
            {
                $path = '../'.FILES_FOLDER."/".DOCUMENTS_FOLDER."/".date("Y",$filedate).'/'.date("m",$filedate).'/'.$db->f("FileNameAr");
                @unlink($path);
            }
        }

        //now unlink all tabs
        $db->query("delete from tbldocuments where ParentTableID='".$TableID."' and DocumentType='".$DocumentType."'");
    }

    function managePages($object,$objectfile,$AllowedVideoFileExtension)
    {
        $db = new DB_Sql();
        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    $this->deletePageFromCms($value);
                    SystemImagesDelete($value,IMAGETYPE_PAGES);
                }
            }
            else
            {
                $this->deletePageFromCms($object['RecordID']);
                SystemImagesDelete($object['RecordID'],IMAGETYPE_PAGES);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "CMS page & all relevant records deleted successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            if($_REQUEST['PageType'] == '-1')
            {
                $ErrorFields['PageType'] = 'Please Select Page Type';
            }

            if($_REQUEST['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($_REQUEST['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($_REQUEST['MenuTitle'] == '')
            {
                $ErrorFields['MenuTitle'] = 'Please Enter Menu Title (English)';
            }

            if($_REQUEST['MenuTitleAr'] == '')
            {
                $ErrorFields['MenuTitleAr'] = 'Please Enter Menu Title (Arabic)';
            }

            if($_REQUEST['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Page Status';
            }

            if($_REQUEST['PageType'] == '1')
            {
                /*if($_REQUEST['Description'] == '')
                {
                    $ErrorFields['Description'] = 'Please Enter Description (English)';
                }

                if($_REQUEST['DescriptionAr'] == '')
                {
                    $ErrorFields['DescriptionAr'] = 'Please Enter Description (Arabic)';
                }*/

                if($_REQUEST['ShowEmailForm'] == 1)
                {
                    if($_REQUEST['FormEmailTo'] == '')
                    {
                        $ErrorFields['FormEmailTo'] = 'Please Enter Email Address';
                    }
                    else if(!ValidateEmailFormat($_REQUEST['FormEmailTo']))
                    {
                        $ErrorFields['FormEmailTo'] = 'Please Enter Valid Email Address';
                    }

                    if($_REQUEST['EmailThanksMessage'] == '')
                    {
                        $ErrorFields['EmailThanksMessage'] = 'Please Enter Thanks Message (English)';
                    }

                    if($_REQUEST['EmailThanksMessageAr'] == '')
                    {
                        $ErrorFields['EmailThanksMessageAr'] = 'Please Enter Thanks Message (Arabic)';
                    }
                }
            }

            if($_REQUEST['PageType'] == '4')
            {
                if($_REQUEST['ExternalLink'] == '')
                {
                    $ErrorFields['ExternalLink'] = 'Please Enter English Site External Link start with http://';
                }
                if($_REQUEST['ExternalLinkAr'] == '')
                {
                    $ErrorFields['ExternalLinkAr'] = 'Please Enter Arabic Site External Link start with http://';
                }
            }

            if($_REQUEST['ShowPopUp'] == '1' && $_REQUEST['PageType'] == '1')
            {
                /*if($_REQUEST['PopUpButtonTitle'] == '')
                {
                    $ErrorFields['PopUpButtonTitle'] = 'Please Enter English Button Title';
                }
                if($_REQUEST['PopUpButtonTitleAr'] == '')
                {
                    $ErrorFields['PopUpButtonTitleAr'] = 'Please Enter Arabic  Button Title';
                }*/

                if($_REQUEST['PopUpText'] == '' && $_REQUEST['PopupStyle']==0)
                {
                    $ErrorFields['PopUpText'] = 'Please Enter PopUp Text (English)';
                }

                if($_REQUEST['PopUpTextAr'] == '' && $_REQUEST['PopupStyle']==0)
                {
                    $ErrorFields['PopUpTextAr'] = 'Please Enter PopUp Text (Arabic)';
                }

                if($objectfile['Video']['name'] == '' && $_REQUEST['PopupStyle']==1  && $_REQUEST['trigger']!='edit')
                {
                    $ErrorFields['Video'] = 'Please Select Popup Video (English)';
                }

                if($objectfile['VideoAr']['name'] == '' && $_REQUEST['PopupStyle']==1  && $_REQUEST['trigger']!='edit')
                {
                    $ErrorFields['VideoAr'] = 'Please Select Popup Video (Arabic)';
                }

                if($objectfile['Video']['name'] != '' && $_REQUEST['PopupStyle']==1)
                {
                    $filesize = (filesize($objectfile['Video']['tmp_name']) * .0009765625) * .0009765625;
                    $ext = mime_content_type($objectfile['Video']['tmp_name']);
                    if($filesize > VideoSize)
                    {
                        $ErrorFields['Video'] = "Please choose ".VideoSize." MB File Size";
                    }
                    else if(!in_array($ext,$AllowedVideoFileExtension) )
                    {
                        $ErrorFields['Video'] = "Please choose flv to upload";
                    }

                    $FileName = date("YmdHis").'-'.$objectfile['Video']['name'];
                }

                if($objectfile['VideoAr']['name'] != '' && $_REQUEST['PopupStyle']==1)
                {
                    $filesize = (filesize($objectfile['VideoAr']['tmp_name']) * .0009765625) * .0009765625;
                    $ext = mime_content_type($objectfile['VideoAr']['tmp_name']);
                    if($filesize > VideoSize)
                    {
                        $ErrorFields['VideoAr'] = "Please choose ".VideoSize." MB File Size";
                    }
                    else if(!in_array($ext,$AllowedVideoFileExtension) )
                    {
                        $ErrorFields['VideoAr'] = "Please choose flv to upload";
                    }

                    $FileNameAr = date("YmdHis").'ar-'.$objectfile['VideoAr']['name'];

                }

            }

            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['ParentTableID']=='')
            {
                $object['ParentTableID']=0;
            }


            if($object['ShowInNav']=='')
            {
                $object['ShowInNav']=0;
            }


            if($object['ShowInTopNav']=='')
            {
                $object['ShowInTopNav']=0;
            }


            if($object['ShowInLeftNav']=='')
            {
                $object['ShowInLeftNav']=0;
            }


            if($object['ShowInFooterNav1']=='')
            {
                $object['ShowInFooterNav1']=0;
            }


            if($object['ShowInFooterNav2']=='')
            {
                $object['ShowInFooterNav2']=0;
            }

            if($object['ShowEmailForm']=='')
            {
                $object['ShowEmailForm']=0;
            }

            if($object['ShowPopUp']=='')
            {
                $object['ShowPopUp']=0;
            }

            if($object['trigger']=='edit')
                $Query="update tblpages set";
            else
                $Query="insert into tblpages set";

            $Query .= " PageType = '".$object['PageType']."',
			Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			MenuTitle = '".clearTextForDb($object['MenuTitle'])."',
			MenuTitleAr = '".clearTextForDb($object['MenuTitleAr'])."',
			BannerTitle = '".clearTextForDb($object['BannerTitle'])."',
			BannerTitleAr = '".clearTextForDb($object['BannerTitleAr'])."',
			Active = '".$object['Active']."',
			ApplyOnlineFormID = '".$object['ApplyOnlineFormID']."',
			ParentTableID = '".$object['ParentTableID']."',
			ExternalLink = '".$object['ExternalLink']."',
			ExternalLinkAr = '".$object['ExternalLinkAr']."',
			Description = '".clearTextForDb($object['Description'])."',
			DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
			BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
			EnquiryInfo = '".$object['EnquiryInfo']."',
			EnquiryInfoAr = '".$object['EnquiryInfoAr']."',
			MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
			MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
			MetaTitle = '".clearTextForDb($object['MetaTitle'])."',
			MetaTitleAr = '".clearTextForDb($object['MetaTitleAr'])."',
			MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
			MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
			MetaOthers = '".clearTextForDb($object['MetaOthers'])."',
			MetaOthersAr = '".clearTextForDb($object['MetaOthersAr'])."',
			ShowInNav = '".$object['ShowInNav']."',
			ShowInTopNav = '".$object['ShowInTopNav']."',
			ShowInLeftNav = '".$object['ShowInLeftNav']."',
			ShowInFooterNav1 = '".$object['ShowInFooterNav1']."',
			ShowInFooterNav2 = '".$object['ShowInFooterNav2']."',
			ShowEmailForm = '".$object['ShowEmailForm']."',
			FormEmailTo = '".clearTextForDb($object['FormEmailTo'])."',
			EmailThanksMessage = '".clearTextForDb($object['EmailThanksMessage'])."',
			EmailThanksMessageAr = '".clearTextForDb($object['EmailThanksMessageAr'])."',
			ShowAccordion = '".$object['ShowAccordion']."',
			ShowPopUp = '".$object['ShowPopUp']."',
			PopupStyle = '".$object['PopupStyle']."',
			PopUpButtonTitle = '".clearTextForDb($object['PopUpButtonTitle'])."',
			PopUpButtonTitleAr = '".clearTextForDb($object['PopUpButtonTitleAr'])."',
			PopUpText = '".clearTextForDb($object['PopUpText'])."',
			PopUpTextAr = '".clearTextForDb($object['PopUpTextAr'])."'
			";

            if($object['URLKeyword'] == '')
            {
                $URLKeyword = SEOFriendlyURL($object['MenuTitle']);
                $URLKeyword = SEOFriendlyPageURL($URLKeyword,$URLKeyword);
            }
            else
            {
                $URLKeyword = $object['URLKeyword'];
            }

            $Query .= ", URLKeyword = '".$URLKeyword."'";

            if($FileName!='')
            {
                $Query .= ", Video='".$FileName."' ";

                $FinalPath = '../'.FILES_FOLDER.'/'.UPLOAD_VIDEOS;
                @unlink($FinalPath.'/'.$object['OldVideo']);


                $FinalFilePath = $FinalPath.'/'.$FileName;
                copy($objectfile['Video']['tmp_name'],$FinalFilePath);
            }

            if($FileNameAr!='')
            {
                $Query .= ", VideoAr = '".$FileNameAr."' ";


                $FinalPathAr = '../'.FILES_FOLDER.'/'.UPLOAD_VIDEOS;
                @unlink($FinalPathAr.'/'.$object['OldVideoAr']);

                $FinalFilePathAr = $FinalPathAr.'/'.$FileNameAr;
                copy($objectfile['VideoAr']['tmp_name'],$FinalFilePathAr);
            }


            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $ParentTableID = ($object['ParentTableID'] > 0)?$object['ParentTableID']:0;
                $rOrder = maxID("rOrder","tblpages where ParentTableID='".$ParentTableID."'",1);

                $Query .= ", rOrder = '".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDate = '".date("Y-m-d")."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            foreach($object['AccTitle'] as $key=>$val)
            {
                if($val!='' || $object['accdescription'][$key]!='')
                {
                    $AcTitle = clearTextForDb($val);
                    $AcTitleAr = clearTextForDb($object['AccTitleAr'][$key]);
                    $AcDexscription = clearTextForDb($object['accdescription'][$key]);
                    $AcDexscriptionAr = clearTextForDb($object['accdescriptionAr'][$key]);
                    $QueryAcc = "insert into tblAccordionPages set Title='".$AcTitle."',TitleAr='".$AcTitleAr."',Description='".$AcDexscription."' ,DescriptionAr='".$AcDexscriptionAr."', PageID='".$recordid."', ModifiedDate=NOW()";
                    $db->query($QueryAcc);
                    $QueryAcc = "insert into tblAccordionPageslog set Title='".$AcTitle."',TitleAr='".$AcTitleAr."',Description='".$AcDexscription."' ,DescriptionAr='".$AcDexscriptionAr."', PageID='".$recordid."', ModifiedDate=NOW()";
                    $db->query($QueryAcc);
                }
            }
            foreach($object['AccTitleEdt'] as $key=>$val)
            {
                if($val!='' || $object['accdescriptionedt'][$key]!='')
                {
                    $tableID = $key;
                    $AcTitle = clearTextForDb($val);
                    $AcTitleAr = clearTextForDb($object['AccTitleEdtAr'][$key]);
                    $AcDexscription = clearTextForDb($object['accdescriptionedt'][$key]);
                    $AcDexscriptionAr = clearTextForDb($object['accdescriptionedtAr'][$key]);
                    $QueryAcc = "update tblAccordionPages set Title='".$AcTitle."',TitleAr='".$AcTitleAr."',Description='".$AcDexscription."' ,DescriptionAr='".$AcDexscriptionAr."', ModifiedDate=NOW() where TableID='".$tableID."'";
                    $db->query($QueryAcc);
                    $QueryAcc = "insert into tblAccordionPageslog set Title='".$AcTitle."',TitleAr='".$AcTitleAr."',Description='".$AcDexscription."' ,DescriptionAr='".$AcDexscriptionAr."', PageID='".$recordid."', ModifiedDate=NOW()";
                    $db->query($QueryAcc);
                }
            }
            if($object['delids'] != '')
            {
                $deleteIDS = explode(",",$object['delids']);
                foreach($deleteIDS as $deleteID)
                {
                    $db->query("insert into tblAccordionPageslog (Title,TitleAr,Description,DescriptionAr) select Title,TitleAr,Description,DescriptionAr from tblAccordionPages where TableID='".$deleteID."'");
                    $db->query("update tblAccordionPages set ModifiedDate=NOW() where TableID='".$deleteID."'");
                    $db->query("delete from tblAccordionPages where TableID='".$deleteID."'");
                }
            }
            if($recordid > 0)
            {
                //log table
                $logquery =    "PageType = '".$object['PageType']."',
								Title = '".clearTextForDb($object['Title'])."',
								TitleAr = '".clearTextForDb($object['TitleAr'])."',
								MenuTitle = '".clearTextForDb($object['MenuTitle'])."',
								MenuTitleAr = '".clearTextForDb($object['MenuTitleAr'])."',
								BannerTitle = '".clearTextForDb($object['BannerTitle'])."',
								BannerTitleAr = '".clearTextForDb($object['BannerTitleAr'])."',
								Active = '".$object['Active']."',
								ApplyOnlineFormID = '".$object['ApplyOnlineFormID']."',
								ParentTableID = '".$object['ParentTableID']."',
								ExternalLink = '".$object['ExternalLink']."',
								ExternalLinkAr = '".$object['ExternalLinkAr']."',
								Description = '".clearTextForDb($object['Description'])."',
								DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
								BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			                    BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
								EnquiryInfo = '".$object['EnquiryInfo']."',
								EnquiryInfoAr = '".$object['EnquiryInfoAr']."',
								MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
								MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
								MetaTitle = '".clearTextForDb($object['MetaTitle'])."',
								MetaTitleAr = '".clearTextForDb($object['MetaTitleAr'])."',
								MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
								MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
								MetaOthers = '".clearTextForDb($object['MetaOthers'])."',
								MetaOthersAr = '".clearTextForDb($object['MetaOthersAr'])."',
								ShowInNav = '".$object['ShowInNav']."',
								ShowInTopNav = '".$object['ShowInTopNav']."',
								ShowInLeftNav = '".$object['ShowInLeftNav']."',
								ShowInFooterNav1 = '".$object['ShowInFooterNav1']."',
								ShowInFooterNav2 = '".$object['ShowInFooterNav2']."',
								ShowEmailForm = '".$object['ShowEmailForm']."',
								FormEmailTo = '".clearTextForDb($object['FormEmailTo'])."',
								EmailThanksMessage = '".clearTextForDb($object['EmailThanksMessage'])."',
								EmailThanksMessageAr = '".clearTextForDb($object['EmailThanksMessageAr'])."',
								ShowAccordion = '".$object['ShowAccordion']."',
								ShowPopUp = '".$object['ShowPopUp']."',
								PopupStyle = '".$object['PopupStyle']."',
								PopUpButtonTitle = '".clearTextForDb($object['PopUpButtonTitle'])."',
								PopUpButtonTitleAr = '".clearTextForDb($object['PopUpButtonTitleAr'])."',
								PopUpText = '".clearTextForDb($object['PopUpText'])."',
								PopUpTextAr = '".clearTextForDb($object['PopUpTextAr'])."',
								URLKeyword = '".$URLKeyword."'
							    ";

                logTableInsertQuery('tblpages',$recordid , $logquery, $object['trigger']);


                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Web Page Edited Successfully":"Web Page Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }


        if($_REQUEST['start'] > 0)
            $_SESSION['PageReturnPage'] = $_REQUEST['start'];


        redirect("home.php?".EncodeUrl("action=viewallpages"), 0);
    }

    function loadRecursivePages(&$finalstring, $parentid = 0)
    {
        global $PageTypeAr;
        $db = new DB_Sql();

        $sql="select * from tblpages where ParentTableID = '".$parentid."' order by rOrder ASC";

        $db->query($sql);

        if($db->num_rows() > 0)
        {
            if($parentid == 0)
            {
                $finalstring .= '<ul id="sortablelist" data-tablename="tblpages" data-parentid="'.$parentid.'">';
            }
            else
            {
                $finalstring .= '<ul data-tablename="tblpages" data-parentid="'.$parentid.'">';
            }


            while($db->next_record())
            {
                $finalstring .= '<li id="listItem_'.$db->f("TableID").'" class="ui-state-default"> <span class="ui-icon ui-icon-arrowthick-2-n-s"></span> '.$db->f('Title');

                $this->loadRecursivePages($finalstring, $db->f("TableID"));

                $finalstring .= '</li>';
            }

            $finalstring .= '</ul>';
        }
    }

    function loadTag()
    {
        $db = new DB_Sql();
        $sql = "select * from tblcoupontag where ShowHome = 1 and Active  = 1 limit 2";
        $db->query($sql);
        $var = '';
        while($db->next_record()){
            $var .= "<li style=''><a class='element-span' href='".RESOURCES_DOMAIN."/tag/".$db->f('URLKeyword')."' ><span style='padding-top: 3px;'>".$db->f('Title')."</span></a></li>";
        }
        echo $var;
    }

    function loadFrontNavigation($lang,$currentactivemenu,$columnfornav,&$finalstring, $parentid = 0, $Checkparentid = 0)
    {
        global $PageTypeAr;
        $db = new DB_Sql();
        $db1 = new DB_Sql();
        $db2 = new DB_Sql();
        $sub=0;
        $footercls = '';

        if($columnfornav == 'ShowInNav')
        {
            $sql="select * from tblpages where ParentTableID = '".$parentid."' and ".$columnfornav." = 1 and Active='".ACTIVE."' order by Sequence ASC";
        }
        else if($columnfornav == 'ShowInFooterNav1')
        {
            $limitdata = ($parentid==0)?'LIMIT 5':'';
            $sql="select * from tblpages where ParentTableID = '".$parentid."' and ".$columnfornav." = 1 and Active='".ACTIVE."' order by Sequence ASC $limitdata";
        }
        else
        {
            $sql="select * from tblpages where ".$columnfornav." = 1 and Active='".ACTIVE."' order by Sequence ASC";
        }

        // if($columnfornav == 'ShowInFooterNav2')
        // {
        // 	$footercls="menu-footer";
        // }

        $db->query($sql);

        if($db->num_rows() > 0)
        {
            $counter = 0;
            $counterloop = 0;
            $backgroundclassforfooter = '';
            if($columnfornav == 'ShowInNav')
            {
                if($parentid == 0 && $columnfornav == 'ShowInNav')
                {
                    $finalstring .= '<ul class="navigation-menu">';
                    //$finalstring .= '<li class="level1 hover-menu"><a title="'.TXT_HOME_MENU.'"  href="'.DOMAINNAME.'">'.TXT_HOME_MENU.'</a></li>';
                }
                else if($columnfornav == 'ShowInNav')
                {
                    $finalstring .= '<ul class="submenu">';
                }

            }

            while($db->next_record())
            {
                $counter++;

                $counterloop++;

                $class = ($currentactivemenu == $db->f("TableID"))?' active':'';

                $target = "";
                if($db->f("PageType") == 4)
                    $target = ($db->f("ExternalOpenIn") == 1)?" target='_blank'":"";

                $Title = $db->f("MenuTitle".LANG_SEP_DB);

                $countvalues = getCountRecord("tblpages",$columnfornav." = 1 and ParentTableID",$db->f("TableID"));


                $classloop = ($db->f("ParentTableID") ==0)?' has-submenu hassub':'';
                $Checkparentid  = ($countvalues > 0 && $db->f("ParentTableID") > 0)? 1:0;
// '.$this->generateURLLink($db,$lang).'
                $finalstring .= '<li class="'.$footercls.' '.$class.' '.$classloop.'"><a title="'.clearTextForField($Title).'"  href="'.RESOURCES_DOMAIN.'/'.$db->f('URLKeyword').'" '.$target.' '.$backgroundclassforfooter.'">'.clearTextForField($Title).' '.$db->f('Title').'</a>';

                if($db->f("PageType") == 7 && $columnfornav == 'ShowInNav' && $db->f("ParentTableID") ==0)
                {
                    $StoreQuery="select * from tblstore order by name ASC Limit 10";
                    $db1->query($StoreQuery);
                    if($db1->num_rows() > 0)
                    {
                        $Storecounter= 0;
                        $finalstring .='<ul class="submenu">';
                        while($db1->next_record())
                        {
                            $Storecounter++;
                            $urlPath = RESOURCES_DOMAIN.'/'.STORE_URL.'/'.$db1->f('URLKeyword');
                            $finalstring .='<li ><a href="'.$urlPath.'">'.$db1->f('name').'</a></li>';
                        }

                        if($Storecounter ==10)
                        {
                            $finalstring .='<li><a href="'.$this->generateURLLink($db,$lang).'">All Stores</a></li>';
                        }

                        $finalstring .='</ul>';
                    }
                }

                if($db->f("PageType") == 8 && $columnfornav == 'ShowInNav' && $db->f("ParentTableID") ==0)
                {
                    $StoreQuery="SELECT * FROM `tblcoupontype` WHERE Active  = 1 LIMIT 10";
                    $db1->query($StoreQuery);
                    if($db1->num_rows() > 0)
                    {
                        $Storecounter= 0;
                        $finalstring .='<ul class="submenu">';
                        while($db1->next_record())
                        {
                            $Storecounter++;
                            $urlPath = $db1->f('URLKeyword');
                            $finalstring .='<li ><a href="'.$db1->f('URL').'">'.$db1->f('Title').'</a></li>';
                        }

                        if($Storecounter ==10)
                        {
                            $finalstring .='<li><a href="'.$this->generateURLLink($db,$lang).'">All Coupons</a></li>';
                        }

                        $finalstring .='</ul>';
                    }
                }

                if($db->f("PageType") == 5 && $columnfornav == 'ShowInNav' && $db->f("ParentTableID") ==0)
                {
                    $StoreQuery="SELECT * FROM `tblcategory` WHERE ParentID = 0 and `Active` = 1 order by Title ASC Limit 10";
                    $db1->query($StoreQuery);
                    if($db1->num_rows() > 0)
                    {
                        $Storecounter= 0;
                        $finalstring .='<ul class="submenu">';
                        while($db1->next_record())
                        {
                            $Storecounter++;
                            $urlPath = RESOURCES_DOMAIN . '/' . CATEGORY_URL . '/' . $db1->f('URLKeyword');
                            $finalstring .='<li class="has-submenu"><a href="'.$urlPath.'">'.$db1->f('Title').'</a>';

                            $SubCategoryQuery = "SELECT * FROM `tblcategory` WHERE ParentID = ".$db1->f('TableID')." AND `Active` = 1 order by Title ASC Limit 10";
                            $db2->query($SubCategoryQuery);
                            if($db2->num_rows() == 0)
                                $finalstring .="</li>";
                            else
                                $finalstring .= '<ul class="submenu">';
                            while($db2->next_record())
                            {
                                $urlPath = RESOURCES_DOMAIN.'/'.CATEGORY_URL.'/'.$db2->f('URLKeyword');
                                $finalstring .='<li ><a href="'.$urlPath.'">'.$db2->f('Title').'</a></li>';
                            }
                            if($db2->num_rows() > 0)
                                $finalstring .= "</ul></li>";
                        }
                        if($Storecounter ==10)
                        {
                            $finalstring .='<li><a href="'.$this->generateURLLink($db,$lang).'">All Categories</a></li>';
                        }

                        $finalstring .='</ul>';
                    }
                }

//                if($db->f("PageType") == 2 && $columnfornav == 'ShowInNav' && $db->f("ParentTableID") ==0)
//                {
//                    $StoreQuery="select * from tblproduct where  Active='".ACTIVE."' order by ProductName ASC Limit 10";
//                    $db1->query($StoreQuery);
//                    if($db1->num_rows() > 0)
//                    {
//                        $Storecounter= 0;
//                        $finalstring .='<ul class="submenu">';
//                        while($db1->next_record())
//                        {
//                            $Storecounter++;
//                            $urlPath = RESOURCES_DOMAIN.'/'.STORE_URL.'/'.$db1->f('URLKeyword');
//                            $finalstring .='<li ><a href="'.$urlPath.'">'.$db1->f('ProductName').'</a></li>';
//                        }
//
//                        if($Storecounter ==10)
//                        {
//                            $finalstring .='<li><a href="'.$this->generateURLLink($db,$lang).'">All Stores</a></li>';
//                        }
//                        $finalstring .='</ul>';
//                    }
//                }


                if($columnfornav == 'ShowInNav')
                {
                    $this->loadFrontNavigation($lang,$currentactivemenu,$columnfornav,$finalstring, $db->f("TableID"), $Checkparentid);
                }

                $finalstring .= '</li>';
            }

            if($columnfornav == 'ShowInNav')
            {
                $finalstring .= '</ul>';
            }
        }
    }

    function loadFrontNavigation1($lang,$currentactivemenu,$columnfornav,&$finalstring,$formobile,$prooritybanking, $parentid = 0)
    {
        global $PageTypeAr;
        $db = new DB_Sql();
        $counter = 0;
        $counterloop = 0;
        $backgroundclassforfooter = '';

        if($columnfornav == 'ShowInNav' || $columnfornav == 'ShowInFooterNav1')
        {
            $sql="select * from tblpages where ParentTableID = '".$parentid."' and ".$columnfornav." = 1 and Active='".ACTIVE."' order by rOrder ASC";
        }
        else
        {
            $sql="select * from tblpages where ".$columnfornav." = 1 and Active='".ACTIVE."' order by rOrder ASC";
        }

        $db->query($sql);

        if($db->num_rows() > 0)
        {
            if($columnfornav == 'ShowInNav')
            {
                if($parentid == 0 && $formobile==1)
                {
                    $finalstring .= '<ul class="slimmenu">';
                }
                else if($parentid == 0 && $columnfornav == 'ShowInFooterNav1')
                {
                    $finalstring .= '<ul class="footermenu">';
                }
                else if($parentid == 0)
                {
                    $finalstring .= '<ul>';
                }
                else
                {
                    $finalstring .= '<ul>';
                }
            }




            while($db->next_record())
            {
                $counter++;

                $counterloop++;
                $class = ($currentactivemenu == $db->f("TableID"))?' active':'';

                $prioritybankingcolor = ($db->f("TableID")==170)?' style="color:#c59d3d;"':'';

                $target = ($db->f("PageType") == 4)?" target='_blank'":"";

                $Title = ($lang == 'ar')?$db->f("MenuTitleAr"):$db->f("MenuTitle");

                $countvalues = getCountRecord("tblpages","ParentTableID",$db->f("TableID"));
                $hasclass = ($countvalues > 0 && $db->f("ParentTableID") > 0)?' <span></span> ':'';
                if($prooritybanking=="")
                {
                    $backgroundclassforfooter = ($counterloop==5 && $columnfornav == 'ShowInFooterNav1' && $parentid == 0)?' style="background:#a6192e;"':'';
                }
                else
                {
                    $backgroundclassforfooter = ($counterloop==5 && $columnfornav == 'ShowInFooterNav1' && $parentid == 0)?' style="background:#cba340;"':'';
                }

                $prioritybankingcolor = '';

                $finalstring .= '<li class="'.$class.'"><a href="'.$this->generateURLLink($db,$lang).'" '.$target.' '.$backgroundclassforfooter.'" '.$prioritybankingcolor.'>'.clearTextForField($Title).' '.$hasclass.'</a>';

                if($columnfornav == 'ShowInNav' || $columnfornav == 'ShowInFooterNav1')
                {
                    $this->loadFrontNavigation($lang,$currentactivemenu,$columnfornav,$finalstring, $db->f("TableID"));
                }

                $finalstring .= '</li>';

            }

            if($columnfornav == 'ShowInNav')
            {
                $finalstring .= '</ul>';
            }
        }
    }


    function loadFrontNavigationsitemap($lang,$currentactivemenu,$columnfornav,&$finalstring,$formobile,$prooritybanking, $parentid = 0)
    {
        global $PageTypeAr;
        $db = new DB_Sql();

        if($columnfornav == 'ShowInNav' || $columnfornav == 'ShowInFooterNav1')
        {
            $sql="select * from tblpages where ParentTableID = '".$parentid."' and ".$columnfornav." = 1 and Active='".ACTIVE."' order by rOrder ASC";
        }
        else
        {
            $sql="select * from tblpages where ".$columnfornav." = 1 and Active='".ACTIVE."' order by rOrder ASC";
        }

        $db->query($sql);

        if($db->num_rows() > 0)
        {
            if($columnfornav == 'ShowInNav' || $columnfornav == 'ShowInFooterNav1')
            {
                if($parentid == 0 && $formobile==1)
                {
                    $finalstring .= '<ul class="slimmenu">';
                }
                else if($parentid == 0 && $columnfornav == 'ShowInFooterNav1')
                {
                    $finalstring .= '<ul class="footermenu">';
                }
                else if($parentid == 0)
                {
                    $finalstring .= '<ul class="page-text-main-container-inner sitemaplist">';
                }
                else
                {
                    $finalstring .= '<ul>';
                }
            }




            while($db->next_record())
            {
                $counter++;

                $counterloop++;
                $class = ($currentactivemenu == $db->f("TableID"))?' active':'';

                $prioritybankingcolor = ($db->f("TableID")==170)?' style="color:#c59d3d;"':'';

                $target = ($db->f("PageType") == 4)?" target='_blank'":"";

                $Title = ($lang == 'ar')?$db->f("MenuTitleAr"):$db->f("MenuTitle");

                $countvalues = getCountRecord("tblpages","ParentTableID",$db->f("TableID"));
                $hasclass = ($countvalues > 0 && $db->f("ParentTableID") > 0)?' <span></span> ':'';
                if($prooritybanking=="")
                {
                    $backgroundclassforfooter = ($counterloop==5 && $columnfornav == 'ShowInFooterNav1' && $parentid == 0)?' style="background:#a6192e;"':'';
                }
                else
                {
                    $backgroundclassforfooter = ($counterloop==5 && $columnfornav == 'ShowInFooterNav1' && $parentid == 0)?' style="background:#cba340;"':'';
                }
                $finalstring .= '<li class="'.$class.'"><a href="'.$this->generateURLLink($db,$lang).'" '.$target.' '.$backgroundclassforfooter.'" '.$prioritybankingcolor.'>'.clearTextForField($Title).' '.$hasclass.'</a>';

                if($columnfornav == 'ShowInNav' || $columnfornav == 'ShowInFooterNav1')
                {
                    $this->loadFrontNavigation($lang,$currentactivemenu,$columnfornav,$finalstring, $db->f("TableID"));
                }

                $finalstring .= '</li>';
            }

            if($columnfornav == 'ShowInNav'  || $columnfornav == 'ShowInFooterNav1')
            {
                $finalstring .= '</ul>';
            }
        }
    }


    function loadFrontNavigationPriorityBanking($lang,$currentactivemenu,$finalstring,$formobile,$test=0, $parentid = 0)
    {
        global $PageTypeAr;
        $db = new DB_Sql();
        $counter=0;
        $counterloop = 0;
        $backgroundclassforfooter = '';
        $sql="select * from tblprioritybankingpages where ParentTableID = '".$parentid."'AND ShowInNav=1  AND Active='".ACTIVE."' order by rOrder ASC";
        $db->query($sql);
        if($db->num_rows() > 0)
        {
            if($parentid == 0 && $formobile==1)
            {
                echo  '<ul class="slimmenu">';
            }
            elseif($parentid == 0){
                echo '<ul class="sub-menu">';
            }
            else
            {
                echo  '<ul>';
            }


            if($parentid == 0){
                echo '<li><a href="'.DOMAINNAME.'" style="padding: 5px;margin: -1px 0 0 0;"><img src="'.DOMAINNAME_PRIORITY_BANKING.'/images/logo.png" class="logo_main" style="width: 130px;height: 45px;"></a></li>';
            }

            if($test==0)
            {
                ?>

                <li><a href="<?php echo DOMAINNAME;?>">Ajman Bank</a></li>
                <li><a href="<?php echo generateFrontUrlForPriorityBanking(isset($_SESSION['TRA_FRONT_WEB_LANG']) ? $_SESSION['TRA_FRONT_WEB_LANG'] : 'en');?>/"><?=HOME?></a></li>
                <?php
            }
            while($db->next_record())
            {
                $counter++;

                $counterloop++;
                $class = ($currentactivemenu == $db->f("TableID"))?' active':'';

                $target = ($db->f("PageType") == 4)?" target='_blank'":"";

                $Title = ($lang == 'en')?$db->f("MenuTitle"):$db->f("MenuTitleAr");

                $countvalues = getCountRecord("tblprioritybankingpages","ParentTableID",$db->f("TableID"));
                $hasclass = ($countvalues > 0 && $db->f("ParentTableID") > 0)?' <span></span> ':'';

                echo  '<li class="'.$class.'"><a href="'.$this->generateURLLinkPriorityBanking($db,"en").'" '.$target.' '.$backgroundclassforfooter.'">'.clearTextForField($Title).' '.$hasclass.'</a>';

                $this->loadFrontNavigationPriorityBanking($db->f("TableID"),$lang,$currentactivemenu,$finalstring,$formobile=2,$test=1);


                echo  '</li>';
            }

            echo  '</ul>';
        }

    }

    function generateURLLinkPriorityBanking($dbobj,$lang)
    {
        $finallink = '';
        if($dbobj->f("PageType") == 3)
        {
            $finallink = "javascript:void(0)";
        }
        else if($dbobj->f("PageType") == 4)
        {
            //$finallink = "http://".str_replace("http://","",$dbobj->f("ExternalLink".LANG_SEP_DB));
            $finallink = $dbobj->f("ExternalLink".LANG_SEP_DB);
        }
        else if($dbobj->f("PageType") == 22)
        {
            //$finallink = "http://".str_replace("http://","",$dbobj->f("ExternalLink".LANG_SEP_DB));
            $finallink = $dbobj->f("ExternalLink".LANG_SEP_DB);
        }
        else
        {
            $Domain = ($lang == 'en')?DOMAINNAME_PRIORITY_BANKING:DOMAINNAME_PRIORITY_BANKING_AR;

            $finallink = $Domain.'/'.$dbobj->f("URLKeyword").".html";
        }

        return $finallink;
    }

    function generateURLLink($dbobj,$lang)
    {
        $finallink = '';
        if($dbobj->f("PageType") == 3)
        {
            $finallink = "javascript:void(0)";
        }
        else if($dbobj->f("PageType") == 4)
        {
            //$finallink = "http://".str_replace("http://","",$dbobj->f("ExternalLink".LANG_SEP_DB));
            $finallink = $dbobj->f("ExternalLink".LANG_SEP_DB);
        }
        // else if($dbobj->f("PageType") == 22)
        // {
        // 	//$finallink = "http://".str_replace("http://","",$dbobj->f("ExternalLink".LANG_SEP_DB));
        // 	$finallink = $dbobj->f("ExternalLink".LANG_SEP_DB);
        // }
        else
        {
            $Domain = ($lang == 'en')?DOMAINNAME:DOMAINNAME;

            $finallink = $Domain.'/'.$dbobj->f("URLKeyword")."";
        }

        return $finallink;
    }

    function generateBreadCrumbPriorityBanking($dbobj,$lang,&$finalarray)
    {
        if($dbobj->f("ParentTableID") > 0)
        {
            $db = new DB_Sql();
            $sql="select * from tblprioritybankingpages where TableID = '".$dbobj->f("ParentTableID")."'";
            $db->query($sql);
            $db->next_record();

            if($db->f("TableID") > 0)
            {
                $target = ($db->f("PageType") == 4)?" target='_blank'":"";

                $Title = ($lang == 'ar')?$db->f("MenuTitleAr"):$db->f("MenuTitle");

                $finalarray[$db->f("TableID")] = '<a href="'.$this->generateURLLinkPriorityBanking($db,$lang).'" class="startmenu'.$class.'"'.$target.'>'.$Title.'</a>';

                $this->generateBreadCrumbPriorityBanking($db,$lang,$finalarray);
            }
        }

        ksort($finalarray);
    }

    function generateBreadCrumb($dbobj,$lang,&$finalarray)
    {
        if($dbobj->f("ParentTableID") > 0)
        {
            $db = new DB_Sql();
            $sql="select * from tblpages where TableID = '".$dbobj->f("ParentTableID")."'";
            $db->query($sql);
            $db->next_record();

            if($db->f("TableID") > 0)
            {
                $target = ($db->f("PageType") == 4)?" target='_blank'":"";

                $Title = ($lang == 'ar')?$db->f("MenuTitleAr"):$db->f("MenuTitle");

                $finalarray[$db->f("TableID")] = '<a href="'.$this->generateURLLink($db,$lang).'" class="startmenu'.$class.'"'.$target.'>'.$Title.'</a>';

                $this->generateBreadCrumb($db,$lang,$finalarray);
            }
        }

        ksort($finalarray);
    }

    function manageDocuments($object,$objectfiles,$AllowedFileExtension)
    {
        global $AllowedDocumentsExtensions;
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    $RecordInfo = FetchRecordByID($value,"TableID","tbldocuments");
                    if($RecordInfo['TableID'] > 0)
                    {
                        $db->query("delete from tbldocuments where TableID=$value");
                        $af_rows = $db->affected_rows();

                        if($af_rows >= 0)
                        {
                            $filedate = strtotime($RecordInfo['CreationDateTime']);
                            if($RecordInfo['FileName'] != '')
                            {
                                $path = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER."/".$RecordInfo['FileName'];
                                @unlink($path);
                            }

                            if($RecordInfo['FileNameAr'] != '')
                            {
                                $path = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER."/".$RecordInfo['FileNameAr'];
                                @unlink($path);
                            }
                        }
                    }
                }
            }
            else
            {
                $RecordInfo = FetchRecordByID($object['RecordID'],"TableID","tbldocuments");

                if($RecordInfo['TableID'] > 0)
                {
                    $filedate = strtotime($RecordInfo['CreationDateTime']);
                    $path = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER."/";

                    $db->query("delete from tbldocuments where TableID='".$object['RecordID']."'");
                    $af_rows = $db->affected_rows();

                    if($af_rows >= 0)
                    {
                        $filedate = strtotime($RecordInfo['CreationDateTime']);
                        if($RecordInfo['FileName'] != '')
                        {
                            $path = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER."/".$RecordInfo['FileName'];
                            @unlink($path);
                        }

                        if($RecordInfo['FileNameAr'] != '')
                        {
                            $path = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER."/".$RecordInfo['FileNameAr'];
                            @unlink($path);
                        }
                    }
                }
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Documents removed successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $Title = $object['Title'];
            $TitleAr = $object['TitleAr'];
            $Description = $object['Description'];
            $DescriptionAr = $object['DescriptionAr'];
            $Files = $objectfiles['Files'];
            $FilesAr = $objectfiles['FilesAr'];

            for($i=0;$i<sizeof($Title);$i++)
            {
                if($Title[$i] == '')
                {
                    $ErrorFields[$i]['Title'] = "Please enter title in english";
                }

                if($TitleAr[$i] == '')
                {
                    $ErrorFields[$i]['TitleAr'] = "Please enter title in arabic";
                }

                $allowed_ext_text = implode(", ",$AllowedDocumentsExtensions);

                if($object['trigger']=='edit')
                {
                    if($Files['name'][$i] != '')
                    {
                        $filesize = (filesize($Files['name'][$i]) * .0009765625) * .0009765625;
                        $ext = mime_content_type($Files['name'][$i]);

                        if($filesize > DocumentFileSize)
                        {
                            $ErrorFields[$i]['File'] = "Please choose ".DocumentFileSize." MB File Size";
                        }
                        else if(!in_array($ext,$AllowedFileExtension) )
                        {

                            $ErrorFields[$i]['File'] = "Please choose pdf,doc,xls,docx or xlsx file to upload";
                        }

                        /*$FileName = date("YmdHis").'-'.$objectfile['UploadDocument']['name'];

                        $ext = strtolower(end(explode(".",$Files['name'][$i])));
                        //if($ext != 'pdf')
                        if(!in_array($ext,$AllowedDocumentsExtensions))
                        {
                            $ErrorFields[$i]['File'] = "Please choose ".$allowed_ext_text." file to upload";
                        }*/
                    }
                    if($FilesAr['name'][$i] != '')
                    {
                        /*$ext2 = strtolower(end(explode(".",$FilesAr['name'][$i])));
                        //if($ext != 'pdf')
                        if(!in_array($ext2,$AllowedDocumentsExtensions))
                        {
                            $ErrorFields[$i]['FilesAr'] = "Please choose ".$allowed_ext_text." file to upload in arabic";
                        }*/

                        $filesize2 = (filesize($FilesAr['name'][$i]) * .0009765625) * .0009765625;
                        $ext2 = mime_content_type($FilesAr['name'][$i]);

                        if($filesize2 > DocumentFileSize)
                        {
                            $ErrorFields[$i]['FilesAr'] = "Please choose ".DocumentFileSize." MB File Size";
                        }
                        else if(!in_array($ext2,$AllowedFileExtension) )
                        {
                            $ErrorFields[$i]['FilesAr'] = "Please choose pdf,doc,xls,docx or xlsx file to upload";
                        }

                    }
                }
                else
                {
                    if($Files['name'][$i] == '')
                    {
                        $ErrorFields[$i]['File'] = "Please select file to upload";
                    }
                    else
                    {
                        $filesize = (filesize($Files['tmp_name'][$i]) * .0009765625) * .0009765625;
                        $ext = mime_content_type($Files['tmp_name'][$i]);

                        if($filesize > DocumentFileSize)
                        {
                            $ErrorFields[$i]['File'] = "Please choose ".DocumentFileSize." MB File Size";
                        }
                        else if(!in_array($ext,$AllowedFileExtension) )
                        {
                            $ErrorFields[$i]['File'] = "Please choose pdf,doc,xls,docx or xlsx file to upload ";
                        }


                        /*$ext = strtolower(end(explode(".",$Files['name'][$i])));
                        //if($ext != 'pdf')
                        if(!in_array($ext,$AllowedDocumentsExtensions))
                        {
                            $ErrorFields[$i]['File'] = "Please choose ".$allowed_ext_text." file to upload";
                        }*/
                    }

                    if($FilesAr['name'][$i] == '')
                    {
                        $ErrorFields[$i]['FilesAr'] = "Please select file to upload in arabic";
                    }
                    else
                    {
                        /*$ext = strtolower(end(explode(".",$FilesAr['name'][$i])));
                        //if($ext != 'pdf')
                        if(!in_array($ext,$AllowedDocumentsExtensions))
                        {
                            $ErrorFields[$i]['FilesAr'] = "Please choose ".$allowed_ext_text." file to upload in arabic";
                        }*/

                        $filesize2 = (filesize($FilesAr['tmp_name'][$i]) * .0009765625) * .0009765625;
                        $ext2 = mime_content_type($FilesAr['tmp_name'][$i]);

                        if($filesize2 > DocumentFileSize)
                        {
                            $ErrorFields[$i]['FilesAr'] = "Please choose ".DocumentFileSize." MB File Size";
                        }
                        else if(!in_array($ext2,$AllowedFileExtension) )
                        {
                            $ErrorFields[$i]['FilesAr'] = "Please choose pdf,doc,xls,docx or xlsx file to upload";
                        }


                    }
                }
            }


            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            for($i=0;$i<sizeof($Title);$i++)
            {
                if($object['trigger']=='edit')
                    $Query ="UPDATE tbldocuments set";
                else
                    $Query ="insert into tbldocuments set";

                $FileName = date("YmdHis").'-'.$Files['name'][$i];
                $FileNameAr = date("YmdHis").'-'.$FilesAr['name'][$i];

                $Query .= " ParentTableID = '".$object['PageTableID']."',
				DocumentType = '".$object['DocumentType']."',
				Title = '".clearTextForDb($Title[$i])."',
				TitleAr = '".clearTextForDb($TitleAr[$i])."',
				Description = '".clearTextForDb($Description[$i])."',
				DescriptionAr = '".clearTextForDb($DescriptionAr[$i])."',
				Active = '".ACTIVE."' ";

                if($object['trigger']=='edit')
                {
                    if($Files['name'][$i]!='')
                    {
                        $Query .= ", FileName = '".$FileName."' ";
                    }
                    if($FilesAr['name'][$i]!='')
                    {
                        $Query .= ", FileNameAr = '".$FileNameAr."' ";
                    }

                }
                else
                {
                    $Query .= ", FileName = '".$FileName."',
							   FileNameAr = '".$FileNameAr."' ";
                }

                $ParentTableID = ($object['PageTableID'] > 0)?$object['PageTableID']:0;
                $rOrder = maxID("rOrder","tbldocuments where ParentTableID='".$ParentTableID."'",1);

                if($object['trigger']=='edit')
                {
                    $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
					ModificationDateTime = '".getCurrentDateTime()."' 
					where TableID='".$object['RecordID']."'
					";
                }
                else
                {
                    $Query .= ", rOrder = '".$rOrder."',
					CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
					CreationDate = '".date("Y-m-d")."',
					CreationDateTime = '".getCurrentDateTime()."'
					";
                }

                $db->query($Query);

                //$recordid = $db->MysqlInsertID();
                $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();
                if($recordid > 0)
                {
                    if($Files['tmp_name'][$i]!='')
                    {
                        $FinalFilePath = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER.'/'.$FileName;
                        @copy($Files['tmp_name'][$i],$FinalFilePath);
                    }

                    if($FilesAr['tmp_name'][$i]!='')
                    {
                        $FinalFilePathAr = BASE_URL.'/'.SET_FILE_FOLDER_NAME.'/'.DOCUMENTS_FOLDER.'/'.$FileNameAr;
                        @copy($FilesAr['tmp_name'][$i],$FinalFilePathAr);
                    }
                }
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Documents updated successfully":"Documents uploaded successfully";
        }

        redirect("home.php?".EncodeUrl("action=".$object['DocumentAction']."&PageType=".$object['DocumentPageType']."&TableID=".$object['PageTableID']), 0);
    }

    private function deletePageTab($TableID)
    {
        $db = new DB_Sql();

        $RecordInfo = FetchRecordByID($TableID,"TableID","tbltabs");

        if($RecordInfo['TableID'] > 0)
        {
            $deletemasternow = 1;

            //if($RecordInfo['TabType'] == 2)
            //{
            $this->DeleteDocuments($RecordInfo['TableID'],'tabs');
            //}

            if($deletemasternow)
            {
                $db->query("delete from tbltabs where TableID='".$RecordInfo['TableID']."'");
                $af_rows = $db->affected_rows();

                if($af_rows >= 0)
                {
                    if($RecordInfo['FileName'] != '')
                    {
                        $path = '../'.FILES_FOLDER."/".WEB_PAGE_TABS."/".$RecordInfo['FileName'];
                        @unlink($path);
                    }

                    if($RecordInfo['FileNameAr'] != '')
                    {
                        $path = '../'.FILES_FOLDER."/".WEB_PAGE_TABS."/".$RecordInfo['FileNameAr'];
                        @unlink($path);
                    }
                }
            }
        }
    }

    function managePageTabs($object,$objectfiles)
    {
        $db = new DB_Sql();
        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');


            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    $db->query("delete from tblprioritybankingtab where TableID='".$value."'");
                }
            }
            else
            {
                $db->query("delete from tblprioritybankingtab where TableID='".$object['RecordID']."'");
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Pripority Banking Page Tab Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';


            if($_REQUEST['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($_REQUEST['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($_REQUEST['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Page Status';
            }
            if($_REQUEST['ParentTableID'] == 40)
            {
                if($_REQUEST['PageSection'] == '-1')
                {
                    $ErrorFields['PageSection'] = 'Please Select Page Section';
                }
            }
            if($_REQUEST['Description'] == '')
            {
                $ErrorFields['Description'] = 'Please Enter Description (English)';
            }

            if($_REQUEST['DescriptionAr'] == '')
            {
                $ErrorFields['DescriptionAr'] = 'Please Enter Description (Arabic)';
            }

            if($objectfiles['TabImage']['name'] != '')
            {
                $filesize = (filesize($objectfiles['TabImage']['tmp_name']) * .0009765625) * .0009765625;
                //$ext = mime_content_type($objectfile['TabImage']['tmp_name']);
                if($filesize > ImageSize)
                {
                    $ErrorFields['TabImage'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    //$ErrorFields['Icon'] = "Please choose jpg,gif and png to upload";
                }

                $TabImage = date("YmdHis").'-'.$objectfiles['TabImage']['name'];

            }
            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['trigger']=='edit')
                $Query="update tblprioritybankingtab set";
            else
                $Query="insert into tblprioritybankingtab set";

            $Query .= " ParentTableID = '".$object['ParentTableID']."', 
			Title = '".clearTextForDb($object['Title'])."',
			URL = '".clearTextForDb($object['URL'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			Description = '".clearTextForDb($object['Description'])."',
			DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
			BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
			PageSection = '".$object['PageSection']."',
			Active = '".$object['Active']."'
			";

            if($TabImage != '')
            {
                $Query .= ", TabImage = '".$TabImage."'";
            }
            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $ParentTableID = ($object['ParentTableID'] > 0)?$object['ParentTableID']:0;
                $rOrder = maxID("rOrder","tblprioritybankingtab where ParentTableID='".$ParentTableID."'",1);

                $Query .= ", rOrder = '".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }


            $db->query($Query);



            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                if($objectfiles['TabImage']['name'] != '')
                {
                    $FinalPath = '../'.FILES_FOLDER.'/'.TABS_ICON;

                    $FinalFilePath = $FinalPath.'/'.$TabImage;

                    if(copy($objectfiles['TabImage']['tmp_name'],$FinalFilePath))
                    {
                        //now create thuumbail
                        $ThumbImgPath = $FinalPath.'/thumb_'.$TabImage;

                        $resizeObj = new resize($FinalFilePath);
                        //$resizeObj -> resizeImage(PRIORITY_BANKING_BANNER_WIDTH, PRIORITY_BANKING_BANNER_HEIGHT, 'crop');
                        $resizeObj -> saveImage($ThumbImgPath, 100);
                    }
                }

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Pripority Banking Page Tab Edited Successfully":"Pripority Banking  Page Tab Added Successfully";

            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallprioritybanking&PageType=TabListing&PageRecordID=".$_REQUEST['PageRecordID'].'&PageTitle='.$_REQUEST['PageTitle']), 0);
    }



    function managePageCategory($object,$objectfile,$AllowedImageExtension)
    {
        $db = new DB_Sql();
        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');


            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    $db->query("delete from tblprioritybankingcategory where TableID='".$value."'");
                }
            }
            else
            {
                $db->query("delete from tblprioritybankingcategory where TableID='".$object['RecordID']."'");
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Pripority Banking Page Category Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';


            if($_REQUEST['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($_REQUEST['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($_REQUEST['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Page Status';
            }

            /*if($_REQUEST['BriefDescription'] == '')
            {
                $ErrorFields['BriefDescription'] = 'Please Enter Brief Description (English)';
            }

            if($_REQUEST['BriefDescriptionAr'] == '')
            {
                $ErrorFields['BriefDescriptionAr'] = 'Please Enter Brief Description (Arabic)';
            }*/

            if($_REQUEST['Description'] == '')
            {
                $ErrorFields['Description'] = 'Please Enter Description (English)';
            }

            if($_REQUEST['DescriptionAr'] == '')
            {
                $ErrorFields['DescriptionAr'] = 'Please Enter Description (Arabic)';
            }

            if($objectfile['Icon']['name'] != '')
            {
                $filesize = (filesize($objectfile['Icon']['tmp_name']) * .0009765625) * .0009765625;
                $ext = mime_content_type($objectfile['Icon']['tmp_name']);

                if($filesize > ImageSize)
                {
                    $ErrorFields['Icon'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    $ErrorFields['Icon'] = "Please choose jpg,gif and png to upload";
                }

                $FileName = date("YmdHis").'-'.$objectfile['Icon']['name'];
            }

            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['trigger']=='edit')
                $Query="update tblprioritybankingcategory set";
            else
                $Query="insert into tblprioritybankingcategory set";

            $Query .= " ParentTableID = '".$object['ParentTableID']."', 
			Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			Description = '".clearTextForDb($object['Description'])."',
			DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
			BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
			Active = '".$object['Active']."',
			ReadMorePageID = '".$object['ReadMorePageID']."'
			";




            if($FileName!='')
            {
                $Query .= ", IconFile = '".$FileName."'";
            }

            if($object['trigger']=='edit')
            {
                if($object['RemoveImage'] == 1 && $object['RemoveImage'] != '' && $object['IconFile'] != '')
                {
                    $FinalPath = '../'.FILES_FOLDER.'/'.NEWS_ICONS;
                    @unlink($FinalPath.'/'.$object['IconFile']);
                    @unlink($FinalPath.'/thumb_'.$object['IconFile']);

                    if($FileName == '')
                    {
                        $Query .= ", IconFile = ''";
                        $removeimage .= ", IconFile = ''";
                    }
                }

                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $ParentTableID = ($object['ParentTableID'] > 0)?$object['ParentTableID']:0;
                $rOrder = maxID("rOrder","tblprioritybankingcategory where ParentTableID='".$ParentTableID."'",1);

                $Query .= ", rOrder = '".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {

                if($objectfile['Icon']['name'] != '')
                {
                    $FinalPath = '../'.FILES_FOLDER.'/'.NEWS_ICONS;

                    $FinalFilePath = $FinalPath.'/'.$FileName;

                    if(copy($objectfile['Icon']['tmp_name'],$FinalFilePath))
                    {
                        //now create thuumbail
                        $ThumbImgPath = $FinalPath.'/thumb_'.$FileName;

                        $resizeObj = new resize($FinalFilePath);
                        $resizeObj -> resizeImage(PRIORITY_BANKING_CATEGORY_IMAGE_WIDTH, PRIORITY_BANKING_CATEGORY_IMAGE_HEIGHT, 'crop');
                        $resizeObj -> saveImage($ThumbImgPath, 100);
                    }
                }

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Pripority Banking Page Category Edited Successfully":"Pripority Banking  Page Category Added Successfully";

            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallprioritybanking&PageType=CategoryListing&PageRecordID=".$_REQUEST['PageRecordID'].'&PageTitle='.$_REQUEST['PageTitle']), 0);
    }

    private function deleteBoardMemberRecords($TableID)
    {
        $db = new DB_Sql();

        $RecordInfo = FetchRecordByID($TableID,"TableID",'tbllocator');

        if($RecordInfo['TableID'] > 0)
        {
            $deletemasternow = 1;

            $db->query("delete from tbllocator where TableID='".$RecordInfo['TableID']."'");
            $af_rows = $db->affected_rows();

            if($af_rows >= 0 && $RecordInfo['IconFile'] != '')
            {
                $path = '../'.FILES_FOLDER.'/'.BOARD_MEMBERS_ICONS.'/'.$RecordInfo['IconFile'];
                @unlink($path);
            }
        }
    }

    function manageStoreLocator($object,$objectfile)
    {
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    //log table
                    $dataObject = FetchRecordByID($value,'TableID','tbllocator');
                    $logquery =    "Title = '".($dataObject['Title'])."',
									TitleAr = '".($dataObject['TitleAr'])."',
									Address = '".($dataObject['Address'])."',
									AddressAr = '".($dataObject['AddressAr'])."',
									Telephone = '".($dataObject['Telephone'])."',
									Fax = '".($dataObject['Fax'])."',
									BranchLocator = '".($dataObject['BranchLocator'])."',
									Branchsite = '".($dataObject['Branchsite'])."',
									Latitude = '".($dataObject['Latitude'])."',
									Longitude = '".($dataObject['Longitude'])."',
									BranchCategoryID = '".($dataObject['BranchCategoryID'])."',
									Active = '".$dataObject['Active']."'
									";
                    logTableInsertQuery('tbllocator',$value , $logquery, 3);

                    $this->deleteBoardMemberRecords($value);
                }
            }
            else
            {
                //log table
                $dataObject = FetchRecordByID($object['RecordID'],'TableID','tbllocator');
                $logquery =    "Title = '".($dataObject['Title'])."',
								TitleAr = '".($dataObject['TitleAr'])."',
								Address = '".($dataObject['Address'])."',
								AddressAr = '".($dataObject['AddressAr'])."',
								Telephone = '".($dataObject['Telephone'])."',
								Fax = '".($dataObject['Fax'])."',
								BranchLocator = '".($dataObject['BranchLocator'])."',
								Branchsite = '".($dataObject['Branchsite'])."',
								Latitude = '".($dataObject['Latitude'])."',
								Longitude = '".($dataObject['Longitude'])."',
								BranchCategoryID = '".($dataObject['BranchCategoryID'])."',
								Active = '".$dataObject['Active']."'
								";
                logTableInsertQuery('tbllocator',$object['RecordID'] , $logquery, 3);

                $this->deleteBoardMemberRecords($object['RecordID']);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Branch/ATM Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';

            if($object['BranchCategoryID'] == '')
            {
                $ErrorFields['BranchCategoryID'] = 'Please Select Branch Category';
            }

            if($object['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($object['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($object['Address'] == '')
            {
                $ErrorFields['Address'] = 'Please Enter Address (English)';
            }

            if($object['AddressAr'] == '')
            {
                $ErrorFields['AddressAr'] = 'Please Enter Address (Arabic)';
            }

            if($object['Latitude'] == '')
            {
                $ErrorFields['Latitude'] = 'Please Enter Latitude ';
            }


            if($object['Longitude'] == '')
            {
                $ErrorFields['Longitude'] = 'Please Enter Longitude';
            }

            if($object['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Status';
            }


            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['trigger']=='edit')
                $Query="update tbllocator set";
            else
                $Query="insert into tbllocator set";

            $Query .= " Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			Address = '".clearTextForDb($object['Address'])."',
			AddressAr = '".clearTextForDb($object['AddressAr'])."',
			Telephone = '".clearTextForDb($object['Telephone'])."',
			Fax = '".clearTextForDb($object['Fax'])."',
			BranchLocator = '".clearTextForDb($object['BranchLocator'])."',
			Branchsite = '".clearTextForDb($object['Branchsite'])."',
			Latitude = '".clearTextForDb($object['Latitude'])."',
			Longitude = '".clearTextForDb($object['Longitude'])."',
			BranchCategoryID = '".clearTextForDb($object['BranchCategoryID'])."',
			Active = '".$object['Active']."'
			";


            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $rOrder = maxID("rOrder","tbllocator",1);

                $Query .= ", rOrder='".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                //log table
                $logquery =    "Title = '".clearTextForDb($object['Title'])."',
								TitleAr = '".clearTextForDb($object['TitleAr'])."',
								Address = '".clearTextForDb($object['Address'])."',
								AddressAr = '".clearTextForDb($object['AddressAr'])."',
								Telephone = '".clearTextForDb($object['Telephone'])."',
								Fax = '".clearTextForDb($object['Fax'])."',
								BranchLocator = '".clearTextForDb($object['BranchLocator'])."',
								Branchsite = '".clearTextForDb($object['Branchsite'])."',
								Latitude = '".clearTextForDb($object['Latitude'])."',
								Longitude = '".clearTextForDb($object['Longitude'])."',
								BranchCategoryID = '".clearTextForDb($object['BranchCategoryID'])."',
								Active = '".$object['Active']."'
								";
                logTableInsertQuery('tbllocator',$recordid , $logquery, $object['trigger']);

                if($objectfile['Icon']['name'] != '')
                {
                    $FinalFilePath = '../'.FILES_FOLDER.'/'.BOARD_MEMBERS_ICONS.'/'.$FileName;

                    @copy($objectfile['Icon']['tmp_name'],$FinalFilePath);
                    @unlink($objectfile['Icon']['tmp_name']);
                }

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Branch/ATM Information Updated Successfully":"Branch/ATM Information Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallbrancheslocator"), 0);
    }

    function manageJobInformation($object,$objectfile)
    {
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {

                    //log table
                    $dataObject = FetchRecordByID($value,'TableID','tbljobs');
                    $logquery = "Title = '".clearTextForDb($dataObject['Title'])."',
								TitleAr = '".clearTextForDb($dataObject['TitleAr'])."',
								`BriefDescription` = '".clearTextForDb($dataObject['BriefDescription'])."',
								`BriefDescriptionAr` = '".clearTextForDb($dataObject['BriefDescriptionAr'])."',
								`Description` = '".clearTextForDb($dataObject['Description'])."',
								`DescriptionAr` = '".clearTextForDb($dataObject['DescriptionAr'])."',
								JobExpire = '".clearTextForDb($dataObject['JobExpire'])."',
								MetaKeywords = '".clearTextForDb($dataObject['MetaKeywords'])."',
								MetaKeywordsAr = '".clearTextForDb($dataObject['MetaKeywordsAr'])."',
								MetaDescription = '".clearTextForDb($dataObject['MetaDescription'])."',
								MetaDescriptionAr = '".clearTextForDb($dataObject['MetaDescriptionAr'])."',
								Active = '".$dataObject['Active']."',
								URLKeyword = '".$dataObject['URLKeyword']."',
								Location = '".clearTextForDb($dataObject['Location'])."',
								LocationAr = '".clearTextForDb($dataObject['LocationAr'])."',
								VacantPositions = '".clearTextForDb($dataObject['VacantPositions'])."',
								Department = '".clearTextForDb($dataObject['Department'])."',
								DepartmentAr = '".clearTextForDb($dataObject['DepartmentAr'])."'
								";
                    logTableInsertQuery('tbljobs',$value , $logquery, 3);

                    $db->query("delete from tbljobapplication where JobID='".$value."'");
                    $db->query("delete from tbljobs where TableID='".$value."'");
                }
            }
            else
            {
                //log table
                $dataObject = FetchRecordByID($object['RecordID'],'TableID','tbljobs');
                $logquery = "Title = '".clearTextForDb($dataObject['Title'])."',
							TitleAr = '".clearTextForDb($dataObject['TitleAr'])."',
							`BriefDescription` = '".clearTextForDb($dataObject['BriefDescription'])."',
							`BriefDescriptionAr` = '".clearTextForDb($dataObject['BriefDescriptionAr'])."',
							`Description` = '".clearTextForDb($dataObject['Description'])."',
							`DescriptionAr` = '".clearTextForDb($dataObject['DescriptionAr'])."',
							JobExpire = '".clearTextForDb($dataObject['JobExpire'])."',
							MetaKeywords = '".clearTextForDb($dataObject['MetaKeywords'])."',
							MetaKeywordsAr = '".clearTextForDb($dataObject['MetaKeywordsAr'])."',
							MetaDescription = '".clearTextForDb($dataObject['MetaDescription'])."',
							MetaDescriptionAr = '".clearTextForDb($dataObject['MetaDescriptionAr'])."',
							Active = '".$dataObject['Active']."',
							URLKeyword = '".$dataObject['URLKeyword']."',
							Location = '".clearTextForDb($dataObject['Location'])."',
							LocationAr = '".clearTextForDb($dataObject['LocationAr'])."',
							VacantPositions = '".clearTextForDb($dataObject['VacantPositions'])."',
							Department = '".clearTextForDb($dataObject['Department'])."',
							DepartmentAr = '".clearTextForDb($dataObject['DepartmentAr'])."'
							";
                logTableInsertQuery('tbljobs',$object['RecordID'] , $logquery, 3);

                $db->query("delete from tbljobapplication where JobID='".$object['RecordID']."'");
                $db->query("delete from tbljobs where TableID='".$object['RecordID']."'");
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Job Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';

            if($object['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($object['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($object['JobExpire'] == '')
            {
                $ErrorFields['JobExpire'] = 'Please Select Job Expire Date';
            }

            if($object['BriefDescription'] == '')
            {
                $ErrorFields['BriefDescription'] = 'Please Enter Brief Description (English)';
            }

            if($object['BriefDescriptionAr'] == '')
            {
                $ErrorFields['BriefDescriptionAr'] = 'Please Enter Brief Description (Arabic)';
            }

            if($object['Description'] == '')
            {
                $ErrorFields['Description'] = 'Please Enter Description (English)';
            }
            if($object['DescriptionAr'] == '')
            {
                $ErrorFields['DescriptionAr'] = 'Please Enter Description (Arabic)';
            }

            if($object['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Status';
            }

            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['trigger']=='edit')
                $Query="update tbljobs set";
            else
                $Query="insert into tbljobs set";

            $Query .= " Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			`BriefDescription` = '".clearTextForDb($object['BriefDescription'])."',
			`BriefDescriptionAr` = '".clearTextForDb($object['BriefDescriptionAr'])."',
			`Description` = '".clearTextForDb($object['Description'])."',
			`DescriptionAr` = '".clearTextForDb($object['DescriptionAr'])."',
			JobExpire = '".clearTextForDb($object['JobExpire'])."',
			MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
			MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
			MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
			MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
			Active = '".$object['Active']."',
			Location = '".clearTextForDb($object['Location'])."',
			LocationAr = '".clearTextForDb($object['LocationAr'])."',
			VacantPositions = '".clearTextForDb($object['VacantPositions'])."',
			Department = '".clearTextForDb($object['Department'])."',
			DepartmentAr = '".clearTextForDb($object['DepartmentAr'])."'
			";

            if($object['URLKeyword'] == '')
            {
                $URLKeyword = SEOFriendlyURL($object['Title']);
                $URLKeyword = $this->SEOFriendlyURL($URLKeyword,$URLKeyword,"tbljobs");
            }
            else
            {
                $URLKeyword = $object['URLKeyword'];
            }

            $Query .= ", URLKeyword = '".$URLKeyword."'";


            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $rOrder = maxID("rOrder","tbljobs",1);

                $Query .= ", rOrder='".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {

                //log table
                $logquery =    "Title = '".clearTextForDb($object['Title'])."',
								TitleAr = '".clearTextForDb($object['TitleAr'])."',
								`BriefDescription` = '".clearTextForDb($object['BriefDescription'])."',
								`BriefDescriptionAr` = '".clearTextForDb($object['BriefDescriptionAr'])."',
								`Description` = '".clearTextForDb($object['Description'])."',
								`DescriptionAr` = '".clearTextForDb($object['DescriptionAr'])."',
								JobExpire = '".clearTextForDb($object['JobExpire'])."',
								MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
								MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
								MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
								MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
								Active = '".$object['Active']."',
								URLKeyword = '".$URLKeyword."',
								Location = '".clearTextForDb($object['Location'])."',
								LocationAr = '".clearTextForDb($object['LocationAr'])."',
								VacantPositions = '".clearTextForDb($object['VacantPositions'])."',
								Department = '".clearTextForDb($object['Department'])."',
								DepartmentAr = '".clearTextForDb($object['DepartmentAr'])."'
								";
                logTableInsertQuery('tbljobs',$recordid , $logquery, $object['trigger']);

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Job Updated Successfully":"Job Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewalljobs"), 0);
    }

    function deleteJobInformation($object,$objectfile)
    {
        $db = new DB_Sql();
        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    $FileName  = getFieldDataByID('Resume','TableID',$value,'tbljobapplication');
                    $FinalFilePath = BASE_URL.'/'.$FileName;
                    @unlink($FinalFilePath);
                    $db->query("delete from tbljobapplication where TableID='".$value."'");
                }
            }
            else
            {
                $FileName  = getFieldDataByID('Resume','TableID',$object['RecordID'],'tbljobapplication');
                $FinalFilePath = BASE_URL.'/'.$FileName;
                @unlink($FinalFilePath);
                $db->query("delete from tbljobapplication where TableID='".$object['RecordID']."'");
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Job Applicants Deleted Successfully";
        }
        redirect("home.php?".EncodeUrl("action=managejobapplicants&JobID=".$object['JobID']), 0);
    }

    private function SEOFriendlyURL($originalstring,$finalstring,$tablename)
    {
        if($finalstring!= '')
        {
            $db = new DB_Sql();

            $query = "select * from ".$tablename." where URLKeyword='".$finalstring."' order by TableID DESC limit 0,1";

            $db->query($query);

            if($db->num_rows() > 0)
            {
                $db->next_record();
                $finalval = end(explode("-",$finalstring));

                if($finalval > 0)
                {
                    $finalval += 1;
                }
                else
                {
                    $finalval = 1;
                }

                $finalstring = $originalstring.'-'.$finalval;

                return $this->SEOFriendlyURL($originalstring,$finalstring,$tablename);
            }
            else
            {
                return $finalstring;
            }
        }
    }

    public function getPageBreadByTypeID($typeid,$lang)
    {
        $db = new DB_Sql();
        $query = "select * from tblpages where PageType = '".$typeid."' limit 0,1";
        $db->query($query);
        $db->next_record();

        $BreadCrumbs = array();

        if($db->f("TableID") > 0)
        {
            $this->generateBreadCrumb($db,$lang,$BreadCrumbs);

            $target = ($db->f("PageType") == 4)?" target='_blank'":"";
            $Title = ($lang == 'ar')?$db->f("MenuTitleAr"):$db->f("MenuTitle");
            $BreadCrumbs[] = '<a href="'.$this->generateURLLink($db,$lang).'"'.$target.'>'.$Title.'</a>';
        }

        return $BreadCrumbs;
    }

    private function deleteShortBanners($TableID,$TableName,$FolderPath)
    {
        $db = new DB_Sql();

        $RecordInfo = FetchRecordByID($TableID,"TableID",$TableName,$FolderPath);

        if($RecordInfo['TableID'] > 0)
        {
            if($RecordInfo["FileName"] != '')
            {
                $path = '../'.FILES_FOLDER."/".$FolderPath.'/'.$RecordInfo["FileName"];
                @unlink($path);
            }

            if($RecordInfo["FileNameAr"] != '')
            {
                $path = '../'.FILES_FOLDER."/".$FolderPath.'/'.$RecordInfo["FileNameAr"];
                @unlink($path);
            }

            //now unlink all tabs
            $db->query("delete from ".$TableName." where TableID='".$RecordInfo['TableID']."'");
        }
    }
    private function deletePriorityBanners($TableID,$TableName,$FolderPath)
    {
        $db = new DB_Sql();

        $RecordInfo = FetchRecordByID($TableID,"TableID",$TableName,$FolderPath);

        if($RecordInfo['TableID'] > 0)
        {
            if($RecordInfo["FileName"] != '')
            {
                $path = '../'.FILES_FOLDER."/".$FolderPath.'/'.$RecordInfo["FileName"];
                @unlink($path);
            }

            if($RecordInfo["FileNameAr"] != '')
            {
                $path = '../'.FILES_FOLDER."/".$FolderPath.'/'.$RecordInfo["FileNameAr"];
                @unlink($path);
            }

            //now unlink all tabs
            $db->query("delete from ".$TableName." where TableID='".$RecordInfo['TableID']."'");
        }
    }
    function manageShortLinks($object,$objectfile,$AllowedImageExtension,$ShortLinkTypeAr)
    {
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    //log table
                    $dataObject = FetchRecordByID($value,'TableID','tblshortlinks');
                    $logquery =    "CategoryID = '".$dataObject['CategoryID']."',
									ShortLinkType = '".$dataObject['ShortLinkType']."',
									Title = '".($dataObject['Title'])."',
									TitleAr = '".($dataObject['TitleAr'])."',
									Title2 = '".($dataObject['Title2'])."',
									Title2Ar = '".($dataObject['Title2Ar'])."',
									LinkTitle = '".($dataObject['LinkTitle'])."',
									LinkTitleAr = '".($dataObject['LinkTitleAr'])."',
									BriefDescription = '".($dataObject['BriefDescription'])."',
									BriefDescriptionAr = '".($dataObject['BriefDescriptionAr'])."',
									Description = '".($dataObject['Description'])."',
									DescriptionAr = '".($dataObject['DescriptionAr'])."', 
									Active = '".$dataObject['Active']."',
									URL = '".($dataObject['URL'])."',
									URLAr = '".($dataObject['URLAr'])."',
									URLTarget = '".$dataObject['URLTarget']."',
									IconFile = '".$dataObject['IconFile']."'
									";
                    logTableInsertQuery('tblshortlinks',$value , $logquery, 3);

                    $this->deleteShortBanners($value,"tblshortlinks",SHORT_LINKS);
                }
            }
            else
            {
                //log table
                $dataObject = FetchRecordByID($object['RecordID'],'TableID','tblshortlinks');
                $logquery =    "CategoryID = '".$dataObject['CategoryID']."',
								ShortLinkType = '".$dataObject['ShortLinkType']."',
								Title = '".($dataObject['Title'])."',
								TitleAr = '".($dataObject['TitleAr'])."',
								Title2 = '".($dataObject['Title2'])."',
								Title2Ar = '".($dataObject['Title2Ar'])."',
								LinkTitle = '".($dataObject['LinkTitle'])."',
								LinkTitleAr = '".($dataObject['LinkTitleAr'])."',
								BriefDescription = '".($dataObject['BriefDescription'])."',
								BriefDescriptionAr = '".($dataObject['BriefDescriptionAr'])."',
								Description = '".($dataObject['Description'])."',
								DescriptionAr = '".($dataObject['DescriptionAr'])."', 
								Active = '".$dataObject['Active']."',
								URL = '".($dataObject['URL'])."',
								URLAr = '".($dataObject['URLAr'])."',
								URLTarget = '".$dataObject['URLTarget']."',
								IconFile = '".$dataObject['IconFile']."'
								";
                logTableInsertQuery('tblshortlinks',$object['RecordID'] , $logquery, 3);

                $this->deleteShortBanners($object['RecordID'],"tblshortlinks",SHORT_LINKS);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Homepage Tab Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';

            if($object['CategoryID'] == '-1')
            {
                $ErrorFields['CategoryID'] = 'Please Select Link Category';
            }


            if($object['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($object['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($object['CategoryID']==1)
            {

                if($object['BriefDescription'] == '')
                {
                    $ErrorFields['BriefDescription'] = 'Please Enter Brief Description (English)';
                }

                if($object['BriefDescriptionAr'] == '')
                {
                    $ErrorFields['BriefDescriptionAr'] = 'Please Enter Brief Description (Arabic)';
                }
                if($object['trigger']!='edit')
                {
                    if($objectfile['Icon']['name'] == '')
                    {
                        $ErrorFields['Icon'] = "Please Select Icon";
                    }
                }

            }

            if($objectfile['Icon']['name'] != '')
            {
                $filesize = (filesize($objectfile['Icon']['tmp_name']) * .0009765625) * .0009765625;
                $ext = mime_content_type($objectfile['Icon']['tmp_name']);
                //$ext = 'image/png';
                if($filesize > ImageSize)
                {
                    $ErrorFields['Icon'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    $ErrorFields['Icon'] = "Please choose jpg,gif and png to upload";
                }

                $info = getimagesize($objectfile['Icon']['tmp_name']);
                $CatAr = $ShortLinkTypeAr[$object['CategoryID']];
                if($info[0] != $CatAr['IconW'] || $info[1] != $CatAr['IconH'])
                {
                    $ErrorFields['Icon'] = "Please upload image of ".$CatAr['IconW']."px x ".$CatAr['IconH']."px to upload";
                }

                $FileName = date("YmdHis").'-'.generatepassword(15).$objectfile['Icon']['name'];
            }

            if($object['CategoryID']==2)
            {

                if($object['Description'] == '')
                {
                    $ErrorFields['Description'] = 'Please Enter Description (English)';
                }

                if($object['DescriptionAr'] == '')
                {
                    $ErrorFields['DescriptionAr'] = 'Please Enter Description (Arabic)';
                }
                if($object['trigger']!='edit')
                {
                    if($objectfile['Icon']['name'] == '')
                    {
                        $ErrorFields['Icon'] = "Please Select Slider Image";
                    }
                }
            }

            if($object['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Category Status';
            }



            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }


            if($object['trigger']=='edit')
                $Query="update tblshortlinks set";
            else
                $Query="insert into tblshortlinks set";

            $Query .= " Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			Title2 = '".clearTextForDb($object['Title2'])."',
			Title2Ar = '".clearTextForDb($object['Title2Ar'])."',
			LinkTitle = '".clearTextForDb($object['LinkTitle'])."',
			LinkTitleAr = '".clearTextForDb($object['LinkTitleAr'])."',
			BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
			Description = '".clearTextForDb($object['Description'])."',
			DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."', 
			Active = '".$object['Active']."',
			URL = '".clearTextForDb($object['URL'])."',
			URLAr = '".clearTextForDb($object['URLAr'])."',
			URLTarget = '".$object['URLTarget']."'
			";

            if($FileName!='')
            {
                $Query .= ", IconFile = '".$FileName."'";
            }

            if($FileNamePdf!='')
            {
                $Query .= ", FileName = '".$FileNamePdf."'";
            }

            if($FileNamePdfAr!='')
            {
                $Query .= ", FileNameAr = '".$FileNamePdfAr."'";
            }

            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $rOrder = maxID("rOrder","tblshortlinks",1);
                $object['ShortLinkType'] = 0;
                $Query .= ", CategoryID = '".$object['CategoryID']."',
				ShortLinkType = '".$object['ShortLinkType']."',
				rOrder='".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                $object['ShortLinkType'] = 0;
                //log table
                $logquery =    "CategoryID = '".$object['CategoryID']."',
								ShortLinkType = '".$object['ShortLinkType']."',
								Title = '".clearTextForDb($object['Title'])."',
								TitleAr = '".clearTextForDb($object['TitleAr'])."',
								Title2 = '".clearTextForDb($object['Title2'])."',
								Title2Ar = '".clearTextForDb($object['Title2Ar'])."',
								LinkTitle = '".clearTextForDb($object['LinkTitle'])."',
								LinkTitleAr = '".clearTextForDb($object['LinkTitleAr'])."',
								BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
								BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
								Description = '".clearTextForDb($object['Description'])."',
								DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."', 
								Active = '".$object['Active']."',
								URL = '".clearTextForDb($object['URL'])."',
								URLAr = '".clearTextForDb($object['URLAr'])."',
								URLTarget = '".$object['URLTarget']."'
								";

                if($FileName!='')
                {
                    $logquery .= ", IconFile = '".$FileName."'";
                }
                else if($object['IconFile'] != '')
                {
                    $logquery .= ", IconFile = '".$object['IconFile']."'";
                }

                if($FileNamePdf!='')
                {
                    $logquery .= ", FileName = '".$FileNamePdf."'";
                }
                else if($object['OldFileName'] != '')
                {
                    $logquery .= ", FileName = '".$object['OldFileName']."'";
                }

                if($FileNamePdfAr!='')
                {
                    $logquery .= ", FileNameAr = '".$FileNamePdfAr."'";
                }
                else if($object['OldFileNameAr'] != '')
                {
                    $logquery .= ", FileNameAr = '".$object['OldFileNameAr']."'";
                }
                logTableInsertQuery('tblshortlinks',$recordid , $logquery, $object['trigger']);

                $FolderPath = '../'.FILES_FOLDER.'/'.SHORT_LINKS.'/';
                if($objectfile['Icon']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileName;

                    if(copy($objectfile['Icon']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['IconFile']!='')
                        {
                            @unlink($FolderPath.$object['IconFile']);
                        }
                    }
                }

                if($objectfile['FileName']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileNamePdf;

                    if(copy($objectfile['FileName']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['OldFileName']!='')
                        {
                            @unlink($FolderPath.$object['OldFileName']);
                        }
                    }
                }

                if($objectfile['FileNameAr']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileNamePdfAr;

                    if(copy($objectfile['FileNameAr']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['OldFileNameAr']!='')
                        {
                            @unlink($FolderPath.$object['OldFileNameAr']);
                        }
                    }
                }

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Homepage Tab Edited Successfully":"Homepage Tab Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallshortlinks"), 0);
    }

    public function PrintShortLinkBoxes($CategoryID, $rlimit=0)
    {
        $db = new DB_Sql();

        $limit = ($rlimit == 0)?'':' limit 0,'.$rlimit;

        $query = "select * from tblshortlinks where CategoryID = '".$CategoryID."' and Active='".ACTIVE."' order by rOrder ASC".$limit;

        $db->query($query);

        $finalhtml = '';
        $totalrows = $db->num_rows();
        $rowcount = 0;

        while($db->next_record())
        {
            $urltogo = ($db->f("ShortLinkType") == 2)?DOMAINNAME.'/processfile.php?f='.SHORT_LINKS.'&file='.$db->f("FileName".LANG_SEP_DB).'&l='.(isset($_SESSION['TRA_FRONT_WEB_LANG']) ? $_SESSION['TRA_FRONT_WEB_LANG'] : 'en'):$db->f("URL".LANG_SEP_DB);

            $urltogo = ($urltogo!='')?$urltogo:'javascript:void(0)';
            $classname = ($db->f("OpenInColorBox"))?" ajaxboxiframe":'';
            $IconFile = ($db->f('IconFile') != '')?' style="background-image:url('.FILES_URL.'/'.SHORT_LINKS.'/'.$db->f('IconFile').');"':'';
            $IconFile1 = ($db->f('IconFile') != '')?'<img src="'.FILES_URL.'/'.SHORT_LINKS.'/'.$db->f('IconFile').'" border="0" style="max-width:30px; max-height:30px;" />':'';

            if($db->f("CategoryID") == 1)
            {
                $finalhtml .= '<div class="shortlinks1"'.$IconFile.');"">
								<div class="firsthead">'.clearTextForField($db->f('Title'.LANG_SEP_DB)).'</div>
								<div class="secondhead">'.clearTextForField($db->f('Title2'.LANG_SEP_DB)).'</div>
								<a href="'.$urltogo.'" target="'.$db->f("URLTarget").'" class="testlinka'.$classname.'">'.clearTextForField($db->f('LinkTitle'.LANG_SEP_DB)).'</a>
							</div>';
            }
            else
            {
                $totalrows -= 1;
                $rowcount += 1;

                if($rowcount == 1)
                    $idforfirst = 'partoneorg';
                else if($totalrows == 0)
                    $idforfirst = 'partfourorg';
                else
                    $idforfirst = '';

                $stylecustom = ($urltogo == 'javascript:void(0)')?' style="cursor:default;"':'';

                $finalhtml .= '<div class="col-lg-3 col-sm-3 firstorg swiper-slide" id="'.$idforfirst.'">
									<a href="'.$urltogo.'" target="'.$db->f("URLTarget").'" class="org-bg img-circle"'.$stylecustom.'>
										<span class="img">'.$IconFile1.'</span>
										<span>'.clearTextForField($db->f('Title'.LANG_SEP_DB)).'<br />'.clearTextForField($db->f('Title2'.LANG_SEP_DB)).'</span>
									</a>
							  </div>';
            }
        }

        return $finalhtml;
    }

    function manageBanners($object,$objectfile,$AllowedImageExtension)
    {
        global $BannersCatAr;
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    //log table
                    $dataObject = FetchRecordByID($value,'TableID','tblbanners');
                    $logquery =    "CategoryID = '".$dataObject['CategoryID']."',
									Title = '".($dataObject['Title'])."',
									TitleAr = '".($dataObject['TitleAr'])."',
									BriefDescription = '".($dataObject['BriefDescription'])."',
									BriefDescriptionAr = '".($dataObject['BriefDescriptionAr'])."',
									Heading1 = '".($dataObject['Heading1'])."',
									Heading1Ar = '".($dataObject['Heading1Ar'])."',
									Heading2 = '".($dataObject['Heading2'])."',
									Heading2Ar = '".($dataObject['Heading2Ar'])."',
									Active = '".$dataObject['Active']."',
									URL = '".($dataObject['URL'])."',
									URLAr = '".($dataObject['URLAr'])."',
									FileName = '".$dataObject['FileName']."',
									FileNameAr = '".$dataObject['FileNameAr']."'
									";
                    logTableInsertQuery('tblbanners',$value , $logquery, 3);

                    $this->deleteShortBanners($value,"tblbanners",WEB_BANNERS);
                }
            }
            else
            {
                //log table
                $dataObject = FetchRecordByID($object['RecordID'],'TableID','tblbanners');
                $logquery =    "CategoryID = '".$dataObject['CategoryID']."',
								Title = '".($dataObject['Title'])."',
								TitleAr = '".($dataObject['TitleAr'])."',
								BriefDescription = '".($dataObject['BriefDescription'])."',
								BriefDescriptionAr = '".($dataObject['BriefDescriptionAr'])."',
								Heading1 = '".($dataObject['Heading1'])."',
								Heading1Ar = '".($dataObject['Heading1Ar'])."',
								Heading2 = '".($dataObject['Heading2'])."',
								Heading2Ar = '".($dataObject['Heading2Ar'])."',
								Active = '".$dataObject['Active']."',
								URL = '".($dataObject['URL'])."',
								URLAr = '".($dataObject['URLAr'])."',
								FileName = '".$dataObject['FileName']."',
								FileNameAr = '".$dataObject['FileNameAr']."'
								";
                logTableInsertQuery('tblbanners',$object['RecordID'] , $logquery, 3);

                $this->deleteShortBanners($object['RecordID'],"tblbanners",WEB_BANNERS);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Banner Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';

            if($object['CategoryID'] == '-1')
            {
                $ErrorFields['CategoryID'] = 'Please Select Banner Category';
            }

            if($object['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($object['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($object['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Category Status';
            }

            if($object['BriefDescription'] == '')
            {
                $ErrorFields['BriefDescription'] = 'Please Enter Brief Description (English)';
            }

            if($object['BriefDescriptionAr'] == '')
            {
                $ErrorFields['BriefDescriptionAr'] = 'Please Enter Brief Description (Arabic)';
            }

            if($object['trigger']!='edit')
            {
                if($objectfile['FileName']['name'] == '')
                {
                    $ErrorFields['FileName'] = "Please Select Banner File";
                }

                if($objectfile['FileNameAr']['name'] == '')
                {
                    $ErrorFields['FileNameAr'] = "Please Select Banner File";
                }
            }

            if($objectfile['FileName']['name'] != '')
            {
                $filesize = (filesize($objectfile['FileName']['tmp_name']) * .0009765625) * .0009765625;
                $ext = mime_content_type($objectfile['FileName']['tmp_name']);
                //$ext = ($objectfile['FileName']['type']);

                //print_r($ext);
                //exit;

                if($filesize > ImageSize)
                {
                    $ErrorFields['FileName'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    $ErrorFields['FileName'] = "Please choose jpg,gif and png to upload";
                }
                else
                {

                    $info = getimagesize($objectfile['FileName']['tmp_name']);

                    $CatAr = $BannersCatAr[$object['CategoryID']];

                    if($info[0] != $CatAr['IconW'] || $info[1] != $CatAr['IconH'])
                    {
                        $ErrorFields['FileName'] = "Please upload image of ".$CatAr['IconW']."px x ".$CatAr['IconH']."px to upload";
                    }
                }

                $FileNameBanner = date("YmdHis").'-'.generatepassword(15).$objectfile['FileName']['name'];
            }

            if($objectfile['FileNameAr']['name'] != '')
            {
                $filesize = (filesize($objectfile['FileNameAr']['tmp_name']) * .0009765625) * .0009765625;
                //$ext = mime_content_type($objectfile['FileNameAr']['tmp_name']);
                $ext = ($objectfile['FileName']['type']);
                if($filesize > ImageSize)
                {
                    $ErrorFields['FileNameAr'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    $ErrorFields['FileNameAr'] = "Please choose jpg,gif and png to upload";
                }
                else
                {
                    $info = getimagesize($objectfile['FileNameAr']['tmp_name']);

                    $CatAr = $BannersCatAr[$object['CategoryID']];

                    if($info[0] != $CatAr['IconW'] || $info[1] != $CatAr['IconH'])
                    {
                        $ErrorFields['FileNameAr'] = "Please upload image of ".$CatAr['IconW']."px x ".$CatAr['IconH']."px to upload";
                    }
                }

                $FileNameBannerAr = date("YmdHis").'-'.generatepassword(15).$objectfile['FileNameAr']['name'];
            }

            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['trigger']=='edit')
                $Query="update tblbanners set";
            else
                $Query="insert into tblbanners set";

            $Query .= " Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
			BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
			Heading1 = '".clearTextForDb($object['Heading1'])."',
			Heading1Ar = '".clearTextForDb($object['Heading1Ar'])."',
			Heading2 = '".clearTextForDb($object['Heading2'])."',
			Heading2Ar = '".clearTextForDb($object['Heading2Ar'])."',
			Active = '".$object['Active']."',
			URL = '".clearTextForDb($object['URL'])."',
			URLAr = '".clearTextForDb($object['URLAr'])."'
			";

            if($FileNameBanner!='')
            {
                $Query .= ", FileName = '".$FileNameBanner."'";
            }

            if($FileNameBannerAr!='')
            {
                $Query .= ", FileNameAr = '".$FileNameBannerAr."'";
            }

            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $rOrder = maxID("rOrder","tblbanners",1);

                $Query .= ", CategoryID = '".$object['CategoryID']."',
				rOrder='".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                //log table
                $logquery =    "CategoryID = '".$object['CategoryID']."',
								Title = '".clearTextForDb($object['Title'])."',
								TitleAr = '".clearTextForDb($object['TitleAr'])."',
								BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
								BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',
								Heading1 = '".clearTextForDb($object['Heading1'])."',
								Heading1Ar = '".clearTextForDb($object['Heading1Ar'])."',
								Heading2 = '".clearTextForDb($object['Heading2'])."',
								Heading2Ar = '".clearTextForDb($object['Heading2Ar'])."',
								Active = '".$object['Active']."',
								URL = '".clearTextForDb($object['URL'])."',
								URLAr = '".clearTextForDb($object['URLAr'])."'
								";
                if($FileNameBanner!='')
                {
                    $logquery .= ", FileName = '".$FileNameBanner."'";
                }
                else if($object['OldFileName'] != '')
                {
                    $logquery .= ", FileName = '".$object['OldFileName']."'";
                }

                if($FileNameBannerAr!='')
                {
                    $logquery .= ", FileNameAr = '".$FileNameBannerAr."'";
                }
                else if($object['OldFileNameAr'] != '')
                {
                    $logquery .= ", FileNameAr = '".$object['OldFileNameAr']."'";
                }
                logTableInsertQuery('tblbanners',$recordid , $logquery, $object['trigger']);

                $FolderPath = '../'.FILES_FOLDER.'/'.WEB_BANNERS.'/';

                if($objectfile['FileName']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileNameBanner;

                    if(copy($objectfile['FileName']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['OldFileName']!='')
                        {
                            @unlink($FolderPath.$object['OldFileName']);
                        }
                    }
                }

                if($objectfile['FileNameAr']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileNameBannerAr;

                    if(copy($objectfile['FileNameAr']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['OldFileNameAr']!='')
                        {
                            @unlink($FolderPath.$object['OldFileNameAr']);
                        }
                    }
                }

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Banner Edited Successfully":"Banner Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallbanners"), 0);
    }
    function managePriorityBanners($object,$objectfile,$AllowedImageExtension)
    {
        global $BannersCatAr;
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    //log table
                    /*$dataObject = FetchRecordByID($value,'TableID','tblprioritybanners');
                    $logquery =    "CategoryID = '".$dataObject['CategoryID']."',
                                    Title = '".($dataObject['Title'])."',
                                    TitleAr = '".($dataObject['TitleAr'])."',
                                    BriefDescription = '".($dataObject['BriefDescription'])."',
                                    BriefDescriptionAr = '".($dataObject['BriefDescriptionAr'])."',
                                    Heading1 = '".($dataObject['Heading1'])."',
                                    Heading1Ar = '".($dataObject['Heading1Ar'])."',
                                    Heading2 = '".($dataObject['Heading2'])."',
                                    Heading2Ar = '".($dataObject['Heading2Ar'])."',
                                    Active = '".$dataObject['Active']."',
                                    URL = '".($dataObject['URL'])."',
                                    URLAr = '".($dataObject['URLAr'])."',
                                    FileName = '".$dataObject['FileName']."',
                                    FileNameAr = '".$dataObject['FileNameAr']."'
                                    ";
                    logTableInsertQuery('tblprioritybanners',$value , $logquery, 3);
                    */
                    $this->deletePriorityBanners($value,"tblprioritybanners",WEB_BANNERS);
                }
            }
            else
            {
                //log table
                /*$dataObject = FetchRecordByID($object['RecordID'],'TableID','tblprioritybanners');
                $logquery =    "CategoryID = '".$dataObject['CategoryID']."',
                                Title = '".($dataObject['Title'])."',
                                TitleAr = '".($dataObject['TitleAr'])."',
                                BriefDescription = '".($dataObject['BriefDescription'])."',
                                BriefDescriptionAr = '".($dataObject['BriefDescriptionAr'])."',
                                Heading1 = '".($dataObject['Heading1'])."',
                                Heading1Ar = '".($dataObject['Heading1Ar'])."',
                                Heading2 = '".($dataObject['Heading2'])."',
                                Heading2Ar = '".($dataObject['Heading2Ar'])."',
                                Active = '".$dataObject['Active']."',
                                URL = '".($dataObject['URL'])."',
                                URLAr = '".($dataObject['URLAr'])."',
                                FileName = '".$dataObject['FileName']."',
                                FileNameAr = '".$dataObject['FileNameAr']."'
                                ";
                logTableInsertQuery('tblprioritybanners',$object['RecordID'] , $logquery, 3);*/

                $this->deletePriorityBanners($object['RecordID'],"tblprioritybanners",WEB_BANNERS);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Priority Banner Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';

            if($object['CategoryID'] == '-1')
            {
                $ErrorFields['CategoryID'] = 'Please Select Banner Category';
            }

            if($object['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($object['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($object['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Category Status';
            }

            /*if($object['BriefDescription'] == '')
            {
                $ErrorFields['BriefDescription'] = 'Please Enter Brief Description (English)';
            }

            if($object['BriefDescriptionAr'] == '')
            {
                $ErrorFields['BriefDescriptionAr'] = 'Please Enter Brief Description (Arabic)';
            }*/

            if($object['trigger']!='edit')
            {
                if($objectfile['FileName']['name'] == '')
                {
                    $ErrorFields['FileName'] = "Please Select Banner File";
                }

                if($objectfile['FileNameAr']['name'] == '')
                {
                    $ErrorFields['FileNameAr'] = "Please Select Banner File";
                }
            }

            if($objectfile['FileName']['name'] != '')
            {
                $detect = array('image/jpeg', 'image/png', 'image/gif');
                $filesize = (filesize($objectfile['FileName']['tmp_name']) * .0009765625) * .0009765625;
                //$ext = mime_content_type($objectfile['FileName']['tmp_name']);
                //$ext = ($objectfile['FileName']['type']);

                /*print_r($ext);
                exit;*/

                if($filesize > ImageSize)
                {
                    $ErrorFields['FileName'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($objectfile['FileName']['type'],$detect))
                {
                    $ErrorFields['FileName'] = "Please choose jpg,gif and png to upload";
                }
                else
                {

                    $info = getimagesize($objectfile['FileName']['tmp_name']);

                    $CatAr = $BannersCatAr[$object['CategoryID']];

                    if($info[0] != $CatAr['IconW'] || $info[1] != $CatAr['IconH'])
                    {
                        $ErrorFields['FileName'] = "Please upload image of ".$CatAr['IconW']."px x ".$CatAr['IconH']."px to upload";
                    }
                }

                $FileNameBanner = date("YmdHis").'-'.generatepassword(15).$objectfile['FileName']['name'];
            }

            if($objectfile['FileNameAr']['name'] != '')
            {
                $filesize = (filesize($objectfile['FileNameAr']['tmp_name']) * .0009765625) * .0009765625;
                //$ext = mime_content_type($objectfile['FileNameAr']['tmp_name']);
                $ext = ($objectfile['FileName']['type']);
                if($filesize > ImageSize)
                {
                    $ErrorFields['FileNameAr'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    $ErrorFields['FileNameAr'] = "Please choose jpg,gif and png to upload";
                }
                else
                {
                    $info = getimagesize($objectfile['FileNameAr']['tmp_name']);

                    $CatAr = $BannersCatAr[$object['CategoryID']];

                    if($info[0] != $CatAr['IconW'] || $info[1] != $CatAr['IconH'])
                    {
                        $ErrorFields['FileNameAr'] = "Please upload image of ".$CatAr['IconW']."px x ".$CatAr['IconH']."px to upload";
                    }
                }

                $FileNameBannerAr = date("YmdHis").'-'.generatepassword(15).$objectfile['FileNameAr']['name'];
            }

            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }
            /*BriefDescription = '".clearTextForDb($object['BriefDescription'])."',
            BriefDescriptionAr = '".clearTextForDb($object['BriefDescriptionAr'])."',*/
            if($object['trigger']=='edit')
                $Query="update tblprioritybanners set";
            else
                $Query="insert into tblprioritybanners set";

            $Query .= " Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			Active = '".$object['Active']."',
			URL = '".clearTextForDb($object['URL'])."',
			URLAr = '".clearTextForDb($object['URLAr'])."'
			";

            if($FileNameBanner!='')
            {
                $Query .= ", FileName = '".$FileNameBanner."'";
            }

            if($FileNameBannerAr!='')
            {
                $Query .= ", FileNameAr = '".$FileNameBannerAr."'";
            }

            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $rOrder = maxID("rOrder","tblprioritybanners",1);

                $Query .= ", CategoryID = '".$object['CategoryID']."',
				rOrder='".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                //log table
                /*	$logquery =    "CategoryID = '".$object['CategoryID']."',
                                    Title = '".clearTextForDb($object['Title'])."',
                                    TitleAr = '".clearTextForDb($object['TitleAr'])."',

                                    Active = '".$object['Active']."',
                                    URL = '".clearTextForDb($object['URL'])."',
                                    URLAr = '".clearTextForDb($object['URLAr'])."'
                                    ";*/
                /*if($FileNameBanner!='')
                {
                    $logquery .= ", FileName = '".$FileNameBanner."'";
                }
                else if($object['OldFileName'] != '')
                {
                    $logquery .= ", FileName = '".$object['OldFileName']."'";
                }

                if($FileNameBannerAr!='')
                {
                    $logquery .= ", FileNameAr = '".$FileNameBannerAr."'";
                }
                else if($object['OldFileNameAr'] != '')
                {
                    $logquery .= ", FileNameAr = '".$object['OldFileNameAr']."'";
                }*/
                //logTableInsertQuery('tblprioritybanners',$recordid , $logquery, $object['trigger']);

                $FolderPath = '../'.FILES_FOLDER.'/'.WEB_BANNERS.'/';

                if($objectfile['FileName']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileNameBanner;

                    if(copy($objectfile['FileName']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['OldFileName']!='')
                        {
                            @unlink($FolderPath.$object['OldFileName']);
                        }
                    }
                }

                if($objectfile['FileNameAr']['name'] != '')
                {
                    $FinalFilePath = $FolderPath.$FileNameBannerAr;

                    if(copy($objectfile['FileNameAr']['tmp_name'],$FinalFilePath))
                    {
                        //unlink old file if any
                        if($object['OldFileNameAr']!='')
                        {
                            @unlink($FolderPath.$object['OldFileNameAr']);
                        }
                    }
                }

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Banner Edited Successfully":"Banner Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallprioritybanner"), 0);
    }
    public function PrintBannerHTML($CategoryID, $rlimit=0)
    {
        global $BannersCatAr;

        $db = new DB_Sql();

        $limit = ($rlimit == 0)?'':' limit 0,'.$rlimit;

        $query = "select * from tblbanners where CategoryID = '".$CategoryID."' and Active='".ACTIVE."' order by rOrder ASC".$limit;
        echo $query;
        exit;
        $db->query($query);

        $finalhtml = '';
        $totalrows = $db->num_rows();
        $rowcount = 0;

        $CatAr = $BannersCatAr[$CategoryID];

        while($db->next_record())
        {
            $urltogo = ($db->f("URL".LANG_SEP_DB)!='')?$db->f("URL".LANG_SEP_DB):'javascript:void(0)';

            if(file_exists(FILES_FOLDER.'/'.WEB_BANNERS.'/'.$db->f('FileName'.LANG_SEP_DB)))
            {
                $finalhtml .= ($CategoryID == 2)?'<li>':'';

                $finalhtml .= '<a href="'.$urltogo.'" target="_blank" title="'.$db->f("Title".LANG_SEP_DB).'"><img src="'.FILES_URL.'/'.WEB_BANNERS.'/'.$db->f('FileName'.LANG_SEP_DB).'" alt="'.$db->f("Title".LANG_SEP_DB).'" border="0" style="max-width:'.$CatAr['IconW'].'px; max-height:'.$CatAr['IconH'].'px;" /></a>';

                $finalhtml .= ($CategoryID == 2)?'</li>':'';
            }
        }

        return $finalhtml;
    }

    private function deleteCreditCardBanner($TableID)
    {
        $db = new DB_Sql();

        $RecordInfo = FetchRecordByID($TableID,"TableID","tblcreditcardbanner");

        if($RecordInfo['TableID'] > 0)
        {
            $db->query("delete from tblcreditcardbanner where TableID='".$RecordInfo['TableID']."'");
            $af_rows = $db->affected_rows();

            if($af_rows >= 0)
            {
                if($RecordInfo['FileName'] != '')
                {
                    $path = '../'.FILES_FOLDER."/".WEB_BANNERS."/".$RecordInfo['FileName'];
                    @unlink($path);
                }

                if($RecordInfo['FileNameAr'] != '')
                {
                    $path = '../'.FILES_FOLDER."/".WEB_BANNERS."/".$RecordInfo['FileNameAr'];
                    @unlink($path);
                }
            }

        }
    }

    function manageCreditCardBanner($object,$objectfiles,$AllowedImageExtension)
    {
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');


            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    //log table
                    $dataObject = FetchRecordByID($value,'TableID','tblcreditcardbanner');
                    $logquery =    "Url = '".($dataObject['Url'])."',
									UrlAr = '".($dataObject['UrlAr'])."', 
									Active = '".$dataObject['Active']."',
									FileName = '".$dataObject['FileName']."',
									FileNameAr = '".$dataObject['FileNameAr']."'
									";
                    logTableInsertQuery('tblcreditcardbanner',$value , $logquery, 3);

                    $this->deleteCreditCardBanner($value);
                }
            }
            else
            {
                //log table
                $dataObject = FetchRecordByID($object['RecordID'],'TableID','tblcreditcardbanner');
                $logquery =    "Url = '".($dataObject['Url'])."',
								UrlAr = '".($dataObject['UrlAr'])."', 
								Active = '".$dataObject['Active']."',
								FileName = '".$dataObject['FileName']."',
								FileNameAr = '".$dataObject['FileNameAr']."'
								";
                logTableInsertQuery('tblcreditcardbanner',$object['RecordID'] , $logquery, 3);

                $this->deleteCreditCardBanner($object['RecordID']);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Credit Card Deleted Successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            $FileName = '';
            $FileNameAr = '';

            if($objectfiles['File']['name']=='' && $object['trigger']!='edit')
            {
                $ErrorFields['File'] = 'Please Select File (English)';
            }

            if($objectfiles['FileAr']['name']=='' && $object['trigger']!='edit')
            {
                $ErrorFields['FileAr'] = 'Please Select File (Arabic)';
            }

            if($_REQUEST['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Page Status';
            }


            if($objectfiles['File']['name']!='')
            {
                $filesize = (filesize($objectfiles['File']['tmp_name']) * .0009765625) * .0009765625;
                $ext = mime_content_type($objectfiles['File']['tmp_name']);

                if($filesize > ImageSize)
                {
                    $ErrorFields['File'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension))
                {
                    $ErrorFields['File'] = "Please choose jpg,png or gif file to upload".$ext;
                }

                $FileName = date("YmdHis").'-'.$objectfiles['File']['name'];
            }

            if($objectfiles['FileAr']['name']!='')
            {
                $filesizeAr = (filesize($objectfiles['FileAr']['tmp_name']) * .0009765625) * .0009765625;
                $extAr = mime_content_type($objectfiles['FileAr']['tmp_name']);

                if($filesizeAr > ImageSize)
                {
                    $ErrorFields['FileAr'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($extAr,$AllowedImageExtension) )
                {
                    $ErrorFields['FileAr'] = "Please choose jpg,png or gif file to upload";
                }

                $FileNameAr = date("YmdHis").'-'.$objectfiles['FileAr']['name'];
            }




            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['trigger']=='edit')
                $Query="update tblcreditcardbanner set";
            else
                $Query="insert into tblcreditcardbanner set";

            $Query .= " 
			Url = '".clearTextForDb($object['Url'])."',
			UrlAr = '".clearTextForDb($object['UrlAr'])."', 
			Active = '".$object['IsActive']."' 
			";

            if($FileName != '')
            {
                $Query .= ",FileName = '".$FileName."'";
            }

            if($FileNameAr != '')
            {
                $Query .= ",FileNameAr = '".$FileNameAr."'";
            }

            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $rOrder = maxID("rOrder","tblcreditcardbanner",1);

                $Query .= ", rOrder = '".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);

            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                //log table operation
                $logquery =    "Url = '".clearTextForDb($object['Url'])."',
								UrlAr = '".clearTextForDb($object['UrlAr'])."', 
								Active = '".$object['IsActive']."' 
								";
                if($FileName != '')
                {
                    $logquery .= ",FileName = '".$FileName."'";
                }
                else if($object['OldFileName'] != '')
                {
                    $logquery .= ",FileName = '".$object['OldFileName']."'";
                }

                if($FileNameAr != '')
                {
                    $logquery .= ",FileNameAr = '".$FileNameAr."'";
                }
                else if($object['OldFileNameAr'] != '')
                {
                    $logquery .= ",FileNameAr = '".$object['OldFileNameAr']."'";
                }
                logTableInsertQuery('tblcreditcardbanner',$recordid , $logquery, $object['trigger']);

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Credit Card Edited Successfully":"Credit Card Added Successfully";

                $FolderPath = '../'.FILES_FOLDER.'/'.WEB_BANNERS.'/';

                $FinalFilePath = '../'.FILES_FOLDER.'/'.WEB_BANNERS.'/'.$FileName;
                $FinalFilePathAr = '../'.FILES_FOLDER.'/'.WEB_BANNERS.'/'.$FileNameAr;

                if(copy($objectfiles['File']['tmp_name'],$FinalFilePath))
                {
                    //now create thuumbail

                    $resizeObj = new resize($FinalFilePath);
                    $resizeObj -> resizeImage(CREDIT_CARD_BANNER_WIDTH, CREDIT_CARD_BANNER_HEIGHT, 'crop');
                    $resizeObj -> saveImage($FinalFilePath, 100);
                    @unlink($FolderPath.$object['OldFileName']);
                }

                if(copy($objectfiles['FileAr']['tmp_name'],$FinalFilePathAr))
                {
                    //now create thuumbail
                    $ThumbImgPath = $FinalPath.'/thumb_'.$FileNameAr;

                    $resizeObj = new resize($FinalFilePathAr);
                    $resizeObj -> resizeImage(CREDIT_CARD_BANNER_WIDTH, CREDIT_CARD_BANNER_HEIGHT, 'crop');
                    $resizeObj -> saveImage($FinalFilePathAr, 100);
                    @unlink($FolderPath.$object['OldFileNameAr']);
                }
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }

        redirect("home.php?".EncodeUrl("action=viewallcreditcardbanner"), 0);
    }



    //// Priority Banking Pages / area

    private function deletePriorityBankingPages($TableID)
    {
        $db = new DB_Sql();
        //deletePriority Banking

        $db->query("delete from tblprioritybankingpages where ParentTableID='".$TableID."'");
        $db->query("delete from tblprioritybankingpages where TableID='".$TableID."'");
    }


    function managePriorityBankingPages($object,$objectfile)
    {
        $db = new DB_Sql();

        //Edit Record Goes Here
        if($object['trigger']=='delete')
        {
            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],'DeletePermissions',$db,DELETEMESSAGE,'home.php');

            if(is_array($object['RecordID']))
            {
                foreach($object['RecordID'] as $key => $value)
                {
                    //log table
                    $dataObject = FetchRecordByID($value,'TableID','tblprioritybankingpages');
                    $logquery = 	"PageType = '".$dataObject['PageType']."',
									Title = '".($dataObject['Title'])."',
									TitleAr = '".($dataObject['TitleAr'])."',
									MenuTitle = '".($dataObject['MenuTitle'])."',
									MenuTitleAr = '".($dataObject['MenuTitleAr'])."',
									BannerTitle = '".($dataObject['BannerTitle'])."',
									BannerTitleAr = '".($dataObject['BannerTitleAr'])."',
									Active = '".$dataObject['Active']."', 
									ParentTableID = '".$dataObject['ParentTableID']."',
									ExternalLink = '".$dataObject['ExternalLink']."',
									ExternalLinkAr = '".$dataObject['ExternalLinkAr']."',
									Description = '".($dataObject['Description'])."',
									DescriptionAr = '".($dataObject['DescriptionAr'])."',
									MetaDescription = '".($dataObject['MetaDescription'])."',
									MetaDescriptionAr = '".($dataObject['MetaDescriptionAr'])."',
									MetaTitle = '".($dataObject['MetaTitle'])."',
									MetaTitleAr = '".($dataObject['MetaTitleAr'])."',
									MetaKeywords = '".($dataObject['MetaKeywords'])."',
									MetaKeywordsAr = '".($dataObject['MetaKeywordsAr'])."',
									MetaOthers = '".($dataObject['MetaOthers'])."',
									MetaOthersAr = '".($dataObject['MetaOthersAr'])."',
									URLKeyword = '".$dataObject['URLKeyword']."'
									";
                    logTableInsertQuery('tblprioritybankingpages',$value , $logquery, 3);

                    $this->deletePriorityBankingPages($value);
                }
            }
            else
            {
                //log table
                $dataObject = FetchRecordByID($object['RecordID'],'TableID','tblprioritybankingpages');
                $logquery =    "PageType = '".$dataObject['PageType']."',
								Title = '".($dataObject['Title'])."',
								TitleAr = '".($dataObject['TitleAr'])."',
								MenuTitle = '".($dataObject['MenuTitle'])."',
								MenuTitleAr = '".($dataObject['MenuTitleAr'])."',
								BannerTitle = '".($dataObject['BannerTitle'])."',
								BannerTitleAr = '".($dataObject['BannerTitleAr'])."',
								Active = '".$dataObject['Active']."', 
								ParentTableID = '".$dataObject['ParentTableID']."',
								ExternalLink = '".$dataObject['ExternalLink']."',
								ExternalLinkAr = '".$dataObject['ExternalLinkAr']."',
								Description = '".($dataObject['Description'])."',
								DescriptionAr = '".($dataObject['DescriptionAr'])."',
								MetaDescription = '".($dataObject['MetaDescription'])."',
								MetaDescriptionAr = '".($dataObject['MetaDescriptionAr'])."',
								MetaTitle = '".($dataObject['MetaTitle'])."',
								MetaTitleAr = '".($dataObject['MetaTitleAr'])."',
								MetaKeywords = '".($dataObject['MetaKeywords'])."',
								MetaKeywordsAr = '".($dataObject['MetaKeywordsAr'])."',
								MetaOthers = '".($dataObject['MetaOthers'])."',
								MetaOthersAr = '".($dataObject['MetaOthersAr'])."',
								URLKeyword = '".$dataObject['URLKeyword']."'
								";
                logTableInsertQuery('tblprioritybankingpages',$object['RecordID'] , $logquery, 3);
                $this->deletePriorityBankingPages($object['RecordID']);
            }

            $_SESSION[ADMIN_MESSAGE_SUCCESS] = "Priority Banking Pages records deleted successfully";
        }
        else
        {
            //Checking Editing Permission
            $PermissionToCheck = ($object['trigger'] == 'edit')?'EditPermissions':'AddPermissions';
            $PermissionMessage = ($object['trigger'] == 'edit')?EDITMESSAGE:ADDMESSAGE;

            checkPermission($_SESSION[ADMIN_SESSION.'_userid'],$_REQUEST['action'],$PermissionToCheck,$db,$PermissionMessage,'home.php');
            //Storing System User Records

            if($_REQUEST['PageType'] == '-1')
            {
                $ErrorFields['PageType'] = 'Please Select Page Type';
            }

            if($_REQUEST['Title'] == '')
            {
                $ErrorFields['Title'] = 'Please Enter Title (English)';
            }

            if($_REQUEST['TitleAr'] == '')
            {
                $ErrorFields['TitleAr'] = 'Please Enter Title (Arabic)';
            }

            if($_REQUEST['MenuTitle'] == '')
            {
                $ErrorFields['MenuTitle'] = 'Please Enter Menu Title (English)';
            }

            if($_REQUEST['MenuTitleAr'] == '')
            {
                $ErrorFields['MenuTitleAr'] = 'Please Enter Menu Title (Arabic)';
            }

            if($_REQUEST['Active'] == '-1')
            {
                $ErrorFields['Active'] = 'Please Select Page Status';
            }

            if($_REQUEST['PageType'] == '1')
            {
                /* if($_REQUEST['Description'] == '')
                 {
                     $ErrorFields['Description'] = 'Please Enter Description (English)';
                 }

                 if($_REQUEST['DescriptionAr'] == '')
                 {
                     $ErrorFields['DescriptionAr'] = 'Please Enter Description (Arabic)';
                 }*/

            }

            if($_REQUEST['PageType'] == '4')
            {
                if($_REQUEST['ExternalLink'] == '')
                {
                    $ErrorFields['ExternalLink'] = 'Please Enter English Site External Link start with http://';
                }
                if($_REQUEST['ExternalLinkAr'] == '')
                {
                    $ErrorFields['ExternalLinkAr'] = 'Please Enter Arabic Site External Link start with http://';
                }
            }
            if($_REQUEST['PageType'] == '5')
            {

                if($objectfile['Banner']['name'] == '' && $object['trigger'] !='edit')
                {
                    $ErrorFields['Banner'] = 'Please Enter uplaod Banner Image';
                }
                if ($_REQUEST['BannerOld'] == '' && $object['trigger'] =='edit') {
                    $ErrorFields['Banner'] = 'Please Enter uplaod Banner Image';
                }

            }
            if($objectfile['Banner']['name'] != '')
            {
                $filesize = (filesize($objectfile['Banner']['tmp_name']) * .0009765625) * .0009765625;
                //$ext = mime_content_type($objectfile['Banner']['tmp_name']);
                if($filesize > ImageSize)
                {
                    $ErrorFields['Banner'] = "Please choose ".ImageSize." MB File Size";
                }
                else if(!in_array($ext,$AllowedImageExtension) )
                {
                    //$ErrorFields['Icon'] = "Please choose jpg,gif and png to upload";
                }

                $FileName_icon = date("YmdHis").'-'.$objectfile['Banner']['name'];

            }

            if(sizeof($ErrorFields) > 0)
            {
                return $ErrorFields;
            }

            if($object['ParentTableID']=='')
            {
                $object['ParentTableID']=0;
            }


            if($object['trigger']=='edit')
                $Query="update tblprioritybankingpages set";
            else
                $Query="insert into tblprioritybankingpages set";

            $Query .= " PageType = '".$object['PageType']."',
			Title = '".clearTextForDb($object['Title'])."',
			TitleAr = '".clearTextForDb($object['TitleAr'])."',
			MenuTitle = '".clearTextForDb($object['MenuTitle'])."',
			MenuTitleAr = '".clearTextForDb($object['MenuTitleAr'])."',
			BannerTitle = '".clearTextForDb($object['BannerTitle'])."',
			BannerTitleAr = '".clearTextForDb($object['BannerTitleAr'])."',
			Active = '".$object['Active']."',
			ShowInNav = '".$object['ShowInNav']."',  
			CategoryTab = '".$object['CategoryTab']."', 
			ParentTableID = '".$object['ParentTableID']."',
			ExternalLink = '".$object['ExternalLink']."',
			ExternalLinkAr = '".$object['ExternalLinkAr']."',
			Description = '".clearTextForDb($object['Description'])."',
			DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
			MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
			MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
			MetaTitle = '".clearTextForDb($object['MetaTitle'])."',
			MetaTitleAr = '".clearTextForDb($object['MetaTitleAr'])."',
			MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
			MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
			MetaOthers = '".clearTextForDb($object['MetaOthers'])."',
			MetaOthersAr = '".clearTextForDb($object['MetaOthersAr'])."'
			
			";
            if($FileName_icon!='')
            {
                $Query .= ", BannerImage = '".$FileName_icon."'";
            }
            if($object['URLKeyword'] == '')
            {
                $URLKeyword = SEOFriendlyURL($object['MenuTitle'],$object['MenuTitle'],"tblprioritybankingpages");
                $URLKeyword = SEOFriendlyPriorityBankingURL($URLKeyword,$URLKeyword);
                //$URLKeyword = SEOFriendlyPriorityBankingURL($object['MenuTitle'],$object['MenuTitle']);
            }
            else
            {
                $URLKeyword = $object['URLKeyword'];
            }

            $Query .= ", URLKeyword = '".$URLKeyword."'";

            if($object['trigger']=='edit')
            {
                $Query .= ", ModifiedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				ModificationDateTime = '".getCurrentDateTime()."' 
				where TableID='".$object['RecordID']."'
				";
            }
            else
            {
                $ParentTableID = ($object['ParentTableID'] > 0)?$object['ParentTableID']:0;
                $rOrder = maxID("rOrder","tblprioritybankingpages where ParentTableID='".$ParentTableID."'",1);

                $Query .= ", rOrder = '".$rOrder."',
				CreatedBy = '".$_SESSION[ADMIN_SESSION.'_userid']."',
				CreationDate = '".date("Y-m-d")."',
				CreationDateTime = '".getCurrentDateTime()."'
				";
            }

            $db->query($Query);
            if($objectfile['Banner']['name'] != '')
            {
                $FinalPath = '../'.FILES_FOLDER.'/'.WEB_BANNERS;

                $FinalFilePath = $FinalPath.'/'.$FileName_icon;

                if(copy($objectfile['Banner']['tmp_name'],$FinalFilePath))
                {
                    //now create thuumbail
                    $ThumbImgPath = $FinalPath.'/thumb_'.$FileName_icon;

                    $resizeObj = new resize($FinalFilePath);
                    $resizeObj -> resizeImage(PRIORITY_BANKING_BANNER_WIDTH, PRIORITY_BANKING_BANNER_HEIGHT, 'crop');
                    $resizeObj -> saveImage($ThumbImgPath, 100);
                }
            }
            $recordid = ($object['trigger']=='edit')?$object['RecordID']:$db->MysqlInsertID();

            if($recordid > 0)
            {
                //log table
                $logquery = 	"PageType = '".$object['PageType']."',
								Title = '".clearTextForDb($object['Title'])."',
								TitleAr = '".clearTextForDb($object['TitleAr'])."',
								MenuTitle = '".clearTextForDb($object['MenuTitle'])."',
								MenuTitleAr = '".clearTextForDb($object['MenuTitleAr'])."',
								BannerTitle = '".clearTextForDb($object['BannerTitle'])."',
								BannerTitleAr = '".clearTextForDb($object['BannerTitleAr'])."',
								Active = '".$object['Active']."', 
								ParentTableID = '".$object['ParentTableID']."',
								ExternalLink = '".$object['ExternalLink']."',
								ExternalLinkAr = '".$object['ExternalLinkAr']."',
								Description = '".clearTextForDb($object['Description'])."',
								DescriptionAr = '".clearTextForDb($object['DescriptionAr'])."',
								MetaDescription = '".clearTextForDb($object['MetaDescription'])."',
								MetaDescriptionAr = '".clearTextForDb($object['MetaDescriptionAr'])."',
								MetaTitle = '".clearTextForDb($object['MetaTitle'])."',
								MetaTitleAr = '".clearTextForDb($object['MetaTitleAr'])."',
								MetaKeywords = '".clearTextForDb($object['MetaKeywords'])."',
								MetaKeywordsAr = '".clearTextForDb($object['MetaKeywordsAr'])."',
								MetaOthers = '".clearTextForDb($object['MetaOthers'])."',
								MetaOthersAr = '".clearTextForDb($object['MetaOthersAr'])."',
								URLKeyword = '".$URLKeyword."'
								";
                logTableInsertQuery('tblprioritybankingpages',$recordid , $logquery, $object['trigger']);

                $_SESSION[ADMIN_MESSAGE_SUCCESS] = ($object['trigger']=='edit')?"Priority Banking Page Edited Successfully":"Priority Banking Page Added Successfully";
            }
            else
            {
                $_SESSION[ADMIN_MESSAGE_ERROR] = "Unable to process your request, contact administrator!";
            }
        }


        if($_REQUEST['start'] > 0)
            $_SESSION['PageReturnPage'] = $_REQUEST['start'];


        redirect("home.php?".EncodeUrl("action=viewallprioritybanking"), 0);
    }


    function loadRecursivePriorityBankingPages(&$finalstring, $parentid = 0)
    {
        global $PageTypeAr;
        $db = new DB_Sql();

        $sql="select * from tblprioritybankingpages where ParentTableID = '".$parentid."' order by rOrder ASC";

        $db->query($sql);

        if($db->num_rows() > 0)
        {
            if($parentid == 0)
            {
                $finalstring .= '<ul id="sortablelist" data-tablename="tblprioritybankingpages" data-parentid="'.$parentid.'">';
            }
            else
            {
                $finalstring .= '<ul data-tablename="tblprioritybankingpages" data-parentid="'.$parentid.'">';
            }


            while($db->next_record())
            {
                $finalstring .= '<li id="listItem_'.$db->f("TableID").'" class="ui-state-default"> <span class="ui-icon ui-icon-arrowthick-2-n-s"></span> '.$db->f('Title');

                $this->loadRecursivePriorityBankingPages($finalstring, $db->f("TableID"));

                $finalstring .= '</li>';
            }

            $finalstring .= '</ul>';
        }
    }

}
?>
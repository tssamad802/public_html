<?php
/**
 *
 *
 *
 * @Class   						Rountinefunctions
 * @Purpose    						Methods for performing rountine operations
 * @Author   	  					Shehzad Asghar Saddiq
 * @Creation Date    				5th December , 2006
 * @Last Modified    				10th January , 2010
 *
 *
 *
 **/
class Rountinefunctions extends Databaseconnection
{
		private $TableNameForSequence;
		private $SequenceForSequence;
		private $ModifiedBy;
		private $ModificationDateTime;
		
		function setTableNameForSequence($TableName)
		{
			$this->TableNameForSequence=$TableName;
		}
		function GetTableNameForSequence()
		{
			return $this->TableNameForSequence;
		}
		
		function setTableIDForSequence($TableID)
		{
			$this->TableIDForSequence=$TableID;
		}
		function GetTableIDForSequence()
		{
			return $this->TableIDForSequence;
		}
		
		function setSequenceForSequence($Sequence)
		{
			$this->SequenceForSequence=$Sequence;
		}
		function GetSequenceForSequence()
		{
			return $this->SequenceForSequence;
		}
		
		function setModifiedBy($ModifiedBy)
		{
			$this->ModifiedBy=$ModifiedBy;
		}
		function GetModifiedBy()
		{
			return $this->ModifiedBy;
		}
		
		function setModifiedDateTime($ModifiedDateTime)
		{
			$this->ModifiedDateTime=$ModifiedDateTime;
		}
		function GetModifiedDateTime()
		{
			return $this->ModifiedDateTime;
		}
		
			function CheckPasswordExpiry($UserID)
			{
				$CheckPasswordExpiry = "select datediff(NOW(),CreationDateTime) AS DateInterval from tblsystempasswords where UserID='".$UserID."' order by TableID DESC limit 1";
				$this->query($CheckPasswordExpiry);
				$this->next_Record();
				if($this->f('DateInterval') > PASSWORD_EXPIRYLIFE)
				{
				
					return 0;
				}
				else
				{
					return 1;
				}
					
			}
			
			



		function Getpriorityreasons()
		{
			$ReasonsQuery = "";	
				
			$GetReasons = "select * from tblagentpriorityreasons where AgentID='".$_SESSION[APPLICATION_SESSION_USERID]."'";
		
			$this->query($GetReasons);
			$Count = $this->num_rows();
			$RecordCount = 0;
			while($this->next_Record())
			{
				$RecordCount =  $RecordCount+1;
				if($RecordCount==$Count)
				{
					$ReasonsQuery =  $ReasonsQuery.$this->f('PriorityReasonID');
				}else
				{
					$ReasonsQuery =  $ReasonsQuery.$this->f('PriorityReasonID').",";
				}
			}
		
			
			if($ReasonsQuery=="")
			{
				$_SESSION['ReasonsQuery'] = $ReasonsQuery;
			}else
			{
				$_SESSION['ReasonsQuery'] = ",".$ReasonsQuery;
			}
			
	
		
		}
	
		function UpdateSequence()
		{
			$UpdateSequenceQuery = "update ".$this->GetTableNameForSequence()." set 
			Sequence='".$this->GetSequenceForSequence()."', 
			ModifiedBy='".$this->GetModifiedBy()."', 
			ModifiedDateTime='".$this->GetModifiedDateTime()."' 
			where TableID='".$this->GetTableIDForSequence()."'";
			$this->query($UpdateSequenceQuery);
		}
		

			
			// Deleting of Directory
			function deldir($dir){
			   $current_dir = opendir($dir);
			   while($entryname = readdir($current_dir)){
				 if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
					 deldir("${dir}/${entryname}");
				 }elseif($entryname != "." and $entryname!=".."){
					 unlink("${dir}/${entryname}");
				 }
			   }
			   closedir($current_dir);
			   rmdir(${dir});
			} 
			
			// Making of Directory
			function mkdir_p($target)
			{
				if (is_dir($target)||empty($target)) return 1; // best case check first
				if (file_exists($target) && !is_dir($target)) return 0;
				if (mkdir_p(substr($target,0,strrpos($target,'/'))))
				  return mkdir($target); // crawl back up & create dir tree
				return 0;
			}
			// Takes care of SQL Injection
			function sqlInjection($phpString)
			{
				$pieces = explode("/", $phpString);
				$sqlString=$pieces[0];
				return $sqlString; 
			}
			//******************** Searching Through Primary Key and returns String Data
		
			//Fetch Entire Data 
			function FetchRecordByID($id,$primarykey,$tablename)
			{
					$sqlQuery="Select * from ".$tablename." where ".$primarykey."='".$id."'";
					$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
					$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
					$result=mysqli_query($db_conn,$sqlQuery);
					$count=mysqli_num_fields($result);
					$i=0;
					while($row=mysqli_fetch_array($result,MYSQLI_BOTH))
						{
							while($i<$count)
							{
								$fieldName = mysqli_fetch_field_direct($result, $i)->name;
								
								$object[$fieldName]=$row[$i];
								
								$i++;
							}
						}
							mysqli_close();
			return $object;
			}
			
				function getFieldDataByID($StringField,$WhereField,$WhereValue,$TableName)
			{
					$sqlQuery="Select ".$StringField." from ".$TableName." where ".$WhereField."='".$WhereValue."'";
					$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
					$selectDB=mysqli_select_db($db_conn,DATABASE_NAME);
					$result=mysqli_query($db_conn,$sqlQuery);
						while($row=mysqli_fetch_array($result,MYSQLI_NUM))
						{
							return $row[0];
						}
					mysqli_close();
			}
			
			
			//******************** Fill The Combo Box
			function fillcombocontrol($SelectedIndex,$FieldOne,$FieldTwo,$TableName,$SortField)
			{
				$sqlQuery="Select $FieldOne,$FieldTwo from $TableName order by $SortField";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db($db_conn,DATABASE_NAME);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			function fillcombocontrolservices($SelectedIndex,$FieldOne,$FieldTwo,$TableName,$SortField,$SalesField,$Sales)
			{
				$sqlQuery="Select $FieldOne,$FieldTwo from $TableName where $SalesField=$Sales order by $SortField";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			//******************** Fill The Combo Box
			function fillcombocontrolwithwhereclause($SelectedIndex,$FieldOne,$FieldTwo,$WhereField,$WhereValue,$TableName,$SortField,$Flag=0)
			{
				
				if($TableName!="tblservices")
				{
						$sqlQuery="Select $FieldOne,$FieldTwo from $TableName where $WhereField=$WhereValue or $FieldOne=$SelectedIndex order by $SortField";
						$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
						$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
						$result=mysqli_query($db_conn,$sqlQuery);
						$Text="";
							while($row=mysqli_fetch_array($result,MYSQLI_NUM))
							{
								if($SelectedIndex==$row{0})
								{
								$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
								}
								else
								{
								$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
								}
							}
				}else
				{
						if($Flag==0)
						{
							$sqlQuery="Select TableID,EnglishService,ParentID from $TableName where $WhereField=$WhereValue or $FieldOne=$SelectedIndex order by $SortField";
						}else
						{
							$sqlQuery="Select TableID,EnglishService,ParentID from $TableName where ($WhereField=$WhereValue and IsPrintable=1) or $FieldOne=$SelectedIndex order by $SortField";
						}
						$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
						$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
						$result=mysqli_query($db_conn,$sqlQuery);
						$Text="";
							while($row=mysqli_fetch_array($result,MYSQLI_NUM))
							{
								$Flag=$this->checkIfParent($row{0});
								$Flag=0;
								if($Flag==0)
								{
											if($row{2}==0)
											{
												$Label=$row{1};
											}else
											{
												$Parent=$this->GetFieldDataByID('EnglishService','TableID',$row{2},'tblservices');
												$Label=$row{1}.' ('.$Parent.')';
											}
											if($SelectedIndex==$row{0})
											{
											$Text.="<option selected value='".$row{0}."'>".$Label."</option>";
											}
											else
											{
											$Text.="<option value='".$row{0}."'>".$Label."</option>";
											}
								}
							}
				}
					mysqli_close();
					return $Text;
			}
			
			function checkIfParent($ServiceID)
			{
				$Query="select * from tblservices where IsPrintable=0 and ParentID='$ServiceID'";
				$this->query($Query);
				return $this->num_rows();
			}
			
			//******************** Fill The Combo Box
			function fillcounters($SelectedIndex,$FieldOne,$FieldTwo,$WhereField,$WhereValue,$TableName,$SortField)
			{
				//$sqlQuery="Select $FieldOne,$FieldTwo from $TableName where $WhereField=$WhereValue or $FieldOne=$SelectedIndex order by $SortField limit 0,".MAXCOUNTERS;
				
				if(($WhereField==1) && ($WhereValue==1))
				{
					$sqlQuery="Select A.TableID,A.CounterNumber,B.Department,A.CounterName from tblcounters A inner join tbldepartments B on A.DepartmentID=B.TableID where 1=1 or A.$FieldOne=$SelectedIndex order by B.Department asc,A.CounterName asc limit 0,".MAXCOUNTERS;
				}else
				{
				$sqlQuery="Select A.TableID,A.CounterNumber,B.Department,A.CounterName from tblcounters A inner join tbldepartments B on A.DepartmentID=B.TableID where A.$WhereField=$WhereValue or A.$FieldOne=$SelectedIndex order by B.Department asc,A.CounterName asc limit 0,".MAXCOUNTERS;
				}
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{2}." - ".$row{3}." - ".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{2}." - ".$row{3}." - ".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			function fillcountersdual($SelectedIndex,$FieldOne,$FieldTwo,$WhereField1,$WhereValue1,$WhereField2,$WhereValue2,$SortField)
			{
				
				$sqlQuery="Select A.$FieldOne,A.$FieldTwo,B.Department from tblcounters A inner join tbldepartments B on A.DepartmentID=B.TableID where A.$WhereField1=$WhereValue1 and A.$WhereField2=$WhereValue2 order by B.TableID asc,A.CounterName asc";
			
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{2}." ".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{2}." ".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			
			//******************** Fill the Images 
			function fillimages()
			{
				$sqlQuery="Select TableID,FileTitle from tblimages where IsActive=".YES." order by FileTitle";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			//******************** Fill the Jquery effects
			function filljqueryeffects()
			{
				$sqlQuery="Select TableID,Effect from tbljqueryeffects order by Effect";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			//******************** Fill the Duration
			function fillduration()
			{
				$sqlQuery="Select TableID,Duration from tblduration order by TableID";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			//******************** Fill The Combo Box
			function fillDateTimeFormat($SelectedIndex,$FieldOne,$FieldTwo,$TableName,$SortField)
			{
				$sqlQuery="Select $FieldOne,$FieldTwo from $TableName order by $SortField";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".date($row{1})."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".date($row{1})."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			function fillBuildings($SelectedIndex)
			{
				$sqlQuery="Select TableID,BuildingName,Phase from tblbuildings order by Phase,BuildingName";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($row{2}==1)
						{
							$Phase="Phase 1";
						}else
						{
							$Phase="Phase 2";
						}
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>(".$Phase.") - ".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>(".$Phase.") - ".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			
			//******************** Fill The Combo Box
			function FillDesignations($SelectedIndex,$FieldOne,$FieldTwo,$TableName,$SortField)
			{
				$sqlQuery="Select TableID,DesignationEnglish from tbldesignation where TableID=$SelectedIndex or IsActive=1 order by $SortField";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$sqlQuery);
				$Text="";
					while($row=mysqli_fetch_array($result,MYSQLI_NUM))
					{
						if($SelectedIndex==$row{0})
						{
						$Text.="<option selected value='".$row{0}."'>".$row{1}."</option>";
						}
						else
						{
						$Text.="<option value='".$row{0}."'>".$row{1}."</option>";
						}
					}
						mysqli_close();
					return $Text;
			}
			
			
			//******************** Print Count
			function fillcount($SelectedIndex,$MaxValue)
			{
					$Text="";
					for($Parser=1;$Parser<=$MaxValue;$Parser++)
					{
						if($SelectedIndex==$Parser)
						{
						$Text.="<option selected value='".$Parser."'>".$Parser."</option>";
						}
						else
						{
						$Text.="<option value='".$Parser."'>".$Parser."</option>";
						}
					}
					return $Text;
			}
			
			
			// Function for Creating Thumbnails for the Images
			function createthumbnail($files,$newfile,$newname,$extension,$newwidth,$newheight,$location)
			 {
					list($width, $height) = getimagesize($newfile);
					$image_p = imagecreatetruecolor($newwidth,$newheight);
					ini_set("max_execution_time", "500");
					ini_set("max_input_time", "500");
					$extension = strtolower($extension);			
					if($extension=='image/pjpeg') {
						$img = @imagecreatefromjpeg($newfile);
						imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						$location= $location.$newname;
						imagejpeg($image_p,$location, 100);           		
					} else if($extension == 'image/gif') {
						$img = @imagecreatefromgif($newfile);
						imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						$location= $location.$newname;
						imagegif($image_p,$location, 100); 		
					} else if($extension == 'image/png') {
						$img = @imagecreatefrompng($newfile);
						imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						$location= $location.$newname;
						imagepng($image_p,$location, 100);		
					}
						else if($extension == 'image/jpg') {
						$img = @imagecreatefromjpg($newfile);
						imagecopyresampled($image_p, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
						$location= $location.$newname;
						imagejpg($image_p,$location, 100);		
					}
				}
				
			//Function for creating JPEG Images	
			function create_jpeg_image() 
			{ 
				$md5 = md5(rand(0,999)); 
				$pass = substr($md5, 10, 5); 
				$width = 100; 
				$height = 20;  
				$image = ImageCreate($width, $height);  
				$white = ImageColorAllocate($image, 255, 255, 255); 
				$black = ImageColorAllocate($image, 0, 0, 0); 
				$grey = ImageColorAllocate($image, 204, 204, 204); 
				ImageFill($image, 0, 0, $black); 
				ImageString($image, 3, 30, 3, $pass, $white); 
				ImageRectangle($image,0,0,$width-1,$height-1,$grey); 
				imageline($image, 0, $height/2, $width, $height/2, $grey); 
				imageline($image, $width/2, 0, $width/2, $height, $grey); 
				header("Content-Type: image/jpeg"); 
				ImageJpeg($image);     
				ImageDestroy($image); 
			} 
			function generatepassword($length)
			{
			  $password = "";
			  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
			  $i = 0; 
			  while ($i < $length) { 
				$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
				if (!strstr($password, $char)) { 
				  $password .= $char;
				  $i++;
				}
			  }
			  return $password;
			}
			function redirect($url,$time)
			{
				if($time==0)
				{
				?>
					<script language="javascript">
						window.location="<?php echo $url;?>";
					</script>
				<?php
				}else
				{
					echo '<meta http-equiv=refresh content='.$time.';URL='.$url.'>';
				}
				exit;
			}	
			
			//Showing Alert Message
			function showmessage($msg)
			{
			?>
					<script language="javascript">
					alert("<?=$msg?>");
					</script>
			<?php
			}
			
			//Check User Permission
			function checkPermission($userid,$pagename,$permissiontype,$permissionmessage,$redirectpage)
			{
					//Check if action is null to make sure it is not home page
					if ($pagename=='')
					{
						//If Home Page Allow
						return true;
					}
					else
					{				
						//Check Required Permissions
						$LinkID=$this->FetchSubLinkID($pagename);
						if($LinkID==0)
						{
								$this->redirect($redirectpage,0);
						}
						$FetchPermission = "select ".$permissiontype." from tbluserpermissions where SubLinkID=$LinkID and UserID=$userid";
						$this->query($FetchPermission);
						if($this->num_rows()!=0)
						{
							while($this->next_Record())
							{
								if ($this->f(0)==1)
								{
									return true;
								}else if ($this->f(0)==0)
								{
									$this->showmessage($permissionmessage);
									$this->redirect($redirectpage,0);
								}			
							}
						}else
						{
							$this->showmessage($permissionmessage);
							$this->redirect($redirectpage,0);
						}	
					}
			}
			//Fetch Sub Link ID from Link Table
			function FetchSubLinkID($pagename)
			{
				$FetchLink = "select TableID from tblsublinks where PageUrl='".$pagename.".php'";
				$this->query($FetchLink);
				if($this->num_rows()!=0)
				{
					while($this->next_Record())
					{
						return $this->f(0);
					}
				}else
				{
					return 0;
				}
			}
			function checkExistingPermission($userid,$pagename,$db)
			{
						//Check Required Permissions
						$LinkID=$this->FetchSubLinkID($pagename);
						$FetchPermission = "select ViewPermissions,AddPermissions,EditPermissions,DeletePermissions from tbluserpermissions where FeatureID=$LinkID and UserID=$userid";
						$this->query($FetchPermission);
						$RecordCount=0;
						if($this->num_rows()!=0)
						{
							while($this->next_Record())
							{
								$permissionarray[0]=$this->f('ViewPermissions');
								$permissionarray[1]=$this->f('AddPermissions');
								$permissionarray[2]=$this->f('EditPermissions');
								$permissionarray[3]=$this->f('DeletePermissions');
							}
						}else
						{
							$permissionarray[0]=0;
							$permissionarray[1]=0;
							$permissionarray[2]=0;
							$permissionarray[3]=0;
						}	
						if($permissionarray[0]==0)
						{
							$permissionflags['ViewPermissions']=' ';
						}else
						{
							$permissionflags['ViewPermissions']=' checked ';
						}	
						if($permissionarray[1]==0)
						{
							$permissionflags['AddPermissions']=' ';
						}else
						{
							$permissionflags['AddPermissions']=' checked ';
						}	
						if($permissionarray[2]==0)
						{
							$permissionflags['EditPermissions']=' ';
						}else
						{
							$permissionflags['EditPermissions']=' checked ';
						}	
						if($permissionarray[3]==0)
						{
							$permissionflags['DeletePermissions']=' ';
						}else
						{
							$permissionflags['DeletePermissions']=' checked ';
						}	
						
						return $permissionflags;
			}
			
			//Generate Random Session ID
			function GenerateRandomSessionID()
			{
				$SessionID=rand(0,9999).rand(0,9999).rand(0,9999).rand(0,9999);
				return $SessionID;
			}
			//Get Date Time in SQL Standard Format
			function GetStandardDateTime()
			{
				return date("Y-m-d H:i:s");
				return date("Y-m-d H:i:s A");
			}
			
			function GetStandardDateTimewithoutAMPM()
			{
				return date("Y-m-d H:i:s");
			}
			  /**
			 *
			 *
			 *
			 * @Function						EncodeUrl()   						
			 * @Purpose    						This function is used for encoding the URL
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				13th April , 2010
			 * @Aurguments						Plain PageName(String) 
			 * @Return Type						Encoded PageName(String)
			 *
			 *
			 *
			 **/
			 function EncodeUrl($Url)
			 {
			 	$UrlObjects=explode(".",$Url);
				/*
				for($Parser=1;$Parser<=ENCODING_TIMES;$Parser++)
				{
					$UrlObjects[0]=base64_encode($UrlObjects[0]);
				}
				*/
				//$UrlObjects[0]=trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, PREDEFINED_SALT_VALUE, $UrlObjects[0], MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
				
				//$UrlObjects[0]=$this->encryptsslfunction($UrlObjects[0]);
				$UrlObjects[0] = $UrlObjects[0];
				
				$UrlObjects[0]=$this->secured_encrypt($UrlObjects[0]);
				
				//encryptsslfunction
				
				
				$EncodedUrl='home.php?'.$UrlObjects[0];
				//$EncodedUrl='home.php?'.$Url;
				
				
				return $EncodedUrl;
			 }
			 
			 function EncodePlainUrl($Url)
			 {
			 
			 	$UrlObjects=explode(".",$Url);
				/*
				for($Parser=1;$Parser<=ENCODING_TIMES;$Parser++)
				{
					$UrlObjects[0]=base64_encode($UrlObjects[0]);
				}
				*/
				//$UrlObjects[0]=trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, PREDEFINED_SALT_VALUE, $UrlObjects[0], MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
				//$EncodedUrl=$UrlObjects[0];
				
				$EncodedUrl=$this->secured_decrypt($UrlObjects[0]);
				
				return $EncodedUrl;
			 }
			 
			  function EncodeUrlDashboard($Url)
			 {
			 	$UrlObjects=explode(".",$Url);
				/*
				for($Parser=1;$Parser<=ENCODING_TIMES;$Parser++)
				{
					$UrlObjects[0]=base64_encode($UrlObjects[0]);
				}
				*/
				//$UrlObjects[0]=trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, PREDEFINED_SALT_VALUE, $UrlObjects[0], MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
				$UrlObjects[0]=$this->secured_encrypt($UrlObjects[0]);
				$EncodedUrl='dashboard/index.php?'.$UrlObjects[0];
				return $EncodedUrl;
			 }
			 
			 
			 
			   /**
			 *
			 *
			 *
			 * @Function						DecodeUrl()   						
			 * @Purpose    						This function is used for decoding the enrypted URL
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				13th April , 2010
			 * @Aurguments						Null
			 * @Return Type						Null 
			 *
			 *
			 *
			 **/
			  function DecodeUrl()
			 {
			 	$CompletionUrl=$_SERVER['REQUEST_URI'];
				//$CompleteUrlBreakUpObject=explode("/",$CompletionUrl);
				//$UrlDataObject=$CompleteUrlBreakUpObject[count($CompleteUrlBreakUpObject)-1];
				//$UrlData=explode("?",$UrlDataObject);
				$UrlData=explode("?",$CompletionUrl);
				if(count($UrlData)<=1)
				{
					$_REQUEST['action']="";
					$_SESSION['PageType']="home";
					$_SESSION['NavigationalCss']="nav-outer-repeat2";
					return;
				}else
				{
					$RemainingUrl=$UrlData[1];
					/*
					for($Parser=1;$Parser<=ENCODING_TIMES;$Parser++)
					{
						$RemainingUrl=base64_decode($RemainingUrl);
					}
					*/
					//$RemainingUrl=trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, PREDEFINED_SALT_VALUE, base64_decode($RemainingUrl), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
					
					//$RemainingUrl=$this->secured_decrypt($RemainingUrl);
					
					$RemainingUrl=$this->secured_decrypt($RemainingUrl);
					
				
					
					$RemainingUrlDataObject=explode("&",$RemainingUrl);
					foreach($RemainingUrlDataObject as $UrlObjects)
					{
						$UrlObject=explode("=",$UrlObjects);
						$_REQUEST[$UrlObject[0]]=$UrlObject[1];
					}
					$_SESSION['PageType']="inner";
					$_SESSION['NavigationalCss']="nav-outer-repeat";
					return;
				}
			 }
			 
			 /**
			 *
			 *
			 *
			 * @Function						printArrayCombo()   						
			 * @Purpose    						This function prints a array in a combo
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				2nd May , 2010
			 * @Aurguments						Array Name (String) , Control Name (String) , Selected Value (Integer) , Css class (String)
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			 
			 function EncodeDashboardUrlNew($Url)
			 {
			 	
			 	//$UrlObjects=explode(".",$Url);
				/*
				for($Parser=1;$Parser<=ENCODING_TIMES;$Parser++)
				{
					$UrlObjects[0]=base64_encode($UrlObjects[0]);
				}
				*/
				//$UrlObjects[0]=trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, PREDEFINED_SALT_VALUE, $UrlObjects[0], MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
				//$EncodedUrl=$UrlObjects[0];
				$EncodedUrl=$this->secured_decrypt($Url);
				return $EncodedUrl;
			 }
			 
			 
			 function printArrayCombo($ArrayName,$SelectedValue)
			 {
			 ?>
				<?php
				foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						$selected="selected=selected";
					}else
					{
						$selected="";
					}
			 ?>
						<option <?=$selected?> value="<?php echo $Key;?>"><?php echo $Value;?></option>
			 <?php
			 	}
			?>
			<?php
			 }
			  /**
			 *
			 *
			 *
			 * @Function						printArrayRadioButtons()   						
			 * @Purpose    						This function prints a array in a combo
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				2nd May , 2010
			 * @Aurguments						Array Name (String) , Control Name (String) , Selected Value (Integer) , Css class (String)
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			 function printArrayRadioButtons($ArrayName,$ControlName,$SelectedValue)
			 {
			 ?>
				<?php
				foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						$checked="checked=checked";
					}else
					{
						$checked='';
					}
				 ?>
			 			<input <?=$checked?> type="radio" name="<?php echo $ControlName;?>" value="<?php echo $Key;?>" /> <?php echo $Value;?>
				<?php
			 	}
			?>
			<?php
			 }
			 
			  /**
			 *
			 *
			 *
			 * @Function						printSignageUpdateRadioButtons()   						
			 * @Purpose    						This function prints a array in a combo
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				2nd May , 2010
			 * @Aurguments						Array Name (String) , Control Name (String) , Selected Value (Integer) , Css class (String)
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			 function printSignageUpdateRadioButtons($ArrayName,$ControlName,$SelectedValue)
			 {
			 ?>
				<?php
				foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						$checked="checked=checked";
					}else
					{
						$checked='';
					}
				 ?>
			 			<input <?=$checked?> type="radio" onclick="UpdateSignageControls(this);" name="<?php echo $ControlName;?>" value="<?php echo $Key;?>" /> <?php echo $Value;?>
				<?php
			 	}
			?>
			<?php
			 }
			 
			 function printAgentButtons($ArrayName,$ControlName,$SelectedValue)
			 {
			 ?>
				<?php
				foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						$checked="checked=checked";
					}else
					{
						$checked='';
					}
				 ?>
			 			<input <?=$checked?> type="radio" onclick="UpdateAgentControls(this);" name="<?php echo $ControlName;?>" value="<?php echo $Key;?>" /> <?php echo $Value;?>
				<?php
			 	}
			?>
			<?php
			 }
			 
			 /**
			 *
			 *
			 *
			 * @Function						printApplicationCostArrayRadioButtons()   						
			 * @Purpose    						This function prints a array in a combo
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				2nd May , 2010
			 * @Aurguments						Array Name (String) , Control Name (String) , Selected Value (Integer) , Css class (String)
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			 function printApplicationCostArrayRadioButtons($ArrayName,$ControlName,$SelectedValue)
			 {
			 ?>
				<?php
				foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						$checked="checked=checked";
					}else
					{
						$checked='';
					}
				 ?>
			 			<input <?=$checked?> type="radio" name="<?php echo $ControlName;?>" onclick="LoadPerApplicationCostControl();" value="<?php echo $Key;?>" /> <?php echo $Value;?>
				<?php
			 	}
			?>
			<?php
			 }
			 
			  /**
			 *
			 *
			 *
			 * @Function						printApplicationCostArrayRadioButtons()   						
			 * @Purpose    						This function prints a array in a combo
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				2nd May , 2010
			 * @Aurguments						Array Name (String) , Control Name (String) , Selected Value (Integer) , Css class (String)
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			 function printGetUrgentFeeDivArrayRadioButtons($ArrayName,$ControlName,$SelectedValue)
			 {
			 ?>
				<?php
				foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						$checked="checked=checked";
					}else
					{
						$checked='';
					}
				 ?>
			 			<input <?=$checked?> type="radio" name="<?php echo $ControlName;?>" onclick="GetUrgentFeeDiv();" value="<?php echo $Key;?>" /> <?php echo $Value;?>
				<?php
			 	}
			?>
			<?php
			 }
			 
			 
			 /**
			 *
			 *
			 *
			 * @Function						getChoices()   						
			 * @Purpose    						This function returns Yes or No based on the Value submitted
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Array Name (String) , Selected Value (Integer)
			 * @Return Type						String Value of the array index
			 *
			 *
			 *
			 **/
			function getChoices($ArrayName,$SelectedValue)
			 {
			 	foreach($ArrayName as $Key=>$Value)
				{
					if($Key==$SelectedValue)
					{
						return $Value;
					}
			 	}
			 }
			 
			
			 
			 /**
			 *
			 *
			 *
			 * @Function						GetPermission()   						
			 * @Purpose    						This Function gets a specific permission for a user on a specific Page
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Permission Type as String , Page Name as String , User ID as Integer
			 * @Return Type						Permission as Integer
			 *
			 *
			 *
			 **/
			function GetSpecificPermission($PermissionType,$PageName,$UserID)
			{
				$PageName=$PageName.'.php';
				$GetSpecificPermission="select A.$PermissionType from tbluserpermissions A inner join tblofflinefeatures B on A.FeatureID=B.TableID where B.PageUrl='$PageName' and A.UserID=$UserID";
				$this->query($GetSpecificPermission);
				while($this->next_Record())
				{
					return $this->f($PermissionType);
				}
			}
			
			 /**
			 *
			 *
			 *
			 * @Function						GetPermissionForApplications()   						
			 * @Purpose    						This Function gets a number of permissions for manging the application
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Permission Type as String , Page Name as String , User ID as Integer
			 * @Return Type						PermissionArray as Array
			 *
			 *
			 *
			 **/
			function GetPermissionForApplications($PageName,$UserID)
			{
				$PageName=$PageName.'.php';
				$GetSpecificPermission="select A.EditPermission,A.EditStatusPermission,A.EditPaymentPermission from tbluserpermissions A inner join tblofflinefeatures B on A.FeatureID=B.TableID where B.PageUrl='$PageName' and A.UserID=$UserID";
				$this->query($GetSpecificPermission);
				while($this->next_Record())
				{
					$PermissionArray['EditPermission']=$this->f('EditPermission');
					$PermissionArray['EditStatusPermission']=$this->f('EditStatusPermission');
					$PermissionArray['EditPaymentPermission']=$this->f('EditPaymentPermission');
				}
				return $PermissionArray;
			}
			
			 /**
			 *
			 *
			 *
			 * @Function						PrintDate()   						
			 * @Purpose    						This Function is used to print date in a specific format
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				10th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Date
			 *
			 *
			 *
			 **/
			function PrintDate($DateValue)
			{
				if(($DateValue!='') && ($DateValue!='0000-00-00'))
				{
				 	return date(dS." ".F." ".Y, strtotime($DateValue));
				}else
				{
					return "";
				}
			}
			function PrintShortDate($DateValue)
			{
				if(($DateValue!='') && ($DateValue!='0000-00-00'))
				{
				 	return date(dS." ".M." ".Y, strtotime($DateValue));
				}else
				{
					return "";
				}
			}
			
			function PrintReportDate($DateValue)
			{
				if(($DateValue!='') && ($DateValue!='0000-00-00'))
				{
				 	return date(d."/".m."/".Y, strtotime($DateValue));
				}else
				{
					return "";
				}
			}
			
			
			function PrintDateShortYear($DateValue)
			{
				if(($DateValue!='') && ($DateValue!='0000-00-00'))
				{
				 	return date(dS." ".M." ".Y, strtotime($DateValue));
				}else
				{
					return "";
				}
			}
			
			/**
			 *
			 *
			 *
			 * @Function						PrintDateTime()   						
			 * @Purpose    						This Function is used to print date and time in a specific format
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				16th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Date
			 *
			 *
			 *
			 **/
			function PrintDateTime($DateTimeValue)
			{
				if($DateTimeValue!='')
				{
				 	return date(dS." ".F." ".Y, strtotime($DateTimeValue));
				}else
				{
					return "-";
				}
			}
			
		function PrintDashboardTime($DateTimeValue)
			{
				if($DateTimeValue!='')
				{
				 	return date(h.":".i.":".s.' '.A, strtotime($DateTimeValue));
				}else
				{
					return "-";
				}
			}
			
			
			function PrintTime($DateTimeValue)
			{
				if($DateTimeValue!='')
				{
				 	return date(H.":".i.":".s.' '.A, strtotime($DateTimeValue));
				}else
				{
					return "-";
				}
			}
			
			 /**
			 *
			 *
			 *
			 * @Function						printArrayWithString()   						
			 * @Purpose    						This function prints the array and keeps the combo values as string
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				14th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			 function printArrayWithString($ArrayName,$SelectedValue)
			 {
				$ReferrerObject=explode("/",$_SERVER['HTTP_REFERER']);
				
				foreach($ArrayName as $Key=>$Value)
				{
					if(($ReferrerObject[4]=="investors") && ($Value=="N/A"))
					{
						continue;
					}

					if($Value==$SelectedValue)
					{
						$selected="selected=selected";
					}else
					{
						$selected="";
					}
			 ?>
						<option <?=$selected?> value="<?php echo $Value;?>"><?php echo $Value;?></option>
			 <?php
			 	}
			?>
			<?php
			 }
			 
			
			/**
			 *
			 *
			 *
			 * @Function						AddingTimePeriodToDate()   						
			 * @Purpose    						This function is used for adding a certain time period to a Date
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				17th May , 2010
			 * @Aurguments						Date/Operator , Number , Duration
			 * @Return Type						Date
			 *
			 *
			 *
			 **/
			 function AddingTimePeriodToDate($Date,$Operation,$Number,$Duration)
			 {

				$Date = strtotime(date("Y-m-d", strtotime($Date)) . " $Operation$Number $Duration");
				return date(Y."/".m."/".d,$Date);				
			 }
			/**
			 *
			 *
			 *
			 * @Function						GetCurrentDate()   						
			 * @Purpose    						This function is getting current date
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				17th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Date
			 *
			 *
			 *
			 **/
			 function GetCurrentDate()
			 {
				return date("Y-m-d");				
			 }
			  function GetCurrentDatewithSlash()
			 {
				return date("Y/m/d");				
			 }
			 /**
			 *
			 *
			 *
			 * @Function						get_time_difference()   						
			 * @Purpose    						This function is for getting different in two dates
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				18th May , 2010
			 * @Aurguments						$StartDate,$EndDate
			 * @Return Type						Array which has years,months and days
			 *
			 *
			 *
			 **/
			function get_time_difference($start,$end)
			{
				$uts['start']      =    strtotime($start);
				$uts['end']        =    strtotime($end);
				if( $uts['start']!==-1 && $uts['end']!==-1 )
				{
					if( $uts['end'] >= $uts['start'] )
					{
						$diff    =    $uts['end'] - $uts['start'];
						if( $days=intval((floor($diff/86400))) )
							$diff = $diff % 86400;
						if( $hours=intval((floor($diff/3600))) )
							$diff = $diff % 3600;
						if( $minutes=intval((floor($diff/60))) )
							$diff = $diff % 60;
						$diff    =    intval( $diff );            
						return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
					}
					else
					{
						return 0;
					}
				}
			}
			
			
			
			
			/**
			 *
			 *
			 *
			 * @Function						GetRecordsDataObject()   						
			 * @Purpose    						This Function gets the records details
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				14th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function GetRecordsDataObject()
			{
				$resultset=$this->query($this->Query);
				$count=mysqli_num_fields($resultset);
				$i=0;
				$RecordIndex=0;
				while($this->next_Record())
				{
					$i=0;
					while($i<$count)
					{
						$fieldName = mysqli_fetch_field_direct($resultset, $i)->name;
					
						//$RecordDatasObject[$RecordIndex][mysql_field_name($resultset,$i)]=$this->f($i);
						
						$RecordDatasObject[$RecordIndex][$fieldName]=$this->f($i);
						
						$i++;
					}
					$RecordIndex=$RecordIndex+1;
				}
				return $RecordDatasObject;
			}
			function ChangeImageDiv($ImagePath)
			{
			?>
				<script language="javascript">
					window.opener.document.getElementById("imagediv").innerHTML='<img src="<?php echo $ImagePath;?>" vspace="5" border="0" width="150" />';
					window.opener.document.getElementById("Image").value="<?php echo $_SESSION[$_SESSION['ImageContainer']];?>";
					window.opener.document.getElementById("ImageUploaded").value="<?php echo YES;?>";
					window.opener.document.getElementById("imagebutton").innerHTML='<input onclick="DeleteApplicationImage();" value="Delete Image" type="button" class="button">';
				</script>
			<?php
			}
			function refreshparentwindow()
			{
			?>
				<script language="javascript">
					window.opener.location.reload();
				</script>
			<?php
			}
			//Window Close
			function windowclose()
			{
			?>
				<script language="javascript">
				window.close();
				</script>
			<?php
			}
				//Image Component Functions
				function resizeImage($image,$width,$height,$scale) {
					list($imagewidth, $imageheight, $imageType) = getimagesize($image);
					$imageType = image_type_to_mime_type($imageType);
					$newImageWidth = ceil($width * $scale);
					$newImageHeight = ceil($height * $scale);
					$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
					switch($imageType) {
						case "image/gif":
							$source=imagecreatefromgif($image); 
							break;
						case "image/pjpeg":
						case "image/jpeg":
				
						case "image/jpg":
							$source=imagecreatefromjpeg($image); 
							break;
						case "image/png":
						case "image/x-png":
							$source=imagecreatefrompng($image); 
							break;
					}
					imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
					
					switch($imageType) {
						case "image/gif":
							imagegif($newImage,$image); 
							break;
						case "image/pjpeg":
						case "image/jpeg":
						case "image/jpg":
							imagejpeg($newImage,$image,90); 
							break;
						case "image/png":
						case "image/x-png":
							imagepng($newImage,$image);  
							break;
					}
					
					chmod($image, 0777);
					return $image;
				}
				//You do not need to alter these functions
				function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
					list($imagewidth, $imageheight, $imageType) = getimagesize($image);
					$imageType = image_type_to_mime_type($imageType);
					
					$newImageWidth = ceil($width * $scale);
					$newImageHeight = ceil($height * $scale);
					$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
					switch($imageType) {
						case "image/gif":
							$source=imagecreatefromgif($image); 
							break;
						case "image/pjpeg":
						case "image/jpeg":
						case "image/jpg":
							$source=imagecreatefromjpeg($image); 
							break;
						case "image/png":
						case "image/x-png":
							$source=imagecreatefrompng($image); 
							break;
					}
					imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
					switch($imageType) {
						case "image/gif":
							imagegif($newImage,$thumb_image_name); 
							break;
						case "image/pjpeg":
						case "image/jpeg":
						case "image/jpg":
							imagejpeg($newImage,$thumb_image_name,90); 
							break;
						case "image/png":
						case "image/x-png":
							imagepng($newImage,$thumb_image_name);  
							break;
					}
					chmod($thumb_image_name, 0777);
					return $thumb_image_name;
				}
				//You do not need to alter these functions
				function getHeight($image) {
					$size = getimagesize($image);
					$height = $size[1];
					return $height;
				}
				//You do not need to alter these functions
				function getWidth($image) {
					$size = getimagesize($image);
					$width = $size[0];
					return $width;
				}

			// Deleting Files
			function DeleteFiles($ArrayToDelete)
			{
				foreach($ArrayToDelete as $File)
				{
					if(file_exists($File))
					{
						unlink($File);
					}
				}
			} 
			
			function uploadfilethumbnail($File,$width,$height,$dir,$newLocation,$filescheme)
			{
					$Images_Allowed = array(0=>"image/jpeg",1=>"image/jpg",2=>"image/gif"); 
					if(!(in_array($File['type'],$Images_Allowed)))
					{
						return $FileName;
					}
					if($filescheme=='R')
					{
						$extension = explode('.',$File['name']);
						$FileName=$this->generatePassword(15) . '.'.$extension[1];
					}else
					{
						$FileName=$filescheme.'_'.$File['name'];
					}
				
						if(!file_exists($dir))
							mkdir($dir);
						$uploaddir = realpath ($dir);
						$path = $uploaddir."/";
					//******** Uploadin to a temporary location
						if (is_uploaded_file($File['tmp_name'])) 
						{
					//******** Copy the file to the location		
							$resultCopy = copy($File['tmp_name'], $path .$FileName);
							
								if (!$resultCopy )
								{
									echo "Transaction failed!";
									return 0;
								} 	
							else
								{
									$location=$dir.'/' . $FileName;
									$type=$File['type'];
									if(!file_exists($newLocation))
									mkdir($newLocation);
									$GetImageSize=getimagesize($location);
									if($GetImageSize[0])
									{
										$this->createthumbnail($File,$location,$FileName,$type,$width,$height,$newLocation);
									}else
									{
										unlink($newLocation);
									}
									return $FileName;
								}
						}
			}
			
			 /**
			 *
			 *
			 *
			 * @Function						EncodeReportUrl()   						
			 * @Purpose    						This function is used for encoding the URL
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				13th April , 2010
			 * @Aurguments						Plain PageName(String) 
			 * @Return Type						Encoded PageName(String)
			 *
			 *
			 *
			 **/
			 function EncodeReportUrl($ReportUrl,$Url)
			 {
			 	$UrlObjects=explode(".",$Url);
				for($Parser=1;$Parser<=ENCODING_TIMES;$Parser++)
				{
					$UrlObjects[0]=base64_encode($UrlObjects[0]);
				}
				$EncodedUrl=$ReportUrl.'?'.$UrlObjects[0];
				return $EncodedUrl;
			 }
			 
			function windowopen($url)
			{
			?>
					<script language="javascript">
					window.open("<?=$url?>");
					</script>
			<?php
			}
			
			
			 /**
			 *
			 *
			 *
			 * @Function						checkExistense()   						
			 * @Purpose    						This Function is used for checking the existense of a service with a customer.
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			
			function checkExistense($ServiceID,$AgentID)
			{
				$ReturnArray['Found']=0;
				$ReturnArray['Priority']=0;
				$CheckExistense="select * from tblagentservices where AgentID='$AgentID' and ServiceID='$ServiceID'";
				$this->query($CheckExistense);
				while($this->next_Record())
				{
					$ReturnArray['Found']=1;
					$ReturnArray['Priority']=$this->f('Priority');
				}
				return $ReturnArray;
			}
			
			function checAgentPrioritykExistense($Agent,$ReasonID)
			{
				$ReturnArray['Found']=0;
				$ReturnArray['Priority']=0;
				$CheckExistense="select * from tblagentpriorityreasons where AgentID='$Agent' and PriorityReasonID='$ReasonID'";
				$this->query($CheckExistense);
				while($this->next_Record())
				{
					$ReturnArray['Found']=1;
					$ReturnArray['Priority']=$this->f('Priority');
				}
				return $ReturnArray;
			}
			
			
			
		
		function GetArray($TableID,$FieldName,$TableName)
		{
			$Query="select $TableID,$FieldName from $TableName";
			$this->query($Query);
			while($this->next_Record())
			{
				$ReturnArray[$this->f($TableID)]=$this->f($FieldName);
			}
			return $ReturnArray;
		}
		
		function ReformDate($DateValue)
		{
			return date("g:i:s a", strtotime($DateValue));
		}
		
		function PrintLastLoginDateTime($DateValue)
		{
			return date("dS M Y h:i:s A", strtotime($DateValue));
		}
		function FormLoginTime()
		{
			return date(d." - ".F." - ".Y." ".h.":".i.":".s." A");	
		}
		function GetTicketsByCounterSession($CounterSessionID)
		{
			$Query="select count(*) as Totalcount from tbltickets where CounterSessionID=$CounterSessionID";
			$this->query($Query);
			while($this->next_Record())
			{
				return $this->f('Totalcount');
			}
		}
		
		function GenerateBranchUrls()
		{
			$GenerateBranchUrls="select * from tblbranches where IsActive=".YES." order by Branch";
			$this->query($GenerateBranchUrls);
			while($this->next_Record())
			{
				$Path="http://".$this->f('Host')."/".$this->f('ApplicationName');
			?>
				<option value="<?php echo $Path;?>"><?php echo $this->f('Branch');?></option>
			<?php	
			}
		}
		
		function FormatLastUpdatedTime($DateValue)
		{
			return date("dS M Y H:i:s A", strtotime($DateValue));
		}
		
		
		function converttoseconds($InputArray)
		{
			$TotalSeconds=0;
			if($InputArray['days']>0)
			{
				$TotalSeconds=$TotalSeconds+($InputArray['days']*24*60*60);
			}
			if($InputArray['hours']>0)
			{
				$TotalSeconds=$TotalSeconds+($InputArray['hours']*60*60);
			}
			if($InputArray['minutes']>0)
			{
				$TotalSeconds=$TotalSeconds+($InputArray['minutes']*60);
			}
			if($InputArray['seconds']>0)
			{
				$TotalSeconds=$TotalSeconds+$InputArray['seconds'];
			}
			return $TotalSeconds;
		}
		
		function converttoput($Seconds,$ConvertType=3)
		{
				$ReturnArray['Hrs']=0;
				$Mins=$Seconds/60;
				$ReturnArray['Mins']=floor($Mins);
				$ReturnArray['Secs']=($Mins-$ReturnArray['Mins'])*60;
				$ReturnArray['Secs']=floor($ReturnArray['Secs']);
				if($ReturnArray['Mins']>59)
				{
					$Hrs=$ReturnArray['Mins']/60;
					$ReturnArray['Hrs']=floor($Hrs);
					$ReturnArray['Mins']=($Hrs-$ReturnArray['Hrs'])*60;
				}else
				{
					$ReturnArray['Hrs']=0;
				}
				if($ReturnArray['Hrs']<10)
				{
					$ReturnArray['Hrs']="0".$ReturnArray['Hrs'];
				}
				if($ReturnArray['Mins']<10)
				{
					$ReturnArray['Mins']="0".$ReturnArray['Mins'];
				}
				if($ReturnArray['Secs']<10)
				{
					$ReturnArray['Secs']="0".$ReturnArray['Secs'];
				}
				
				if(is_nan($ReturnArray['Hrs']))
				{
					$ReturnArray['Hrs'] = "00";	
				}
				if(is_nan($ReturnArray['Mins']))
				{
					$ReturnArray['Mins'] = "00";	
				}
				if(is_nan($ReturnArray['Secs']))
				{
					$ReturnArray['Secs'] = "00";	
				}
				
			
			return $ReturnArray;
		}
		
	function QuestionSequence($SurveyID)
	{
		$sqlQuery="Select max(Sequence) from tblquestions where SurveyID='$SurveyID'";
		$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
		$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
		$result=mysqli_query($db_conn,$sqlQuery);
			while($row=mysqli_fetch_array($result,MYSQLI_NUM))
			{
				if ($row[0]=='')
				{
				return 1;
				}
				else
				{
				return ($row[0]+1);
				}
			}
	}
	
	
	function UploadImageFile($File,$width,$height,$dir,$filescheme)
	{
			$ReturnArray['Error']=0;
			$ReturnArray['FileName']="";
			$Images_Allowed = array(0=>"image/jpeg",1=>"image/jpg",2=>"image/gif"); 
			// $string = 'Hello World!';
			 // if(stristr($string, 'earth') === FALSE) {
				//echo '"earth" not found in string';
			  //}
 	 		//if(!(in_array($File['type'],$Images_Allowed)))
			if(stristr($File['type'], 'image') === FALSE)
			{
				$ReturnArray['Error']=1;
				$ReturnArray['ErrorMessage']="Only Images are Allowed - Please upload an Image File Only";
				return $ReturnArray;
			}
			if($filescheme=='R')
			{
				$extension = explode('.',$File['name']);
				$FileName=$this->generatePassword(15) . '.'.$extension[1];
			}else
			{
				$FileName=$filescheme.'_'.$File['name'];
			}
				if(!file_exists($dir))
					mkdir($dir);
				$uploaddir = realpath ($dir);
				$path = $uploaddir."/";
				if (is_uploaded_file($File['tmp_name'])) 
				{
						$resultCopy = copy($File['tmp_name'], $path .$FileName);
						if (!$resultCopy )
						{
							echo "Transaction failed!";
							return 0;
						} 	
						else
						{
							$location=$dir.'/' . $FileName;
							$type=$File['type'];
							if(!file_exists($newLocation))
							mkdir($newLocation);
							$GetImageSize=getimagesize($location);
							if(($GetImageSize[0]!=$width) || ($GetImageSize[1]!=$height))
							{
								$ReturnArray['Error']=1;
								$ReturnArray['ErrorMessage']="Incorrect Image size uploaded - Please upload an image of ".$width."px into ".$height."px size";
								unlink($location);
								return $ReturnArray;
							}
							$ReturnArray['FileName']=$FileName;
							return $ReturnArray;
						}
				}
	}
	
function buildservicearray()
{
		$sqlQuery="Select * from tblservices";
		$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER, DATABASE_PASSWORD,DATABASE_NAME);
		$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
		$result=mysqli_query($db_conn,$sqlQuery);
		while($row=mysqli_fetch_array($result,MYSQLI_BOTH))
		{
			$ServicesArray[$row{'TableID'}]['TableID']=$row{'TableID'};
			$ServicesArray[$row{'TableID'}]['EnglishService']=$row{'EnglishService'};
			$ServicesArray[$row{'TableID'}]['Prefix']=$row{'Prefix'};
			$ServicesArray[$row{'TableID'}]['ParentID']=$row{'ParentID'};
		}
	return $ServicesArray;
}
	private $FormulatedService="";
	function formulateservicenames($ServiceID)
	{
		$Text="";
		$Array=$_SESSION['FullServicesArray'];
		$Text=$this->createnames($Array[$ServiceID]['ParentID'],$Text);
		if($_SESSION['Text']=="")
		{
			return $Array[$ServiceID]['EnglishService'];
		}else
		{
			return $Array[$ServiceID]['EnglishService']." 	(".$_SESSION['Text'].")";
		}
	}
	function createnames($ServiceID,$Text)
	{
		$Array=$_SESSION['FullServicesArray'];
		if($Array[$ServiceID]['ParentID']==0)
		{
			$Text=$Text.$Array[$ServiceID]['Prefix'];
		}else
		{
			$Text=$Text.$Array[$ServiceID]['Prefix'].",";
		}
		if($Array[$ServiceID]['ParentID']==0)
		{
			$_SESSION['Text']=$Text;
			return;
		}else
		{
			$this->createnames($Array[$ServiceID]['ParentID'],$Text);
		}
	}
	
	function FormulateProcessedTickets($Mode,$AgentID)
			 {
			 	//Changing Processing Tickets to Processed
				if($Mode==0)
				{
					$Query="select A.TableID,A.TicketingSurfingStartTime,B.BenchmarkServingTime,A.TicketDate,A.ModifiedBy from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketDate<='".$this->getcurrentdate()."' and A.TicketStatus='".PROCESSING."'";
					$this->query($Query);
				}else
				{
					$Query="select A.TableID,A.TicketingSurfingStartTime,B.BenchmarkServingTime,A.TicketDate,A.ModifiedBy from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketDate='".$this->getcurrentdate()."' and A.TicketStatus='".PROCESSING."' and A.ModifiedBy='$AgentID'";
					$this->query($Query);
				}
				$CountIndex=0;
				while($this->next_Record())
				{
					$TicketArray[$CountIndex]['TicketID']=$this->f('TableID');
					$TicketArray[$CountIndex]['StartTime']=strtotime($this->f('TicketingSurfingStartTime'));
					$TicketArray[$CountIndex]['TicketDate']=$this->f('TicketDate');
					$TicketArray[$CountIndex]['AgentID']=$this->f('ModifiedBy');
					$CountIndex=$CountIndex+1;
				}
				if(count($TicketArray)>0)
				{
							foreach($TicketArray as $Ticket)
							{
								$Query="select A.TableID,A.TicketingSurfingStartTime,A.TicketingSurfingEndTime from tbltickets A where A.TicketDate='".$Ticket['TicketDate']."' and A.ModifiedBy='".$Ticket['AgentID']."' and A.TicketStatus in (".PROCESSED.",".MISSING.",".TRANSFERRED.")";
								$this->query($Query);
								$Difference=100000000000000000000000000000;
								$MainTime=$Ticket['StartTime'];
								while($this->next_Record())
								{
									
									$StartTime=strtotime($this->f('TicketingSurfingStartTime'));
									$TempDiff=$StartTime-$MainTime;
									if($TempDiff>0)
									{
										if($TempDiff<$Difference)
										{
											$Difference=$TempDiff;
											$TicketIdentified=$this->f('TableID');
										}
									}else
									{
										$TicketIdentified=-1;
									}
								}
								if($TicketIdentified==-1)
								{
									$Query="select A.TableID,A.TicketingSurfingStartTime,A.TicketingSurfingEndTime,B.BenchmarkServingTime from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TableID='".$Ticket['TicketID']."'";
										$this->query($Query);
										while($this->next_Record())
										{
												$BenchmarkTime=$this->f('BenchmarkServingTime');
												$Time=rand(1,$this->f('BenchmarkServingTime')).".".rand(1,10);
												$Time=$Time*60;
												$FormulatedTime=$Ticket['StartTime']+$Time;
												$FormulatedTime=date(d." - ".F." - ".Y." ".h.":".i.":".s." A",$FormulatedTime);
												$UpdateTicket="update tbltickets set IsUpdatedToCentralDB=0,TicketingSurfingEndTime='$FormulatedTime',TicketStatus='".PROCESSED."' where TableID='".$Ticket['TicketID']."'";								
												$this->query($UpdateTicket);
										}
								}else
								{
									$Minutes=$Difference/60;
									$Query="select A.TableID,A.TicketingSurfingStartTime,A.TicketingSurfingEndTime,B.BenchmarkServingTime from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TableID='$TicketIdentified'";
									$this->query($Query);
									while($this->next_Record())
									{
										$BenchmarkTime=$this->f('BenchmarkServingTime');
										if($BenchmarkTime>$Minutes)
										{
											$UpdateTicket="update tbltickets set IsUpdatedToCentralDB=0,TicketingSurfingEndTime='".$this->f('TicketingSurfingStartTime')."',TicketStatus='".PROCESSED."' where TableID='".$Ticket['TicketID']."'";
											$this->query($UpdateTicket);
										}else
										{
											$Time=rand(1,$this->f('BenchmarkServingTime')).".".rand(1,10);
											$Time=$Time*60;
											$FormulatedTime=$Ticket['StartTime']+$Time;
											$FormulatedTime=date(d." - ".F." - ".Y." ".h.":".i.":".s." A",$FormulatedTime);
											$UpdateTicket="update tbltickets set IsUpdatedToCentralDB=0,TicketingSurfingEndTime='$FormulatedTime',TicketStatus='".PROCESSED."' where TableID='".$Ticket['TicketID']."'";
											$this->query($UpdateTicket);
										}
									}
								}
							}
				}
			 }
			 
			 function sendBySMTP($EmailType,$MailSendTo, $MailSubject, $MailMessage,$FromName,$EmailClassPath="../phpmailer/class.phpmailer.php")
			{
				include_once($EmailClassPath);
				$mail             = new PHPMailer();
				//$body             = eregi_replace("[\]",'',$MailMessage);
				$body             = $MailMessage;
				
				$mail->IsSMTP(); // telling the class to use SMTP
				/*
				$mail->Host = EMAIL_HOST; // SMTP server
				$mail->Port = EMAIL_PORT;
				$mail->SMTPAuth = false;
				$mail->Username = EMAIL_USERNAME;
				$mail->Password = EMAIL_PASSWORD;
				$mail->From = $FromEmail;
				$mail->FromName = EMAIL_FROMNAME;
				*/
				$GetSmptDetails="select * from tblsystemconfiguration where TableID=1";
				$this->setQuery($GetSmptDetails);
				$RecordDataObject=$this->GetRecordDataObject();
				if($RecordDataObject['IsAuthenticated']==1)
				{
					$mail->SMTPAuth = true;
				}else
				{
					$mail->SMTPAuth = false;
				}
				$mail->Host = $RecordDataObject['SmtpServer']; // SMTP server
				$mail->Port = $RecordDataObject['SmtpPort'];
				$mail->Username = $RecordDataObject['EmailUserName'];
				$mail->Password = $RecordDataObject['FromEmailPassword'];
				$mail->From = $RecordDataObject['FromEmail'];
				$mail->FromName = $FromName;
				$mail->CharSet = 'UTF-8';
				$mail->Subject    = $MailSubject;
				$mail->MsgHTML($body);
				$emailToSendAr = explode(",",$MailSendTo);
				foreach($emailToSendAr as $key => $email)
				{
					$mail->AddAddress($email);
				}
				if(!$mail->Send()) 
				{
					 $ErrorMessage=$mail->ErrorInfo;
					 $Query="insert into tblsmtplogs(EmailType,ErrorDetails,EmailAddress,ErrorDate,IPAddress,CreationDateTime) values('$EmailType','$ErrorMessage','$MailSendTo','".$this->getcurrentdate()."','".$_SERVER['REMOTE_ADDR']."','".$this->GetStandardDateTime()."')";
					 $this->query($Query);
				} 
					else 
				{
					 $ErrorMessage="The Email has been Sent";
					 $Query="insert into tblsmtplogs(EmailType,ErrorDetails,EmailAddress,ErrorDate,IPAddress,IsSent,CreationDateTime) values('$EmailType','$ErrorMessage','$MailSendTo','".$this->getcurrentdate()."','".$_SERVER['REMOTE_ADDR']."','1','".$this->GetStandardDateTime()."')";
					 $this->query($Query);
				}
				return  $ErrorMessage;
			}
			
			 function EmailOutofpapernotification()
			 {
				$KioskMachineConfigurationObject=$this->FetchRecordByID(1,'TableID','tblkioskconfiguration');
				if($KioskMachineConfigurationObject['CurrentTicketCount']>=$KioskMachineConfigurationObject['ResetNotificationCount'])
				{
						$Administrator=$this->FormulateEmailAdministration();
						$MailMessage.='<html>
						<head>
						<meta http-equiv="Content-Language" content="en-us">
						<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
						<meta name="ProgId" content="FrontPage.Editor.Document">
						<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
						<title>Dear Recipient</title>
						</head>
						<body>
						<div>
						  <font face="Arial" size="2">
						  <div align="center">
							<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">
							<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear 
							Recipient,</span></font></b></strong>
						  </div>
						  <div align="center">
							<p align="left" dir="ltr">The paper roll has to be changed for the Queue machine</div>
					
						  <p class="MsoBodyText" style="line-height: 100%" align="justify">
						  <font color="#000000" face="Verdana" size="1"><strong>Thanks &amp; very best 
						  regards,<br>
						  <br>
						  </strong></font><strong><b><font face="Tahoma" color="#993300" size="1">
						  <span style="font-size: 8pt; color: #993300; font-family: Tahoma">RSI Queue 
						  Administrator<br>
						  </span></font><font face="Tahoma" size="1" color="#0000FF">
						  <span style="font-size: 8pt; font-family: Tahoma">'.$Administrator.'</span></font></b></strong></font></div>
						</body>
						</html>';
						//$this->sendBySMTP($KioskMachineConfigurationObject['PaperRollNotificationEmail'],"RSI Queue Notification - Out of Paper",$MailMessage,EMAIL_FROMEMAIL);
						$Message=$this->sendBySMTP(EMAILTYPE_OUTOFPAPER,$KioskMachineConfigurationObject['PaperRollNotificationEmail'],"RSI Queue Notification - Out of Paper",$MailMessage,EMAIL_FROMNAME,OUTSIDEEMAILPATH);
				}
			 }
			 
			 function FormulateEmailAdministration()
			 {
				$GetDetails="select CorporateName,BranchID from tblsystemconfiguration where TableID=1";
				$this->setQuery($GetDetails);
				$RecordDataObject=$this->GetRecordDataObject();
				$BranchName=$this->getFieldDataByID('Branch','TableID',$RecordDataObject['BranchID'],'tblbranches');
				return $RecordDataObject['CorporateName'].' - '.$BranchName;
			 }
			 
			
			
			
			function CalculateDeadline($givenDate, $hours, $CountSat=COUNT_SATURDAY)
			{ 
					
					$range = (ceil($hours/7)*120);
					$cnt=1;
					$goodhours = array();
					$skipdates = array("2018-05-21","2018-05-22");
					foreach(range(1,$range) as $num)
					{
						$datetime = date("Y-m-d H:i:s", strtotime('+'.$num.' hour',strtotime($givenDate)));
						$time = date("H", strtotime('+'.$num.' hour',strtotime($givenDate)));
						$day = date("D", strtotime('+'.$num.' hour', strtotime($givenDate)));
						$FullDate = date("Y-m-d", strtotime('+'.$num.' hour', strtotime($givenDate)));
						
						if($CountSat==1)
						{
							if($day != 'Fri' && $day != 'Sat' && !in_array($FullDate,$skipdates) && $time > OFFICE_START_TIME && $time <= OFFICE_END_TIME)
							{
								$goodhours[$cnt] = $datetime;
								 
								if($cnt >= $hours && array_key_exists($hours,$goodhours))
								{
									return $goodhours[$hours];
									break;
								}
								
								$cnt++;
							}
						}
						else
						{
							if($day != 'Fri'  && !in_array($FullDate,$skipdates) && $time > OFFICE_START_TIME && $time <= OFFICE_END_TIME)
							{
								$goodhours[$cnt] = $datetime;
								 
								if($cnt >= $hours && array_key_exists($hours,$goodhours))
								{
									return $goodhours[$hours];
									break;
								}
								
								$cnt++;
							}
						}
						
					}
		 	}
			
			function PrintDateTime_New($DateTimeValue)
			{
				if($DateTimeValue!='')
				{
				 	return date(dS." ".F." ".Y." ".H.":".i.":".s, strtotime($DateTimeValue));
				}else
				{
					return "-";
				}
			}
			
			function SendRakezSMS($mobileNumber,$msgContent,$SmsType)
			{
			
				$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
						<soapenv:Header/>
						<soapenv:Body>
							<tem:SendSMSMessage>
							<tem:UserID>rsiconceptsadmin</tem:UserID>
							<tem:Password>R@k3zSMSIT123456</tem:Password>
							<tem:Category>test</tem:Category>
							<tem:MobileNumber>'.$mobileNumber.'</tem:MobileNumber>
							<tem:MessageBody>'.$msgContent.'</tem:MessageBody>
							<tem:IsArabic>true</tem:IsArabic>
							<tem:IsWantToProcess>true</tem:IsWantToProcess>
							</tem:SendSMSMessage>
						 </soapenv:Body>
						 </soapenv:Envelope>';
				$headers = array("Content-Type: text/xml;charset=utf-8",
					"SOAPAction: http://tempuri.org/ISMSProcessor/SendSMSMessage",
					"Content-length: ".strlen($xml),
					"Host: ebiz.rakez.com",
					"Connection: Keep-Alive"
					); 
				$url = "http://ebiz.rakez.com/SMSServiceGateway/SMSProcessor.svc";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($ch); 
				if(curl_errno($ch)) {
					$result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
				} 
				else {
					$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
					switch($returnCode) {
						case 200 :
							break;
						default :
							$result = "HTTP ERROR: " . $returnCode;
					}
				}
				$msgID = str_replace(array('<s:envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
				<sendsmsmessageresponse xmlns="http://tempuri.org/"><sendsmsmessageresult>','</sendsmsmessageresult></sendsmsmessageresponse></s:body></s:envelope>'), '', $response);
				curl_close($ch);
				if(is_numeric($msgID))
				{
					$_SESSION['SMSErrorMessageFlag'] = 0;
					$Query="insert into tblsmslog(SmsType,MobileNumber,Message,ResultID,SentDateTime) values('$SmsType','$mobileNumber','$msgContent','$msgID','".$this->GetStandardDateTime()."')";
					$this->query($Query);
				}else
				{
					$_SESSION['SMSErrorMessageFlag'] = 1;
				}
			}
			
			
			function GetCurrentBranchID()
			{
				$GetBranchID = "select * from tblbranches where IsActive=1 order by TableID limit 0,1";
				$this->query($GetBranchID);
				$this->next_Record();
				return $this->f('TableID');
			}
			function WaitingTicketsCountCategory($ServiceID,$Date)
			{
				$Query = "select count(*) as TotalCount from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketStatus in (".WAITING.") and B.ParentID in ($ServiceID) and A.TicketDate='$Date'";
				
				$this->query($Query);
				$this->next_Record();
				return $this->f('TotalCount');
			}
			
			function WaitingTicketsCount($ServiceID,$Date)
			{
				$Query = "select count(*) as TotalCount from tbltickets where TicketStatus in (".WAITING.") and ServiceID in ($ServiceID) and TicketDate='$Date'";
				
				$this->query($Query);
				$this->next_Record();
				return $this->f('TotalCount');
			}
			
			function CheckIfAgentLoggedin($AgentID)
			{
				$GetRecord = "select * from tblcounterservices where CreatedBy='$AgentID' and RegisterDate='".$this->getcurrentdate()."' and Status=1";
				$this->query($GetRecord);
				return $this->num_rows();
			}
			
			function CheckIfAgentLoggedin_New($AgentID)
			{
				$GetRecord = "select * from tblcounterservices where CreatedBy='$AgentID' and RegisterDate='".$this->getcurrentdate()."' and Status=1";
				$this->query($GetRecord);
				if($this->num_rows()!=0)
				{
					return $this->num_rows();
				}
				
				$GetRecord = "SELECT * FROM tblsystemusers WHERE LastActionDateTime >=( NOW() - INTERVAL 15 MINUTE) and TableID='$AgentID'";
				
				$this->query($GetRecord);
				if($this->num_rows()!=0)
				{
					return $this->num_rows();
				}
				return 0;
			}
			
			function GetBreakDetails($AgentID)
			{
				$BreakFound = 0;
				$GetRecord = "select A.BreakStartDateTime,B.Reason,B.Duration from tblagentbreaks A inner join tblbreakreasons B on A.ReasonID=B.TableID where AgentID='$AgentID' and A.BreakDate='".$this->getcurrentdate()."' and A.IsActive=1 order by A.TableID desc limit 0,1";
				$this->query($GetRecord);
				while($this->next_Record())
				{
					$Reason = $this->f('Reason');
					$Duration = $this->f('Duration');
					$BreakStartDateTime = $this->f('BreakStartDateTime');
					$BreakFound = 1;
				}
				$ReturnArray['BreakFound'] = $BreakFound;
				$ReturnArray['Message'] = "The Agent is on break for ".$Reason." and will be back in ".$Duration." mins";
				return $ReturnArray;
			}
			
			function FormulateTableIDForBranchesold($TableName)
			{
				$GetBranchID = "select * from tblbranches where IsActive=1 order by TableID limit 0,1";
				$this->query($GetBranchID);
				while($this->next_Record())
				{
					$BranchID = $this->f('TableID');
				}
				$Query = "select count(*) as Count from $TableName";
				$this->query($Query);
				$this->next_Record();
				$Count = $this->f('Count');

				$Count = (MAXTABLEIDFIGURE * $BranchID) + $Count + 1;
				return $Count;
			}
			
			
			function FormulateTableIDForBranches($TableName)
			{
				$GetBranchID = "select * from tblbranches where IsActive=1 order by TableID limit 0,1";
				$this->query($GetBranchID);
				while($this->next_Record())
				{
					$BranchID = $this->f('TableID');
				}
			
				$Query = "select max(TableID) as MaxID from $TableName";
				$this->query($Query);
				$this->next_Record();
				if($this->f('MaxID')=="")
				{
					$Count = 0;
					$Count = (MAXTABLEIDFIGURE * $BranchID) + $Count + 1;
				}else
				{
					$Count = $this->f('MaxID');
					$Count = $Count +  1;
				}
				
				return $Count;
			}
			
			function MigrateDateTime($DateTime)
			{
				return date("Y-m-d H:i:s A",strtotime($DateTime));
			}
			
			function CheckAgentBreaks($AgentID,$ReasonID)
			{
				$GetBreaks="select count(*) as Count from tblagentbreaks where AgentID='$AgentID' and ReasonID='$ReasonID' and BreakDate='".$this->getcurrentdate()."'";
				$this->query($GetBreaks);
				$this->next_Record();
				return $this->f('Count');
			}
			
				function GetSpecificAgentsonBreak($AgentID)
				{
					$Query = "select count(*) as TotalCount from tblagentbreaks A where A.BreakDate='".$this->getcurrentdate()."' and A.IsActive=1 and A.AgentID='$AgentID'";
					$this->query($Query);
					$this->next_Record();
					return $this->f('TotalCount');
				}
	
		function IsNanCheck($Value)
		{
			if(is_nan($Value))
			{
				return 0;
			}else
			{	
				if($Value=="nan")
				{
					return 0;
				}else
				{	
					return $Value;
				}
			}
		}
		
		
	function secured_encrypt($data)
	{
		$first_key = base64_decode(FIRSTKEY);
		$second_key = base64_decode(SECONDKEY);   
		$method = "aes-256-cbc";   
		$iv_length = openssl_cipher_iv_length($method);
		$iv = openssl_random_pseudo_bytes($iv_length);
		$first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);   
		$second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
		$output = base64_encode($iv.$second_encrypted.$first_encrypted);   
		
		return $output;       
	}

	function secured_decrypt($input)
	{
		$first_key = base64_decode(FIRSTKEY);
		$second_key = base64_decode(SECONDKEY);           
		$mix = base64_decode($input);
		$method = "aes-256-cbc";   
		$iv_length = openssl_cipher_iv_length($method);
		$iv = substr($mix,0,$iv_length);
		$second_encrypted = substr($mix,$iv_length,64);
		$first_encrypted = substr($mix,$iv_length+64);
		$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
		$second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, TRUE);
		if (hash_equals($second_encrypted,$second_encrypted_new))
		return $data;
		return false;
	}
	
	
	
	
			
			
	
}
?>
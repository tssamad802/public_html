<?php
/**
 *
 *
 *
 * @Class   						User Authentication and Authorization
 * @Purpose    						This class will included all the methods for the activities related to System Administration
 * @Author   	  					Shehzad Asghar Saddiq
 * @Creation Date    				20th November , 2010
 *
 *
 *
 **/
 
class UserAuthenticationAuthorization extends Rountinefunctions 
{

			private $UserID;
			private $CreatorID;
			private $IsFloorManager;


			private $Duration;
			
			private $RefreshTime;
			private $IsReceptionist;
			private $AllowBreak;
			private $IsSales;
			
			//Private Variables for Roles
			private $Role;
			private $Description;
			private $IsActive;

			//Private Variables for System Users
			private $UserName;
			private $SendEmailNotification;
			
			
			private $SystemUserPassword;
			private $NewPassword;
			private $EnglishName;
			private $ArabicName;
			private $IsMale;
			private $Telephone;
			private $Mobile;
			private $Fax;
			private $Email;
			private $RoleID;
			private $BranchID;
			private $DepartmentID;
			private $CounterID;
			private $IsAgent;
			private $OutofTurnTickets;
			private $MissingTickets;
			private $TransferToCounter;
			private $TransferToService;
			private $IsAccountactive;
			private $ShowReportingDashBoard;
			private $AccessCompleteReports;
			private $AccessFloorViewManager;
			private $AccessDashboard_FloorView;
			private $AccessDashboard_MessageCenter;
			private $AccessDashboard_QuickView;
			private $AccessDashboard_Reminders;
			private $AccessDashboard_Notifications;
			private $ModifyDashboard;
			private $Remarks;
			private $LastLoginIP;
			private $LastLoginDateTime;
			private $ServiceArray;
			private $PriorityArray;
			
			
			private $CanChangeCounter;
			
			
			
			//Private Variables for Reminders
			private $ReminderTitle;
			private $DueDate;
			private $IsCompleted;
			//Common Variables to the class
			private $CreatedBy;
			private $CreationDateTime;
			private $ModifiedBy;
			private $ModificationDateTime;
			private $CompletionMessage;
			private $AlternativeCompletionMessage;
			private $DestinationPage;
			private $TableID;
			private $Action;
			
			private $DB_BestPerformance;
			private $DB_LeastPerformance;
			private $DB_ServiceAnalytics;
			private $DB_ServiceStaffAnalytics;
			private $DB_Slabs;
			private $DB_PeakOffPeak;
			private $DB_DeptAnalytics;
			private $DB_NPS;
			private $DB_BranchAnalytics;
			
			
			//Get and Set Value Functions for Roles Variables
			
			
			
			//$CreatorID
			function setCreatorID($CreatorID)
			{
				$this->CreatorID=$CreatorID;
			}
			function GetCreatorID()
			{
				return $this->CreatorID;
			}
			
			
			//$UserID
			function setUserID($UserID)
			{
				$this->UserID=$UserID;
			}
			function GetUserID()
			{
				return $this->UserID;
			}
			
			
			
			
			
				//$DB_BranchAnalytics
			function setDB_BranchAnalytics($DB_BranchAnalytics)
			{
				$this->DB_BranchAnalytics=$DB_BranchAnalytics;
			}
			function GetDB_BranchAnalytics()
			{
				return $this->DB_BranchAnalytics;
			}
			
			
			
			//$IsFloorManager
			function setIsFloorManager($IsFloorManager)
			{
				$this->IsFloorManager=$IsFloorManager;
			}
			function GetIsFloorManager()
			{
				return $this->IsFloorManager;
			}
			
			
			
		
			//$Duration
			function setDuration($Duration)
			{
				$this->Duration=$Duration;
			}
			function GetDuration()
			{
				return $this->Duration;
			}
			
			
		
		
			//$DB_BestPerformance
			function setDB_BestPerformance($DB_BestPerformance)
			{
				$this->DB_BestPerformance=$DB_BestPerformance;
			}
			function GetDB_BestPerformance()
			{
				return $this->DB_BestPerformance;
			}
			//$DB_LeastPerformance
			function setDB_LeastPerformance($DB_LeastPerformance)
			{
				$this->DB_LeastPerformance=$DB_LeastPerformance;
			}
			function GetDB_LeastPerformance()
			{
				return $this->DB_LeastPerformance;
			}
			//$DB_ServiceAnalytics
			function setDB_ServiceAnalytics($DB_ServiceAnalytics)
			{
				$this->DB_ServiceAnalytics=$DB_ServiceAnalytics;
			}
			function GetDB_ServiceAnalytics()
			{
				return $this->DB_ServiceAnalytics;
			}
			//$DB_ServiceStaffAnalytics
			function setDB_ServiceStaffAnalytics($DB_ServiceStaffAnalytics)
			{
				$this->DB_ServiceStaffAnalytics=$DB_ServiceStaffAnalytics;
			}
			function GetDB_ServiceStaffAnalytics()
			{
				return $this->DB_ServiceStaffAnalytics;
			}
			//$DB_Slabs
			function setDB_Slabs($DB_Slabs)
			{
				$this->DB_Slabs=$DB_Slabs;
			}
			function GetDB_Slabs()
			{
				return $this->DB_Slabs;
			}
			//$DB_PeakOffPeak
			function setDB_PeakOffPeak($DB_PeakOffPeak)
			{
				$this->DB_PeakOffPeak=$DB_PeakOffPeak;
			}
			function GetDB_PeakOffPeak()
			{
				return $this->DB_PeakOffPeak;
			}
			//$DB_DeptAnalytics
			function setDB_DeptAnalytics($DB_DeptAnalytics)
			{
				$this->DB_DeptAnalytics=$DB_DeptAnalytics;
			}
			function GetDB_DeptAnalytics()
			{
				return $this->DB_DeptAnalytics;
			}
			//$DB_NPS
			function setDB_NPS($DB_NPS)
			{
				$this->DB_NPS=$DB_NPS;
			}
			function GetDB_NPS()
			{
				return $this->DB_NPS;
			}
			//$DB_MyPerformance
			function setDB_MyPerformance($DB_MyPerformance)
			{
				$this->DB_MyPerformance=$DB_MyPerformance;
			}
			function GetDB_MyPerformance()
			{
				return $this->DB_MyPerformance;
			}
			
			
			
			
		
		
			//$RefreshTime
			function setRefreshTime($RefreshTime)
			{
				$this->RefreshTime=$RefreshTime;
			}
			function GetRefreshTime()
			{
				return $this->RefreshTime;
			}
		
			//$IsReceptionist
			function setIsReceptionist($IsReceptionist)
			{
				$this->IsReceptionist=$IsReceptionist;
			}
			function GetIsReceptionist()
			{
				return $this->IsReceptionist;
			}
			
		
			//$AllowBreak
			function setAllowBreak($AllowBreak)
			{
				$this->AllowBreak=$AllowBreak;
			}
			function GetAllowBreak()
			{
				return $this->AllowBreak;
			}




			//$IsSales
			function setIsSales($IsSales)
			{
				$this->IsSales=$IsSales;
			}
			function GetIsSales()
			{
				return $this->IsSales;
			}




			//$Role
			function setRole($Role)
			{
				$this->Role=$Role;
			}
			function GetRole()
			{
				return $this->Role;
			}
			//$Description
			function setDescription($Description)
			{
				$this->Description=$Description;
			}
			function GetDescription()
			{
				return $this->Description;
			}
			
			//$IsActive
			function setIsActive($IsActive)
			{
				$this->IsActive=$IsActive;
			}
			function GetIsActive()
			{
				return $this->IsActive;
			}
			
			
			
			//Get and Set Value Functions for System User Variables
			//$SendEmailNotification
			function setSendEmailNotification($SendEmailNotification)
			{
				$this->SendEmailNotification=$SendEmailNotification;
			}
			function GetSendEmailNotification()
			{
				return $this->SendEmailNotification;
			}
			//$UserName
			function setUserName($UserName)
			{
				$this->UserName=$UserName;
			}
			function GetUserName()
			{
				return $this->UserName;
			}
			//$SystemUserPassword
			function setSystemUserPassword($SystemUserPassword)
			{
				$this->SystemUserPassword=$SystemUserPassword;
			}
			function GetSystemUserPassword()
			{
				return $this->SystemUserPassword;
			}
			
			//$NewPassword
			function setNewPassword($NewPassword)
			{
				$this->NewPassword=$NewPassword;
			}
			function GetNewPassword()
			{
				return $this->NewPassword;
			}
			//$EnglishName
			function setEnglishName($EnglishName)
			{
				$this->EnglishName=$EnglishName;
			}
			function GetEnglishName()
			{
				return $this->EnglishName;
			}
			
			//$ArabicName
			function setArabicName($ArabicName)
			{
				$this->ArabicName=$ArabicName;
			}
			function GetArabicName()
			{
				return $this->ArabicName;
			}
			
			
			//$IsMale
			function setIsMale($IsMale)
			{
				$this->IsMale=$IsMale;
			}
			function GetIsMale()
			{
				return $this->IsMale;
			}
			
			//$Telephone
			function setTelephone($Telephone)
			{
				$this->Telephone=$Telephone;
			}
			function GetTelephone()
			{
				return $this->Telephone;
			}
			
			//$Mobile
			function setMobile($Mobile)
			{
				$this->Mobile=$Mobile;
			}
			function GetMobile()
			{
				return $this->Mobile;
			}
			
			//$Fax
			function setFax($Fax)
			{
				$this->Fax=$Fax;
			}
			function GetFax()
			{
				return $this->Fax;
			}
			
			//$Email
			function setEmail($Email)
			{
				$this->Email=$Email;
			}
			function GetEmail()
			{
				return $this->Email;
			}
			
			//$RoleID
			function setRoleID($RoleID)
			{
				$this->RoleID=$RoleID;
			}
			function GetRoleID()
			{
				return $this->RoleID;
			}
			
			//$BranchID
			function setBranchID($BranchID)
			{
				$this->BranchID=$BranchID;
			}
			function GetBranchID()
			{
				return $this->BranchID;
			}
			
			//$DepartmentID
			function setDepartmentID($DepartmentID)
			{
				$this->DepartmentID=$DepartmentID;
			}
			function GetDepartmentID()
			{
				return $this->DepartmentID;
			}
			
			//$CounterID
			function setCounterID($CounterID)
			{
				$this->CounterID=$CounterID;
			}
			function GetCounterID()
			{
				return $this->CounterID;
			}
			
			//$IsAgent
			function setIsAgent($IsAgent)
			{
				$this->IsAgent=$IsAgent;
			}
			function GetIsAgent()
			{
				return $this->IsAgent;
			}
			
			//$OutofTurnTickets
			function setOutofTurnTickets($OutofTurnTickets)
			{
				$this->OutofTurnTickets=$OutofTurnTickets;
			}
			function GetOutofTurnTickets()
			{
				return $this->OutofTurnTickets;
			}
			
			//$MissingTickets
			function setMissingTickets($MissingTickets)
			{
				$this->MissingTickets=$MissingTickets;
			}
			function GetMissingTickets()
			{
				return $this->MissingTickets;
			}
			//$TransferToCounter
			function setTransferToCounter($TransferToCounter)
			{
				$this->TransferToCounter=$TransferToCounter;
			}
			function GetTransferToCounter()
			{
				return $this->TransferToCounter;
			}
			//$TransferToService
			function setTransferToService($TransferToService)
			{
				$this->TransferToService=$TransferToService;
			}
			function GetTransferToService()
			{
				return $this->TransferToService;
			}
			
			//$IsAccountactive
			function setIsAccountactive($IsAccountactive)
			{
				$this->IsAccountactive=$IsAccountactive;
			}
			function GetIsAccountactive()
			{
				return $this->IsAccountactive;
			}
			//$ShowReportingDashBoard
			function setShowReportingDashBoard($ShowReportingDashBoard)
			{
				$this->ShowReportingDashBoard=$ShowReportingDashBoard;
			}
			function GetShowReportingDashBoard()
			{
				return $this->ShowReportingDashBoard;
			}
			//$AccessCompleteReports
			function setAccessCompleteReports($AccessCompleteReports)
			{
				$this->AccessCompleteReports=$AccessCompleteReports;
			}
			function GetAccessCompleteReports()
			{
				return $this->AccessCompleteReports;
			}
			//$AccessFloorViewManager
			function setAccessFloorViewManager($AccessFloorViewManager)
			{
				$this->AccessFloorViewManager=$AccessFloorViewManager;
			}
			function GetAccessFloorViewManager()
			{
				return $this->AccessFloorViewManager;
			}
		
			//$AccessDashboard_FloorView
			function setAccessDashboard_FloorView($AccessDashboard_FloorView)
			{
				$this->AccessDashboard_FloorView=$AccessDashboard_FloorView;
			}
			function GetAccessDashboard_FloorView()
			{
				return $this->AccessDashboard_FloorView;
			}
			
			//$AccessDashboard_MessageCenter
			function setAccessDashboard_MessageCenter($AccessDashboard_MessageCenter)
			{
				$this->AccessDashboard_MessageCenter=$AccessDashboard_MessageCenter;
			}
			function GetAccessDashboard_MessageCenter()
			{
				return $this->AccessDashboard_MessageCenter;
			}
			
			//$AccessDashboard_QuickView
			function setAccessDashboard_QuickView($AccessDashboard_QuickView)
			{
				$this->AccessDashboard_QuickView=$AccessDashboard_QuickView;
			}
			function GetAccessDashboard_QuickView()
			{
				return $this->AccessDashboard_QuickView;
			}
			
			//$AccessDashboard_Reminders
			function setAccessDashboard_Reminders($AccessDashboard_Reminders)
			{
				$this->AccessDashboard_Reminders=$AccessDashboard_Reminders;
			}
			function GetAccessDashboard_Reminders()
			{
				return $this->AccessDashboard_Reminders;
			}
			//$AccessDashboard_Notifications
			function setAccessDashboard_Notifications($AccessDashboard_Notifications)
			{
				$this->AccessDashboard_Notifications=$AccessDashboard_Notifications;
			}
			function GetAccessDashboard_Notifications()
			{
				return $this->AccessDashboard_Notifications;
			}
			//$ModifyDashboard
			function setModifyDashboard($ModifyDashboard)
			{
				$this->ModifyDashboard=$ModifyDashboard;
			}
			function GetModifyDashboard()
			{
				return $this->ModifyDashboard;
			}
			
			//$Remarks
			function setRemarks($Remarks)
			{
				$this->Remarks=$Remarks;
			}
			function GetRemarks()
			{
				return $this->Remarks;
			}
			//$LastLoginIP
			function setLastLoginIP($LastLoginIP)
			{
				$this->LastLoginIP=$LastLoginIP;
			}
			function GetLastLoginIP()
			{
				return $this->LastLoginIP;
			}
			//$LastLoginDateTime
			function setLastLoginDateTime($LastLoginDateTime)
			{
				$this->LastLoginDateTime=$LastLoginDateTime;
			}
			function GetLastLoginDateTime()
			{
				return $this->LastLoginDateTime;
			}
			//$ServiceArray
			function setServiceArray($ServiceArray)
			{
				$this->ServiceArray=$ServiceArray;
			}
			function GetServiceArray()
			{
				return $this->ServiceArray;
			}
			//$PriorityArray
			function setPriorityArray($PriorityArray)
			{
				$this->PriorityArray=$PriorityArray;
			}
			function GetPriorityArray()
			{
				return $this->PriorityArray;
			}
			
			//Get and Set Value Functions for Reminders
			//$ReminderTitle
			function setReminderTitle($ReminderTitle)
			{
				$this->ReminderTitle=$ReminderTitle;
			}
			function GetReminderTitle()
			{
				return $this->ReminderTitle;
			}
			//$DueDate
			function setDueDate($DueDate)
			{
				$this->DueDate=$DueDate;
			}
			function GetDueDate()
			{
				return $this->DueDate;
			}
			
			//$IsCompleted
			function setIsCompleted($IsCompleted)
			{
				$this->IsCompleted=$IsCompleted;
			}
			function GetIsCompleted()
			{
				return $this->IsCompleted;
			}
			
			//Get and Set Value Functions for Common Variables
			//$CreatedBy
			function setCreatedBy($CreatedBy)
			{
				$this->CreatedBy=$CreatedBy;
			}
			function GetCreatedBy()
			{
				return $this->CreatedBy;
			}

			//$CreationDateTime
			function setCreationDateTime($CreationDateTime)
			{
				$this->CreationDateTime=$CreationDateTime;
			}
			function GetCreationDateTime()
			{
				return $this->CreationDateTime;
			}
			
			//$ModifiedBy
			function setModifiedBy($ModifiedBy)
			{
				$this->ModifiedBy=$ModifiedBy;
			}
			function GetModifiedBy()
			{
				return $this->ModifiedBy;
			}

			//$ModificationDateTime
			function setModificationDateTime($ModificationDateTime)
			{
				$this->ModificationDateTime=$ModificationDateTime;
			}
			function GetModificationDateTime()
			{
				return $this->ModificationDateTime;
			}
			
			//$CompletionMessage
			function setCompletionMessage($CompletionMessage)
			{
				$this->CompletionMessage=$CompletionMessage;
			}
			function GetCompletionMessage()
			{
				return $this->CompletionMessage;
			}
			
			//$AlternativeCompletionMessage
			function setAlternativeCompletionMessage($AlternativeCompletionMessage)
			{
				$this->AlternativeCompletionMessage=$AlternativeCompletionMessage;
			}
			function GetAlternativeCompletionMessage()
			{
				return $this->AlternativeCompletionMessage;
			}
			//$DestinationPage
			function setDestinationPage($DestinationPage)
			{
				$this->DestinationPage=$DestinationPage;
			}
			function GetDestinationPage()
			{
				return $this->DestinationPage;
			}
			
			//$TableID
			function setTableID($TableID)
			{
				$this->TableID=$TableID;
			}
			function GetTableID()
			{
				return $this->TableID;
			}
			
			//$Action
			function setAction($Action)
			{
				$this->Action=$Action;
			}
			function GetAction()
			{
				return $this->Action;
			}
			
			
			//$CanChangeCounter
			function setCanChangeCounter($CanChangeCounter)
			{
				$this->CanChangeCounter=$CanChangeCounter;
			}
			function GetCanChangeCounter()
			{
				return $this->CanChangeCounter;
			}
			
			
			
			/**
			 *
			 *
			 *
			 * @Function						checkSession()   						
			 * @Purpose    						This function is used to check the session and redirect to the login page if session is not found
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				13th April , 2010
			 * @Aurguments						Null
			 * @Return Type						Null 
			 *
			 *
			 *
			 **/
			function checkSession($sessionvalue)
			{
				if (($sessionvalue==false) || ($sessionvalue==''))
				{
					$this->redirect('index.php',0);
				}
			}
			
			
			function FormulateBranchesSession()
			{
				if(ISHO==1)
				{
					$Query = "select * from tblbranches where TableID not in (200)";
				}else
				{
					$Query = "select * from tblbranches where IsActive=1";
				}
				$this->query($Query);
				$Count = $this->num_rows();
				$Index = 0;
				$CountRecord = 0;
				$BranchIDs = "";
				while($this->next_Record())
				{
					$CountRecord = $CountRecord+1;
					if($CountRecord==$Count)
					{
						$BranchIDs = $BranchIDs.$this->f('TableID');
					}else
					{
						$BranchIDs = $BranchIDs.$this->f('TableID').',';
					}
					$Array[$Index]['TableID'] = $this->f('TableID');
					$Array[$Index]['Branch'] = $this->f('Branch');
					$ComparisonArray[$Index] = $this->f('TableID');
					$Index = $Index+1;
				}	
					$_SESSION['BranchesID'] = $BranchIDs;
					$_SESSION['BranchesArray'] = $Array;
					$_SESSION['ComparisonArray'] = $ComparisonArray;
			}
			
			
			
			function FormulateServiceTypeSessions()
			{
				if($_SESSION['ServiceType']==-1)
				{
					$_SESSION['ServiceTypeQuery'] = "TicketServiceType in (1,2)";
				}else
				{
					$_SESSION['ServiceTypeQuery'] = "TicketServiceType in (".$_SESSION['ServiceType'].")";
				}
			}
			
			
			
			
			function ValidateUserLogin()
			 {
			 			$ReturnArray['ResultFlag']="";
						$ReturnArray['ReturnMessage']="";
						$UserName=$this->GetUserName();
						$Password=md5(PREDEFINED_SALT_VALUE.md5($this->SystemUserPassword).PREDEFINED_SALT_VALUE);
						$PasswordSHA1=sha1($this->SystemUserPassword);
						
						if(ISHO==1)
						{
							$GetUser="Select * from tblsystemusers where UserName='$UserName' and Password IN ('$Password','$PasswordSHA1') and IsBranchRecord=0";
						}else
						{
							$GetUser="Select * from tblsystemusers where UserName='$UserName' and Password IN ('$Password','$PasswordSHA1')";
						}
						$this->query($GetUser);
						if ($this->num_rows()!=0)
						{
							while($this->next_Record())
							{
								if ($this->f('IsAccountactive')==ACCOUNTSTATUS_INACTIVE)
								{
									$resultset[] = array(
									"ResultFlag"=>ACCOUNTSTATUS_INACTIVE, 
									"ReturnMessage"=>APPLICATION_MESSAGE_ACCOUNTDISABLED
									);
			 					}else
								{
									/*
									if(BRANCHID==6)
									{
										$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/01';
										$Date = $this->GetCurrentDatewithSlash();
										$_SESSION['DashboardFromDate'] = date( "Y/m/d", strtotime( "$Date -1 day" ) );
										
										
									}else if(BRANCHID==2)
									{
										if($this->f('IsAgent')==YES)
										{
											$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/'.date("d");
										}else if($this->f('IsReceptionist')==YES)
										{
											$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/'.date("d");
										}else
										{
											$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/01';
										}
									}else
									{
										if($this->f('IsAgent')==YES)
										{
											if(BRANCHID==1)
											{
												$_SESSION['DashboardFromDate'] = '2019/03/24';
											}else
											{
												$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/'.date("d");
											}
										}else if($this->f('IsReceptionist')==YES)
										{
											$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/'.date("d");
										}else
										{
											$_SESSION['DashboardFromDate'] = date("Y").'/01/01';
										}
											$_SESSION['DashboardFromDate'] = date("Y").'/01/01';
									}
									*/
									if(ISHO==1)
									{
										$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/'.date("d");
										
										//$Date = $this->GetCurrentDatewithSlash();
										//$_SESSION['DashboardFromDate'] = date( "Y/m/d", strtotime( "$Date -180 day" ) );
										
									}else
									{
										
										$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/01';
									}

									
									$_SESSION['ServiceType'] = -1;




									$_SESSION['DashboardFromDate'] = date("Y").'/'.date("m").'/'.date("d");
									$_SESSION['DashboardToDate'] = $this->GetCurrentDatewithSlash();
									$_SESSION['TopFromDate'] = $_SESSION['DashboardFromDate'];
									$_SESSION['TopToDate'] = $_SESSION['DashboardToDate'];
									$_SESSION[APPLICATION_SESSION_LOGIN]=true;
									$_SESSION['FullName']=$this->f('EnglishName');
									$_SESSION['DepartmentID']=$this->f('DepartmentID');
									$_SESSION['IsAgent']=$this->f('IsAgent');
									$_SESSION['RoleID']=$this->f('RoleID');
									$_SESSION[APPLICATION_SESSION_USERID]=$this->f('TableID');
									$_SESSION[APPLICATION_SESSION_USERID_PWDTEMPSESSION]=$this->f('TableID');
									$_SESSION['Boxes_0'] = $this->f('AccessDashboard_FloorView');
									$_SESSION['Boxes_1'] = $this->f('AccessDashboard_MessageCenter');
									$_SESSION['Boxes_2'] = $this->f('AccessDashboard_QuickView');
									$_SESSION['Boxes_3'] = $this->f('AccessDashboard_Reminders');
									$_SESSION['Boxes_4'] = $this->f('AccessDashboard_Notifications');
									$_SESSION['ModifyDashboard'] = $this->f('ModifyDashboard');
									$_SESSION['NPSTrend'] = 1;
									$_SESSION['NPSSurveyID'] = "";
									$_SESSION['Violations'] = 1;
									$_SESSION['BranchID'] = $this->f('BranchID');
									if($this->f('LastLoginDateTime')=='')
									{
										$_SESSION['LastLoginDateTime'] = 'Never';
									}else
									{
										$_SESSION['LastLoginDateTime'] = $this->f('LastLoginDateTime');
									}
									//Updating Login Date/Time and IP Address
									$CurrentDateTime=$this->FormLoginTime();
									$CurrentIP=$_SERVER['REMOTE_ADDR'];
									$UpdateLoginDateTime="update tblsystemusers set LastLoginDateTime='$CurrentDateTime',LastLoginIP='$CurrentIP' where TableID=".$this->f('TableID');
									$this->query($UpdateLoginDateTime);
									$this->FormulateBranchesSession();
									$resultset[] = array(
									"ResultFlag"=>ACCOUNTSTATUS_ACTIVE, 
									"ReturnMessage"=>APPLICATION_MESSAGE_SUCCESSFULLOGIN,
									"DestinationUrl"=>'home.php'
									);
									$this->LoginCleanUpProcess();
								}
							}
							$GetConfiguration="select BranchID,MaxCounters,IsCentralLocation from tblsystemconfiguration where TableID=1";
							$this->setQuery($GetConfiguration);
							$RecordDataObject=$this->GetRecordDataObject();
							$_SESSION[APPLICATION_SESSION_BRANCHID]=$RecordDataObject['BranchID'];
							$_SESSION[APPLICATION_SESSION_CENTRALLOCATION]=$RecordDataObject['IsCentralLocation'];
						}
						else
						{
							$resultset[] = array(
							"ResultFlag"=>ACCOUNTSTATUS_INACTIVE, 
							"ReturnMessage"=>APPLICATION_MESSAGE_WRONGUSERLOGIN
							);
							$_SESSION['NameArray'][]=$this->GetUserName();
							foreach($_SESSION['NameArray'] as $Item)
							{
								if($Item==$this->GetUserName())
								{
									$CountFailedLogins=$CountFailedLogins+1;
								}
							}
							$MaxTries=$this->GetFieldDataByID('MaxTries','TableID',1,'tblsecurityconfiguration');
							if($MaxTries==$CountFailedLogins)
							{
								$FreezeUser="update tblsystemusers set IsAccountactive='".NO."',Remarks='Maximum Tries of Failed Login Attempts exceeded from ".$_SERVER['REMOTE_ADDR']." (Last Login Attempt : ".$this->GetStandardDateTime().")',ModificationDateTime='".$this->GetStandardDateTime()."' where UserName='".$this->GetUserName()."'";
								$this->query($FreezeUser);
								unset($_SESSION['NameArray']);
							}
						}
						return $resultset;
			 }
			 
			 
			 
			 
			 
			 
			 /**
			 *
			 *
			 *
			 * @Function						AddRole()   						
			 * @Purpose    						This Function is used for Adding New Role
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function AddRole()
			{
				//Adding Role
				$object=$_REQUEST;
				$AddRole="insert into tblroles(Role,Description,IsActive,CreatedBy,CreationDateTime) values('".$this->getRole()."','".$this->getDescription()."',".$this->getIsActive().",".$this->getCreatedBy().",'".$this->getCreationDateTime()."')";
				$this->query($AddRole);
				//$this->setTableID(mysql_insert_id());
				$this->setTableID(maxID('TableID','tblroles',0));
				//Getting Modules
				$GetModules="select TableID from tblmasterlinks order by Sequence";
				$this->query($GetModules);
				while($this->next_Record())
				{
					$Modules[]=$this->f('TableID');
				}
				//Setting Default Role Permissions to Null
				foreach($Modules as $Module)
				{
					$AddPermission="insert into tblmasterlinkpermissions(MasterLinkID,RoleID,IsAllowed,CreatedBy,CreationDateTime) values($Module,".$this->GetTableID().",".NO.",".$this->getCreatedBy().",'".$this->getCreationDateTime()."')";
					$this->query($AddPermission);
				}
				$DestinationUrl=$this->EncodeUrl("action=viewallroles&RecordID=".$this->GetTableID()."&PageType=".APPLICATION_URL_PERMISSIONS);
				$this->setDestinationPage($DestinationUrl);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			
			/**
			 *
			 *
			 *
			 * @Function						EditRole()   						
			 * @Purpose    						This Function is used for Editing Existing Role
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function EditRole()
			{
				$EditRole="update tblroles set IsUpdatedToCentralDB=0,Role='".$this->getRole()."',Description='".$this->getDescription()."',IsActive=".$this->GetIsActive().",ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."' where TableID='".$this->GetTableID()."';";
				
				//$EditRole="update tblroles set ModificationDateTime='".$this->GetModificationDateTime()."' where TableID='".$this->GetTableID()."';";
			
				
				//$EditRole="update tblroles set IsUpdatedToCentralDB=0,Role='".$this->getRole()."',Description='".$this->getDescription()."',IsActive=".$this->GetIsActive().",ModifiedBy=".$this->GetModifiedBy()." where TableID='".$this->GetTableID()."';";
				
				//$EditRole="update tblroles set Role='".$this->getRole()."' where TableID='".$this->GetTableID()."';";
				
				
				$this->query($EditRole);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			 /**
			 *
			 *
			 *
			 * @Function						DeleteRole()   						
			 * @Purpose    						This Function is used for Delete Existing Role
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function DeleteRole()
			{
				$DeleteRole="delete from tblroles where TableID=".$this->GetTableID().";";
				$this->query($DeleteRole);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}


			 /**
			 *
			 *
			 *
			 * @Function						EditRolePermission()   						
			 * @Purpose    						This Function is used for Editing Role Permission
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function EditRolePermission()
			{
				//Delete Current Permission
				$DeleteExistingRolePermission="delete from tblmasterlinkpermissions where RoleID=".$this->getTableID().";";
				$this->query($DeleteExistingRolePermission);
				$GetModules="select TableID from tblmasterlinks order by Sequence";
				$this->query($GetModules);
				while($this->next_Record())
				{
					$Modules[]=$this->f('TableID');
				}
				//Adding New Role Permission
				if(count($_REQUEST['Permissions'])>0)
				{
					foreach($Modules as $Module)
					{
						if(in_array($Module,$_REQUEST['Permissions']))
						{
							$IsAllowed=YES;
						}else
						{
							$IsAllowed=NO;
						}
						$InsertPermission="insert into tblmasterlinkpermissions(MasterLinkID,RoleID,IsAllowed,CreatedBy,CreationDateTime) values($Module,".$this->GetTableID().",$IsAllowed,".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($InsertPermission);
					}
				}
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			
				/**
			 *
			 *
			 *
			 * @Function						AddSystemUser()   						
			 * @Purpose    						This Function is use to Add Nerw System User
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function AddSystemUser()
			{
				$object=$_REQUEST;
				$Password=md5(PREDEFINED_SALT_VALUE.md5($this->GetSystemUserPassword()).PREDEFINED_SALT_VALUE);
				$AddSystemUser="insert into tblsystemusers(TableID,UserName,Password,EnglishName,ArabicName,IsMale,Telephone,Mobile,Fax,Email,RoleID,BranchID,DepartmentID,CounterID,IsAgent,OutofTurnTickets,MissingTickets,TransferToCounter,TransferToService,CanChangeCounter,IsAccountactive,ShowReportingDashBoard,AccessCompleteReports,AccessFloorViewManager,AccessDashboard_FloorView,AccessDashboard_MessageCenter,AccessDashboard_QuickView,AccessDashboard_Reminders,AccessDashboard_Notifications,DB_BestPerformance,DB_LeastPerformance,DB_ServiceAnalytics,DB_ServiceStaffAnalytics,DB_Slabs,DB_PeakOffPeak,DB_DeptAnalytics,DB_NPS,DB_BranchAnalytics,DB_MyPerformance,ModifyDashboard,IsSales,IsReceptionist,IsFloorManager,Remarks,CreatedBy,CreationDateTime) values('".$this->FormulateTableIDForBranches("tblsystemusers")."','".$this->GetUserName()."','".$Password."','".$this->GetEnglishName()."','".$this->GetArabicName()."','".$this->GetIsMale()."','".$this->GetTelephone()."','".$this->GetMobile()."','".$this->GetFax()."','".$this->GetEmail()."','".$this->GetRoleID()."','".$_SESSION[APPLICATION_SESSION_BRANCHID]."','".$this->GetDepartmentID()."','".$this->GetCounterID()."','".$this->GetIsAgent()."','".$this->GetOutofTurnTickets()."','".$this->GetMissingTickets()."','".$this->GetTransferToCounter()."','".$this->GetTransferToService()."','".$this->GetCanChangeCounter()."','".$this->GetIsAccountactive()."','".$this->GetShowReportingDashBoard()."','".$this->GetAccessCompleteReports()."','".$this->GetAccessFloorViewManager()."','".$this->GetAccessDashboard_FloorView()."','".$this->GetAccessDashboard_MessageCenter()."','".$this->GetAccessDashboard_QuickView()."','".$this->GetAccessDashboard_Reminders()."','".$this->GetAccessDashboard_Notifications()."','".$this->GetDB_BestPerformance()."','".$this->GetDB_LeastPerformance()."','".$this->GetDB_ServiceAnalytics()."','".$this->GetDB_ServiceStaffAnalytics()."','".$this->GetDB_Slabs()."','".$this->GetDB_PeakOffPeak()."','".$this->GetDB_DeptAnalytics()."','".$this->GetDB_NPS()."','".$this->GetDB_BranchAnalytics()."','".$this->GetDB_MyPerformance()."','".$this->GetModifyDashboard()."','".$this->GetIsSales()."','".$this->GetIsReceptionist()."','".$this->GetIsFloorManager()."','".$this->GetRemarks()."','".$this->GetCreatedBy()."','".$this->GetCreationDateTime()."')";
				$this->query($AddSystemUser);
				
				



				$GetMaxID="select max(TableID) as MaxID from tblsystemusers";
				$this->query($GetMaxID);
				while($this->next_Record())
				{
					$MaxID=$this->f('MaxID');
				}
				$this->setTableID($MaxID);
				//Getting Features and their Permissions
				$GetFeatures="select A.TableID,B.IsAllowed from tblsublinks A inner join tblmasterlinkpermissions B on A.MasterLinkID=B.MasterLinkID where B.RoleID=".$this->GetRoleID()." order by A.TableID";
				$this->query($GetFeatures);
				while($this->next_Record())
				{
					$Features[] = array(
					"FeatureID"=>$this->f("TableID"), 
					"IsAllowed"=>$this->f("IsAllowed")
					);
				}
				//Setting the User Permissions
				foreach($Features as $Feature)
				{
					$AddUserPermission="insert into tbluserpermissions(SubLinkID,ReadPermission,AddPermission,EditPermission,DeletePermission,UserID,CreatedBy,CreationDateTime) values($Feature[FeatureID],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],'".$this->GetTableID()."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
					$this->query($AddUserPermission);
				}
				//Adding Services
				if(count($this->GetServiceArray())!=0)
				{
					$ServiceArray=$this->GetServiceArray();
					$PriorityArray=$this->GetPriorityArray();
					for($Parser=0;$Parser<count($this->GetServiceArray());$Parser++)
					{
						$ExplodeObject=explode("-",$ServiceArray[$Parser]);
						$AddService="insert into tblagentservices(AgentID,ServiceID,Priority,CreatedBy,CreationDateTime) values('".$this->GetTableID()."','".$ExplodeObject[0]."','".$PriorityArray[$ExplodeObject[1]]."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($AddService);
					}
				}
				$this->setSystemUserPassword($Password);
				$this->setUserID($this->GetTableID());
				$this->setCreatorID($this->GetCreatedBy());
				$this->UpdatePasswordHistory();
					
					
				if($this->GetSendEmailNotification()==YES)
				{
					$IsEmailNotificationsEnabled=$this->GetFieldDatabyID('IsEmailNotificationsEnabled','TableID',1,'tblsystemconfiguration');
					if($IsEmailNotificationsEnabled==YES)
					{
						$Administrator=$this->FormulateEmailAdministration();
						$Statement="The Following are your account details for accessing RSI Queue System";
						$MailMessage.='<html>
						<head>
						<meta http-equiv="Content-Language" content="en-us">
						<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
						<meta name="ProgId" content="FrontPage.Editor.Document">
						<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
						<title>Dear '.$this->GetEnglishName().'</title>
						</head>
						<body>
						<div>
						<font face="Arial" size="2">
						<div align="center">
						<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">
						<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear 
						'.$this->GetEnglishName().',</span></font></b></strong>
						</div>
						<div align="center">
						<p align="left" dir="ltr">'.$Statement.'</div>
						<p align="left" dir="ltr" width="100%">
						URL					:	http://'.$_SERVER['HTTP_HOST'].'
						</div>
						<p align="left" dir="ltr">Username				:	'.$this->GetUserName().'</div>
						<p align="left" dir="ltr">Password				:	'.$this->GetSystemUserPassword().'</div>
						
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
						$Subject="RSI Queue User Account created";
						$Message=$this->sendBySMTP(EMAILTYPE_CREDENTAILS,$this->GetEmail(),$Subject,$MailMessage,EMAIL_FROMNAME,OUTSIDEEMAILPATH);
					}
				
				}
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			
			
			function EmailUserCredentialsPassword($Name,$Username,$Password,$Subject,$Statement,$Email)
			{
				include_once("../phpmailer/class.phpmailer.php");
				$Administrator=$this->GetFieldDatabyID('CorporateName','TableID',1,'tblsystemconfiguration');
				$MailMessage.='<html>
				<head>
				<meta http-equiv="Content-Language" content="en-us">
				<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
				<meta name="ProgId" content="FrontPage.Editor.Document">
				<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
				<title>Dear '.$Name.'</title>
				</head>
				<body>
				<div>
				<font face="Arial" size="2">
				<div align="center">
				<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">
				<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear 
				'.$Name.',</span></font></b></strong>
				</div>
				<div align="center">
				<p align="left" dir="ltr">'.$Statement.'</div>
				<p align="left" dir="ltr" width="100%">
				URL					:	http://'.$_SERVER['HTTP_HOST'].'
				</div>
				<p align="left" dir="ltr">Username				:	'.$Username.'</div>
				<p align="left" dir="ltr">Password				:	'.$Password.'</div>
				
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
				$this->sendBySMTP($Email,$Subject,$MailMessage,EMAIL_FROMEMAIL);
			}
			/**
			 *
			 *
			 *
			 * @Function						EditSystemUser()   						
			 * @Purpose    						This Function is used for Editing Existing System User
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function EditSystemUser()
			{
				//Editing Password
				$CurrentUserDataObject=$this->FetchRecordByID($this->GetTableID(),'TableID','tblsystemusers');
				if($this->GetSystemUserPassword()!='')
				{
					$EnteredPassword=md5(PREDEFINED_SALT_VALUE.md5($this->GetSystemUserPassword()).PREDEFINED_SALT_VALUE);
					$EditPassword="update tblsystemusers set Password='$EnteredPassword' where TableID=".$this->GetTableID();
					$this->query($EditPassword);
					$this->setSystemUserPassword($EnteredPassword);
					$this->setUserID($this->GetTableID());
					$this->setCreatorID($this->GetCreatedBy());
					$this->UpdatePasswordHistory();
					
					
					if($this->GetSendEmailNotification()==YES)
					{
						$Username=$this->GetFieldDatabyID('UserName','TableID',$this->GetTableID(),'tblsystemusers');
						$IsEmailNotificationsEnabled=$this->GetFieldDatabyID('IsEmailNotificationsEnabled','TableID',1,'tblsystemconfiguration');
						if($IsEmailNotificationsEnabled==YES)
						{
							$Administrator=$this->FormulateEmailAdministration();
							$Statement="Your password has been reset , The Following are the credentials : ";
							$MailMessage.='<html>
							<head>
							<meta http-equiv="Content-Language" content="en-us">
							<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
							<meta name="ProgId" content="FrontPage.Editor.Document">
							<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
							<title>Dear '.$this->GetEnglishName().'</title>
							</head>
							<body>
							<div>
							<font face="Arial" size="2">
							<div align="center">
							<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">
							<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear 
							'.$this->GetEnglishName().',</span></font></b></strong>
							</div>
							<div align="center">
							<p align="left" dir="ltr">'.$Statement.'</div>
							<p align="left" dir="ltr" width="100%">
							URL					:	http://'.$_SERVER['HTTP_HOST'].'
							</div>
							<p align="left" dir="ltr">Username				:	'.$Username.'</div>
							<p align="left" dir="ltr">Password				:	'.$this->GetSystemUserPassword().'</div>
							
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
							
							$Subject="RSI Queue Notification , Your password has been reset";
							$Message=$this->sendBySMTP(EMAILTYPE_EDITCREDENTAILS,$this->GetEmail(),$Subject,$MailMessage,EMAIL_FROMNAME,OUTSIDEEMAILPATH);
						}
				
					}
				}
				//Editing System User Permissions If role is updated
				if($this->GetRoleID()!=$CurrentUserDataObject['RoleID'])
				{
						//Deleting Existing Permission of the User
						$DeleteExistingUserPermissions="delete from tbluserpermissions where UserID=".$this->GetTableID();
						$this->query($DeleteExistingUserPermissions);
						//Getting Features and their Permissions
						$GetFeatures="select A.TableID,B.IsAllowed from tblsublinks A inner join tblmasterlinkpermissions B on A.MasterLinkID=B.MasterLinkID where B.RoleID=".$this->GetRoleID()." order by A.TableID";
						$this->query($GetFeatures);
						while($this->next_Record())
						{
							$Features[] = array(
							"FeatureID"=>$this->f("TableID"), 
							"IsAllowed"=>$this->f("IsAllowed")
							);
						}
						//Setting the User Permissions
						foreach($Features as $Feature)
						{
							$AddUserPermission="insert into tbluserpermissions(SubLinkID,ReadPermission,AddPermission,EditPermission,DeletePermission,UserID,CreatedBy,CreationDateTime) values($Feature[FeatureID],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],'".$this->GetTableID()."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
							$this->query($AddUserPermission);
						}
				}
				$EditSystemUser="update tblsystemusers set IsUpdatedToCentralDB=0,EnglishName='".$this->GetEnglishName()."',ArabicName='".$this->GetArabicName()."',IsMale='".$this->GetIsMale()."',Telephone='".$this->GetTelephone()."',Mobile='".$this->GetMobile()."',Fax='".$this->GetFax()."',Email='".$this->GetEmail()."',RoleID='".$this->GetRoleID()."',DepartmentID='".$this->GetDepartmentID()."',CounterID='".$this->GetCounterID()."',IsAccountactive='".$this->GetIsAccountactive()."',ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."',IsAgent='".$this->GetIsAgent()."',OutofTurnTickets='".$this->GetOutofTurnTickets()."',MissingTickets='".$this->GetMissingTickets()."',TransferToCounter='".$this->GetTransferToCounter()."',TransferToService='".$this->GetTransferToService()."',Remarks='".$this->GetRemarks()."',ShowReportingDashBoard='".$this->GetShowReportingDashBoard()."',AccessCompleteReports='".$this->GetAccessCompleteReports()."',AccessFloorViewManager='".$this->GetAccessFloorViewManager()."',AccessDashboard_FloorView='".$this->GetAccessDashboard_FloorView()."',AccessDashboard_MessageCenter='".$this->GetAccessDashboard_MessageCenter()."',AccessDashboard_QuickView='".$this->GetAccessDashboard_QuickView()."',AccessDashboard_Reminders='".$this->GetAccessDashboard_Reminders()."',AccessDashboard_Notifications='".$this->GetAccessDashboard_Notifications()."',ModifyDashboard='".$this->GetModifyDashboard()."',IsSales='".$this->GetIsSales()."',IsReceptionist='".$this->GetIsReceptionist()."',CanChangeCounter='".$this->GetCanChangeCounter()."',AllowBreak='".$this->GetAllowBreak()."',DB_BestPerformance='".$this->GetDB_BestPerformance()."',DB_LeastPerformance='".$this->GetDB_LeastPerformance()."',DB_ServiceAnalytics='".$this->GetDB_ServiceAnalytics()."',DB_ServiceStaffAnalytics='".$this->GetDB_ServiceStaffAnalytics()."',DB_Slabs='".$this->GetDB_Slabs()."',DB_PeakOffPeak='".$this->GetDB_PeakOffPeak()."',DB_DeptAnalytics='".$this->GetDB_DeptAnalytics()."',DB_NPS='".$this->GetDB_NPS()."',DB_MyPerformance='".$this->GetDB_MyPerformance()."',IsFloorManager='".$this->GetIsFloorManager()."',DB_BranchAnalytics='".$this->GetDB_BranchAnalytics()."' where TableID=".$this->GetTableID();
				$this->query($EditSystemUser);
				//Deleting Services
				$DeleteService="delete from tblagentservices where AgentID='".$this->GetTableID()."'";
				$this->query($DeleteService);
				//Adding Services
				if(count($this->GetServiceArray())!=0)
				{
					$ServiceArray=$this->GetServiceArray();
					$PriorityArray=$this->GetPriorityArray();
					for($Parser=0;$Parser<count($this->GetServiceArray());$Parser++)
					{
						$ExplodeObject=explode("-",$ServiceArray[$Parser]);
						$AddService="insert into tblagentservices(AgentID,ServiceID,Priority,CreatedBy,CreationDateTime) values('".$this->GetTableID()."','".$ExplodeObject[0]."','".$PriorityArray[$ExplodeObject[1]]."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($AddService);
					}
				}
			
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			
			
			
			
			
			 /**
			 *
			 *
			 *
			 * @Function						EditSystemUserPermission()   						
			 * @Purpose    						This Function is used for Editing User Permissions
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function EditSystemUserPermission()
			{
				$object=$_REQUEST;
				//Set Current Permissions to Null
				$SetPermissionsNull="update tbluserpermissions set ReadPermission=".NO.",AddPermission=".NO.",EditPermission=".NO.",DeletePermission=".NO." where UserID=".$this->GetTableID();
				$this->query($SetPermissionsNull);
				//Checking Read Permissions
				if(count($object['ReadPermissions'])>0)
				{
					$Query="";
					$CountRecord=0;
					foreach($object['ReadPermissions'] as $Feature)
					{
						$CountRecord=$CountRecord+1;
						if($CountRecord==count($object['ReadPermissions']))
						{
							$Query=$Query."SubLinkID=$Feature";
						}else
						{
							$Query=$Query."SubLinkID=$Feature or ";
						}
					}
					//Updating Read Permissions;
					$UpdateReadPermission="update tbluserpermissions set ReadPermission=".YES." where ($Query) and UserID=".$this->GetTableID(); 
					$this->query($UpdateReadPermission);
				}
				
				//Checking Add Permissions
				if(count($object['AddPermissions'])>0)
				{
					$Query="";
					$CountRecord=0;
					foreach($object['AddPermissions'] as $Feature)
					{
						$CountRecord=$CountRecord+1;
						if($CountRecord==count($object['AddPermissions']))
						{
							$Query=$Query."SubLinkID=$Feature";
						}else
						{
							$Query=$Query."SubLinkID=$Feature or ";
						}
					}
					//Updating Add Permissions;
					$UpdateAddPermission="update tbluserpermissions set AddPermission=".YES." where ($Query) and UserID=".$this->GetTableID(); 
					$this->query($UpdateAddPermission);
				}
				
				//Checking Edit Permissions
				if(count($object['EditPermissions'])>0)
				{
					$Query="";
					$CountRecord=0;
					foreach($object['EditPermissions'] as $Feature)
					{
						$CountRecord=$CountRecord+1;
						if($CountRecord==count($object['EditPermissions']))
						{
							$Query=$Query."SubLinkID=$Feature";
						}else
						{
							$Query=$Query."SubLinkID=$Feature or ";
						}
					}
					//Updating Edit Permissions;
					$UpdateEditPermission="update tbluserpermissions set EditPermission=".YES." where ($Query) and UserID=".$this->GetTableID(); 
					$this->query($UpdateEditPermission);
				}
				
				//Checking Delete Permissions
				if(count($object['DeletePermissions'])>0)
				{
					$Query="";
					$CountRecord=0;
					foreach($object['DeletePermissions'] as $Feature)
					{
						$CountRecord=$CountRecord+1;
						if($CountRecord==count($object['DeletePermissions']))
						{
							$Query=$Query."SubLinkID=$Feature";
						}else
						{
							$Query=$Query."SubLinkID=$Feature or ";
						}
					}
					//Updating Delete Permissions;
					$UpdateDeletePermission="update tbluserpermissions set DeletePermission=".YES." where ($Query) and UserID=".$this->GetTableID(); 
					$this->query($UpdateDeletePermission);
				}
				
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			
			/**
			 *
			 *
			 *
			 * @Function						DeleteSystemUser()   						
			 * @Purpose    						This Function is used for Delete Existing System User
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				3rd May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function DeleteSystemUser()
			{
				$DeleteSystemUser="delete from tblsystemusers where TableID=".$this->GetTableID().";";
				$this->query($DeleteSystemUser);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			/**
			 *
			 *
			 *
			 * @Function						ChangePassword()   						
			 * @Purpose    						This Function is used for updating User Profile
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				5th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function ChangePassword($ForcePasswordChange=0,$SuccessUrl="",$WrongUrl="")
			{
				
				//Editing Password
				$CurrentUserDataObject=$this->FetchRecordByID($this->GetTableID(),'TableID','tblsystemusers');
			
				$CurrentEnteredPassword=md5(PREDEFINED_SALT_VALUE.md5($this->GetSystemUserPassword()).PREDEFINED_SALT_VALUE);
			
				if($CurrentEnteredPassword!=$CurrentUserDataObject['Password'])
				{
					$this->showMessage($this->GetAlternativeCompletionMessage());
					if($ForcePasswordChange==1)
					{
						$this->redirect($WrongUrl,0);
					}else
					{
						$this->redirect($this->GetDestinationPage(),0);
					}
						
				}else
				{
					$NewEnteredPassword=md5(PREDEFINED_SALT_VALUE.md5($this->GetNewPassword()).PREDEFINED_SALT_VALUE);
					$EditPassword="update tblsystemusers set Password='$NewEnteredPassword' where TableID=".$this->GetTableID().";";
					$this->query($EditPassword);
					$this->setSystemUserPassword($NewEnteredPassword);
					$this->setUserID($this->GetTableID());
					$this->setCreatorID($this->GetTableID());
					$this->UpdatePasswordHistory();
					$this->showMessage($this->GetCompletionMessage());
					if($ForcePasswordChange==1)
					{
						$this->redirect($SuccessUrl,0);
					}else
					{
						$this->redirect($this->GetDestinationPage(),0);
					}
				}
			}
			
			
			function UpdatePasswordHistory()
			{
				$UpdatePasswordHistory="insert tblsystempasswords set Password='".$this->GetSystemUserPassword()."',UserID='".$this->GetUserID()."',CreatedBy='".$this->GetCreatorID()."',CreationDateTime='".$this->GetStandardDateTime()."'";
				$this->query($UpdatePasswordHistory);
			}
			
			
			
			
			 /**
			 *
			 *
			 *
			 * @Function						AddReminder()   						
			 * @Purpose    						This Function is used for Adding New Reminder
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				5th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function AddReminder()
			{
				$AddReminder="insert into tblreminders(ReminderTitle,DueDate,Description,IsActive,IsCompleted,CreatedBy,CreationDateTime) values('".$this->getReminderTitle()."','".$this->getDueDate()."','".$this->getDescription()."','".$this->getIsActive()."','".NO."',".$this->getCreatedBy().",'".$this->getCreationDateTime()."')";
				$this->query($AddReminder);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			 /**
			 *
			 *
			 *
			 * @Function						EditReminder()   						
			 * @Purpose    						This Function is used for Editing Reminder
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				5th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function EditReminder()
			{
				$EditReminder="update tblreminders set ReminderTitle='".$this->getReminderTitle()."',DueDate='".$this->getDueDate()."',IsCompleted='".$this->getIsCompleted()."',IsActive=".$this->getIsActive().",Description='".$this->getDescription()."',ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."' where TableID=".$this->GetTableID();
				$this->query($EditReminder);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			 /**
			 *
			 *
			 *
			 * @Function						DeleteReminder()   						
			 * @Purpose    						This Function is used for Deleting Existing Branch
			 * @Author   	  					Shehzad Asghar Saddiq
			 * @Creation Date    				5th May , 2010
			 * @Aurguments						Null
			 * @Return Type						Null
			 *
			 *
			 *
			 **/
			function DeleteReminder()
			{
				$DeleteReminder="delete from tblreminders where TableID='".$this->GetTableID()."'";
				$this->query($DeleteReminder);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			function FindConnectivityStatus($BranchID,$Host,$UserName,$Password)
			{
				$_SESSION[$BranchID]['TestHost']=$Host;
				$_SESSION[$BranchID]['TestUserName']=$UserName;
				$_SESSION[$BranchID]['TestPassword']=$Password;
				if(($Host!='') && ($UserName!=''))
				{
					$LinkID=mysqli_connect($Host,$UserName,$Password);
					if(!$LinkID)
					{
						return "Not Active ( <a target='_blank' href='TestConnection.php?BranchID=$BranchID'>=>View Error</a>)";
					}else
					{
						return "Active";
					}
				}else
				{
					return "-";
				}
			}
			
			function CreateLog($object)
			{
				$CreateLog="insert into tblsystemlog(UserID,Action,ActionType,PageType,RecordID,DateTime) values('".$_SESSION[APPLICATION_SESSION_USERID]."','".$object['action']."','".$object['ActionType']."','".$object['PageType']."','".$object['RecordID']."','".$this->GetStandardDateTime()."')";
				$this->query($CreateLog);
			}
			
			function LoginCleanUpProcess()
			{
				$CheckCurrentStatus="select TableID from tblcounterservices where Status=".ACTIVE." and CreatedBy=".$_SESSION[APPLICATION_SESSION_USERID];
				$this->query($CheckCurrentStatus);
				while($this->next_Record())
				{
						$CurrentSessions[]=$this->f('TableID');
				}
				if(count($CurrentSessions)>0)
				{
					foreach($CurrentSessions as $CurrentSession)
					{
						$GetTickets="select TableID,TicketDate,TicketingSurfingStartTime from tbltickets where CounterSessionID='$CurrentSession' and TicketStatus='".PROCESSING."'";
						$this->query($GetTickets);
						while($this->next_Record())
						{
								$TicketQuery="select * from tbltickets where TicketDate='".$this->f('TicketDate')."'";
								$ResultArray=$this->ExecuteLoginQueryArray($TicketQuery);
								$this->processLoginticket($this->f('TableID'),$this->f('TicketingSurfingStartTime'),$ResultArray);
						}
						$EndImproperSession="update tblcounterservices set IsUpdatedToCentralDB=0,Status='".INACTIVE."',EndTime='Improper Session End' where TableID='$CurrentSession'";
						$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD);
						$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
						mysqli_query($db_conn,$EndImproperSession);
					}
				}
			}
			
			function processLoginticket($TicketID,$TicketingSurfingStartTime,$ResultArray)
			{
				$ProcessingSeconds=($ResultArray['avgprocessingtimemins']*60)+$ResultArray['avgprocessingtimesecond'];
				$TicketingSurfingEndTime=date(d." - ".F." - ".Y." ".h.":".i.":".s." A",strtotime($TicketingSurfingStartTime)+$ProcessingSeconds);	
				$UpdateTicket="update tbltickets set IsUpdatedToCentralDB=0,TicketingSurfingEndTime='$TicketingSurfingEndTime',TicketStatus='".PROCESSED."',ModifiedBy=-1 where TableID='$TicketID'";
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				mysqli_query($db_conn,$UpdateTicket);
			}
			
			function ExecuteLoginQueryArray($Query)
			{
				$TotalTickets=0;
				$TotalWaitingTicket=0;
				$TotalProcessingTicket=0;
				$Waiting=0;
				$Processing=0;
				$Processed=0;
				$Destroyed=0;
				$Missing=0;
				$Transferred=0;
				$db_conn=mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD);
				$selectDB=mysqli_select_db(DATABASE_NAME,$db_conn);
				$result=mysqli_query($db_conn,$Query);
				while($row=mysqli_fetch_array($result,MYSQLI_BOTH))
				{
					$TotalTickets=$TotalTickets+1;
					if($row['TicketStatus']==WAITING)
					{
						$Waiting=$Waiting+1;
						continue;
					}else if($row['TicketStatus']==PROCESSING)
					{
						$Processing=$Processing+1;
						$TotalWaitingTicket=$TotalWaitingTicket+1;
					}else if($row['TicketStatus']==PROCESSED)
					{
						$Processed=$Processed+1;
						$TotalWaitingTicket=$TotalWaitingTicket+1;
						$TotalProcessingTicket=$TotalProcessingTicket+1;
					}else if($row['TicketStatus']==DESTROYED)
					{
						$Destroyed=$Destroyed+1;
						continue;
					}else if($row['TicketStatus']==MISSING)
					{
						$Missing=$Missing+1;
						$TotalWaitingTicket=$TotalWaitingTicket+1;
						$TotalProcessingTicket=$TotalProcessingTicket+1;
					}else if($row['TicketStatus']==TRANSFERRED)
					{
						$Transferred=$Transferred+1;
						$TotalWaitingTicket=$TotalWaitingTicket+1;
						$TotalProcessingTicket=$TotalProcessingTicket+1;
					}
					/***************************Adding up Wating Time*******************************/
					$waitingdifferenceobject=$this->classfunction_get_time_difference($row['TicketDispensingTime'],$row['TicketingSurfingStartTime']);
					if($waitingdifferenceobject['days']>0)
					{
						$totalwaitingseconds=$totalwaitingseconds+($waitingdifferenceobject['days']*24*60*60);
					}
					if($waitingdifferenceobject['hours']>0)
					{
						$totalwaitingseconds=$totalwaitingseconds+($waitingdifferenceobject['hours']*60*60);
					}
					if($waitingdifferenceobject['minutes']>0)
					{
						$totalwaitingseconds=$totalwaitingseconds+($waitingdifferenceobject['minutes']*60);
					}
					if($waitingdifferenceobject['seconds']>0)
					{
						$totalwaitingseconds=$totalwaitingseconds+$waitingdifferenceobject['seconds'];
					}
					/***************************Adding up Wating Time*******************************/
					if(($row['TicketStatus']!=WAITING) && ($row['TicketStatus']!=PROCESSING))
					{
						/***************************Adding up Processing Time*******************************/
						$processingdifferenceobject=$this->classfunction_get_time_difference($row['TicketingSurfingStartTime'],$row['TicketingSurfingEndTime']);
						if($processingdifferenceobject['days']>0)
						{
							$totalprocessingseconds=$totalprocessingseconds+($processingdifferenceobject['days']*24*60*60);
						}
						if($processingdifferenceobject['hours']>0)
						{
							$totalprocessingseconds=$totalprocessingseconds+($processingdifferenceobject['hours']*60*60);
						}
						if($processingdifferenceobject['minutes']>0)
						{
							$totalprocessingseconds=$totalprocessingseconds+($processingdifferenceobject['minutes']*60);
						}
						if($processingdifferenceobject['seconds']>0)
						{
							$totalprocessingseconds=$totalprocessingseconds+$processingdifferenceobject['seconds'];
						}
						/***************************Adding up Processing Time*******************************/
					}
				}
				
				
					/***************************Processing Wating Time*******************************/
					if($totalwaitingseconds==0)
					{
						$resultobject['avgwaittimemins']=0;
						$resultobject['avgwaittimesecond']=0;
					}else
					{
						$avgwaitingseconds=$totalwaitingseconds/($TotalWaitingTicket);
						$minscount=$avgwaitingseconds/60;
						$mins=floor($minscount)-$minscount;
						$mins=$mins*-1;
						$minscount=$minscount-$mins;
						$resultobject['avgwaittimemins']=$minscount;
						$resultobject['avgwaittimesecond']=round($mins*60,1);
					}
					/***************************Processing Wating Time*******************************/
					/***************************Processing Process Time*******************************/
					if($totalprocessingseconds==0)
					{
						$resultobject['avgprocessingtimemins']=0;
						$resultobject['avgprocessingtimesecond']=0;
					}else
					{
						$avgprocessingseconds=$totalprocessingseconds/($TotalProcessingTicket);
						$minscount=$avgprocessingseconds/60;
						$mins=floor($minscount)-$minscount;
						$mins=$mins*-1;
						$minscount=$minscount-$mins;
						$resultobject['avgprocessingtimemins']=$minscount;
						$resultobject['avgprocessingtimesecond']=round($mins*60,1);
					}
					/***************************Processing Process Time*******************************/
					$resultobject['Waiting']=$Waiting;
					$resultobject['BeingProcessed']=$Processing;
					$resultobject['Processed']=$Processed;
					$resultobject['Destroyed']=$Destroyed;
					$resultobject['Missing']=$Missing;
					$resultobject['Transferred']=$Transferred;
					$resultobject['TotalTickets']=$TotalTickets;
					if($TotalWaitingTicket==0)
					{
						$resultobject['TotalWaitinginSeconds']=0;
					}else
					{
						$resultobject['TotalWaitinginSeconds']=$totalwaitingseconds/$TotalWaitingTicket;
					}
					if($TotalProcessingTicket==0)
					{
						$resultobject['TotalProcessinginSeconds']=0;
					}else
					{
						$resultobject['TotalProcessinginSeconds']=$totalprocessingseconds/$TotalWaitingTicket;
					}
					return $resultobject;
			}
			
			
			function classfunction_get_time_difference($start,$end)
			{
					$uts['start']      =    strtotime( $start );
				
					$uts['end']        =    strtotime( $end );
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
							trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
						}
					}
					else
					{
						trigger_error( "Invalid date/time data detected", E_USER_WARNING );
					}
					return(false);
			}
			
			
			function EditCounterService()
			{
				//Editing Password
				$CurrentUserDataObject=$this->FetchRecordByID($this->GetTableID(),'TableID','tblsystemusers');
				$EditSystemUser="update tblsystemusers set CounterID='".$this->GetCounterID()."',ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."',IsAgent='".$this->GetIsAgent()."',OutofTurnTickets='".$this->GetOutofTurnTickets()."',MissingTickets='".$this->GetMissingTickets()."',TransferToCounter='".$this->GetTransferToCounter()."',TransferToService='".$this->GetTransferToService()."' where TableID=".$this->GetTableID();
				$this->query($EditSystemUser);
				//Deleting Services
				$DeleteService="delete from tblagentservices where AgentID='".$this->GetTableID()."'";
				$this->query($DeleteService);
				//Adding Services
				if(count($this->GetServiceArray())!=0)
				{
					$ServiceArray=$this->GetServiceArray();
					$PriorityArray=$this->GetPriorityArray();
					for($Parser=0;$Parser<count($this->GetServiceArray());$Parser++)
					{
						$ExplodeObject=explode("-",$ServiceArray[$Parser]);
						$AddService="insert into tblagentservices(AgentID,ServiceID,Priority,CreatedBy,CreationDateTime) values('".$this->GetTableID()."','".$ExplodeObject[0]."','".$PriorityArray[$ExplodeObject[1]]."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($AddService);
					}
				}
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			function Calculatedepartmentotherinfo($DepartmentID)
			{
				$FetchRecords="select count(*) as Count from tblsystemusers where DepartmentID='".$DepartmentID."'";
				$this->query($FetchRecords);
				while($this->next_Record())
				{
					$ResultArray['Users']=$this->f('Count');
				}
				
				$FetchRecords="select count(*) as Count from tblcounters where DepartmentID='".$DepartmentID."'";
				$this->query($FetchRecords);
				while($this->next_Record())
				{
					$ResultArray['Counters']=$this->f('Count');
				}
				
				$FetchRecords="select count(*) as Count from tblservices where DepartmentID='".$DepartmentID."' and IsPrintable=".YES;
				$this->query($FetchRecords);
				while($this->next_Record())
				{
					$ResultArray['Services']=$this->f('Count');
				}
				return $ResultArray;
			}
			
			function getDatabasebackupParameters()
			{
				$GetInfo="select A.DatabasebackupPathSource,A.RemoteServerIP,A.DestinationFolder from tblsystemconfiguration A inner join tblbranches B on A.BranchID=B.TableID where A.TableID=1";
				$this->query($GetInfo);
				while($this->next_Record())
				{
					$ReturnArray['DatabasebackupPathSource']=$this->f('DatabasebackupPathSource');
					$ReturnArray['RemoteServerIP']=$this->f('RemoteServerIP');
					$ReturnArray['DestinationFolder']=$this->f('DestinationFolder');
				}
				return $ReturnArray;
			}
			
			function GenerateDashBoard()
			{
				$FetchMasterLinks="select B.HomePageTitle,B.TableID from tblmasterlinkpermissions A inner join tblmasterlinks b on A.MasterLinkID=B.TableID where A.IsAllowed=1 and A.RoleID=".$_SESSION['RoleID']." order by B.Sequence";
				$this->query($FetchMasterLinks);
				while($this->next_Record())
				{
					$ModulesArray[$this->f('TableID')]['ModuleID']=$this->f('TableID');
					$ModulesArray[$this->f('TableID')]['ModuleTitle']=$this->f('HomePageTitle');
				}	
				$FetchUserpermissions="select C.TableID as ModuleID,C.HomePageTitle as ModuleHomePageTitle,B.HomePageTitle as  SubLinkHomePageTitle,B.PageUrl,B.IconImage from tbluserpermissions A inner join tblsublinks B on A.SubLinkID=B.TableID inner join tblmasterlinks C on B.MasterLinkID=C.TableID where A.UserID=".$_SESSION[APPLICATION_SESSION_USERID]." and A.ReadPermission=".YES." and C.IsActive=".YES." order by C.Sequence,B.Sequence";
				$this->query($FetchUserpermissions);
				$SubLinkIndex=0;
				while($this->next_Record())
				{
					//$SubLinksArray[$this->f('ModuleID')]['ModuleID']=$this->f('TableID');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['ModuleID']=$this->f('ModuleID');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['IconImage']=$this->f('IconImage');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['PageUrl']=$this->f('PageUrl');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['SubLinkTitle']=$this->f('SubLinkHomePageTitle');
					$SubLinkIndex++;
				}
				foreach($ModulesArray as $ModuleID=>$ModuleTitle)
				{
					$ID="section_".str_replace(" ","_",strtolower($ModuleTitle['ModuleTitle']));
					//print_r($SubLinksArray[1]);
			?>
				<div class="dashboard-section-outer">
            	<div class="dashboard-sec-heading"><?php echo $ModuleTitle['ModuleTitle'];?></div>
							<div class="dashboard-sec-buttons" id="<?php echo $ID;?>">
								<div class="innerdiv">
									<?php
									foreach($SubLinksArray[$ModuleTitle['ModuleID']] as $SubLinks)
									{
										$SubLinkTitle=$SubLinks['SubLinkTitle'];
										$FeatureIcon=APPLICATION_IMAGES_FOLDER.'/'.APPLICATION_ICON_FOLDER.'/'.$SubLinks['IconImage'];
										if(strpos($SubLinks['PageUrl'],"report")=="")
										{
											$FeatureUrl=$this->EncodeUrl('action='.$SubLinks['PageUrl']);
											$Target="_self";
										?>
											<div align="center" class="Options">
												<a href="<?php echo $FeatureUrl;?>"><img src="<?php echo $FeatureIcon;?>" alt="" /><br><?php echo $SubLinkTitle;?></a>
											</div>
										<?php	
										}else
										{
											$FeatureUrl="javascript:OpenReportWindow('".$SubLinks['PageUrl']."','".str_replace(" ","",$SubLinks['PageUrl'])."')";
											$Target="#";
										?>
										<div align="center" class="Options">
											<a onclick="<?php echo $FeatureUrl;?>" target="_blank"><img src="<?php echo $FeatureIcon;?>" alt="" /><br><?php echo $SubLinkTitle;?></a>
										</div>
										<?php
										}
									?>
									<div style="display:none" align="center" class="Options">
										<a href="<?php echo $FeatureUrl;?>"><img src="<?php echo $FeatureIcon;?>" alt="" /><br><?php echo $SubLinkTitle;?></a>
									</div>
									<?php
										//}
									}
									?>
									<div class="clear"></div>
								</div>
							</div>
							<div class="dashboard-sec-icon"><a href="javascript:void(0)" slideto="down" divid="<?php echo $ID;?>" class="sectionicon"><img src="newimages/dashboard-section-down.png" id="<?php echo $ID;?>_img" /></a></div>
                <div class="clear"></div>
            </div>
			<?php
				}
			}
			
			
			
			function GenerateTopMenu()
			{
				$FetchMasterLinks="select B.HomePageTitle,B.TableID from tblmasterlinkpermissions A inner join tblmasterlinks B on A.MasterLinkID=B.TableID where A.IsAllowed=1 and B.IsActive=1 and A.RoleID=".$_SESSION['RoleID']." order by B.Sequence";
				$this->query($FetchMasterLinks);
				while($this->next_Record())
				{
					$ModulesArray[$this->f('TableID')]['ModuleID']=$this->f('TableID');
					$ModulesArray[$this->f('TableID')]['ModuleTitle']=$this->f('HomePageTitle');
				}	
				$FetchUserpermissions="select C.TableID as ModuleID,C.HomePageTitle as ModuleHomePageTitle,B.HomePageTitle as  SubLinkHomePageTitle,B.PageUrl,B.IconImage from tbluserpermissions A inner join tblsublinks B on A.SubLinkID=B.TableID inner join tblmasterlinks C on B.MasterLinkID=C.TableID where A.UserID=".$_SESSION[APPLICATION_SESSION_USERID]." and A.ReadPermission=".YES." and C.IsActive=".YES." and B.IsActive=".YES." order by C.Sequence,B.Sequence";
				$this->query($FetchUserpermissions);
				$SubLinkIndex=0;
				while($this->next_Record())
				{
					//$SubLinksArray[$this->f('ModuleID')]['ModuleID']=$this->f('TableID');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['ModuleID']=$this->f('ModuleID');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['IconImage']=$this->f('IconImage');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['PageUrl']=$this->f('PageUrl');
					$SubLinksArray[$this->f('ModuleID')][$SubLinkIndex]['SubLinkTitle']=$this->f('SubLinkHomePageTitle');
					$SubLinkIndex++;
				}
				
				foreach($ModulesArray as $ModuleID=>$ModuleTitle)
				{
			?>
					<li><a href="#"><span><?php echo $ModuleTitle['ModuleTitle'];?></span></a>
                    <ul style="display:none">
					<?php
					foreach($SubLinksArray[$ModuleTitle['ModuleID']] as $SubLinks)
					{
						$SubLinkTitle=$SubLinks['SubLinkTitle'];
						$FeatureIcon=APPLICATION_IMAGES_FOLDER.'/'.APPLICATION_ICON_FOLDER.'/'.$SubLinks['IconImage'];
						if(strpos($SubLinks['PageUrl'],"report")=="")
						{
							$FeatureUrl=$this->EncodeUrl('action='.$SubLinks['PageUrl']);
							$Target="_self";
						?>
						 <li><a href="<?php echo $FeatureUrl;?>" target="<?php echo $Target;?>"><?php echo $SubLinkTitle;?></a></li>
						<?php
						}else
						{
							$FeatureUrl="javascript:OpenReportWindow('".$SubLinks['PageUrl']."','".str_replace(" ","",$SubLinks['PageUrl'])."')";
							$Target="#";
						?>
						 <li><a onclick="<?php echo $FeatureUrl;?>" target="<?php echo $Target;?>"><?php echo $SubLinkTitle;?></a></li>
						<?php
						}
					?>	
                    	
                    <?php
					}
					?>
                    
                    
					
					    <div class="clear"></div>
                    </ul>
               	 </li>				
				<?php
				}
                 
			}
			function UpdateMyProfile()
			{
				$UpdateMyProfile="update tblsystemusers set RefreshTime='".$this->GetRefreshTime()."',Telephone='".$this->GetTelephone()."',Mobile='".$this->GetMobile()."',Fax='".$this->GetFax()."',Email='".$this->GetEmail()."',ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."',AccessDashboard_FloorView='".$this->GetAccessDashboard_FloorView()."',AccessDashboard_MessageCenter='".$this->GetAccessDashboard_MessageCenter()."',AccessDashboard_QuickView='".$this->GetAccessDashboard_QuickView()."',AccessDashboard_Reminders='".$this->GetAccessDashboard_Reminders()."',CounterID='".$this->GetCounterID()."',AccessDashboard_Notifications='".$this->GetAccessDashboard_Notifications()."',DB_BestPerformance='".$this->GetDB_BestPerformance()."',DB_LeastPerformance='".$this->GetDB_LeastPerformance()."',DB_ServiceAnalytics='".$this->GetDB_ServiceAnalytics()."',DB_ServiceStaffAnalytics='".$this->GetDB_ServiceStaffAnalytics()."',DB_Slabs='".$this->GetDB_Slabs()."',DB_PeakOffPeak='".$this->GetDB_PeakOffPeak()."',DB_DeptAnalytics='".$this->GetDB_DeptAnalytics()."',DB_NPS='".$this->GetDB_NPS()."',DB_MyPerformance='".$this->GetDB_MyPerformance()."' where TableID=".$this->GetTableID();
				$this->query($UpdateMyProfile);
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			function checkQmanagerSession($sessionvalue)
			{
				if (($sessionvalue==false) || ($sessionvalue==''))
				{
					require_once('qmanagererror.php');
					exit;
				}else if (($_SESSION['CounterNumber']==false) || ($_SESSION['CounterNumber']==''))
				{
					require_once('qmanagererror.php');
					exit;
				}
			}
			
			function checkFloorManagerSession($sessionvalue)
			{
				if (($sessionvalue==false) || ($sessionvalue==''))
				{
					$ErrorMessage='Your session has timed out.<br /><a href="index.php" target="_blank">Click Here</a> to Login again<br />';
					require_once('floorviewmanagererror.php');
					exit;
				}else
				{
					$Permission=$this->GetFieldDataByID('AccessFloorViewManager','TableID',$_SESSION[APPLICATION_SESSION_USERID],'tblsystemusers');
					if($Permission==NO)
					{
						$ErrorMessage="You do not have the permission to access the Floow view Manager.<br>Please get in touch with the Administrator for more information.";
						require_once('floorviewmanagererror.php');
						exit;
					}
				}
			}
			
			function checkResolution()
			{
			?>
				<script language="javascript">
					if(screen.width<<?php echo MINIMUM_WIDTH;?>)
					{
						window.location="resolutionerror.php";
					}
					
				</script>
			<?php
			}
			
			
			function ValidateUserLogin_FVM()
			 {
			 			$ReturnArray['ResultFlag']="";
						$ReturnArray['ReturnMessage']="";
						$UserName=$this->GetUserName();
						$Password=md5(PREDEFINED_SALT_VALUE.md5($this->SystemUserPassword).PREDEFINED_SALT_VALUE);
						$GetUser="Select * from tblsystemusers where UserName='$UserName'";
						$this->query($GetUser);
						if ($this->num_rows()!=0)
						{
							while($this->next_Record())
							{
								if ($this->f('IsAccountactive')==ACCOUNTSTATUS_INACTIVE)
								{
									$resultset[] = array(
									"ResultFlag"=>ACCOUNTSTATUS_INACTIVE, 
									"ReturnMessage"=>APPLICATION_MESSAGE_ACCOUNTDISABLED
									);
			 					}else
								{
									$_SESSION[APPLICATION_SESSION_LOGIN]=true;
									$_SESSION['FullName']=$this->f('EnglishName');
									$_SESSION['DepartmentID']=$this->f('DepartmentID');
									$_SESSION['RoleID']=$this->f('RoleID');
									$_SESSION[APPLICATION_SESSION_USERID]=$this->f('TableID');
									$_SESSION['Boxes_0'] = $this->f('AccessDashboard_FloorView');
									$_SESSION['Boxes_1'] = $this->f('AccessDashboard_MessageCenter');
									$_SESSION['Boxes_2'] = $this->f('AccessDashboard_QuickView');
									$_SESSION['Boxes_3'] = $this->f('AccessDashboard_Reminders');
									$_SESSION['Boxes_4'] = $this->f('AccessDashboard_Notifications');
									$_SESSION['ModifyDashboard'] = $this->f('ModifyDashboard');
									if($this->f('LastLoginDateTime')=='')
									{
										$_SESSION['LastLoginDateTime'] = 'Never';
									}else
									{
										$_SESSION['LastLoginDateTime'] = $this->f('LastLoginDateTime');
									}
									//Updating Login Date/Time and IP Address
									$CurrentDateTime=$this->FormLoginTime();
									$CurrentIP=$_SERVER['REMOTE_ADDR'];
									$UpdateLoginDateTime="update tblsystemusers set LastLoginDateTime='$CurrentDateTime',LastLoginIP='$CurrentIP' where TableID=".$this->f('TableID');
									$this->query($UpdateLoginDateTime);
									$resultset[] = array(
									"ResultFlag"=>ACCOUNTSTATUS_ACTIVE, 
									"ReturnMessage"=>APPLICATION_MESSAGE_SUCCESSFULLOGIN,
									"DestinationUrl"=>'home.php'
									);
									$this->LoginCleanUpProcess();
								}
							}
							$GetConfiguration="select BranchID,MaxCounters,IsCentralLocation from tblsystemconfiguration where TableID=1";
							$this->setQuery($GetConfiguration);
							$RecordDataObject=$this->GetRecordDataObject();
							$_SESSION[APPLICATION_SESSION_BRANCHID]=$RecordDataObject['BranchID'];
							$_SESSION[APPLICATION_SESSION_CENTRALLOCATION]=$RecordDataObject['IsCentralLocation'];
						}
						else
						{
							$resultset[] = array(
							"ResultFlag"=>ACCOUNTSTATUS_INACTIVE, 
							"ReturnMessage"=>APPLICATION_MESSAGE_WRONGUSERLOGIN
							);
							$_SESSION['NameArray'][]=$this->GetUserName();
							foreach($_SESSION['NameArray'] as $Item)
							{
								if($Item==$this->GetUserName())
								{
									$CountFailedLogins=$CountFailedLogins+1;
								}
							}
							$MaxTries=$this->GetFieldDataByID('MaxTries','TableID',1,'tblsecurityconfiguration');
							if($MaxTries==$CountFailedLogins)
							{
								$FreezeUser="update tblsystemusers set IsAccountactive='".NO."',Remarks='Maximum Tries of Failed Login Attempts exceeded from ".$_SERVER['REMOTE_ADDR']." (Last Login Attempt : ".$this->GetStandardDateTime().")',ModificationDateTime='".$this->GetStandardDateTime()."' where UserName='".$this->GetUserName()."'";
								$this->query($FreezeUser);
								unset($_SESSION['NameArray']);
							}
						}
						return $resultset;
			 }
			 
			 function DirectAccessForbidden()
			 {
					if($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_X_REQUESTED_WITH'] == '')
					{
						$this->redirect("index.php");
					}	 
			 }
			 
			 function getbranchname()
			 {
			 	$GetBranchName="select Branch from tblbranches";
				$this->query($GetBranchName);
				while($this->next_Record())
				{
					return $this->f('Branch');
				}
			 }
			 function EditSystemUser_HO()
			{
				//Editing Password
				$CurrentUserDataObject=$this->FetchRecordByID($this->GetTableID(),'TableID','tblsystemusers');
				if($this->GetSystemUserPassword()!='')
				{
					$EnteredPassword=md5(PREDEFINED_SALT_VALUE.md5($this->GetSystemUserPassword()).PREDEFINED_SALT_VALUE);
					$EditPassword="update tblsystemusers set Password='$EnteredPassword' where TableID=".$this->GetTableID();
					$this->query($EditPassword);
					if($this->GetSendEmailNotification()==YES)
					{
						$Username=$this->GetFieldDatabyID('UserName','TableID',$this->GetTableID(),'tblsystemusers');
						$IsEmailNotificationsEnabled=$this->GetFieldDatabyID('IsEmailNotificationsEnabled','TableID',1,'tblsystemconfiguration');
						if($IsEmailNotificationsEnabled==YES)
						{
							$Administrator=$this->FormulateEmailAdministration();
							$Statement="Your password has been reset , The Following are the credentials : ";
							$MailMessage.='<html>
							<head>
							<meta http-equiv="Content-Language" content="en-us">
							<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
							<meta name="ProgId" content="FrontPage.Editor.Document">
							<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
							<title>Dear '.$this->GetEnglishName().'</title>
							</head>
							<body>
							<div>
							<font face="Arial" size="2">
							<div align="center">
							<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">
							<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear 
							'.$this->GetEnglishName().',</span></font></b></strong>
							</div>
							<div align="center">
							<p align="left" dir="ltr">'.$Statement.'</div>
							<p align="left" dir="ltr" width="100%">
							URL					:	http://'.$_SERVER['HTTP_HOST'].'
							</div>
							<p align="left" dir="ltr">Username				:	'.$Username.'</div>
							<p align="left" dir="ltr">Password				:	'.$this->GetSystemUserPassword().'</div>
							
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
							
							$Subject="RSI Queue Notification , Your password has been reset";
							$Message=$this->sendBySMTP(EMAILTYPE_EDITCREDENTAILS,$this->GetEmail(),$Subject,$MailMessage,EMAIL_FROMNAME,OUTSIDEEMAILPATH);
						}
				
					}
				}
				//Editing System User Permissions If role is updated
				if($this->GetRoleID()!=$CurrentUserDataObject['RoleID'])
				{
						//Deleting Existing Permission of the User
						$DeleteExistingUserPermissions="delete from tbluserpermissions where UserID=".$this->GetTableID();
						$this->query($DeleteExistingUserPermissions);
						//Getting Features and their Permissions
						$GetFeatures="select A.TableID,B.IsAllowed from tblsublinks A inner join tblmasterlinkpermissions B on A.MasterLinkID=B.MasterLinkID where B.RoleID=".$this->GetRoleID()." order by A.TableID";
						$this->query($GetFeatures);
						while($this->next_Record())
						{
							$Features[] = array(
							"FeatureID"=>$this->f("TableID"), 
							"IsAllowed"=>$this->f("IsAllowed")
							);
						}
						//Setting the User Permissions
						foreach($Features as $Feature)
						{
							$AddUserPermission="insert into tbluserpermissions(SubLinkID,ReadPermission,AddPermission,EditPermission,DeletePermission,UserID,CreatedBy,CreationDateTime) values($Feature[FeatureID],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],'".$this->GetTableID()."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
							$this->query($AddUserPermission);
						}
				}
				$EditSystemUser="update tblsystemusers set EnglishName='".$this->GetEnglishName()."',ArabicName='".$this->GetArabicName()."',IsMale='".$this->GetIsMale()."',Telephone='".$this->GetTelephone()."',Mobile='".$this->GetMobile()."',Fax='".$this->GetFax()."',Email='".$this->GetEmail()."',RoleID='".$this->GetRoleID()."',DepartmentID='".$this->GetDepartmentID()."',CounterID='".$this->GetCounterID()."',IsAccountactive='".$this->GetIsAccountactive()."',ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."',IsAgent='".$this->GetIsAgent()."',OutofTurnTickets='".$this->GetOutofTurnTickets()."',MissingTickets='".$this->GetMissingTickets()."',TransferToCounter='".$this->GetTransferToCounter()."',TransferToService='".$this->GetTransferToService()."',Remarks='".$this->GetRemarks()."',ShowReportingDashBoard='".$this->GetShowReportingDashBoard()."',AccessCompleteReports='".$this->GetAccessCompleteReports()."',AccessFloorViewManager='".$this->GetAccessFloorViewManager()."',AccessDashboard_FloorView='".$this->GetAccessDashboard_FloorView()."',AccessDashboard_MessageCenter='".$this->GetAccessDashboard_MessageCenter()."',AccessDashboard_QuickView='".$this->GetAccessDashboard_QuickView()."',AccessDashboard_Reminders='".$this->GetAccessDashboard_Reminders()."',AccessDashboard_Notifications='".$this->GetAccessDashboard_Notifications()."',ModifyDashboard='".$this->GetModifyDashboard()."',CanChangeCounter='".$this->GetCanChangeCounter()."' where TableID=".$this->GetTableID();
			
				$this->query($EditSystemUser);
				//Deleting Services
				$DeleteService="delete from tblagentservices where AgentID='".$this->GetTableID()."'";
				$this->query($DeleteService);
				//Adding Services
				if(count($this->GetServiceArray())!=0)
				{
					$ServiceArray=$this->GetServiceArray();
					$PriorityArray=$this->GetPriorityArray();
					for($Parser=0;$Parser<count($this->GetServiceArray());$Parser++)
					{
						$ExplodeObject=explode("-",$ServiceArray[$Parser]);
						$AddService="insert into tblagentservices(AgentID,ServiceID,Priority,CreatedBy,CreationDateTime) values('".$this->GetTableID()."','".$ExplodeObject[0]."','".$PriorityArray[$ExplodeObject[1]]."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($AddService);
					}
				}
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			function CheckUserRecords($Username)
			{
				$Query="select * from tblsystemusers where UserName='$Username'";
				$this->query($Query);
				return $this->num_rows();
			}
			
			
			function AddSystemUser_HO()
			{
				$object=$_REQUEST;
				$Password=md5(PREDEFINED_SALT_VALUE.md5($this->GetSystemUserPassword()).PREDEFINED_SALT_VALUE);
				$AddSystemUser="insert into tblsystemusers(UserName,Password,EnglishName,ArabicName,IsMale,Telephone,Mobile,Fax,Email,RoleID,BranchID,DepartmentID,CounterID,IsAgent,OutofTurnTickets,MissingTickets,TransferToCounter,TransferToService,CanChangeCounter,IsAccountactive,ShowReportingDashBoard,AccessCompleteReports,AccessFloorViewManager,AccessDashboard_FloorView,AccessDashboard_MessageCenter,AccessDashboard_QuickView,AccessDashboard_Reminders,AccessDashboard_Notifications,ModifyDashboard,Remarks,CreatedBy,CreationDateTime) values('".$this->GetUserName()."','".$Password."','".$this->GetEnglishName()."','".$this->GetArabicName()."','".$this->GetIsMale()."','".$this->GetTelephone()."','".$this->GetMobile()."','".$this->GetFax()."','".$this->GetEmail()."','".$this->GetRoleID()."','".$this->GetBranchID()."','".$this->GetDepartmentID()."','".$this->GetCounterID()."','".$this->GetIsAgent()."','".$this->GetOutofTurnTickets()."','".$this->GetMissingTickets()."','".$this->GetTransferToCounter()."','".$this->GetTransferToService()."','".$this->GetCanChangeCounter()."','".$this->GetIsAccountactive()."','".$this->GetShowReportingDashBoard()."','".$this->GetAccessCompleteReports()."','".$this->GetAccessFloorViewManager()."','".$this->GetAccessDashboard_FloorView()."','".$this->GetAccessDashboard_MessageCenter()."','".$this->GetAccessDashboard_QuickView()."','".$this->GetAccessDashboard_Reminders()."','".$this->GetAccessDashboard_Notifications()."','".$this->GetModifyDashboard()."','".$this->GetRemarks()."','".$this->GetCreatedBy()."','".$this->GetCreationDateTime()."')";
				$this->query($AddSystemUser);
				$GetMaxID="select max(TableID) as MaxID from tblsystemusers";
				$this->query($GetMaxID);
				while($this->next_Record())
				{
					$MaxID=$this->f('MaxID');
				}
				$this->setTableID($MaxID);
				//Getting Features and their Permissions
				$GetFeatures="select A.TableID,B.IsAllowed from tblsublinks A inner join tblmasterlinkpermissions B on A.MasterLinkID=B.MasterLinkID where B.RoleID=".$this->GetRoleID()." order by A.TableID";
				$this->query($GetFeatures);
				while($this->next_Record())
				{
					$Features[] = array(
					"FeatureID"=>$this->f("TableID"), 
					"IsAllowed"=>$this->f("IsAllowed")
					);
				}
				//Setting the User Permissions
				foreach($Features as $Feature)
				{
					$AddUserPermission="insert into tbluserpermissions(SubLinkID,ReadPermission,AddPermission,EditPermission,DeletePermission,UserID,CreatedBy,CreationDateTime) values($Feature[FeatureID],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],$Feature[IsAllowed],'".$this->GetTableID()."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
					$this->query($AddUserPermission);
				}
				//Adding Services
				if(count($this->GetServiceArray())!=0)
				{
					$ServiceArray=$this->GetServiceArray();
					$PriorityArray=$this->GetPriorityArray();
					for($Parser=0;$Parser<count($this->GetServiceArray());$Parser++)
					{
						$ExplodeObject=explode("-",$ServiceArray[$Parser]);
						$AddService="insert into tblagentservices(AgentID,ServiceID,Priority,CreatedBy,CreationDateTime) values('".$this->GetTableID()."','".$ExplodeObject[0]."','".$PriorityArray[$ExplodeObject[1]]."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($AddService);
					}
				}
				if($this->GetSendEmailNotification()==YES)
				{
					$IsEmailNotificationsEnabled=$this->GetFieldDatabyID('IsEmailNotificationsEnabled','TableID',1,'tblsystemconfiguration');
					if($IsEmailNotificationsEnabled==YES)
					{
						$Administrator=$this->FormulateEmailAdministration();
						$Statement="The Following are your account details for accessing RSI Queue System";
						$MailMessage.='<html>
						<head>
						<meta http-equiv="Content-Language" content="en-us">
						<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
						<meta name="ProgId" content="FrontPage.Editor.Document">
						<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
						<title>Dear '.$this->GetEnglishName().'</title>
						</head>
						<body>
						<div>
						<font face="Arial" size="2">
						<div align="center">
						<p align="left"><strong><b><font face="Tahoma" color="#993300" size="1">
						<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear 
						'.$this->GetEnglishName().',</span></font></b></strong>
						</div>
						<div align="center">
						<p align="left" dir="ltr">'.$Statement.'</div>
						<p align="left" dir="ltr" width="100%">
						URL					:	http://'.$_SERVER['HTTP_HOST'].'
						</div>
						<p align="left" dir="ltr">Username				:	'.$this->GetUserName().'</div>
						<p align="left" dir="ltr">Password				:	'.$this->GetSystemUserPassword().'</div>
						
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
						$Subject="RSI Queue User Account created";
						$Message=$this->sendBySMTP(EMAILTYPE_CREDENTAILS,$this->GetEmail(),$Subject,$MailMessage,EMAIL_FROMNAME,OUTSIDEEMAILPATH);
					}
				
				}
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
			}
			
			function DeleteSystemUser_HO()
			{
				$DeleteSystemUser="delete from tblsystemusers where TableID=".$this->GetTableID().";";
				$this->query($DeleteSystemUser);
			}
			
			function GetBranchNameForDisplay()
			{
				$GetBranchName="select TableID,Branch from tblbranches where IsActive=1 order by TableID limit 0,1";
				$this->query($GetBranchName);
				$this->next_Record();
				
				if($this->f('TableID')==HEADOFFICEBRANCHID)
				//if(1==2)
				{
					echo "Centralized Administration Suite";
				}else
				{
					//while($this->next_Record())
					//{
						return $this->f('Branch').'&nbsp;Queue System';
					//}
				}
			}
			 function getFormulateSecretkey()
			 {
			 	$GetBranchName="select TableID from tblbranches";
				$this->query($GetBranchName);
				while($this->next_Record())
				{
					$TableID=$this->f('TableID');
				}
				$Key=$TableID.$this->getcurrentdate();
				return $this->EncodeString($this->EncodeString($Key));
			 }
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			  function InsertQueries($TicketID,$ServicesArray)
			 {
			 	$Count = 0;
				$Sequence = 2;
				foreach($ServicesArray as $ServiceID)
				{
					$Count = $Count + 1;
					if($Count==1)
					{
						continue;
					}
					$InsertQuery = "insert into tblticketdetails(TicketID,ServiceID,Sequence,CreationDateTime) values('$TicketID','$ServiceID','$Sequence','".getcurrentdatetime()."')";
					$this->query($InsertQuery);
					$Sequence = $Sequence+1;
				}
				return 1;
			 }
			 
			 function PrintServiceNamesForTickets($TicketID,$Language)
			 {
			 		if($Language==LANGUAGE_ARABIC)
					{
						$FieldName = "ArabicService";
					}else
					{
						$FieldName = "EnglishService";
					}
			 		
					$GetServiceName = "select B.".$FieldName.",A.NextSequence from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TableID='$TicketID'";
					$this->query($GetServiceName);
					$this->next_Record();
					$ServiceName = $this->f($FieldName);
					if($this->f('NextSequence')!=0)
					{
						$GetServiceName = "select B.".$FieldName." from tblticketdetails A inner join tblservices B on A.ServiceID=B.TableID where A.TicketID='$TicketID'";
						$this->query($GetServiceName);
						
						while($this->next_Record())
						{
						   $ServiceName = $ServiceName.'<Br>';
						   $ServiceName = $ServiceName.$this->f($FieldName);
						}
					}
					echo $ServiceName;
			 }

			 function checkNewTicketCount($date,$ServiceID=0)
			{
					if($ServiceID==0)
					{
						$CheckCount="select * from tblticketcount where TicketDate='$date'";
						$this->query($CheckCount);
						if($this->num_rows()==0)
						{	
							$InsertRecord="insert into tblticketcount(Ticketdate,ServiceID,Count) values('".$date."',0,1)";
							$this->query($InsertRecord);
							return 0;
						}else
						{
							$this->next_Record();
							$CurrentCount = $this->f('Count');
							$UpdateCount = $CurrentCount+1;
							$UpdateRecord = "update tblticketcount set Count='$UpdateCount' where Ticketdate='".$date."'";
							$this->query($UpdateRecord);
							return $CurrentCount;
						}

					}else
					{
						$CheckCount="select * from tblticketcount where TicketDate='$date' and ServiceID='$ServiceID'";
						$this->query($CheckCount);
						if($this->num_rows()==0)
						{	
							$InsertRecord="insert into tblticketcount(Ticketdate,ServiceID,Count) values('".$date."',0,1)";
							$this->query($InsertRecord);
							return 0;
						}else
						{
							$this->next_Record();
							$CurrentCount = $this->f('Count');
							$UpdateCount = $CurrentCount+1;
							$UpdateRecord = "update tblticketcount set Count='$UpdateCount' where Ticketdate='".$date."'";
							$this->query($UpdateRecord);
							return $CurrentCount;
						}
					}
					
			}
			
			function SendSMStoWaitingCustomer($MobileNumber,$CountAway,$TicketNumber,$EnglishServiceName,$ArabicsServiceName,$LanguageID)
			{
				if($LanguageID==LANGUAGE_ENGLISH)
				{
					$Message=$this->GetFieldDataByID('CustomerSMSMessageFormatEng','TableID',1,'tblsmsconfiguration');
					$Message = str_replace("(ServiceName)",$EnglishServiceName,$Message);
				}else
				{
					$Message=$this->GetFieldDataByID('CustomerSMSMessageFormatAr','TableID',1,'tblsmsconfiguration');
					$Message = str_replace("(ServiceName)",$ArabicsServiceName,$Message);
				}	
					$Message = str_replace("(TicketNumber)",$TicketNumber,$Message);
					$Message = str_replace("(TokensAway)",$CountAway,$Message);
					//echo $Message.'<br>';
					$this->SendRakezSMS($MobileNumber,$Message,SMSTYPE_WAITINGVISITOR);
			}
			
			
			function GetAgentBreak($UserID)
			{
				$GetActiveBreak = "select * from tblagentbreaks where AgentID='$UserID' and IsActive=1";
			
				$this->query($GetActiveBreak);
				$BreakID = 0;
				while($this->next_Record())
				{
					return $this->f('TableID');
				}
				return $BreakID;
			}
			
			
	function AgentsBreakViolationNotification($AgentID)
	{
		$FromDate = date("Y").'/'.date("m").'/01';
		$ToDate = date("Y").'/'.date("m").'/'.date("d");
		
		//$MaxBreakinMins=$this->GetFieldDatabyID('MaxBreakinMins','TableID',1,'tblagentbreakconfigurations')*60;
		$Query = "select IF(TIMESTAMPDIFF(SECOND, A.BreakStartDateTime,IF(A.IsActive = 1, NOW(),A.BreakEndDateTime)) <= B.Duration*60, 0,1) as Violation from tblagentbreaks A inner join tblbreakreasons B on A.ReasonID=B.TableID where A.AgentID='$AgentID' and A.BreakDate>='$FromDate' and A.BreakDate<='$ToDate' Having Violation = 1";
	
		$this->query($Query);
		$ViolationCount = $this->num_rows();
		return $ViolationCount;
	}
			
			
			
			
	function AgentBreakViolationNotification($BreakID)
	{
		$BreakDataObject = $this->FetchRecordByID($BreakID,'TableID','tblagentbreaks');
		/******* Send Manager Violation *****************************************/
		$ManagerEscalation = $this->getFieldDataByID('ManagerEscalation','TableID',1,'tblagentbreakconfigurations');
		$GetUsers = "select B.Email,B.Mobile from tbluserpermissions A inner join tblsystemusers B on A.UserID=B.TableID where A.SubLinkID='75' and A.EditPermission=1";
		$GetUsers = "select B.Email,B.Mobile from tblsystemusers B  where B.IsFloorManager=1";
		
		
		
		$this->query($GetUsers);
		$ArrayCount = 0;
		while($this->next_Record())
		{
			$Email[$ArrayCount] = $this->f('Email');
			$Mobile[$ArrayCount] = $this->f('Mobile');
			$ArrayCount++;
		}
		
		for($LoopParser=0;$LoopParser<count($Mobile);$LoopParser++)
		{
			if(1==1)
			{
				if($ManagerEscalation==ESCALATIONTIME_EMAIL)
				{
					$this->SendAgentBreak_ManagementEmail($BreakDataObject,$Email[$LoopParser]);
				}else if($ManagerEscalation==ESCALATIONTIME_SMS)
				{
					
					$this->SendAgentBreak_ManagementSMS($BreakID,$Mobile[$LoopParser]);
				}else if($ManagerEscalation==ESCALATIONTIME_BOTH)
				{
					$this->SendAgentBreak_ManagementSMS($BreakID,$Mobile[$LoopParser]);
					$this->SendAgentBreak_ManagementEmail($BreakDataObject,$Email[$LoopParser]);
					
					
				}	
			}
		}
		/******* Send Manager Violation *****************************************/
		unset($Email);
		unset($Mobile);
		
		

		
		
		/******* Send Agent Violation *****************************************/
		$AgentEscalation = $this->getFieldDataByID('AgentEscalation','TableID',1,'tblagentbreakconfigurations');
		$GetUsers = "select A.Email,A.Mobile from tblsystemusers A where A.TableID='".$BreakDataObject['AgentID']."'";
		$this->query($GetUsers);
		$ArrayCount = 0;
		while($this->next_Record())
		{
			$Email[$ArrayCount] = $this->f('Email');
			$Mobile[$ArrayCount] = $this->f('Mobile');
			$ArrayCount++;
		}
		
		for($LoopParser=0;$LoopParser<count($Mobile);$LoopParser++)
		{
			if($AgentEscalation==ESCALATIONTIME_EMAIL)
			{
				$this->SendAgentBreak_AgenttEmail($BreakDataObject,$Email[$LoopParser]);
			}else if($AgentEscalation==ESCALATIONTIME_SMS)
			{
				
				$this->SendAgentBreak_AgentSMS($BreakID,$Mobile[$LoopParser]);
			}else if($AgentEscalation==ESCALATIONTIME_BOTH)
			{
				$this->SendAgentBreak_AgentSMS($BreakID,$Mobile[$LoopParser]);
				$this->SendAgentBreak_AgenttEmail($BreakDataObject,$Email[$LoopParser]);
				//$this->SendManagementEmail($CaseID,$CaseDataObject,$Email[$LoopParser]);
				//$this->SendManagementSMS($this->getFieldDataByID('EnglishService','TableID',$CaseDataObject['ServiceID'],'tblservices'),$this->getFieldDataByID('TicketNumber','TableID',$CaseDataObject['TicketID'],'tbltickets'),$CaseDataObject['CaseNumber'],$EscalationLevelArray[$CaseDataObject['EscalationLevel']],$Mobile[$LoopParser]);
			}	
		}
		
		/******* Send Agent Violation *****************************************/
	}
	
	function SendAgentBreak_ManagementSMS($BreakID,$MobileNumber)
	{
		$GetDetails = "select TimeDiff(A.BreakEndDateTime,A.BreakStartDateTime) as FinishedDuration,TimeDiff(now(),A.BreakStartDateTime) as CurrentDuration,B.EnglishName,C.CounterName,A.BreakStartDateTime,A.IsActive from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='$BreakID'";
		$this->query($GetDetails);
		while($this->next_Record())
		{
			$AgentName = $this->f('EnglishName');
			$CounterNumber = $this->f('CounterName');
			$BreakStartDateTime = $this->f('BreakStartDateTime');
			$Status = $this->f('IsActive');
			$FinishedDuration = $this->f('FinishedDuration');
			$CurrentDuration = $this->f('CurrentDuration');
		}
		if($Status==1)
		{
			$BreakDuration  = $CurrentDuration;
		}else
		{
			$BreakDuration  = $FinishedDuration;
		}
		$Message=$this->GetFieldDataByID('ManagerSMSFormat','TableID',1,'tblagentbreakconfigurations');
		$Message = str_replace("(AgentName)",$AgentName,$Message);
		$Message = str_replace("(CounterNumber)",$CounterNumber,$Message);
		$Message = str_replace("(BreakDuration)",$BreakDuration,$Message);
		
		$this->SendRakezSMS($MobileNumber,$Message,SMSTYPE_AGENTBREAK_MANAGER);
	}
	
	
	function SendAgentBreak_AgentSMS($BreakID,$MobileNumber)
	{
			$GetDetails = "select TimeDiff(A.BreakEndDateTime,A.BreakStartDateTime) as FinishedDuration,TimeDiff(now(),A.BreakStartDateTime) as CurrentDuration,B.EnglishName,C.CounterName,A.BreakStartDateTime,A.IsActive from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='$BreakID'";
		$this->query($GetDetails);
		while($this->next_Record())
		{
			$AgentName = $this->f('EnglishName');
			$CounterNumber = $this->f('CounterName');
			$BreakStartDateTime = $this->f('BreakStartDateTime');
			$Status = $this->f('IsActive');
			$FinishedDuration = $this->f('FinishedDuration');
			$CurrentDuration = $this->f('CurrentDuration');
		}
		if($Status==1)
		{
			$BreakDuration  = $CurrentDuration;
		}else
		{
			$BreakDuration  = $FinishedDuration;
		}
		
		
		
		$Message=$this->GetFieldDataByID('AgentSMSFormat','TableID',1,'tblagentbreakconfigurations');
		$Message = str_replace("(AgentName)",$AgentName,$Message);
		$Message = str_replace("(CounterNumber)",$CounterNumber,$Message);
		$Message = str_replace("(BreakDuration)",$BreakDuration,$Message);
		
		
		$this->SendRakezSMS($MobileNumber,$Message,SMSTYPE_AGENTBREAK_AGENT);
	}

	
	
	function SendAgentBreak_ManagementEmail($BreakDataObject,$Email)
	{
	
		$GetDetails = "select B.EnglishName,C.CounterName,A.BreakStartDateTime from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='".$BreakDataObject['TableID']."'";
		
		$GetDetails="select A.*,TimeDiff(A.BreakEndDateTime,A.BreakStartDateTime) as FinishedDuration,TimeDiff(now(),A.BreakStartDateTime) as CurrentDuration,B.EnglishName,C.CounterName,A.IsActive,A.BreakEndDateTime,A.AgentID from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='".$BreakDataObject['TableID']."'";
		
		$this->query($GetDetails);
		while($this->next_Record())
		{
			$AgentName = $this->f('EnglishName');
			$AgentID = $this->f('AgentID');
			$CounterNumber = $this->f('CounterName');
			$BreakStartDateTime = $this->f('BreakStartDateTime');
			
			if($this->f('IsActive')==1)
			{
				$BreakDuration = $this->f('CurrentDuration');
				$BreakEndDateTime = '-';
			}else
			{
				$BreakDuration = $this->f('FinishedDuration');
				$BreakEndDateTime = $this->PrintTime($this->f('BreakEndDateTime'));
			}
			
			
		}
	
		
		$Subject = "Alert:Break Time Violation";
		$Administrator=$this->FormulateEmailAdministration();
		$Statement="<b>Break violation incurred on ".$this->PrintReportDate($this->getcurrentdate())." for Service Staff: ".$AgentName.", Counter# ".$CounterNumber." : </b>";
		$BreakViolationCountStatement = "The total breaks violation count for this service staff for this month and until today is ".$this->AgentsBreakViolationNotification($AgentID);
		$MailMessage.='<html>
		<head>
		<meta http-equiv="Content-Language" content="en-us">
		<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
		<meta name="ProgId" content="FrontPage.Editor.Document">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<title>Dear Manager</title>
		</head>
		<body>
		<div>
		<font face="Arial" size="2">
		<div align="center">
		<p align="left"><strong><b>
		<span style="font-size: 16pt; color: #11afab; font-family: LinotypeDINNextLTProLightCondensed">Dear Manager,</span></b></strong>
		</div>
		<div align="center">
		<p align="left" dir="ltr" style="font-size: 14pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">'.$Statement.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Break Start Time		:	'.$this->PrintTime($BreakStartDateTime).'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Break End Time		:	'.$BreakEndDateTime.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Violation Duration	 	:	'.$BreakDuration.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">'.$BreakViolationCountStatement.'</div>
		<p class="MsoBodyText" style="line-height: 100%" align="justify">
		<hr>
		<font style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed"><strong>Regards,<br>
		<br>
		</strong></font><strong><b>
		<span style="font-size: 16pt;color:#11afab;font-family:LinotypeDINNextLTProLightCondensed">RSI Queue Management System Auto Notification<br>
		<span style="font-size: 16pt;color:#11afab;font-family:LinotypeDINNextLTProLightCondensed">'.$Administrator.'</span></font></b></strong></font></div>
		</span></div>
		</body>
		</html>';
	
	
		
		$Message=$this->sendBySMTP(EMAILTYPE_CASEMANAGEMENTNOTIFICATION,$Email,$Subject,$MailMessage,EMAIL_FROMNAME);
	}
	
	function SendAgentBreak_AgenttEmail($BreakDataObject,$Email)
	{
	
		$GetDetails = "select B.EnglishName,C.CounterName,A.BreakStartDateTime from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='".$BreakDataObject['TableID']."'";
		
		$GetDetails="select A.*,TimeDiff(A.BreakEndDateTime,A.BreakStartDateTime) as FinishedDuration,TimeDiff(now(),A.BreakStartDateTime) as CurrentDuration,B.EnglishName,C.CounterName,A.IsActive,A.BreakEndDateTime,A.AgentID from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='".$BreakDataObject['TableID']."'";
		
		$this->query($GetDetails);
		while($this->next_Record())
		{
			$AgentName = $this->f('EnglishName');
			$CounterNumber = $this->f('CounterName');
			$AgentID = $this->f('AgentID');
			$BreakStartDateTime = $this->f('BreakStartDateTime');
			if($this->f('IsActive')==1)
			{
				$BreakDuration = $this->f('CurrentDuration');
				$BreakEndDateTime = '-';
			}else
			{
				$BreakDuration = $this->f('FinishedDuration');
				$BreakEndDateTime = $this->PrintTime($this->f('BreakEndDateTime'));
			}
			
			
		}
	
		$Subject = "Alert:Break Time Violation";
		$Administrator=$this->FormulateEmailAdministration();
		$Statement="<b>Break violation incurred on ".$this->PrintReportDate($this->getcurrentdate())." for Service Staff: ".$AgentName.", Counter# ".$CounterNumber." : </b>";
		$BreakViolationCountStatement = "Your total break violation count for this month and until today is ".$this->AgentsBreakViolationNotification($AgentID);
		
		
		$MailMessage.='<html>
		<head>
		<meta http-equiv="Content-Language" content="en-us">
		<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
		<meta name="ProgId" content="FrontPage.Editor.Document">
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<title>Dear Service Staff</title>
		</head>
		<body>
		<div>
		<font face="Arial" size="2">
		<div align="center">
		<p align="left"><strong><b>
		<span style="font-size: 16pt; color: #11afab; font-family: LinotypeDINNextLTProLightCondensed">Dear Service Staff,</span></b></strong>
		</div>
		<div align="center">
		<p align="left" dir="ltr" style="font-size: 14pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">'.$Statement.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Break Start Time		:	'.$this->PrintTime($BreakStartDateTime).'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Break End Time		:	'.$BreakEndDateTime.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Violation Duration	 	:	'.$BreakDuration.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">'.$BreakViolationCountStatement.'</div>
		<p align="left" dir="ltr" style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed">Kindly adhere to break time policy!</div>
		<p class="MsoBodyText" style="line-height: 100%" align="justify">
		<hr>
		<font style="font-size: 13pt;color:#585858;font-family:LinotypeDINNextLTProLightCondensed"><strong>Regards,<br>
		<br>
		</strong></font><strong><b>
		<span style="font-size: 16pt;color:#11afab;font-family:LinotypeDINNextLTProLightCondensed">RSI Queue Management System Auto Notification<br>
		<span style="font-size: 16pt;color:#11afab;font-family:LinotypeDINNextLTProLightCondensed">'.$Administrator.'</span></font></b></strong></font></div>
		</span></div>
		</body>
		</html>';
	
		/*
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
		<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear Service Staff,</span></font></b></strong>
		</div>
		<div align="center">
		<p align="left" dir="ltr">'.$Statement.'</div>
		
		
		<p align="left" dir="ltr">Break Start Time		:	'.$this->PrintTime($BreakStartDateTime).'</div>
		<p align="left" dir="ltr">Break End Time		:	'.$BreakEndDateTime.'</div>
		<p align="left" dir="ltr">Violation Duration	 	:	'.$BreakDuration.'</div>
		<p align="left" dir="ltr">'.$BreakViolationCountStatement.'</div>
		<p align="left" dir="ltr">Kindly adhere to break time policy!</div>
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
		*/
		
		

	
		$Message=$this->sendBySMTP(EMAILTYPE_CASEMANAGEMENTNOTIFICATION,$Email,$Subject,$MailMessage,EMAIL_FROMNAME);
	}
	
	function EditAgentInformation()
	{
				$CurrentUserDataObject=$this->FetchRecordByID($this->GetTableID(),'TableID','tblsystemusers');
				$EditSystemUser="update tblsystemusers set CounterID='".$this->GetCounterID()."',ModifiedBy=".$this->GetModifiedBy().",ModificationDateTime='".$this->GetModificationDateTime()."',IsAgent='".$this->GetIsAgent()."',OutofTurnTickets='".$this->GetOutofTurnTickets()."',MissingTickets='".$this->GetMissingTickets()."',TransferToCounter='".$this->GetTransferToCounter()."',TransferToService='".$this->GetTransferToService()."',CanChangeCounter='".$this->GetCanChangeCounter()."',AllowBreak='".$this->GetAllowBreak()."',BreakTime='".$this->GetDuration()."' where TableID=".$this->GetTableID();
				$this->query($EditSystemUser);
				//Deleting Services
				$DeleteService="delete from tblagentservices where AgentID='".$this->GetTableID()."'";
				$this->query($DeleteService);
				//Adding Services
				if(count($this->GetServiceArray())!=0)
				{
					$ServiceArray=$this->GetServiceArray();
					$PriorityArray=$this->GetPriorityArray();
					for($Parser=0;$Parser<count($this->GetServiceArray());$Parser++)
					{
						$ExplodeObject=explode("-",$ServiceArray[$Parser]);
						$AddService="insert into tblagentservices(AgentID,ServiceID,Priority,CreatedBy,CreationDateTime) values('".$this->GetTableID()."','".$ExplodeObject[0]."','".$PriorityArray[$ExplodeObject[1]]."',".$this->GetCreatedBy().",'".$this->GetCreationDateTime()."')";
						$this->query($AddService);
					}
				}
				$this->showMessage($this->GetCompletionMessage());
				$this->redirect($this->GetDestinationPage(),0);
	}

	function AgentResumeBreakViolationNotification($BreakID)
	{
		$BreakDataObject = $this->FetchRecordByID($BreakID,'TableID','tblagentbreaks');
		/******* Send Manager Violation *****************************************/
		$ManagerEscalation = $this->getFieldDataByID('ManagerEscalation','TableID',1,'tblagentbreakconfigurations');
		//$GetUsers = "select B.Email,B.Mobile from tbluserpermissions A inner join tblsystemusers B on A.UserID=B.TableID where A.SubLinkID='75' and A.EditPermission=1";
		$GetUsers = "select B.Email,B.Mobile from tblsystemusers B  where IsFloorManager=1";
		
		$this->query($GetUsers);
		$ArrayCount = 0;
		while($this->next_Record())
		{
			$Email[$ArrayCount] = $this->f('Email');
			$Mobile[$ArrayCount] = $this->f('Mobile');
			$ArrayCount++;
		}
		
		
		for($LoopParser=0;$LoopParser<count($Mobile);$LoopParser++)
		{
			if($ManagerEscalation==ESCALATIONTIME_EMAIL)
			{
				$this->SendAgentBreakResuming_ManagementEmail($BreakDataObject,$Email[$LoopParser]);
			}else if($ManagerEscalation==ESCALATIONTIME_SMS)
			{
				
				$this->SendAgentBreak_ManagementSMS($BreakID,$Mobile[$LoopParser]);
			}else if($ManagerEscalation==ESCALATIONTIME_BOTH)
			{
				$this->SendAgentBreak_ManagementSMS($BreakID,$Mobile[$LoopParser]);
				$this->SendAgentBreakResuming_ManagementEmail($BreakDataObject,$Email[$LoopParser]);
			
			}	
		}
		/******* Send Manager Violation *****************************************/
	}
			
			
	function SendAgentBreakResuming_ManagementEmail($BreakDataObject,$Email)
	{
	
		$GetDetails = "select B.EnglishName,C.CounterName,A.BreakStartDateTime from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='".$BreakDataObject['TableID']."'";
		
		$GetDetails="select A.*,TimeDiff(A.BreakEndDateTime,A.BreakStartDateTime) as FinishedDuration,TimeDiff(now(),A.BreakStartDateTime) as CurrentDuration,B.EnglishName,C.CounterName,A.IsActive from tblagentbreaks A inner join tblsystemusers B on A.AgentID=B.TableID inner join tblcounters C on B.CounterID=C.TableID where A.TableID='".$BreakDataObject['TableID']."'";
		
		$this->query($GetDetails);
		while($this->next_Record())
		{
			$AgentName = $this->f('EnglishName');
			$CounterNumber = $this->f('CounterName');
			$BreakStartDateTime = $this->f('BreakStartDateTime');
			if($this->f('IsActive')==1)
			{
				$BreakDuration = $this->f('CurrentDuration');
			}else
			{
				$BreakDuration = $this->f('FinishedDuration');
			}
			
			
		}
		$Subject = "RSI Queue Notification : Agent Break Violation";
		$Administrator=$this->FormulateEmailAdministration();
		$Statement="<b>The Following is the detail of an agent break violation and the agent has resumed the break now :  </b>";
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
		<span style="font-size: 8pt; color: #993300; font-family: Tahoma">Dear Recipient,</span></font></b></strong>
		</div>
		<div align="center">
		<p align="left" dir="ltr">'.$Statement.'</div>
		
		<p align="left" dir="ltr">Agent 				:	'.$AgentName.'</div>
		<p align="left" dir="ltr">Counter Number		:	'.$CounterNumber.'</div>
		<p align="left" dir="ltr">Break Start Time		:	'.$this->PrintDateTime_New($BreakStartDateTime).'</div>
		<p align="left" dir="ltr">Break Duration	 	:	'.$BreakDuration.'</div>
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
		$Message=$this->sendBySMTP(EMAILTYPE_CASEMANAGEMENTNOTIFICATION,$Email,$Subject,$MailMessage,EMAIL_FROMNAME,"phpmailer/class.phpmailer.php");
	}
	
	function GetTimeID($Time)
	{
		$ReturnID = 0;
		$GetTimeID = "select TableID from tbltimedurations where TimeDuration='$Time'";
	
		$this->query($GetTimeID);
		while($this->next_Record())
		{
			return $this->f('TableID');
		}
		return $ReturnID;
	}
	
	
	function WorkOutPriority($AHBCustomer,$CustomerType,$PriorityType)
			{
				if($AHBCustomer==0)
				{
					return PRIORITY_CUSTOMERTYPE_AHB_MASS;
				}else if($AHBCustomer==1)
				{
					if($CustomerType==1)
					{
						return PRIORITY_CUSTOMERTYPE_AHB_MASS;
					}else if($CustomerType==2)
					{
						return PRIORITY_CUSTOMERTYPE_AHB_LADIES;
						if($_SESSION['Allowed']==true)
						{
							return PRIORITY_CUSTOMERTYPE_AHB_LADIES;
						}else
						{
							return PRIORITY_CUSTOMERTYPE_AHB_MASS;
						}
					}else if($CustomerType==3)
					{
						return PRIORITY_CUSTOMERTYPE_AHB_PRESTIGE;
					}
				}
			}
			
			
			
	
		function WorkOutNewNumbering($AHBCustomer,$CustomerType,$ServiceType)
			{
				if($AHBCustomer==0)
				{
					//$CheckCount="select count(A.TableID) from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketDate='".$this->getcurrentdate()."' and A.IsAHBCustomer='".$AHBCustomer."' and B.ServiceType='".$ServiceType."'";
					$CheckCount="select count(A.TableID) from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketDate='".$this->getcurrentdate()."' and A.CustomerType in (".CUSTOMERTYPE_NONAHB.",".CUSTOMERTYPE_AHB_MASS.") and B.ServiceType='".$ServiceType."'";

					$this->query($CheckCount);
					while($this->next_Record())
					{
						return $this->f(0);
					}
					
				}else if($AHBCustomer==1)
				{
					
					if($CustomerType==CUSTOMERTYPE_AHB_MASS)
					{
						$CheckCount="select count(A.TableID) from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketDate='".$this->getcurrentdate()."' and A.CustomerType in (".CUSTOMERTYPE_NONAHB.",".CUSTOMERTYPE_AHB_MASS.") and B.ServiceType='".$ServiceType."'";
					}else
					{
					$CheckCount="select count(A.TableID) from tbltickets A inner join tblservices B on A.ServiceID=B.TableID where A.TicketDate='".$this->getcurrentdate()."' and A.IsAHBCustomer='".$AHBCustomer."' and B.ServiceType='".$ServiceType."' and A.CustomerType='$CustomerType'";
					}
					
					$this->query($CheckCount);
					while($this->next_Record())
					{
						return $this->f(0);
					}
				}
			}
			
			function getTransactionCount($TicketID,$Flag=0)
			{
				if($Flag==0)
				{
					$getTransactionCount = "select count(*) as Count from tblticketstransactions where TicketID='$TicketID' and TransactionStatus='".PROCESSED."'";
				}else
				{
					$getTransactionCount = "select count(*) as Count from tblticketstransactions where TicketID='$TicketID'";
				}
				$this->query($getTransactionCount);
				$this->next_Record();
				return $this->f('Count');
				
			}
			
			
			function CheckPasswordPolicy($Password,$IsNew,$UserID=0)
			{
				$Flag = $this->CheckPasswordStrength($Password);
				
				if($Flag==0)
				{
					return PASSWORD_COMPLEXPASSWORDMESSAGE;
				}
				
				$Flag = $this->CheckPasswordLength($Password);
			
				if($Flag==0)
				{
					return PASSWORD_COMPLEXMINLENGTHMESSAGE;
				}
				if($IsNew==0)
				{
					$Flag = $this->CheckLastPasswordHistories($Password,$UserID);
					if($Flag==0)
					{
						return PASSWORD_PASSWORDHISTORYMESSAGE;
					}
				}
				return 1;
			}
			
			
			function CheckPasswordLength($Password)
			{
				if(strlen($Password)>=PASSWORD_MINLENGTH)
				{
					return 1;
				}else
				{
					return 0;
				}
			}
			function CheckPasswordStrength($Password)
			{
				$uppercase = preg_match('@[A-Z]@', $Password);
				$lowercase = preg_match('@[a-z]@', $Password);
				$number    = preg_match('@[0-9]@', $Password);
			
				if(!$uppercase || !$lowercase || !$number ) 
				{
					return 0;
				}else
				{
					return 1;	
				}
			}
			
			function CheckLastPasswordHistories($Password,$UserID)
			{	
				$Password=md5(PREDEFINED_SALT_VALUE.md5($Password).PREDEFINED_SALT_VALUE);
				$CheckLastPasswordHistories = "select * from tblsystempasswords where Password='$Password' and UserID='$UserID' limit 0,".PASSWORD_HISTORY;
				$this->query($CheckLastPasswordHistories);
				if($this->num_rows()==0)
				{
					return 1;
				}else
				{
					return 0;
				}
			}
			
			
		
			function TimeHandling($Days)
			{
				$ToDate = $this->getcurrentdate();
				$FromDate =  date( "Y-m-d", strtotime( "$ToDate -$Days day"));
				$Query = "UPDATE tbltickets SET TicketDispensingTime_Reporting=STR_TO_DATE(TicketDispensingTime, '%d-%M-%Y %r') where TicketDate>='".$FromDate."' and TicketDate<='".$ToDate."'";
				$this->query($Query);
				$Query = "UPDATE tbltickets SET TicketingSurfingStartTime_Reporting=STR_TO_DATE(TicketingSurfingStartTime, '%d-%M-%Y %r') where TicketDate>='".$FromDate."' and TicketDate<='".$ToDate."'";
				$this->query($Query);
				$Query = "UPDATE tbltickets SET TicketingSurfingEndTime_Reporting=STR_TO_DATE(TicketingSurfingEndTime, '%d-%M-%Y %r') where TicketDate>='".$FromDate."' and TicketDate<='".$ToDate."'";
				$this->query($Query);
			}
			

			
			
	

	
	
}
?>

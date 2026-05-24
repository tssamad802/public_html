<?php
	session_start();
	require_once('classes/commonfunctions.php');
	 
	error_reporting(-1);
	SendMail("mali.shaikh87@gmail.com", "test", "test body","",""); 
	/*$SendEmailToUser="select * from tblemailsubmission where IsSend=0"; 
	$db->query($SendEmailToUser); 
	if($db->num_rows() > 0) 
	{
		while($db->next_Record())
		{  
			SendMailWithDatabse($db->f('MailSendTo'), $db->f('MailSubject'), $db->f('MailMessage'));
			$db1->query("UPDATE tblemailsubmission SET IsSend=1, SendDateTime=NOW() Where TableID =  '".$db->f('TableID')."'");
		}
	}*/
?>
 
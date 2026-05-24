<html>
<head>
  <meta http-equiv="refresh" content="10">
</head>
<body>
<?php
	session_start();
	require_once('classes/commonfunctions.php');
	
	$SendEmailToUser="select * from tblsendcomposeemail where IsSend=0"; 
	$db->query($SendEmailToUser); 
	if($db->num_rows() > 0) 
	{
		while($db->next_Record())
		{  
			SendMailWithDatabse($db->f('MailSendTo'), $db->f('MailSubject'), showFrontEndDescription($db->f('MailMessage')));
			$db1->query("UPDATE tblsendcomposeemail SET IsSend=1, SendDateTime=NOW() Where TableID =  '".$db->f('TableID')."'");
		}
	}
?>
</body>
</html>

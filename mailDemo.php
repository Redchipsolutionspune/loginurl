<?php
	// the message
	$msg = "First line of text\nSecond line of text";

	// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($msg,70);

	// send email
	$retval = mail("nilesh.p@redchipsolutions.com","My subject",$msg);
	if($retval==TRUE)
    {
      echo "Message sent successfully...";
    }
    else
    {
		echo "Message could not be sent...";
		print_r(error_get_last());
    }
?>
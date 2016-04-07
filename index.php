<?php	
		require_once('../../config.php'); 
		require_once($CFG->libdir.'/filelib.php');
		global $CFG,$PAGE,$DB,$USER;
		
		$name = isset($_GET['username'])?$_GET['username']:'';
		
		$qstr = $_SERVER["QUERY_STRING"];
		if($qstr!='')
		{
		    $pwdarray =  explode("&password=",$_SERVER["QUERY_STRING"]);
           	$password =	$pwdarray[1];	
		}
		else
		{
		    $password ='';
		}$urlstr = isset($_GET['urlstr'])?$_GET['urlstr']:'';
		$context = context_system::instance();        $PAGE->set_url("$CFG->httpswwwroot/blocks/loginurl/index.php?urlstr=$urlstr&username=$name&password=$password");        $PAGE->set_context($context);
		//$password = isset($_GET['password'])?$_GET['password']:'';
		//echo $name;
		//echo $password;
		
		
		//exit;
		$sqlForUserExitsOrNot = "select * from {user} where username='$name'";
		$result_sqlForUserExitsOrNot = $DB->get_record_sql($sqlForUserExitsOrNot);
		$dbusername = $result_sqlForUserExitsOrNot->username;
		$error=1;
		//print_r(isset($_GET['username']));
		
		if(isset($_GET['username']) &&  isset($_GET['password']))
		{
			
			if($name !='' && $password !='')
			{
				
				if($dbusername == $name)
				{
					if (isloggedin()) 
					{
						redirect($CFG->wwwroot."/".$urlstr);
					}
					else
					{
						if(isset($name) && isset($password) && $name !='' && $password !=''){
							$user = authenticate_user_login($name, $password);
							if(isset($user) && $user !='' && !empty($user))
							{
								if(complete_user_login($user))
								{	
								redirect($urlstr);														//header('location:http://www.redchipmoodle.in/moodle/course/view.php?id=4');                            //exit;
									//redirect("http://localhost/moodle/".$urlstr);
								} 
								else 
								{
									echo "Please <a href='login/index.php'>login</a>";
								}
							}
							else{
								$error=0;
							}
						}
					}
				}
				else
				{
					$error =0;
				}
			}
			else
			{
				
				$error =0;
			}
		}
		else
		{
			
			$error =2;
		}
		
		echo $OUTPUT->header();
?>
<?php if($error==0){
	
		redirect($CFG->wwwroot."/login/index.php?error=0");
	?>
	<?php } ?>
	
	
<?php if($error==2){
	
	?>
	 <div>
		<h5 style="color:red;text-align:center"> <?php echo "Parameters is not valid."; ?> </h5>
	</div> 
	<?php } ?>
	
<?php 	echo $OUTPUT->footer(); ?>
<?php
	require_once('../f/conf/db.db');
	require_once('../forum/SSI.php');
	require_once('../forum/smf_2_api.php');
	
	require_once('../forum/SSI.php');
	
	if ($context['user']['is_guest'])
		{
			echo '<h1>You are not logged into the TLO website, please log into the forums and then return here.';
		}
	else
		{
			
			$user = $user_info['name'];
			$bans = 'bans.txt';

			if (exec('grep '.escapeshellarg($user).' '.$bans))
				{
					echo '<script>alert("You Are Banned From This Service!");</script>';
				}
			else
				{
					$message = $_POST['shout'];
					//$message = 'Manual Submit';
					
					if (strpos($message, '@everyone') !== false)
						{
							echo '<script>alert("Use of the everyone tag is prohibited from this service");</script>';
						}
					else
						{
							
							$stmt = $db->prepare("INSERT INTO discord_general SET `user` = ?, `message` = ?");
							$stmt->bind_param('ss', $user, $message);
							$stmt->execute(); 
							$stmt->close();
							
							$msg = '[WEB] '.$user. ': '.$message;
					
							$file = 'webchat.txt';
					
							$current = file_get_contents($file);
					
							$current .= $msg;
					
							file_put_contents($file, $current);
						}
				}
			
		}
	
?>

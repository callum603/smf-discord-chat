<?php
	// You can change this how you see fit, this page will serve as a very basic moderation tool for the web shoutbox
	
	require_once('../forum/SSI.php');
	require_once('../forum/smf_2_api.php');
	require_once('db.db');
	
	// Change the below line with the group ID numbers you wish to be able to access the moderation tools.  The array should be formatted like so: 1, 2, 3
	$allowed_groups = array(1);
	$can_see = FALSE;
	foreach ($allowed_groups as $allowed)
	if (in_array($allowed, $user_info['groups']))
		{
			$can_see = TRUE;
			break;
		}
	if ($can_see)
		{
			$action = $_GET['action'];
			$id = $_GET['id'];
			
			if ($action == 'hide')
				{
					$hidden = '1';
					$stmt = $db->prepare("UPDATE discord_general SET `hidden` = ? WHERE `id`='$id'");
					$stmt->bind_param('i', $hidden);
					$stmt->execute(); 
					$stmt->close();
					
					echo '<h3>Action complete</h3>';
				}
			else
				{
					$sql = ("SELECT * FROM `discord_general` WHERE `id`='$id'");
					if(!$result = $db->query($sql)){
						die('There was an error running the query [' . $db->error . ']');
					}
					
					$row = $result->fetch_assoc();
					echo '<tr style="vertical-align:top;width:100%;"><td style="white-space: nowrap"><b>['.$row['ftimestamp']. '] '.$row['user']. ':</b> </td><td style="width:100%;"> '.$line. '</td></tr>';
					echo '<h3><a href="moderation.php?id='.$id. '&action=hide">Hide message from chat</a></h3>';
				}
		}
	else
		{
			header ('Location: /index.php');
		}
		
?>
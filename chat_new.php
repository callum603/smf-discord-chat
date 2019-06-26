<?php
	require_once('../forum/SSI.php');
	require_once('../f/conf/db.db');
	
	if ($context['user']['is_guest'])
		{
			echo '<h1>You are not logged into the TLO website, please log into the forums and then return here.';
		}
	else
		{
			echo '<table style="border:none;">';
			$sql = ("SELECT *, DATE_FORMAT(timestamp,'%d-%m-%Y %H:%i') AS ftimestamp FROM (SELECT * FROM `discord_general` WHERE hidden = '0' ORDER BY `id` DESC LIMIT 50) sub ORDER BY `id` ASC");
			if(!$result = $db->query($sql)){
				die('There was an error running the query [' . $db->error . ']');
			}
			
			while ($row=$result->fetch_assoc())
				{
					$line = $row['message'];
					$length = 7;
					$string = 'http://';
					if (strstr($line, 'http://') !== false)
						{
							$links = array();
							foreach (explode(' ', $line) as $w)
								if (substr($w, 0, $length) == $string)
									$links[] = '<a href="'.$w. '" target="_blank">'.$w. '</a>';
								else
									$links[] = $w;
							$line = implode(' ', $links);
						}
					
					$string = 'https://';
					$length = 8;	
					if (strstr($line, 'https://') !== false)
						{			
							$links = array();
							foreach (explode(' ', $line) as $w)
								if (substr($w, 0, $length) == $string)
									$links[] = '<a href="'.$w. '" target="_blank">'.$w. '</a>';
								else
									$links[] = $w;
							$line = implode(' ', $links);
						}
					$profanity = array("shit", "Shit", "fuck", "Fuck", "cunt", "Cunt", "bastard", "Bastard", "SHIT", "FUCK", "CUNT", "BASTARD", "FUCKING", "fucking", "Fucking");
					foreach ($profanity as $filter)
						{
							$line = str_replace($filter,"****",$line);
						}
					echo '<tr style="vertical-align:top;width:100%;"><td style="white-space: nowrap"><b>['.$row['ftimestamp']. '] '.$row['user']. ':</b> </td><td style="width:100%;"> '.$line. '</td></tr>';
				}
				echo '</table>';
		}
?>

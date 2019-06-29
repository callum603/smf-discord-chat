# smf-discord-chat
Simple chat bot to sync SMF shoutbox and a Discord channel

This bot will sync messages sent between the web based shoutbox and a channel on your Discord server.  The web based shoutbox can function without the bot, meaning you have a backup web chat in the event Discord goes down.

The web based chat uses permission groups from SMF which you will need to confiure as outlined below.


# INSTALLATION

Before installation you will require the following to be installed on your server.
Python 3
PIP
Screen

1)	Install the discord.py API
	`python3 -m pip install -U discord.py`
	
2)	Add this file to your root SMF forum directory - https://github.com/AnthonyCalandra/SMF-Modifications/blob/master/WHMCS-SMFIntegration/smf_2_api.php

3)	Open the file db.db and update 'user', 'pass', and 'database' with your database details

4)	Import the file sql.sql from the install folder to your database

5)	Open the file bot.py from the scripts folder and update the database details on line 32
	
6)	Open chat.php and update the first 2 lines to point to your SMF forum
	Update line 53 with your SMF member group ID's that you wish to be able to access the moderation tools
	Update line 63 with the correct path to the moderation.php file on your site

7)	Open the index.php file and update all the example.com lines with your URL and path to the files

8)	Open the moderation.php file and update lines 4 & 5 to point to your SMF forum

9)	Open the processmsg.php file and update lines 3 & 4 to point to your SMF forum

10) Follow the instructions here (https://discordpy.readthedocs.io/en/latest/discord.html) to create an application, get your bot token, and add your bot to your server

11) Copy the bot token and paste it into line 106 of bot.py.
	`client.run("YOUR BOT TOKEN HERE")`
	
12) SSH into your server as the user you wish to run the bot as and navigate to where the bot scripts are located, start the bot `python3 bot.py`. You are now ready to invite your bot to your server and begin syncing messages
	You can embed this chat box on your forum by editting the index.template.php file in your SMF forums theme folder and adding the following lines to where you would like your chat to appear
	`if ($context['user']['is_guest'])
		{
		}
	else
		{
			include('../discord/index.php');
		}`
	Updating the include line to ensure it points to where you have uploaded that file.
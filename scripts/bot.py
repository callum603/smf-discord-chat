# coding=utf-8

import discord
import asyncio
import os
import codecs
import string
import mysql.connector

client = discord.Client()
strings = ("//DO NOT REMOVE//")
version = '1.0'
channel_general = 'general'
channel = discord.Object(id='396360374535847940')

@client.event
async def on_ready():
	print('Logged in as')
	print(client.user.name)
	print(client.user.id)

	print('------')
	await client.change_presence(game=discord.Game(name='Syncing your chat...'))

@client.event
async def on_message(message):
	general_channel = str(message.channel)	
	if general_channel == 'general':
		general_author = str(message.author)
		general_author = general_author.split("#",4)[0]
		
		if general_author != client.user.name:
			general_connection = mysql.connector.connect(host='localhost',database='database',user='user',password='pass')
			cursor = general_connection.cursor(prepared=True)
			general_insert = """ INSERT INTO `discord_general` (`user`, `message`) VALUES (%s,%s)"""
			general_msg = message.content
			if general_msg.find("<@") == -1:
				general_msg = html.escape(str(message.content))
			else:
				try:
					msrch = msg.count('<@')
					while msrch > 0:
						id_start = general_msg.find('<@') + 2
						id_end = general_msg.find('>', id_start)
						id_got = general_msg[id_start:id_end]
						id_cgot = id_got
						if "!" in id_got:
							id_cgot = id_got.replace("!","")
						id_name = ""
						id_name = await client.get_user_info(id_cgot)
						id_name = str(id_name)
						id_name = id_name.split("#",4)[0]
						id_name = "@" + str(id_name)
						id_replace = "<@" + str(id_got) + ">"
						general_msg = general_msg.replace(id_replace, id_name)
						msrch = msrch - 1
						if msrch == 0:
							general_msg = html.escape(str(msg))
				except Exception as ex2:
					general_msg = html.escape(str(message.content))
			general_insert_tuple = (general_author, general_msg)
			general_result = cursor.execute(general_insert, general_insert_tuple)
			general_connection.commit()
			#closing database connection.
			if(general_connection.is_connected()):
				cursor.close()
				general_connection.close()
				
	if message.content.startswith('!ban'):
		author = message.author
		if "cabinet" in [y.name.lower() for y in author.roles]:
			var = message.content
			split_list = var.split(' ')
			var1 = split_list[0]
			var2 = split_list[1]
			with codecs.open('bans.txt','a', encoding='utf8') as file:
				file.write(var2 + '\n')
			await client.send_message(message.channel, 'The Ban Has Successfuly Been Applied! ' + var2 + ' Has Been Banned From The Web Client!')
		elif "president" in [y.name.lower() for y in author.roles]:
			var = message.content
			split_list = var.split(' ')
			var1 = split_list[0]
			var2 = split_list[1]
			with codecs.open('bans.txt','a', encoding='utf8') as file:
				file.write(var2 + '\n')
			await client.send_message(message.channel, 'The Ban Has Successfuly Been Applied! ' + var2 + ' Has Been Banned From The Web Client For!')
		else:
			await client.send_message(message.channel, ':eyes: That will never happen, now please leave me alone...or I will ban you instead')
	elif message.content.startswith('!'):
		await client.send_message(message.channel, message.author.mention + ' 404 Command Not Found.')
				
async def sendmessage():
	await client.wait_until_ready()
	while True:
		webchat = "webchat.txt"
		if os.path.getsize(webchat) > 0:
			f = open('webchat.txt','r',encoding="utf-8")
			for line in f:
				await client.send_message(channel, line)
			f.close()
			f1 = open('webchat.txt','w')
			f1.close()
		await asyncio.sleep(1)


client.loop.create_task(sendmessage())
client.run("")

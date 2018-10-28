import time, os

while (1):
	log = open("KillLog.txt","r").read().split('\n')
	newlog = ""
	
	for line in log:
		line = line.split(' ')
		if (len(line) == 2):
			print (line[1] + " " + str(time.time()))
			if (int(line[1]) < int (time.time())):
				try:
					os.remove("file/" + line[0])
				except:
					pass
			else:
				newlog += ' '.join(line) + '\n'
	
	open("KillLog.txt", "w").write(newlog)
	time.sleep(60)
import pyfirmata
import os
import requests
import time
import subprocess
from pywinauto.application import Application

# se passa abbastanza tempo senza far nulla, si fa partire un video completamente nero che fa da screensaver

# Arduino init
port = 'COM7'
board = pyfirmata.Arduino(port)
it = pyfirmata.util.Iterator(board)
it.start()

# init vari
# si fanno partire VLC e Firefox



#pins
ledPin = 13
sensorPin = board.get_pin('d:4:i')

# variables
val = False

# occhio, aggiungere interfaccia web per VLC e usare Firefox Beta (ha kiosk mode)
vlc = subprocess.Popen(['vlc.exe', '-f', '--start-paused', '--extraintf', 'http', '--intf', 'wx', 'C:\\Users\\Usuario\\Videos\\GreenScreenFireFootage[1].mp4'], executable="C:\\Program Files\\VideoLAN\\VLC\\vlc.exe", shell=False)
firefox = None
# bisogna aspettare che si inizializzi il sensore
#time.sleep(65)

while True:
    val = sensorPin.read()
    print(val)

    if val:
        board.digital[ledPin].write(1)
        requests.get('http://127.0.0.1:8080/requests/status.xml?command=pl_stop')
        if firefox == None:
            firefox = Application().start("C:\\Program Files\\Mozilla Firefox\\firefox.exe")
            #firefox = subprocess.Popen(['firefox.exe', 'www.google.it', '--kiosk'], executable='C:\\Program Files\\Mozilla Firefox\\firefox.exe', shell=False)
    else:
        board.digital[ledPin].write(0)
        if firefox != None:
            firefox.close()
        requests.get('http://127.0.0.1:8080/requests/status.xml?command=pl_play')
    time.sleep(2)
board.exit()
import pyfirmata
from enum import Enum
import os
import requests
import time
import subprocess

class State(Enum):
    SCREENSAVER = 1
    VIDEO = 2
    LIGHTS = 3

currentState = State.SCREENSAVER

# Arduino init
#port = 'COM7'
#board = pyfirmata.Arduino(port)
#it = pyfirmata.util.Iterator(board)
#it.start()

# init vari
# si fanno partire VLC e Firefox
vlc = subprocess.Popen(["vlc", "-f", "--start-paused", "--extraintf", "http", "--http-host", "localhost", "--http-port", "9999", "/home/adminuc/Videos/NotizieallaBreaking Italy-dSPn2fsmbzQ.webm"])
firefox = subprocess.Popen(["firefox", "--kiosk", "www.google.it"])


time.sleep(5)
#pins
#ledPin = 13
#sensorPin = board.get_pin('d:4:i')

# variables
#val = False

# occhio, aggiungere interfaccia web per VLC e usare Firefox Beta (ha kiosk mode)
# bisogna aspettare che si inizializzi il sensore
#time.sleep(65)

while True:
    # si controlla se è il caso di cambiare stato

    if currentState == State.SCREENSAVER:
        print(vlc.pid)

        requests.get('http://localhost:9999/requests/status.xml?command=pl_play')

        # si piazza vlc di fronte a tutto
        os.system("xdotool windowactivate `xdotool search --pid " + vlc.pid + " | tail -1`")
        pass
    elif currentState == State.VIDEO:
        pass
    elif currentState == State.LIGHTS:
        os.system("xdotool windowactivate `xdotool search --pid " + firefox.pid + " | tail -1`")
        pass
    #val = sensorPin.read()
    #print(val)

    #if val:
    #    board.digital[ledPin].write(1)
    #    requests.get('http://127.0.0.1:8080/requests/status.xml?command=pl_stop')
    #    if firefox == None:
    #        Application().start("C:\\Program Files\\Mozilla Firefox\\firefox.exe --kiosk www.google.it")
    #        firefox = Desktop(backend="uia").MozillaFirefox
            #firefox = subprocess.Popen(['firefox.exe', 'www.google.it', '--kiosk'], executable='C:\\Program Files\\Mozilla Firefox\\firefox.exe', shell=False)
    #else:
    #    board.digital[ledPin].write(0)
    #    if firefox != None:
    #        firefox.minimize()
    #    requests.get('http://127.0.0.1:8080/requests/status.xml?command=pl_play')
    #time.sleep(2)
#board.exit()
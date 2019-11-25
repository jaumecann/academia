import pyfirmata
import threading
import usbrelay_py
from enum import Enum
import os
import requests
import time
import subprocess

# VLC va impostato per avere una istanza sola

class State(Enum):
    INIT = 0
    SCREENSAVER = 1
    VIDEO = 2
    LIGHTS = 3

currentState = State.INIT

# Arduino init
port = '/dev/ttyACM0'
board = pyfirmata.Arduino(port)
it = pyfirmata.util.Iterator(board)
it.start()

# init vari
relay = usbrelay_py.board_details()[0]
# si fanno partire VLC e Chrome
chrome = subprocess.Popen(["google-chrome", "--kiosk", "www.google.it"])


time.sleep(5)
#pins
ledPin = 13
sensorPin = board.get_pin('d:4:i')

# variables
disableSensor = False
playingScreensaver = False
chromeForeground = False
vlcForeground = False
vlc = None
# bisogna aspettare che si inizializzi il sensore

def manageRelay():
    relayActivated = False
    relayVal = False
    prevRelayVal = True
    usbrelay_py.board_control(relay[0], 1, 0)
    relayElapsedTime = 0.0
    while True:
        # qua se il sensore non rileva una persona inizia a contare 30 minuti, altrimenti li resetta
        relayVal = sensorPin.read()
        # si calcola il tempo
        if not relayVal and prevRelayVal:
            if not relayActivated:
                time.sleep(10)
            relayElapsedTime = 0.0
            relayStartTime = time.time()
            relayActivated = True
            usbrelay_py.board_control(relay[0], 1, 1)
        elif not relayVal and not prevRelayVal:
            relayElapsedTime += time.time() - relayStartTime
            relayStartTime = time.time()
        elif relayVal and not prevRelayVal:
            relayElapsedTime = 0.0
        print("Relay time: " + str(relayElapsedTime))
        prevRelayVal = relayVal
    
        if relayElapsedTime > 20:
            usbrelay_py.board_control(relay[0], 1, 0)
            relayActivated = False

relayThread = threading.Thread(target=manageRelay)
relayThread.start()

while True:
    # si controlla se è il caso di cambiare stato
    if currentState == State.INIT:
        elapsedTime = 0.0
        startTime = None
        prevVal = True
        val = False
        chromeForeground = False
        vlc = subprocess.Popen(["vlc", "-f", "--no-start-paused", "--no-osd", "--extraintf", "http", "--http-host", "localhost", "--http-port", "9999", "/home/adminuc/Videos/NotizieallaBreaking Italy-dSPn2fsmbzQ.webm"])
        time.sleep(3)
        print(vlc.pid)
        if not playingScreensaver:
            requests.get('http://localhost:9999/requests/status.xml?command=pl_play')
            requests.get('http://localhost:9999/requests/status.xml?command=pl_loop')
            playingScreensaver = True


        # si piazza vlc di fronte a tutto
        os.system("wmctrl -a 'VLC'")
        currentState = State.SCREENSAVER
    elif currentState == State.SCREENSAVER:
        # si controlla il sensore
        val = sensorPin.read()

        if val and not disableSensor:
            disableSensor = True
            currentState = State.VIDEO
            os.system("vlc -f --no-start-paused /home/adminuc/Videos/2.mkv")
            time.sleep(2)
            requests.get('http://localhost:9999/requests/status.xml?command=pl_play')
            playingScreensaver = False
            currentState = State.VIDEO
    elif currentState == State.VIDEO:
        time.sleep(10)
        currentState = State.LIGHTS
        pass
    elif currentState == State.LIGHTS:
        disableSensor = False
        if not chromeForeground:
            os.system("wmctrl -a 'Google Chrome'")
            chromeForeground = True
            usbrelay_py.board_control(relay[0],1,1)
        # qua se il sensore non rileva una persona inizia a contare 30 minuti, altrimenti li resetta
        val = sensorPin.read()
        # si calcola il tempo
        if not val and prevVal:
            elapsedTime = 0.0
            startTime = time.time()
        elif not val and not prevVal:
            elapsedTime += time.time() - startTime
            startTime = time.time()
        elif val and not prevVal:
            elapsedTime = 0.0
        print("Elapsed time: " + str(elapsedTime))
        prevVal = val
        
        if elapsedTime > 10:
            currentState = State.INIT

board.exit()
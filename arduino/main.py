import pyfirmata
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
# si fanno partire VLC e Chrome
chrome = subprocess.Popen(["google-chrome", "--kiosk", "www.google.it"])


time.sleep(5)
#pins
ledPin = 13
sensorPin = board.get_pin('d:4:i')

# variables
val = False
disableSensor = False
playing = False
chromeForeground = False
vlcForeground = False
vlc = None
# bisogna aspettare che si inizializzi il sensore
#time.sleep(65)

while True:
    # si controlla se è il caso di cambiare stato
    if currentState == State.INIT:
        vlc = subprocess.Popen(["vlc", "-f", "--no-start-paused", "--extraintf", "http", "--http-host", "localhost", "--http-port", "9999", "/home/adminuc/Videos/NotizieallaBreaking Italy-dSPn2fsmbzQ.webm"])
        time.sleep(3)
        print(vlc.pid)
        if not playing:
            requests.get('http://localhost:9999/requests/status.xml?command=pl_play')
            requests.get('http://localhost:9999/requests/status.xml?command=pl_loop')
            playing = True


        # si piazza vlc di fronte a tutto
        os.system("xdotool windowactivate `xdotool search --pid " + str(vlc.pid) + " | tail -1`")
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
            currentState = State.VIDEO
    elif currentState == State.VIDEO:
        time.sleep(10)
        currentState = State.LIGHTS
        pass
    elif currentState == State.LIGHTS:
        if not chromeForeground:
            os.system("wmctrl -a 'Google Chrome'")
            chromeForeground = True
        time.sleep(10)

board.exit()
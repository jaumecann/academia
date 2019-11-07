import pyfirmata
import os
import time
import random
import pyautogui

# se passa abbastanza tempo senza far nulla, si fa partire un video completamente nero che fa da screensaver

# Arduino init
port = 'COM7'
board = pyfirmata.Arduino(port)
it = pyfirmata.util.Iterator(board)
it.start()

# init vari


#pins
ledPin = 13
sensorPin = board.get_pin('d:4:i')

# variables
val = 0
motionState = False


# bisogna aspettare che si inizializzi il sensore
time.sleep(65)

while True:
    val = sensorPin.read()
    print(val)

    if val:
        board.digital[ledPin].write(1)
        os.system('cmd /c \" "C:\\Program Files\\VideoLAN\\VLC\\vlc.exe" --fullscreen "C:\\Users\\Usuario\\Videos\\GreenScreenFireFootage[1].mp4"')
        if motionState is False:
            motionState = True
    else:
        board.digital[ledPin].write(0)
        if motionState is True:
            motionState = False
    time.sleep(1)
board.exit()
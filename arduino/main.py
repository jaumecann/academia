import pyfirmata
import os
import time
import random
import pyautogui

# Arduino init
port = 'COM7'
board = pyfirmata.Arduino(port)
it = pyfirmata.util.Iterator(board)
it.start()

# init vari
pyautogui.FAILSAFE = False

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
        pyautogui.press('enter')
        #os.system('cmd /c \" "C:\\Program Files\\VideoLAN\\VLC\\vlc.exe" --fullscreen "D:\\Wrestling\\Mosse che mi interessano\\2019-10-10 13-53-12.mkv"')
        if motionState is False:
            motionState = True
    else:
        board.digital[ledPin].write(0)
        if motionState is True:
            motionState = False
    time.sleep(1)
board.exit()
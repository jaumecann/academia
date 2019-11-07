/* Example code for HC-SR501 PIR motion sensor with Arduino. More info: www.makerguides.com */

// Define connection pins:
#define pirPin 2
#define ledPin 13

int val = 0;
bool motionState = false;

void setup() {
  pinMode(ledPin, OUTPUT);
  pinMode(pirPin, INPUT);
  Serial.begin(9600);
}

void loop() {
  val = digitalRead(pirPin);

  if (val == HIGH) {
    digitalWrite(ledPin, HIGH);
    
    if (motionState == false) {
      Serial.print(1);
      motionState = true;
    }
  } else {
    digitalWrite(ledPin, LOW);

    if (motionState == true) {
      Serial.print(0);
      motionState = false;
    }
  }
}

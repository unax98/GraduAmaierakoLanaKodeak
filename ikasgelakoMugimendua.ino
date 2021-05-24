//Liburutegiak
#include <WiFi.h>

//Konstanteak
const char* ssid = "Tech_D0005263";
const char* pasahitza = "BEEYDRET";
const char* host = "192.168.0.77";
const char portua = 80;
const unsigned char LED = 26;
const unsigned char PIR_SENTSOREA = 27;
const unsigned char ITXARON_DENBORA = 10;

//Aldagaiak
unsigned char kontagailua = 0;
unsigned long oraingoDenbora = millis();
unsigned long mugimenduaDenbora = 0;
boolean mugimenduaDetektatuDa = false;

//WiFi zerbitzaria izendatu
WiFiServer zerbitzaria(portua);

//Mugimendua detektatzen duen funtzioa
void IRAM_ATTR mugimenduaDetektatu() {
  Serial.println("MUGIMENDUA DETEKTATU DA!!!");
  digitalWrite(LED, HIGH);   
  mugimenduaDetektatuDa = true;
  mugimenduaDenbora = millis();
}

//Hasieraketak
void setup(){
  
  Serial.begin(115200);
  Serial.println("");

  //Pinak izendatu
  pinMode(LED, OUTPUT);
  pinMode(PIR_SENTSOREA, INPUT_PULLUP);
  
  digitalWrite(LED, LOW);
  
  //Sarera konektatu
  WiFi.begin(ssid, pasahitza);
  while (WiFi.status() != WL_CONNECTED && kontagailua < 50) { 
    kontagailua = kontagailua + 1;
    delay(500);
    Serial.print(".");
  }
  
  if (kontagailua < 50) {    
      Serial.println("");
      Serial.println("Sarera konektatu da.");
      Serial.println(WiFi.localIP());
      zerbitzaria.begin();
  }
  else { 
      Serial.println("");
      Serial.println("Errorea gertatu da, ez da sarera konektatu.");
  }

  //Etendura
  attachInterrupt(digitalPinToInterrupt(PIR_SENTSOREA), mugimenduaDetektatu, RISING);
  
}

//Programa nagusia
void loop(){
  
  oraingoDenbora = millis();
    
  //Itxaron denbora pasa ondoren, mugimendurik detektatzen ez bada, argia itzaliko da.
  if(mugimenduaDetektatuDa && (oraingoDenbora - mugimenduaDenbora > (ITXARON_DENBORA*1000))) {
    Serial.println("MUGIMENDUA GERATU DA!!!");
    digitalWrite(LED, LOW);     
    mugimenduaDetektatuDa = false; 
  }
  delay(1000);
  bidali();
}

void bidali(){
    WiFiClient client;
  
    if (!client.connect(host, portua)) {
      Serial.println("Arazoak konektatzerakoan");
      return;
    }

    String url = "/esp32/ikasgela.php?argia=";
    url += mugimenduaDetektatuDa;

    
    // Enviamos petición al servidor
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
}

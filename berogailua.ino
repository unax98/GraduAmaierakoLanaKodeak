#include <WiFi.h>
#include <WebServer.h>
#include "DHT.h"

#define DHTMOTA DHT11

//Konstanteak
const char* ssid = "Tech_D0005263";
const char* pasahitza = "BEEYDRET";
const char* host = "192.168.0.77";
const char portua = 80;
const int DHT_SENTSOREA = 25;
const int ERRELEA = 26;

//Aldagaiak
unsigned char kontagailua = 0;
float tenperatura;
float hezetasuna;
boolean balbula;

WebServer zerbitzaria(portua);

DHT dht(DHT_SENTSOREA, DHTMOTA);

void setup(){
  Serial.begin(115200);
  Serial.println("");

  pinMode(DHT_SENTSOREA, INPUT);
  pinMode(ERRELEA, OUTPUT);
  digitalWrite(ERRELEA, HIGH);

  dht.begin();
  
  //Sarera konektatu
  WiFi.begin(ssid, pasahitza);
  while (WiFi.status() != WL_CONNECTED && kontagailua < 50) { 
    kontagailua = kontagailua + 1;;
    delay(500);
    Serial.print(".");
  }
  if (kontagailua < 50) {      
      Serial.println("");
      Serial.println("Sarera konektatu da");
      Serial.println(WiFi.localIP());
      zerbitzaria.begin();
  }
  else { 
      Serial.println("");
      Serial.println("Errorea gertatu da, ez da sarera konektatu.");
  }
}

void loop(){

  tenperatura = dht.readTemperature();
  Serial.print("Tenperatura: ");
  Serial.println(tenperatura);
  hezetasuna = dht.readHumidity();
  Serial.print("Hezetasuna: ");
  Serial.println(hezetasuna);
  if(tenperatura >= 22.0){
    balbula = true;
    digitalWrite(ERRELEA, HIGH);
  }else{
    balbula = false;
    digitalWrite(ERRELEA, LOW);
  }
  bidali();
  delay(2000);
}

void bidali(){
    WiFiClient client;
  
    if (!client.connect(host, portua)) {
      Serial.println("Arazoak konektatzerakoan");
      return;
    }

    String url = "/esp32/berogailua.php?tenperatura=";
    url += tenperatura;
    url += "&hezetasuna=";
    url += hezetasuna;
    url += "&balbula=";
    url += balbula;
    
     client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
}

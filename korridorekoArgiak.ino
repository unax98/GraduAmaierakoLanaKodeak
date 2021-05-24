#include <WiFi.h>
#include <analogWrite.h>

//Konstanteak
const char* ssid = "Tech_D0005263";
const char* pasahitza = "BEEYDRET";
const char* host = "192.168.0.77";
const unsigned char portua = 80;
const unsigned char LDR_SENTSOREA = 34;
const unsigned char LED_TIRA = 25;

//Aldagaiak
unsigned char kontagailua = 0;
unsigned int ldrBalioa;
float tentsioa;
unsigned char argia;

WiFiServer zerbitzaria(portua);

void setup(){
  Serial.begin(115200);
  Serial.println("");

  pinMode(LED_TIRA, OUTPUT);

  //Sarera konektatu
  WiFi.begin(ssid, pasahitza);
  while (WiFi.status() != WL_CONNECTED && kontagailua < 50) { 
    kontagailua = kontagailua + 1;
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
      Serial.println("Errorea gertatu da, ez da sarera konektatu");
  }
}

void loop(){
 // read the input on analog pin 34:
  ldrBalioa = analogRead(LDR_SENTSOREA);
  // print out the value you read:
  Serial.print("Korridoreko sentsoreak jaso duen balio analogikoa: ");
  Serial.println(ldrBalioa);
  argia = map(ldrBalioa,0,4095,0,255);
  analogWrite(LED_TIRA, argia);
  tentsioa = ldrBalioa*(12.0/4095.0);
  Serial.print("Korridoreko argiek jaso behar duten tentsioa V-etan: ");
  Serial.println(tentsioa);
  bidali();
  delay(1000);  
  
}

void bidali(){
    WiFiClient client;
  
    if (!client.connect(host, portua)) {
      Serial.println("Arazoak konektatzerakoan");
      return;
    }

    String url = "/esp32/korridorea.php?ldrBalioa=";
    url += ldrBalioa;
    url += "&tentsioa=";
    url += tentsioa;
    
    // Enviamos petición al servidor
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
}

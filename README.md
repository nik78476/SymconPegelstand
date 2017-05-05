### IP-Symcon Modul Pegelstände

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang) 
2. [Systemanforderungen](#2-systemanforderungen)
3. [Installation](#3-installation)
4. [Befehlsreferenz](#4-befehlsreferenz)
5. [Changelog](#5-changelog) 


## 1. Funktionsumfang

Kleines Modul, dass den Pegelstand von Mess-Stationen von https://www.pegelonline.wsv.de/ ausliest
und als Variablen anzeigt. Die Stationen koennen hier ausgelesen werden:
https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/

In der Konfiguration muss dann der String in der Form
https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/<NAME DER STATION>/W/currentmeasurement.json
eingetragen werden. Beispiel für Deggendorf:
https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/DEGGENDORF/W/currentmeasurement.json


## 2. Systemanforderungen
- IP-Symcon ab Version 4.x


## 3. Installation
Über die Kern-Instanz "Module Control" folgende URL hinzufügen:

`https://github.com/nik78476/SymconPegelstand.git`

Die neue Instanz findet ihr dort, wo ihr sie angelegt habt.


## 4. Befehlsreferenz

keine Befehle

## 5. Changelog

v1.0 first release
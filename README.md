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
und als Variablen anzeigt. 


## 2. Systemanforderungen
- IP-Symcon ab Version 4.x


## 3. Installation
Über die Kern-Instanz "Module Control" folgende URL hinzufügen:

`https://github.com/nik78476/SymconPegelstand.git`

Die neue Instanz findet ihr dort, wo ihr sie angelegt habt.
Die Stationen koennen hier ausgelesen werden:
https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/

In der Konfigurationsform kann die jeweilige Mess-Station ausgewählt werden.
Defaultwert ist der Pegelstand in KONSTANZ.

[[https://github.com/nik78476/SymconPegelstand/blob/master/Screenshots/Pegelstand-moduleConfiguration.png|alt=Konfiguration]]

[[https://github.com/nik78476/SymconPegelstand/blob/master/Screenshots/Pegelstand-Instance.png|alt=Konfiguration]]

Pegelstand aktuell : Wert in cm
Tendenz : -1 fallend / 0 gleichbleibend / 1 steigend


## 4. Befehlsreferenz

keine Befehle

## 5. Changelog

v1.0 first release
v1.1 Auswahl Mess-Station über ComboBox
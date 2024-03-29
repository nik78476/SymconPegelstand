### IP-Symcon Modul Pegelstände

[![Version](https://img.shields.io/badge/Symcon_Version-4.x-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon_Version-5.0-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
![Version](https://img.shields.io/badge/Modul_Version-0.3-blue.svg)
![Version](https://img.shields.io/badge/Code-PHP-blue.svg)
[![License](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-green.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![StyleCI](https://github.styleci.io/repos/136796530/shield?branch=master)](https://github.styleci.io/repos/136796530)
## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang) 
2. [Systemanforderungen](#2-systemanforderungen)
3. [Installation](#3-installation)
4. [Befehlsreferenz](#4-befehlsreferenz)
5. [Changelog](#5-changelog) 


## 1. Funktionsumfang

Kleines Modul, welches den Pegelstand von Mess-Stationen von https://www.pegelonline.wsv.de/ ausliest
und als Variablen anzeigt. 


## 2. Systemanforderungen
- IP-Symcon ab Version 6.x++


## 3. Installation
Dieses Modul kann über den IPS Module Store bezogen werden oder
über die Kern-Instanz "Module Control" folgende URL hinzufügen:

`https://github.com/nik78476/SymconPegelstand.git`

Die neue Instanz findet ihr dort, wo ihr sie angelegt habt.
Die Stationen koennen hier ausgelesen werden:
https://www.pegelonline.wsv.de/webservices/rest-api/v2/stations/

In der Konfigurationsform kann die jeweilige Mess-Station ausgewählt werden
und der Intervall für die Aktualisierung eingerichtet werden.

Parameter | Beschreibung
------ | ---------------------------------
Intervall | Angaben in Millisekunden (Default: 14400)
Mess-Station | Auswahl der Mess-Station (Default: KONSTANZ))




Pegelstand aktuell : Wert in cm

Tendenz | Beschreibung
------ | ---------------------------------
-1     | fallend
0      | gleichbleibend
1      | steigend

Standardprofile für Pegelstand (PGL.Pegelstand) und Tendenz (PGL.Tendenz) sind hinterlegt.
Ab Version 1.6 wird die Tendenz durch Vergleich des Vorgängerwertes berechnet.


## 4. Befehlsreferenz

keine Befehle


## 5. Changelog

Version     | Datum      | Beschreibung
----------- | -----------| -------------------
1.1        | xx.xx.xxxx | Modulerstellung
1.2        | 30.07.2018 | Doku update
1.3        | 31.07.2018 | Debug-Variable
1.4        | 31.07.2018 | Aktualisierung der Vars für Pegeldaten
1.5        | 25.12.2019 | Bugfix, https://www.symcon.de/forum/threads/34768-Pegelstandsanzeige-Modul/page4#34
1.6        | 18.12.2022 | Bugfix, https://community.symcon.de/t/pegelstandsanzeige-modul/44140/45
1.7        | 13.01.2023 | div. kleine Bugfixes, beautifying ;-)



### 7. GUIDs

__Modul GUIDs__:

 Name       | GUID                                   | Bezeichnung  |
------------| -------------------------------------- | -------------|
Bibliothek  | {1BB853CC-67CE-41BC-801F-33359361D6CB} | Library GUID |
Modul       | {1BB853CC-67CE-41BC-801F-33359361D6CB} | Module GUID  |

### 8. Lizenz

[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/)

### 9. Author

Mike Fröhlich
https://github.com/nik78476

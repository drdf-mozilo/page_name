
⚠️ **Hinweis**: Dieses Plugin wird nicht mehr gepflegt!  
(Nov. 2017)

----

page_name - ein [moziloCMS](http://www.mozilo.de/) Plugin
================================

Beschreibung
------------

Ist eine im Text vorkommende Überschrift (z.B. `[ueber1|...]`) mit `=page_name` ausgezeichnet, wird die Überschrift auch als Name der Seite verwendet. Zum Beispiel im Menü oder auch in den Suchergebnissen.

Beispiel
--------

Inhalt der Seite `schoene-gaerten` in der Kategorie `schoene-gaerten`:

    [ueber1=page_name|schöne Gärten]

Bekannte Probleme
-----------------

- [ ] Fehlinterpretation bei verschachtelter Syntax ``[ueber1=page_name|... [fett|...] ...]``.
- [ ] Fehlerhafte Verarbeitung der `^`-Maskierung.
- [ ] Die Angabe von CMS-Variablen und Plugins `{...}` wird in den Seitennamen übernommen. Eine im späteren Programmablauf von mozilo stattfindende Ersetzung führt zu unerwarteten Ergebnissen.
- [ ] Zeilenumbrüche werden in den Seitennamen übernommen.

Lizenz
------

[MIT License](licence.txt)

Autor
-----

[David Ringsdorf](http://davidringsdorf.de)

<?php
/**
* Wylosuj odpowiednią ( opartą na zmiennej $GLOBALS['losowana_liczba_fiszek'] ) liczbę fiszek
* pokaż je i następnie zapamiętaj wylosowaną listę w sesji
*/
// jeśli nie wybrano kategorii, wróć do menu
if (empty($_POST['kat']))
{
	header('Location: menu.php');
	exit;
}

// sesja i funkcje biblioteczne
include("lib.php");

// nagłówek strony
readfile("header.html");


// Zapamiętaj listę wylosowanych fiszek w sesji
if (! isset($_SESSION['lista_fiszek'])) $_SESSION['lista_fiszek']=pobierz_fiszki();
// Pokaż wylosowany zestaw fiszek          
foreach ($_SESSION['lista_fiszek'] as $fiszka)
{
	print "<div class=\"ramka\">\n";
	print "<div class=\"slowo_en\">{$fiszka['word_en']}</div>\n";
	print "<hr class=\"kreska\"/>\n";
	print "<div class=\"slowo_pl\">{$fiszka['word_pl']}</div>\n";
	print "</div>\n";
}
print "<form method=\"POST\" action=\"fiszki_test.php\">";
print "<div class=\"srodek\">";
print "<input autofocus class=\"guzik\" type=\"submit\" value=\"przejdż do testu\">";
print "</div>";
print "</form>";
// dół strony
readfile("footer.html");
?>
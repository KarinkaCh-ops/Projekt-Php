<?php
/**
* funkcja pobiera dane z bazy na podstawie zapytania i patametrów
* i zwraca tablicę z wynikiem zapytania
* @param string $sql - zapytanie (parametry oznaczone :par )
* @param array $params - tablica parametrów - nazwy bez :
*
* @return array - tablica złożona z tablic, zawierająca wynik zapytania 
*                 (1 wiersz na każdy wiersz wyniku zapytania, 
*                  a w każdym wierszu tablica zawierająca pola)
*
*/

include("config.php");

function db_query ($sql, $params) 
{
	// pobierz konfigurację bazy
		$link="{$GLOBALS['db_type']}:host={$GLOBALS['db_host']};port={$GLOBALS['db_port']};dbname={$GLOBALS['db_name']};";
	
	// połącz z bazą
	$baza=new PDO($link, $GLOBALS['db_user'], $GLOBALS['db_password']);
	if(!$baza)
	{
		die("<h1>Połączenie z bazą nie powiodło się.</h1>");
	}	
	// przygotuj zapytanie i podłącz parametry	
	$zap=$baza->prepare($sql);
	
	foreach($params as $key=>$param)
	{
		$zap->bindValue(":$key", $param);
	}	
	
	// wykonaj zapytanie	
	$zap->execute();
	
	// pobierz wynik zapytania jako tablicę
	$wyn = $zap->fetchAll();
	
	// zwolnij wynik zapytania
	unset($zap);
	
	// zwolnij połączenie do bazy
	unset($baza);
	
	// zwróć tablicę z wynikiem zapytania
	return $wyn;
}

// inicjalizuj sesję
session_start();
	
// jeśli w sesji nie ma nazwy użytkownika, przejdź do logowania
if (empty($_SESSION["user"]) && ! $anonymous_page)
{
	header('Location: login.php');
	exit;
}

// jeśli strona wymaga uprawnień admina, a zalogowany użytkownik ich nie ma - przejdź do Menu
if (! empty($admin_page) && ! $_SESSION['is_admin'])
{
	header('Location: menu.php');
	exit;
}

// pokaż link wylogowania i powrotu do menu u góry każdej strony z wyjątkiem stron nie wymagających logowania
if(! isset($anonymous_page))
{
	print "<div class=\"kontener\">\n";
	print "<a class= \"button\" href=\"logout.php\">WYLOGUJ SIĘ</a> <a class= \"button\" href=\"menu.php\">MENU</a> \n";
	if (! empty($_SESSION['is_admin']))
	{
		print "<a class= \"button\" href=\"dodaj_fiszke.php\">ZARZĄDZAJ FISZKAMI</a> \n";
		print "<a class= \"button\" href=\"manage_users.php\">ZARZĄDZAJ UŻYTKOWNIKAMI</a> \n";
	}
	print "</div>";
}

/**
* funkcja losuje i pobiera fiszki 
* i zwraca tablicę z fiszkami
*
* @return array - tablica zawierająca fiszki
*
*/
function pobierz_fiszki()
{
// Wylosuj i pobierz fiszki
$sql="select * 
      from words_en en
      join word_relation wr on en.id_word_en = wr.id_word_en
      join words_pl pl on pl.id_word_pl = wr.id_word_pl
      join assign_category ac on ac.id_word_en = en.id_word_en
      where ac.id_ca = :kat
      order by random() 
      limit :liczba
      ;";
$lista_fiszek=db_query($sql, array("kat"=>$_POST['kat'],"liczba"=>$GLOBALS['losowana_liczba_fiszek']));

return $lista_fiszek;
}

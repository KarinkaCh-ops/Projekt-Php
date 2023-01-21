<?php
// ustaw flagę uprawnień: strona nie wymaga logowania
$anonymous_page=true;

// inicjalizuj sesję i wczytaj funkcje biblioteczne
include("lib.php");

/**
* Drukuj formularz logowania
* @param string $tekst - login, zostanie automatycznie wpisany w pole 
*                        aby nie wpisywać go ponownie, jeśli logowanie się nie powiodło
*                        jeśli brak parametru użyty będzie pusty string
*
* funkcja nie zwraca żadnych wartości
*/
function druk_form($tekst = "") 
{
	if($tekst != "") 
	{
		$wpisz=" value=\"$tekst\" ";
	}	
	else 
	{
		$wpisz="";
	}

	readfile("header.html");	
	
	print <<<EOF
	<h1>Zaloguj się</h1>
	<br/>
	<div class="srodek">
		<div class="log_ramka">
			<form method="POST">
				
				<div class="log_line">
				Login:<br/>
				<input id="login" class="inp1" name="login" $wpisz />
				</div>				
				<div class="log_line">
				Password:<br/>
				<input id="password" class="inp1" type="password" name="haslo"/>
				</div>
				<div class="log_line">
				<input class="guzik" type="submit" value="Zaloguj się"/>
				</div>
			</form>
			<hr class="kreska" />
   		<form action="register_new_user.php" method="POST">
				<div class="log_line">   			
   			Jeżeli nie masz konta <br/>
   			<input class="guzik" type="submit" value="Zarejestruj się"/>
   			</div>
			</form>
  		</div>
	</div>
EOF;
readfile("footer.html");
}

if(empty($_POST['login']))
{
	druk_form();
}
else
{
	// sprawdź czy login i hasło są poprawne (hasło przechowywane jest w bazie w postaci skrótu md5)
	$sql="SELECT user_name, is_admin, id_us FROM users WHERE user_name= :login AND password=md5( :password );";
	$us=db_query($sql,array("login"=>$_POST['login'],"password"=>$_POST['haslo']));
	if(count($us)>0)
	{
		// jeśli logowanie się powiodło (liczba zwróconych wierszy jest większa od zera) zapamiętaj 
		// w $_SESSION nazwę i funkcję użytkownika i przejdź do strony z głównym menu.
		$_SESSION["user"]=$us[0]["user_name"];
		$_SESSION["id_us"]=$us[0]["id_us"];
		$_SESSION["is_admin"]=$us[0]["is_admin"];
		header('Location: menu.php');
	}
	else 
	{
		// jeśli logowanie się nie powiodło wyświetl formularz logowania (z wypełnionym polem login)
		print "<h1>Niepoprawny login lub hasło</h1>";
		druk_form($_POST['login']);
	}
}

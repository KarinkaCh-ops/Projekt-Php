<?php
/**
*
*  Moduł administratorski do zarządzania listami słów, kategorii i ich powiązań słów 
*
*/

// ustaw flagę uprawnień: strona tylko dla administratora
$admin_page=true;

// użyj funkcji bibliotecznych
include("lib.php");

// wykonaj wybraną opreację  dodania, usunięcia lub powiązania słów
if (! empty($_POST['guzik']))
{
  switch ($_POST['guzik'])
  {
	 case 'EN':
		$sql="insert into words_en (word_en) values ( :word );";
		if (! empty($_POST['slowo']))
		{
			db_query($sql, array("word"=>$_POST["slowo"]));
		}
		break;
	 case 'PL':
		$sql="insert into words_pl (word_pl) values ( :word );";
		if (! empty($_POST['slowo']))
		{
			db_query($sql, array("word"=>$_POST["slowo"]));
		}
		break;
	 case 'kategoria':
		$sql="insert into category (cat_name) values ( :word );";
		if (! empty($_POST['slowo']))
		{
			db_query($sql, array("word"=>$_POST["slowo"]));
		}
		break;
	 case 'Skasuj słowo EN':
		$sql="delete from words_en where id_word_en= :id ;";
		if (! empty($_POST['slowo_EN']))
		{
			db_query($sql, array("id"=>$_POST["slowo_EN"]));
		}
		break;
	 case 'Skasuj słowo PL':
	 	$sql="delete from words_pl where id_word_pl= :id ;";
		if (! empty($_POST['slowo_PL']))
		{
			db_query($sql, array("id"=>$_POST["slowo_PL"]));
		}
		break;
	 case 'Skasuj kategorię':
	 	$sql="delete from category where id_ca= :id ;";
		if (! empty($_POST['kategoria']))
		{
			db_query($sql, array("id"=>$_POST["kategoria"]));
		}
		break;
	 case 'Usuń powiązanie':
	 	$id_tab=explode(":",$_POST['powiazania']);
	 	$sql="delete from word_relation where id_word_en= :id_en and id_word_pl= :id_pl ;";
		if (! empty($_POST['powiazania']))
		{
			db_query($sql, array("id_en"=>$id_tab[0], "id_pl"=>$id_tab[1]));
		}
		break;
	 case 'Powiąż':
	 	$sql="insert into word_relation (id_word_en, id_word_pl) values ( :id_en , :id_pl );";
		if (! empty($_POST['slowo_EN']) && ! empty($_POST['slowo_PL']))
		{
			db_query($sql, array("id_en"=>$_POST['slowo_EN'], "id_pl"=>$_POST['slowo_PL']));
		}
		break;
	 case 'Skasuj powiązanie kategorii':
	 	$id_tab=explode(":",$_POST['powiazanie_kat']);
	 	$sql="delete from assign_category where id_ca= :id_ca and id_word_en= :id_en ;";
		if (! empty($_POST['powiazanie_kat']))
		{
			db_query($sql, array("id_ca"=>$id_tab[0], "id_en"=>$id_tab[1]));
		}
		break;
	 case 'Powiąż kategorię':
	 	$sql="insert into assign_category (id_ca, id_word_en) values ( :id_ca , :id_en );";
		if (! empty($_POST['kategoria']) && ! empty($_POST['slowo_EN']))
		{
			db_query($sql, array("id_ca"=>$_POST['kategoria'], "id_en"=>$_POST['slowo_EN']));
		}
		break;
  }
}
// pobierz dane do listy wszystkich slow angielskich
$sql="select id_word_en, word_en from words_en order by word_en;";
$lista_en=db_query($sql, array());

// pobierz dane do listy wszystkich slow polskich
$sql="select id_word_pl, word_pl from words_pl order by word_pl;";
$lista_pl=db_query($sql, array());

// pobierz dane do listy wszystkich kategorii
$sql="select id_ca, cat_name from category order by cat_name;";
$lista_kat=db_query($sql, array());

// pobierz dane do listy powiazan slow angielskich i polskich
$sql="select pl.id_word_pl, pl.word_pl, en.id_word_en, en.word_en 
      from word_relation wr 
      join words_en en on wr.id_word_en=en.id_word_en
      join words_pl pl on wr.id_word_pl=pl.id_word_pl
      order by en.word_en, pl.word_pl;";
$lista_wr=db_query($sql, array());

// pobierz dane do listy powiazan slow angielskich i kategorii
$sql="select c.id_ca, c.cat_name, en.id_word_en, en.word_en 
      from category c
      join assign_category ac on c.id_ca=ac.id_ca
      join words_en en on ac.id_word_en=en.id_word_en
      order by c.cat_name, en.word_en;";
$lista_ca_en=db_query($sql, array());

// nagłówek strony
readfile("header.html");
?>
		<h1>Dodaj fiszkę</h1>
		<div class="kontener">
		<div class="log_ramka">
		<form method="POST">
		Słowo: <input class="inp1" type="text" name="slowo" /><br/>
		Dodaj do słownika 
		<input class="guzik" type="submit" name="guzik" value="EN"/> 
		<input class="guzik" type="submit" name="guzik" value="PL" /> 
		<input class="guzik" type="submit" name="guzik" value="kategoria" />
		</div>
		</div>
		
		<div class="kontener">
		<div class="ramka2">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Skasuj kategorię\" /><br/>";
		print "<select class=\"lista\" name=\"kategoria\" size=\"20\">";
		foreach ($lista_kat as $slowo)
		{
			print "<option value=\"{$slowo['id_ca']}\">{$slowo['cat_name']}</option>";
		}
		print "</select><br/>";
?>
		</div>
		<div class="ramka2">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Skasuj powiązanie kategorii\" /><br/>";
		print "<select class=\"lista\" name=\"powiazanie_kat\" size=\"20\">";
		foreach ($lista_ca_en as $slowo)
		{
			print "<option value=\"{$slowo['id_ca']}:{$slowo['id_word_en']}\">{$slowo['cat_name']}:{$slowo['word_en']}</option>";
		}
		print "</select><br/>";
?>
		<input class="guzik" type="submit" name="guzik" value="Powiąż kategorię" />
		</div>
		<div class="ramka2">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Skasuj słowo EN\" /><br/>";
		print "<select class=\"lista\" name=\"slowo_EN\" size=\"20\">";
		foreach ($lista_en as $slowo)
		{
			print "<option value=\"{$slowo['id_word_en']}\">{$slowo['word_en']}</option>";
		}
		print "</select><br/>";
?>
		</div>
		<div class="ramka2">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Usuń powiązanie\" /><br/>";
		print "<select class=\"lista\" name=\"powiazania\" size=\"20\">";
		foreach ($lista_wr as $powiazanie)
		{
			print "<option value=\"{$powiazanie['id_word_en']}:{$powiazanie['id_word_pl']}\">{$powiazanie['word_en']}:{$powiazanie['word_pl']}</option>";
		}
		print "</select><br/>";
?>
      <input class="guzik" type="submit" name="guzik" value="Powiąż" />
      </div>
		<div class="ramka2">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Skasuj słowo PL\" /><br/>";
		print "<select class=\"lista\" name=\"slowo_PL\" size=\"20\">";
		foreach ($lista_pl as $slowo)
		{
			print "<option value=\"{$slowo['id_word_pl']}\">{$slowo['word_pl']}</option>";
		}
		print "</select><br/>";
?>
		</div>
		</div>
		</form>
<?php
// dół strony
readfile("footer.html");

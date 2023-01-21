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
	 case 'Skasuj użytkownika':
		$sql="delete from users where id_us= :id ;";
		if (! empty($_POST['users']))
		{
			db_query($sql, array("id"=>$_POST["users"]));
		}
		break;
	 case 'Zapisz':
	 	$sql="update users set is_admin= :adm where id_us= :id and id_us <> :this_user ;";
		if (! empty($_POST['users']))
		{
			if(! empty($_POST['admin'])) $adm="TRUE"; else $adm="FALSE";
			db_query($sql, array("id"=>$_POST["users"], "adm"=>$adm, "this_user"=>$_SESSION['id_us']));
		}
		break;
	 
  }
}
// pobierz dane do listy użytkowników
$sql="select id_us, user_name, is_admin, e_mail from users order by id_us;";
$lista_us=db_query($sql, array());

// nagłówek strony
readfile("header.html");
?>
		<h1>Zarządzaj użytkownikami</h1>
		<div class="kontener">
		<form method="POST">

		<div class="ramka1">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Skasuj użytkownika\" /><br/>";
		print "<select id=\"lista_us\" class=\"lista\" name=\"users\" size=\"20\" \">";
		foreach ($lista_us as $slowo)
		{
			if($slowo['is_admin']) 
			{
				$adm="ADMIN";
			} 
			else 
			{
				$adm="USER";
			}
			print "<option value=\"{$slowo['id_us']}\">";
			print "{$slowo['id_us']}, {$slowo['user_name']}, {$slowo['e_mail']}, {$adm}";
			print "</option>";
		}
		print "</select><br/>";
?>
		</div>

		<div class="ramka1">
<?php
		print "<input class=\"guzik\" type=\"submit\" name=\"guzik\" value=\"Zapisz\" /><br/>";
		print "Uczyń ADMINEM:  <input class=\"inp1\" type=\"checkbox\" name=\"admin\" /><br/>";
?>
		</div>

		</form>
<?php
// dół strony
readfile("footer.html");

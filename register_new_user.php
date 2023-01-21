<?php
$anonymous_page=true;
include("lib.php");
function druk_form() 
{
	if(! isset($_POST['e_mail'])) $_POST['e_mail']=""; 
	if(! isset($_POST['login'])) $_POST['login']=""; 
	if(! isset($_POST['haslo1'])) $_POST['haslo1']=""; 
	if(! isset($_POST['haslo2'])) $_POST['haslo2']=""; 

	print <<<EOF
	<h1>Zarejestruj się</h1>
	<br/>
	
	<div class="srodek">
	<div class="log_ramka">
		<form method="POST">
			e-mail: <br/> <input class="inp1" type="email" name="e_mail" value="{$_POST['e_mail']}" id="e_mail"/> <br/>
			Login: <br/> <input class="inp1" type="text" name="login" value="{$_POST['login']}" id="login"/> <br/>
			Password: <br/> <input class="inp1" type="password" name="haslo1" value="{$_POST['haslo1']}" id="haslo1"/> <br/>
			Re-type Password: <br/> <input class="inp1" type="password" name="haslo2" value="{$_POST['haslo2']}" id="haslo2"/> <br/>
			<input class="guzik" type="submit" value="Zarejestruj się" />
		</form>
		<hr class="kreska"/>
		<form action="login.php" method="POST">	
			Jeżeli jenak masz konto 
			<br/>
			<input class="guzik" type="submit" value="zaloguj się" />
		</form>
	</div>
	</div>
EOF;

}

// wczyataj nagłówek strony
readfile("header.html");

if(empty($_POST['login']))
{
	druk_form();
}
else
{
	$sql="SELECT user_name FROM users WHERE user_name= :login;";
	$us=db_query($sql,array("login"=>$_POST['login']));
	if(count($us)>0)
	{
		print "<h1>Ta nazwa jest już zajęta!</h1>";
		druk_form();	
		die();	
	}
	$sql="SELECT e_mail FROM users WHERE e_mail= :e_mail;";
	$us=db_query($sql,array("e_mail"=>$_POST['e_mail']));
	if(count($us)>0)
	{
		print "<h1>Ten e-mail jest już zajęty!</h1>";
		druk_form();	
		die();	
	}
	if (strlen($_POST['haslo1']) <8)
	{
		print "<h1>Hasło musi mieć przynajmniej 8 znaków!</h1>";
		druk_form();	
		die();	
	}	if($_POST['haslo1'] != $_POST['haslo2'])
	{
		print "<h1>Hasła nie pasują!</h1>";
		druk_form();	
		die();	
	}
	if($_POST['haslo1'] != $_POST['haslo2'])
	{
		print "<h1>Hasła nie pasują!</h1>";
		druk_form();	
		die();	
	}
	$sql="insert into users (user_name, password, e_mail) values ( :login , md5( :password ) , :e_mail );";
	$us=db_query($sql,array("login"=>$_POST['login'],"password"=>$_POST['haslo1'],"e_mail"=>$_POST['e_mail']));
	
	print '<div class="srodek">';
	print '<div class="ramka">';
	print "<h1>Zarejestrowano użytkownika</h1>";
	print '<form action="login.php" method="POST">';	
   print '<input class="guzik" type="submit" value="zaloguj się"/>';
   print '</form>';
   print '</div>';
   print '</div>';
}

readfile("footer.html");

?>
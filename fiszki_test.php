<?php
/**
* Testuj zrozumienie słowa z fiszki,
* pokaż je i następnie dolicz punkty do wyniku
*/

// sesja i funkcje biblioteczne
include("lib.php");

if(! empty($_SESSION['lista_fiszek']))
{
	// nagłówek strony
	readfile("header.html");
	print <<<'EOF'
	<script>
		function znikaj()
		{
			document.getElementById('pytanie').style.display="block";
			document.getElementById('wpis').focus();
			if (document.body.contains(document.getElementById('dobrze'))) {document.getElementById('dobrze').style.display="none";}
			if (document.body.contains(document.getElementById('bad'))) {document.getElementById('bad').style.display="none";}
			if (document.body.contains(document.getElementById('cog'))) {document.getElementById('cog').style.display="none";}
		}
		setTimeout(znikaj, 2000);
	</script>
EOF;
	
	// jeśli nie wpisano polskiego słowa pokaż fiszkę
	if (! empty($_POST['odpowiedz']))
	{

		// sprawdż poprawność odpowiedzi (zawsze odpytujemy fiszkę [0])

		if (strtolower(trim($_POST['odpowiedz']))==strtolower(trim($_SESSION['lista_fiszek'][0]['word_pl'])))
		{
			// Dolicz punkty za poprawną lub niepoprawną odpowiedź 
			
			print "<div class=\"kontener\">\n";
			print "<div id=\"dobrze\" class=\"ramka\">\n";
			print "<div class=\"slowo_en\">{$_SESSION['lista_fiszek'][0]['word_en']}</div>\n";
			print "<hr class=\"kreska\"/>\n";
			print "<div class=\"slowo_pl\">{$_SESSION['lista_fiszek'][0]['word_pl']}</div>\n";
			print "</div>\n";
			print "</div>\n";
			
			// Jeśli odpowiedź była prawidłowa usuń najniższą (bieżącą) fiszkę (przez jej nadpisanie kolejną).
			// przesuń zawartość tablicy o jedną pozycję w dół, a następnie obetnij tablicę z góry.		
			for($i=1;$i<count($_SESSION['lista_fiszek']);$i++)
			{
				$_SESSION['lista_fiszek'][$i-1]=$_SESSION['lista_fiszek'][$i];	
			}
			unset($_SESSION['lista_fiszek'][count($_SESSION['lista_fiszek'])-1]);
			
			// dolicz punkty za dobrą odpowiedź
			$_SESSION['test_score']+=$GLOBALS['poprawna_odpowiedz'];
		}
		else
		{
			// odlicz punkty za niepoprawną odpowiedź
			print '<center><img id="bad" src="img/Techpriest.png"></center>';
			$_SESSION['test_score']+=$GLOBALS['niepoprawna_odpowiedz'];		
		}
	}
	else 
	{
		print '<center><img id="cog" src="img/cog.gif"></center>';
	}

   // Pokaż fiszkę (słowo angielskie) i pozwól wpisać polski odpowiednik    
   // jeśli jest co pokazywać, czyli na liście sa jeszcze nierozwiązane fiszki      
	if(count($_SESSION['lista_fiszek'])>0)
	{
		print "<form method=\"POST\" autocomplete=\"off\">\n";
		print "<div class=\"kontener\">";
		print "<div id=\"pytanie\" class=\"ramka\" style=\"display: none;\">\n";
		print "<div class=\"slowo_en\">{$_SESSION['lista_fiszek'][0]['word_en']}</div>\n";
		print "<hr class=\"kreska\"/>\n";
		print "<div class=\"slowo_pl\"><input autofocus class=\"inp1\" id=\"wpis\" type=\"text\" name=\"odpowiedz\"/></div>\n";
		print "<input class=\"guzik\" type=\"submit\" value=\"OK\"/>\n";
		print "</div>\n";
		print "</div>\n";
		print "</form>\n";
	}
	else 
	{
		unset($_SESSION['lista_fiszek']);
		header('Location: wynik_testu.php');
	}
}
else 
{
	unset($_SESSION['lista_fiszek']);
	header('Location: wynik_testu.php');
}
// dół strony
readfile("footer.html");
?>
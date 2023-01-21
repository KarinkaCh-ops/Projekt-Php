<?php
/**
* pokaż wynik testu
*/

// sesja i funkcje biblioteczne
include("lib.php");

// zapisz wynik testu do bazy jako nowy (kolejny) attempt
$sql="insert into attempt (id_us, score) values ( :id , :score )";
db_query($sql, array("id"=>$_SESSION['id_us'], "score"=>$_SESSION['test_score']));

readfile("header.html");

print <<<'EOF'
<form method="POST" action="menu.php">	
<div class="kontener">
<div class="ramka">
<div class="slowo_en">Twój wynik: 
EOF;

print $_SESSION['test_score'];

print <<<'EOF'
</div>
<input autofocus class="guzik" type="submit" value="OK"/>
</div>
</div>
</div>
</form>
EOF;
		
// dół strony
readfile("footer.html");
?>
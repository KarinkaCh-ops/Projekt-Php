<?php
include("lib.php");

// Jeśli lista fiszek nie jest pusta - usuń ją
if(isset($_SESSION['lista_fiszek'])) unset($_SESSION['lista_fiszek']);
// Ustaw zmienną do przechowywania wyniku testu między fiszkami
$_SESSION['test_score']=0;

// pobierz ostatni wynik użytkownika
$sql="select a.score
      from attempt a
      join users u on a.id_us=u.id_us
      where u.user_name = :user and a.id_at=(select max(id_at) from attempt);";
$last_score=db_query($sql, array("user"=>$_SESSION['user']));
if(empty($last_score[0]['score'])) $last_score[0]['score']=0;
   
// pobierz średnią wyników, najwyższy wynik i sumę punktów użytkownika
$sql="select round(avg(a.score),2) as srednia, max(a.score) as najwyzszy, sum(a.score) as suma, count(*) as liczba
      from attempt a
      join users u on a.id_us=u.id_us
      where u.user_name = :user ;";
$score=db_query($sql, array("user"=>$_SESSION['user']));
// jeśli brak wyników ustaw zero
if(empty($score[0]['srednia'])) $score[0]['srednia']=0;
if(empty($score[0]['suma'])) $score[0]['suma']=0;
if(empty($score[0]['najwyzszy'])) $score[0]['najwyzszy']=0;
if(empty($score[0]['liczba'])) $score[0]['liczba']=0;

// pobierz listę kategorii
$sql="select id_ca, cat_name from category order by cat_name;";
$lista_kat=db_query($sql, array());

readfile("header.html");
print <<<EOF
        <h1>Fiszki z języka angielskiego</h1>       
        <div class="kontener">
            <div class="l_ramka">
                <p class="tytul">WYNIKI</p>
                <p>Użytkownik: {$_SESSION['user']}</p>
                <p>Ostatni test: {$last_score[0]['score']}</p>
                <p>Średnia z wyników: {$score[0]['srednia']}</p>
                <p>Punkty: {$score[0]['suma']}</p>
                <p>Najwyższy wynik: {$score[0]['najwyzszy']}</p>
                <p>Liczba prób: {$score[0]['liczba']}</p>
            </div>
            <div class="l_ramka">
                <p class="tytul">TEST</p>
                
                <!--od tego jest kod do kategorii-->
                
                <form method="POST" action="fiszki_ucz.php">
                
                <select autofocus tabindex="1" class="lista1" name="kat" size="12">
                    <optgroup class="tytulkat" label="Kategorie:"></optgroup>
EOF;

foreach ($lista_kat as $kategoria)
{
	print "<option class=\"menu\" value=\"{$kategoria['id_ca']}\">{$kategoria['cat_name']}</option>";
}

print "               
                </select>
                <div class=\"srodek\">
                	<input tabindex=\"2\" class=\"guzik\" type=\"submit\" value=\"rozpocznij test\"/>
                </div>
                </form>
            </div>
        </div>
";
readfile("footer.html");
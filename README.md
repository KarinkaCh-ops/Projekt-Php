# Projekt-Php
a) Wymagania funkcjonalne:
Wymaganiami aplikacji są:
1. Aplikacja zezwala na korzystanie z niej wyłącznie zalogowanym użytkownikom.
2. Osoby nieposiadające konta mogą się w aplikacji zarejestrować.
3. Nie jest dopuszczalne, żeby różni użytkownicy posiadali ten sam login lub e-mail.
4. Funkcje administracyjne są dostępne tylko dla użytkowników z uprawnieniami
administratora.
5. Funkcje administracyjne pozwalają na zarządzanie użytkownikami (usuwanie, oraz nadanie
uprawnień administratorskich) oraz tworzenie i zarządzanie fiszkami.
6. Użytkownik ma możliwość wyboru kategorii słów, które mają mu zostać pokazane i, z
których będzie egzaminowany.
7. Za każdą poprawną odpowiedź użytkownik otrzymuje 2 punkty, a za każdą niepoprawną
odpowiedź zabierany jest mu jeden punkt.
8. W przypadku poprawnej odpowiedzi system wyświetla słowo oraz odpowiedź, w przypadku
niepoprawnej odpowiedzi system piorunuje użytkownika odpowiednim komunikatem i
zmusza do ponownego wpisania wartości, tak długo, aż nie będzie poprawna.
b) Responsywność:
1. Aplikacja została zaprojektowana w oparciu o rozwiązania CSS, co zapewnia, że jest
poprawnie i estetycznie wyświetlana niezależnie od wielkości ekranu zarówno na
urządzeniach stacjonarnych jak i mobilnych.
c) Grafika i wygląd:
1. Dla aplikacji zaprojektowano właściwe elementy graficzne, w tym estetyczne tło, właściwy
dobór kolorów, animowana grafika wyświetlana podczas rozpoczynania testu oraz ekran z
grafiką wyświetlaną w przypadku udzielenia przez użytkownika złej odpowiedzi.
d) Jakość kodu:
1. Kod został zaopatrzony w obszerne komentarze.
2. Parametry konfiguracyjne aplikacji wydzielono w osobnym pliku (config.php).
3. Często używane funkcje wydzielono do osobnego pliku, który jest includowany (lib.php).
4. Wszystkie strony są traktowane domyślnie jako wymagające zalogowania, czyli dostępne dla
użytkownika. Dodatkowo niektóre strony (logowanie i rejestracja) oznaczono jako
dostępne publicznie, natomiast strony administratorskie oznaczono jako dostępne tylko dla
administratora.
5. Zaimplementowano wymuszenie respektowanie uprawnień na wszystkich stronach.
6. Zwrócono szczególną uwagę na bezpieczeństwo. Hasła przechowywane są w postaci funkcji
skrótu md5, logowanie i dostęp do stron oparty jest o sesję, zastosowanie klasy PDO i
szablonowania zapytań (metody prepare, binValue i execute) zabezpieczają program przed
podstawowymi metodami ataku typu SQL-injection.
e) Walidacja HTML i CSS:
1. Stałe fragmenty HTML zostały wydzielone i są includowane na każdej stronie:
header.html i footer.html. Header powoduje także włączenia na każdej stronie arkusza
stylów CSS (fiszki1.css).
2. Poprawność składniowa arkusza stylów została zweryfikowana poprzez użycie
odpowiedniego edytora (Bluefish).
f) Użyteczność:
1. Program pozwala na skuteczne nauczenie się tłumaczeń wskazanych słówek. Zestawy
słówek, ich powiązania oraz kategoryzacje można modyfikować i rozbudowywać z poziomu
funkcji administratora programu. Aby zagwarantować możliwość obsługi wielkiej ilości
użytkowników, w systemie można ustanowić wielu administratorów.
g) Testowanie:
Program poddano intensywnym testom. Przypadki testowe:
1. Rejestracja użytkownika, w tym podanie odpowiedniego oraz zbyt krótkiego hasła, podanie
unikatowego albo powtarzającego się loginu, oraz maila.
2. Zalogowanie użytkownika, w tym podanie poprawnego i niepoprawnego loginu oraz hasła.
3. Menu, w tym wybór kategorii i przejście do testowania.
4. Test fiszkowy: podanie przez użytkownika poprawnej, niepoprawnej oraz pustej
odpowiedzi. Powrót do menu w trakcie testu lub wylogowanie w trakcie testu.
5. Przetestowano także skuteczne wylogowanie użytkownika.
6. Testy funkcji administratorskich, w tym dodawanie i usuwanie słów i kategorii, oraz
wiązanie słów i kategorii, nadawanie użytkownikom uprawnień administratorskich, oraz
usuwanie użytkowników, ze szczególnym zwróceniem uwagi na niemożność usunięcia
samego siebie lub usunięcia uprawnień administratorskich.

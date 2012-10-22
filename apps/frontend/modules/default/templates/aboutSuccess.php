<?php include_partial('global/page_header', array('title' => 'O planecie')) ?>
<h2>Czym jest Planeta PHP.pl?</h2>
<p>Planeta PHP.pl jest serwisem agregującym wpisy z blogów związanych tematycznie z językiem PHP. Serwis działa pod skrzydłami serwisu PHP.pl i pozwala na zebranie informacji z najlepszych blogów o PHP, działających w polskiej blogosferze.</p>
<hr/>

<h2>Jak dodać blog do planety?</h2>
<p>Aby dodać blog do planety, wystarczy wypełnić <?php echo link_to('odpowiedni formularz', '@add') ?>, a następnie przejść proces weryfikacji, którego szczegółowy opis jest załączony do maila, wysyłanemu na adres podany w formularzu. Potem wystarczy już tylko poczekać na akceptację bloga przez administratorów Planety. Proces ten powinien zająć najwyżej dwa dni, jeśli w tym czasie blog nie zostanie dodany, możesz spróbować pogonić administratorów wykorzystując dane ze strony <?php echo link_to('kontakt', '@contact') ?>. Potwierdzenie o akceptacji, bądź też odrzuceniu bloga (wraz z wyjaśnieniem) zostanie wysłane jako wiadomość e-mail. W szczególnych przypadkach administratorzy mogą przed podjęciem decyzji wysłać wiadomość z pytaniami, które pomogą im rozwiać wątpliwości.</p>
<hr/>

<h2>Jakie warunki powinien spełnić blog, aby został przyjęty</h2>
<p>Wystarczy rzeczowo pisać o PHP. Oprócz tego, dobrze jest podać w formularzu link do kanału RSS lub ATOM, który zawiera pełne treści wiadomości, dzięki czemu planeta będzie mogła wykorzystać mechaznim zwijania wpisów. Oczywiście, oprócz rozwijania, dostępny będzie także bezpośredni link do bloga. W ten sposób możesz zwiększyć ilość odwiedzin na swoim blogu.</p> 
<hr/>

<h2>Jak działa planeta?</h2>
<p>Sposób działania planety jest dość prosty. Przy zgłaszaniu bloga, wymagane jest podanie adresu do kanału RSS lub ATOM. Korzystając z tego adresu, planeta analizuje kanały wszystkich blogów, zbierając wpisy z predefiniowanych kategorii. Na planecie kategorie są nazywane tagami (web 2.0 ;)), a proces powstawania tagów sprowadza się do odpowiedniego przeformatowania nazwy kategorii. Wszystkie wpisy są następnie wyświetlane na stronie głównej planety oraz udostępniane na kanale ATOM.</p>
<hr/>

<h2>Jak można zgłosić błąd, propozycję itd.?</h2>
<p>Dane kontaktowe znajdują sie na stronie <?php echo link_to('kontakt', '@contact') ?>.
<hr/>
<?php include_partial('global/page_footer'); ?>

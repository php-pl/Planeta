<?php include_partial('global/page_header', array('title' => 'Weryfikacja właściciela bloga')) ?>

<p>Zakończyć proces weryfikacji można na dwa sposoby:</p>
<ol>
    <li>
        Przez umieszczenie pliku na serwerze: 
        <p>W głównym katalogu swojego bloga (<?php echo link_to(null, $blog->getUrl()) ?>) umieść plik o nazwie <b><?php echo $blog->getFile() ?>.html</b> - tak, żeby można było uzyskać do niego dostęp spod adresu <?php echo link_to(null, $blog->getUrlWithEndingSlash() . $blog->getFile() . '.html') ?>.</p>
    </li>
    <li style="margin-top: 1em">
        <p>Przez umieszczenie tagu meta w sekcji head strony głównej bloga:</p>
        <code><?php echo htmlentities('<meta name="verify-phppl" content="' . $blog->getFile() . '" />') ?></code>
    </li>
</ol>

<p>Następnie wystarczy udać się pod adres <?php echo link_to(null, url_for('@verification?file=' . $blog->getFile(), true)); ?></a>. Jeśli plik będzie istniał na serwerze lub jeśli na stronie głównej będzie znajdował się odpowiedni tag, blog zostanie oznaczony jako zweryfikowany.</p>

<?php if (!$blog->getApproved()): ?>
<p>Po udanym procesie weryfikacji, blog zostanie sprawdzony przez administratorów planety, którzy zadecydują, czy zostanie dodany. O ich decyzji zostaniesz powiadomiony wiadomością e-mail na konto pocztowe, którego adres podałeś podczas rejestracji na Forum PHP.pl. Jeśli adres jest nieakutalny, zmień go zanim dokonasz procesu weryfikacji.</p>
<?php endif ?>

<p><?php echo link_to('Powrót na stronę główną', '@homepage') ?></p> 
<?php include_partial('global/page_footer') ?>
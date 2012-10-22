<?php use_helper('Validation') ?>
<?php include_partial('global/page_header', array('title' => 'Dodaj blog')) ?>

<div class="infobox">
    <p>Dodać blog do planety może tylko jego autor. Jeśli nie jesteś autorem bloga, a uważasz, 
    że jego blog powinien być agregowany przez planetę, podaj mu ten adres. Zgłaszane blogi 
    są weryfikowane, jeśli zgłoszenie nie będzie pochodziło od autora, zostanie odrzucone.</p>
</div>

<?php echo form_tag('blog/add') ?>
	<fieldset id="author_info">
		<legend>Dane z Forum PHP.pl</legend>
    
        <div class="infobox">
            <p>Wypełnij poniższe pola loginem i hasłem swojego konta na 
            <?php echo link_to('Forum PHP.pl', 'http://forum.php.pl') ?>. Jeśli nie posiadasz konta 
            <?php echo link_to('zarejestruj się', 'http://forum.php.pl/index.php?act=Reg') ?>.</p>
        </div>
		
		<div class="row">
			<?php echo form_error('login') ?>
			<label for="login">Login: </label>
			<?php echo input_tag('login'); ?>
		</div>
		
		<div class="row">
			<?php echo form_error('password') ?>
			<label for="password">Hasło: </label>
			<?php echo input_password_tag('password'); ?>
		</div>
	</fieldset>

	<fieldset id="blog_info">
        <div class="infobox">
            <p>Prosimy podać adres kanału, który zawiera <b>pełne treści wpisów</b>  - planeta sama skraca 
            wpisy i wyświetla link do pełnej zawartości na blogu autora.</p>
            <p>Kanał powinien też posiadać <b>nazwy kategorii</b>, w których wpisy zostały umieszczone - 
            są one zamieniane przez planetę na tagi, wpis, który nie posiada zatwierdzonych tagów 
            nie zostanie dodany.</p>
        </div>
  
		<legend>Informacje o blogu i autorze</legend>
    
		<div class="row">
			<?php echo form_error('name') ?>
			<label for="blog_name">Nazwa bloga: </label>
			<?php echo input_tag('name'); ?>
            <span class="desc">2-64 znaków</span>
		</div>
    
        <div class="row">
            <?php echo form_error('author') ?>
            <label for="name">Twoje imię lub pseudonim: </label>
            <?php echo input_tag('author'); ?>
            <span class="desc">2-64 znaków</span>
        </div>
		
		<div class="row">
			<?php echo form_error('url') ?>
			<label for="blog_url">Adres bloga: </label>
			<?php echo input_tag('url'); ?>
            <span class="desc">Maksymalnie 128 znaków</span>
		</div>
		
		<div class="row">
			<?php echo form_error('feed') ?>
			<label for="blog_feed">Adres kanału ATOM/RSS: </label>
			<?php echo input_tag('feed'); ?>
            <span class="desc">Maksymalnie 128 znaków</span>
		</div>
	</fieldset>
	
	<?php echo submit_tag('Dodaj blog', array('class' => 'submit')); ?>
    <?php echo button_to('Powrót', $sf_request->getReferer(), array('class' => 'submit')) ?>
</form>
<?php include_partial('global/page_footer') ?>
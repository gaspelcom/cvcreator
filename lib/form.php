<?php
$Post = new cv\Request\Request($_POST);
?>

<form action="" method="post" enctype = "multipart/form-data">
	<dl>
		<dd><label for="firstname">Vorname</label><input name="firstname" id="form_firstname" value="<?php $Post->getHtml('firstname'); ?>" placeholder="Max" /></dd>
		<dd><label for="lastname">Nachname</label><input name="lastname" id="form_lastname" value="<?php $Post->getHtml('lastname'); ?>" placeholder="Muster" /></dd>
		<dd><label for="birthdate">Geburtsdatum</label><input name="birthdate" id="form_birthdate" value="<?php $Post->getHtml('birthdate'); ?>" placeholder="01.01.1900" /></dd>
		<dd><label for="lastname">Beruf</label><input name="jobtitle" id="form_jobtitle" value="<?php $Post->getHtml('jobtitle'); ?>" placeholder="Automechaniker" /></dd>
		<dd><label for="lastname">Wohnort</label><input name="location" id="form_location" value="<?php $Post->getHtml('location'); ?>" placeholder="Bernerstrasse 01, 5002 Bern" /></dd>
		<dd><label for="lastname">Telefon</label><input name="phone" id="form_phone" value="<?php $Post->getHtml('phone'); ?>" placeholder="079 123 45 67" /></dd>
		<dd><label for="lastname">Mail</label><input name="mail" id="form_mail" value="<?php $Post->getHtml('mail'); ?>" placeholder="max.muster@domain.ch" /></dd>
		<dd><label for="lastname">Geschlecht</label>
			<select name="sex" id="form_sex">
				<?php $Post->getListHtml('sex', array('Männlich', 'Weiblich', 'Anderes')); ?>
			</select>
		</dd>
		<dd><label for="maritalstatus">Zivilstand</label><select name="maritalstatus" id="form_maritalstatus">
				<?php $Post->getListHtml('maritalstatus', array('Ledig', 'Verheiratet', 'Anderes')); ?>
			</select>
		</dd>
		<dd><label for="children">Anzahl Kinder</label><input name="children" id="form_children" value="<?php $Post->getHtml('children'); ?>" type="number" placeholder="0" /></dd>
		<dd><label for="nationality">Nationalität</label><input name="nationality" id="form_nationality" value="<?php $Post->getHtml('nationality'); ?>" type="text" placeholder="Schweiz" /></dd>
	</dl>
	<dl>
		<dd><label for="workExperience">Berufserfahrung</label></dd>
		<?php
			$WorkExperience = new cv\Document\ListHandler('WorkExperience','Berufsbezeichnung', 'Ort des Firmensitzes','Berufserfahrung hinzufügen');
			$WorkExperience->progressPost($_POST);
			print_r($WorkExperience->getAllHtml());
		?>
		<dd><input type="submit" name="action" value="Berufserfahrung hinzufügen"></dd>
	</dl>
	<dl>
		<dd><label for="education" id="ausbildung">Ausbildung</label></dd>
		<?php
			$Education = new cv\Document\ListHandler('Education','Ausbildungstitel', 'Schule','Ausbildung hinzufügen');
			$Education->progressPost($_POST);
			print_r($Education->getAllHtml());
		?>
		<dd><input type="submit" name="action" value="Ausbildung hinzufügen"></dd>
	</dl>
	<dl>
		<dd><label for="competencies">Kompetenzen</label><textarea name="competencies"><?php $Post->getHtml('competencies');?></textarea></dd>
	</dl>
	<dl>
		<dd><label for="technical">Tech. Erfahrung</label><textarea name="technical"><?php $Post->getHtml('technical');?></textarea></dd>
	</dl>
	<dl>
		<dd><label for="picture">Foto auswählen</label><input type="file" name="picture" accept="image/png, image/jpeg" /></dd>
	</dl>
	<dl>
		<dd><label for="doctype">Dokumenten Type auswählen</label>
			<select name="doctype" id="form_doctype">
				<option value="docx" select="select">Office-Word Document</option>
				<!--<option value="odt">Open Office Document</option>-->
				<!--<option value="pdf">PDF</option>-->
			</select>
		</dd>
	</dl>
	<dl>
		<dd>
			<input type="submit" name="action" value="Lebenslauf erstellen" />
		</dd>
	</dl>
	<input type="hidden" name="step" value="2" />
	<input type="hidden" name="TemplateFile" value="<?php echo $_POST['TemplateFile']; ?>" />
</form>
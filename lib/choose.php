<?php

$template = new cv\Document\Template();

?>
<form action="" method="post">
	<dl>
		<dd>
			<?php $template->getTemplateList(); ?>
		</dd>
	</dl>
	<dl>
		<dd>
			<!--<input type="submit" name="action" value="Template erstellen" />-->
			<input type="submit" name="action" value="Lebenslauf erstellen" />
		</dd>
	</dl>
	<input type="hidden" name="step" value="1" />
	
</form>
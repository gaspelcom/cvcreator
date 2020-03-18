<?php
namespace cv\Document;

class Template extends Document {
	
	public function __construct() {
		parent::__construct();		
	}
	
	public function createTemplate($name) {
		
		
		$this->createPreview($name);
	}
	
	private function createPreview($filename) {
		
		$args = array(
				'firstname'		=> 'Max',
				'lastname'		=> 'Muster',
				'birthdate'		=> '01.01.2000',
				'jobtitle'				=> 'Automechaniker',
				'location'				=> 'Bernstrasse 01, 5001 Bern',
				'phone'				=> '079 123 45 67',
				'mail'				=> 'max.muster@domain.ch',
				'sex'				=> 'Männlich',
				'maritalstatus'				=> 'Ledig',
				'children'				=> '0',
				'nationality'				=> 'Schweiz',
				'WorkExperience_0_startDateMonth'				=> '1',
				'WorkExperience_0_startDateYear'				=> '1900',
				'WorkExperience_0_endDateMonth'				=> '12',
				'WorkExperience_0_endDateYear'				=> '2021',
				'WorkExperience_0_title'				=> 'Berufsbezeichnung',
				'WorkExperience_0_description'				=> 'Ort des Firmensitzes',
				'Education_0_startDateMonth'				=> '1',
				'Education_0_startDateYear'				=> '1900',
				'Education_0_endDateMonth'				=> '12',
				'Education_0_endDateYear'				=> '2021',
				'Education_0_title'				=> 'Ausbildungstitel',
				'Education_0_description'				=> 'Schule',
				'competencies'				=> 'Kompetenzen',
				'technical'				=> 'Technische Erfahrungen',
				'doctype'				=> 'docx',				
				'TemplateFile'	=> $filename,
		);
		
		$filename = str_replace(".docx", "", $filename);
		
		$this->createName = $filename;
		$this->createUserPath = $this->templatePreviewPath;
		$this->createUserFile = $this->createUserPath . $filename;
		
		$this->create($args);
	}
	
	public function getPreview($filename) {
		if (!file_exists($this->templatePreviewPath . $filename)) $this->createPreview($filename);
		$URL = "https://".$_SERVER['HTTP_HOST'];
		$URL .= '/'.$this->templatePreviewPath;
		$URL .= $filename;
		
		echo '<iframe src="https://docs.google.com/gview?url='.$URL.'&embedded=true" width="300px" height="400px"></iframe>';
	}
	
	public function getTemplate($filename) {
		echo '<label for="'.$filename.'">';
		$this->getPreview($filename);
		echo 'Vorlage: '.$filename.'<input required="required" type="radio" name="TemplateFile" id="'.$filename.'" value="'.$filename.'" /></label>';
	}
	
	public function getTemplateList() {
		foreach(glob($this->templatePath . "*.docx") as $filename) {
			$filename = str_replace($this->templatePath, '', $filename);
			$this->getTemplate($filename);
		}
	}
	
	
}
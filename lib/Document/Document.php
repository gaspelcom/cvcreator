<?php
namespace cv\Document;

use PhpOffice\PhpWord\Settings;

class Document extends PathExtends {
	
	private $templateProcessor = null;
	
	public function __construct() {
		parent::__construct();		
	}
	
	public function create($args=array()) {
		if (!isset($args['TemplateFile'])) return false;
		if (!$this->checkTemplateFile($args['TemplateFile'])) return false;
		
		$this->templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($this->templatePath . $args['TemplateFile']);
		
		foreach($args as $key => $val) {
			switch ($key) {
				case "TemplateFile":
				case "step":
					//Do Nothing
				break;
				case "competencies":
					$strings = explode("\n", $val);
					$this->templateProcessor->cloneRow('competencies', count($strings));
					for ($i = 1; $i <= count($strings); $i++) {
						$this->templateProcessor->setValue('competencies#'.$i, $strings[$i-1]);
					}
				break;
				case "technical":
					$strings = explode("\n", $val);
					$this->templateProcessor->cloneRow('technical', count($strings));
					for ($i = 1; $i <= count($strings); $i++) {
						$this->templateProcessor->setValue('technical#'.$i, $strings[$i-1]);
					}
				break;
				default:					
					$this->templateProcessor->setValue($key,$val);
				break;
			}
		}
		
		if (array_key_exists('picture',$_FILES)) {
			$this->addImage($_FILES['picture']['tmp_name']);
		} else {
			$this->addImage('');
		}
		
		$listHandler = new ListHandler('WorkExperience');
		$listHandler->progressPost($args);
		$listHandler->progressDocument($this->templateProcessor);
		
		$listHandler = new ListHandler('Education');
		$listHandler->progressPost($args);
		$listHandler->progressDocument($this->templateProcessor);
		
		$this->createUserFile = $this->createUserPath . $this->createName . '.docx';

		$this->templateProcessor->saveAs($this->createUserFile);
	}
	
	public function open($type) {
		if (strlen($this->createUserFile)) {
			
			switch($type) {
				case "docx":
					$file = $this->createUserFile;
				break;
				case "odt":
					$phpWord = \PhpOffice\PhpWord\IOFactory::load($this->createUserFile);
					
					$file = $this->$createUserPath . $this->createName . 'odt';
				
					$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
					$objWriter->save($file);		
				break;
				case "pdf":
					
					Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
					Settings::setPdfRendererPath($this->$createUserPath);
					
					$phpWord = \PhpOffice\PhpWord\IOFactory::load($this->createUserFile);
					
					$file = $file = $this->$createUserPath . $this->createName . 'pdf';
					$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord,'PDF');
					$xmlWriter->save($file);
				break;
			}
			
			
			header ("Location: " . $file);
			return true;
		}
		return false;
	}
	
	private function addImage($filename) {
		if (strlen($filename)) {
			$options = array(
				'src' => $filename,
				'imageAlign' => 'center',
				'scaling' => 100,
				'spacingTop' => 10,
				'spacingBottom' => 0,
				'spacingLeft' => 0,
				'spacingRight' => 20,
				'textWrap' => 0,
				'borderStyle' => 'lgDash',
				'borderWidth' => 6,
				'borderColor' => 'FF0000',
			);
			
			$this->templateProcessor->setImageValue('image', $options);
		} else {
			$this->templateProcessor->setValue('image', '');
		}
	}
	
	private function checkTemplateFile($filename) {
		if (file_exists($this->templatePath . $filename)) {
			return true;
		}
		return false;
	}
	
}
<?php
namespace cv\Document;

class PathExtends 	{
	
	protected $templatePath			= 'docs/template/';
	protected $templatePreviewPath	= 'docs/template/preview/';
	protected $createPath			= 'docs/create/';
	protected $createName			= 'Lebenslauf';
	
	protected $createUserPath = null;
	protected $createUserFile = null;
	
	protected $templateFile	= null;
	
	public function __construct() {
		$this->createUserPath = $this->createPath . session_id();
		
		if (!is_dir($this->createUserPath)) {
			mkdir($this->createUserPath, 0777, true);
		}
		$this->createUserPath .= DIRECTORY_SEPARATOR;
		
	}
	
}
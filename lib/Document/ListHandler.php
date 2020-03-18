<?php
namespace cv\Document;

class ListHandler {
	
	private $yearList = array();
	private $monthList = array();
	
	private $list = array();
	
	private $listName = '';
	private $titleName = '';
	private $descriptionName = '';
	private $actionTrigger = '';
	
	public function __construct($listName, $titleName='', $descriptionName='', $actionTrigger='') {
		$this->__constructYearList();
		$this->__constructMonthList();
		
		$this->listName = $listName;
		$this->titleName = $titleName;
		$this->descriptionName = $descriptionName;
		$this->actionTrigger = $actionTrigger;
	}
	
	public function getHtml($id=-1) {
		if ($id == -1) $id = create();
		$content = '<select name="'.$this->listName.'_'.$id.'_startDateMonth" class="month">';
		$content .= $this->getHtmlList($this->monthList,$this->list[$id]['startDateMonth']);
		$content .=	'</select>';
		$content .= '<span class="devider">/</span>';
		$content .= '<select name="'.$this->listName.'_'.$id.'_startDateYear" class="year">';
		$content .= $this->getHtmlList($this->yearList,$this->list[$id]['startDateYear']);
		$content .=	'</select>';
		$content .= '<span class="devider">-</span>';
		$content .= '<select name="'.$this->listName.'_'.$id.'_endDateMonth" class="month">';
		$content .= $this->getHtmlList($this->monthList,$this->list[$id]['endDateMonth']);
		$content .=	'</select>';
		$content .= '<span class="devider">/</span>';
		$content .= '<select name="'.$this->listName.'_'.$id.'_endDateYear" class="year">';
		$content .= $this->getHtmlList($this->yearList,$this->list[$id]['endDateYear']);
		$content .=	'</select>';
		$content .= '<dl class="list">';
		$content .= '<dd>';
		$content .= '<input name="'.$this->listName.'_'.$id.'_title" placeholder="'.$this->titleName.'" value="'.$this->list[$id]['title'].'" />';
		$content .= '</dd>';
		$content .= '<dd>';
		$content .= '<input name="'.$this->listName.'_'.$id.'_description" placeholder="'.$this->descriptionName.'" value="'.$this->list[$id]['description'].'" />';		
		$content .= '</dd>';
		$content .= '</dl>';
		return $content;
	}
	
	public function getAllHtml() {
		$content = '';
		
		if (count($this->list) == 0) $this->create();
		
		foreach($this->list as $id => $workExperience) {
			$content .= "<dd>";
			$content .= $this->getHtml($id);
			$content .= "</dd>";
		}
		return $content;
	}
	
	public function progressDocument($templateProcessor) {
		$tempList = array();
		$prefix = '';
		
		switch($this->listName) {
			case "WorkExperience":
				$prefix = 'exp';
			break;
			case "Education":
				$prefix = 'edu';
			break;
		}
		
		foreach($this->list as $val) {
			$tempList[] = array(
				$prefix . '_date' => $val['startDateMonth'].'/'.$val['startDateYear'].' - '.$val['endDateMonth'].'/'.$val['endDateYear'],
				$prefix . '_title' => $val['title'],
				$prefix . '_description' => $val['description'],
			);
 		}
		
		$templateProcessor->cloneRowAndSetValues($prefix . '_date', $tempList);
	}
	
	public function progressPost($args=array()) {
		for ($i=0; true; $i++) {
			if (array_key_exists(''.$this->listName.'_'.$i.'_title',$args)) {
				$this->list[] = array(
					'startDateMonth' 	=> $args[$this->listName.'_'.$i.'_startDateMonth'],
					'startDateYear'		=> $args[$this->listName.'_'.$i.'_startDateYear'],
					'endDateMonth'		=> $args[$this->listName.'_'.$i.'_endDateMonth'],
					'endDateYear'		=> $args[$this->listName.'_'.$i.'_endDateYear'],
					'title'				=> $args[$this->listName.'_'.$i.'_title'],
					'description'		=> $args[$this->listName.'_'.$i.'_description'],
				);
			} else {
				if (array_key_exists('action', $args)) {
					if ($args['action'] == $this->actionTrigger) {
						$this->create();
					}
				}
				break;
			}
		}
	}
	
	private function create() {
		$this->list[] = array(
			'startDateMonth' 	=> $this->monthList[0],
			'startDateYear'		=> $this->yearList[0],
			'endDateMonth'		=> $this->monthList[count($this->monthList)-1],
			'endDateYear'		=> $this->yearList[count($this->yearList)-1],
			'title'				=> '',
			'description'		=> '',
		);
		return count($this->list)-1;
	}
	
	
	private function __constructYearList() {
		$currentYear = (int)date("Y");
		
		for ($i = 1900; $i <= $currentYear + 1; $i++) {
			$this->yearList[] = $i;
		}
	}
	
	private function __constructMonthList() {
		for ($i = 1; $i <= 12; $i++) {
			$this->monthList[] = $i;
		}
	}
	
	private function getHtmlList($list, $current) {
		$listContent = '';
		foreach($list as $content) {
			$select = ($content == $current) ? 'selected="selected" ' : '';
			$listContent .= '<option value="'.$content.'" '.$select.'>'.$content.'</option>';
		}
		return $listContent;
	}
	
}
<?php
namespace cv\Request;

class Request {
	
	private $post = array();
	
	public function __construct($args = array()) {
		$this->post = $args;
	}
	
	public function get($key) {
		if (array_key_exists($key,$this->post)) {
			return $this->post[$key];
		}
		return '';
	}
	
	public function getHtml($key) {
		print_r($this->get($key));
	}
	
	public function getList($key, $list = array()) {
		if (array_key_exists($key,$this->post)) {
			$searchString = $this->post[$key];
		}
		$content = '';
		
		foreach($list as $value) {
			$selected = ($value == $searchString) ? 'selected="selected" ' : '';
			$content .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
		}
		
		return $content;
	}
	
	public function getListHtml($key, $list = array()) {
		print_r($this->getList($key, $list));
	}
	
}
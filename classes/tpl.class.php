<?php

class tpl {
	public function __construct($template) {
		$this->template = file_get_contents($template);
		$this->templateDone = $this->template;
	}
	public function setVar($name, $value) {
		$this->templateDone = str_replace('{%' . $name . '}', $value, $this->templateDone);
	}
	public function render() {
		return $this->templateDone;
	}
	public function printit() {
		header('Content-Type: text/html');
		print $this->templateDone;
	}
}
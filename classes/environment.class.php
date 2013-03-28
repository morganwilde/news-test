<?php

class environment {
	// initialisation
	public function __construct($modelUrl, $newsDB) {
		$this->modelUrl = $modelUrl;
		$this->newsDB = $newsDB;
		$this->newsDBLink = $this->modelUrl . $this->newsDB;
		$this->xmlObject = simplexml_load_file($this->newsDBLink);
	}
	// getters
	public function getModelUrl() {
		return $this->modelUrl;
	}
	public function getNewsDB() {
		return $this->newsDB;
	}
	public function getNewsDBLink() {
		return $this->newsDBLink;
	}
	public function getXmlObject() {
		return $this->xmlObject;
	}
	public function getAction() {
		if (isset($_GET['action']) === TRUE and empty($_GET['action']) === FALSE) {
			return $_GET['action'];
		} else {
			return FALSE;
		}
	}
	public function getErrors() {
		$response = '';
		if (isset($_GET['missingTitle'])) {
			$response .= 'News item submitted with empty "title"!<br>';
		}
		if (isset($_GET['missingContent'])) {
			$response .= 'News item submitted with empty "content"!<br>';
		}
		return $response;
	}
}
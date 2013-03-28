<?php

require_once 'classes/tpl.class.php';

class actions extends news {
	public function __construct($news, $action) {
		$this->news = $news;
		$this->action = $action;
	}
	// getters
	public function getAction() {
		return $this->action;
	}
	public function getForm($form = 'newsAdd') {
		switch ($form) {
			case 'newsAdd': $tpl = new tpl('templates/news.add.html'); return $tpl->render(); break;
		}
	}
	// listen to actions
	public function listen() {
		if ($this->action !== FALSE) {
			$errors = Array();
			if ($this->action === 'newsAdd') {
				// check if everything is present
				$title = $_POST['title'];
				$content = $_POST['content'];
				// save it
				$saveResult = $this->news->setNewsItem($title, time(), $content);
				if ($saveResult !== TRUE) {
					$errors = $saveResult;
				}
			}
			// if we have errors, send them down
			if (empty($errors) === FALSE) {
				$queryString = '?' . http_build_query($errors);
			} else {
				$queryString = '';
			}
			header('Location: index.php' . $queryString);
			exit();
		}
	}
}
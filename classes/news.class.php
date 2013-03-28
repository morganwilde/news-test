<?php

require_once 'classes/external/SimpleDOM.php';
require_once 'classes/tpl.class.php';

class news {
	public function __construct($environment) {
		$this->environment = $environment;
	}
	// setters
	public function setNewsItem($title, $time, $content) {
		$newsItemTemplate = $this->environment->xmlObject->newsItem[0];
		// create a new node
		$news 		= dom_import_simplexml($this->environment->xmlObject);
		$newsItem 	= dom_import_simplexml($newsItemTemplate);
		
		// append it
		$newsItemNew 	= $news->appendChild($newsItem->cloneNode(true));
		$newsItemNode 	= simplexml_import_dom($newsItemNew);
		$newsItemNode['id'] 	= time();
		$newsItemNode->title 	= $title;
		$newsItemNode->time 	= $time;
		$newsItemNode->content 	= $content;
		
		// write to db
		if (empty($newsItemNode->title) === FALSE and empty($newsItemNode->content) === FALSE){
			$this->environment->xmlObject->asXml($this->environment->getNewsDBLink());
			return TRUE;
		} else {
			// error checking
			$error = Array();
			if (empty($newsItemNode->title) === TRUE) {
				$error['missingTitle'] = 1;
			}
			if (empty($newsItemNode->content) === TRUE) {
				$error['missingContent'] = 1;
			}
			return $error;
		}
	}
	// return news
	public function getNews() {
		$newsUnsorted = simpledom_load_string($this->environment->xmlObject->asXml());
		$newsSorted = $newsUnsorted->sortedXPath('//newsItem', '@id', SORT_DESC);
		$html = '';
		foreach ($newsSorted as $news) {
			if (empty($news->title) === FALSE) {
				$time = date("Y.m.d H:i:s", intval($news->time));
				
				$template = new tpl('templates/news.list.html');
				$template->setVar('time', $time);
				$template->setVar('title', $news->title);
				$template->setVar('content', $news->content);
				$html .= $template->render();
			}
		}
		return $html;
	}
}
<?php

require_once 'classes/environment.class.php';
require_once 'classes/news.class.php';
require_once 'classes/actions.class.php';
require_once 'classes/tpl.class.php';

$env 		= new environment('model/', 'news.data.xml');
$news 		= new news($env);
$actions 	= new actions($news, $env->getAction());
$template 	= new tpl('templates/index.html');

// listen for errors
$template->setVar('errors', $env->getErrors());

// listen for form actions
$actions->listen();

// print the news
$template->setVar('news_block', $news->getNews());

// print input form
$template->setVar('form_block', $actions->getForm());

// we're done, ship it
$template->printit();
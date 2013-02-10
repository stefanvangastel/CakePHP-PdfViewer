# PdfViewer
- - -

# Intro

Display a PDF file in a webpage using an element. Renders the PDF without the need for a PDF reader client application. Using Mozilla's Pdf.js project.

Nice to use in combination with the CakePdf plugin to create PDF's: https://github.com/ceeram/CakePdf 

# Installation and Setup


(1) Check out a copy of the PdfViewer CakePHP plugin from the repository using Git :

	git clone http://github.com/stefanvangastel/CakePHP-PdfViewer.git

or download the archive from Github: 

	https://github.com/stefanvangastel/CakePHP-PdfViewer/archive/master.zip

You must place the PdfViewer CakePHP plugin within your CakePHP 2.x app/Plugin directory.

(2) Load the plugin in app/Config/bootstrap.php

// Load PdfViewer plugin, with loading routes for short urls
	
	CakePlugin::load('PdfViewer');

# Usage

See the example (view) code below on how to use:

	<?php
	//Use the html helper to generate a link (cannot be crossdomain);
	$pdfurl = $this->Html->url('/pdf_viewer/files/cookbookdemo.pdf',true); //Using true for full url, cookbookdemo.pdf is an example in the webroot of the plugin

	$vieweroptions = array(
			'pdfurl' 	=>	$pdfurl,
			'class'		=>	'span6', //Class you want to give to canvas, use your own class. I use TwitterBootstrap so therefore i use the span6 (half page) class.
			'scale'		=>	2.0, //The 'zoom' or 'scale' factor. I use 2 for making the PDF more sharp in displaying. 
			'startpage'	=>	1, //Starting page
		);

	//Get the PdfView element that renders the PDF
	echo $this->element('PdfViewer.viewer',$vieweroptions);
	?>
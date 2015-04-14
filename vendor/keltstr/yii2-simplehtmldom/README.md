"PHP Simple HTML DOM Parser" Yii2 extension (keltstr/yii2-simplehtmldom)
===============
"Simple HTML Dom"(PHP Simple HTML DOM Parser) http://simplehtmldom.sourceforge.net/ library rev.210 adapted to yii2 extension class autoload(psr-4 from \vendor\keltstr\simplehtmldom) 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Either run
```
php composer.phar require --prefer-dist keltstr/yii2-simplehtmldom "dev-master"
```
or (if composer installed to OS)
```
composer require --prefer-dist keltstr/yii2-simplehtmldom "dev-master"
```
OR add(code below) to the require section of your `composer.json` file and run command Install(Composer)
```
"keltstr/yii2-simplehtmldom": "dev-master"
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \keltstr\simplehtmldom\SimpleHTMLDom::file_get_html('http://google.com'); ?>```
```
OR use alias namespace by `use`
```php
<?php
use keltstr\simplehtmldom\SimpleHTMLDom as SHD
$html_source = SHD::file_get_html('http://google.com'); 
?>
```
About the functional read on the official website: http://simplehtmldom.sourceforge.net/

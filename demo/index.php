<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Karla demo</title>
	<link href="http://alexgorbatchev.com/pub/sh/current/styles/shThemeRDark.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php
    require_once 'Demo.php';
    $demo = new Demo();
    $examples = $demo->examples();
    ?>
    
    <?php foreach ($examples as $example) :?>
     <h2><?php echo $example['name'];?></h2>
    <img alt="demo" src="<?php echo $example['original'];?>"/>
    <img alt="demo" src="<?php echo $example['result'];?>"/>
    <h3>Karla query</h3>
    <pre class='brush: php'>
    <?php echo $example['code'];?>
    </pre>
    <h3>Imagemagick query</h3>
    <pre class='brush: bash'>
    <?php echo $example['console'];?>
     </pre>
     <hr/>
    <?php endforeach;?>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js" type="text/javascript"></script>
  <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushPhp.js" type="text/javascript"></script>
  <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushBash.js" type="text/javascript"></script>
  <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shAutoloader.js" type="text/javascript"></script>
  <script type="text/javascript">SyntaxHighlighter.all();</script>
</body>
</html>

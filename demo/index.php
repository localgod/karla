<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Karla demo</title>
	<style>
	/* Pretty printing styles. Used with prettify.js. */
/* Vim sunburst theme by David Leibovic */

pre .str, code .str { color: #65B042; } /* string  - green */
pre .kwd, code .kwd { color: #E28964; } /* keyword - dark pink */
pre .com, code .com { color: #AEAEAE; font-style: italic; } /* comment - gray */
pre .typ, code .typ { color: #89bdff; } /* type - light blue */
pre .lit, code .lit { color: #3387CC; } /* literal - blue */
pre .pun, code .pun { color: #fff; } /* punctuation - white */
pre .pln, code .pln { color: #fff; } /* plaintext - white */
pre .tag, code .tag { color: #89bdff; } /* html/xml tag    - light blue */
pre .atn, code .atn { color: #bdb76b; } /* html/xml attribute name  - khaki */
pre .atv, code .atv { color: #65B042; } /* html/xml attribute value - green */
pre .dec, code .dec { color: #3387CC; } /* decimal - blue */

pre.prettyprint, code.prettyprint {
        background-color: #000;
        -moz-border-radius: 8px;
        -webkit-border-radius: 8px;
        -o-border-radius: 8px;
        -ms-border-radius: 8px;
        -khtml-border-radius: 8px;
        border-radius: 8px;
}

pre.prettyprint {
        width: 95%;
        margin: 1em auto;
        padding: 1em;
        white-space: pre-wrap;
}


/* Specify class=linenums on a pre to get line numbering */
ol.linenums { margin-top: 0; margin-bottom: 0; color: #AEAEAE; } /* IE indents via margin-left */
li.L0,li.L1,li.L2,li.L3,li.L5,li.L6,li.L7,li.L8 { list-style-type: none }
/* Alternate shading for lines */
li.L1,li.L3,li.L5,li.L7,li.L9 { }

@media print {
  pre .str, code .str { color: #060; }
  pre .kwd, code .kwd { color: #006; font-weight: bold; }
  pre .com, code .com { color: #600; font-style: italic; }
  pre .typ, code .typ { color: #404; font-weight: bold; }
  pre .lit, code .lit { color: #044; }
  pre .pun, code .pun { color: #440; }
  pre .pln, code .pln { color: #000; }
  pre .tag, code .tag { color: #006; font-weight: bold; }
  pre .atn, code .atn { color: #404; }
  pre .atv, code .atv { color: #060; }
}
	
	</style>
</head>
<body onload="prettyPrint()">
    <?php
    require_once 'Demo.php';
    $demo = new Demo();
    $examples = $demo->examples();
    ?>
    
    <?php foreach ($examples as $example) :?>
     <h2><?php echo $example['name'];?></h2>
    <img alt="demo" src="<?php echo $example['original'];?>"/>
    <img alt="demo" src="<?php echo $example['result'];?>"/>
    <h3>Imagick code</h3>
    <pre class="prettyprint lang-php">
    <?php echo $example['imagick'];?>
    </pre>
    <h3>Karla query code</h3>
    <pre class="prettyprint lang-php">
    <?php echo $example['code'];?>
    </pre>
    <h3>Imagemagick query</h3>
    <pre class="prettyprint lang-bsh">
    <?php echo $example['console'];?>
     </pre>
     <hr/>
    <?php endforeach;?>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/188.0.0/prettify.js"></script>
</body>
</html>

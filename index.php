<!DOCTYPE HTML>
<html>
  <head>
    <title>PHPbeard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <style>.pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#607d8b;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px}</style>
  </head>
  <body>
    <div class="container">
      <div class="row">
      <?php
    // include lastRSS
    include "./lastRSS.php";

    // Create lastRSS object
    $rss = new lastRSS;

    // Set cache dir and cache time limit (1200 seconds)
    // (don't forget to chmod cahce dir to 777 to allow writing)
    $rss->cache_dir = './temp';
    $rss->cache_time = 1200;

    // Try to load and parse RSS file
    if ($rs = $rss->get('https://www.urduru.com/phpbeard/combine')) {
      // Show website logo (if presented)
      if ($rs[image_url] != '') {
        echo "<a href=\"$rs[image_link]\"><img src=\"$rs[image_url]\" alt=\"$rs[image_title]\"  /></a>\n";
      }
    // Show clickable website title
      echo "<div class='pull-left col-lg-12 col-md-12 col-sm-12 col-xs-12'><h1><a href=\"$rs[link]\">$rs[title]<sup>beta</sup></a></h1></div>\n";
    // Show website description
    // echo "<p>$rs[description]</p>\n";
    // Show last published articles (title, link, description)
    echo '<div class="pull-left col-lg-8 col-md-8 col-sm-8 col-xs-8">';
    echo "<ul>\n";
    foreach($rs['items'] as $item) {
      echo "\t<li class='list title'><a href=\"$item[link]\">".$item['title']."</a>".$item['description']."</li>\n";
    }
    echo "</ul>\n";
  }
  else {
    echo "Error: It's not possible to reach RSS file...\n";
  }
    ?>
  </div>
  <div class="pull-right">
    <ul><h4>
      <li class="or side">&nbsp;&nbsp;tech&nbsp;&nbsp;</li>
      <li class="yl side">&nbsp;&nbsp;gaming&nbsp;&nbsp;</li>
      <li class="pr side">&nbsp;&nbsp;culture&nbsp;&nbsp;</li>
      <li class="bl side">&nbsp;&nbsp;dev&nbsp;&nbsp;</li>
      <li class="rd side">&nbsp;&nbsp;food&nbsp;&nbsp;</li>
      <li class="gn side">&nbsp;&nbsp;money&nbsp;&nbsp;</li>
      <li class="lb side">&nbsp;&nbsp;science&nbsp;&nbsp;</li>
    </h4></ul>
  </div>
  </div>
    </div>
  </body>
</html>

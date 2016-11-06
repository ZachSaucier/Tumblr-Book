<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Tumblr Book</title>

  <link rel="stylesheet" href="style.css">
</head>
<body>

  <script>
  var siteURL = '<?php
  if(isset($_GET['blog'])){
	  echo 'https://' . $_GET['blog'] . '.tumblr.com/';
  }else{
	  // temporary default
	  echo 'https://solacingsavant.tumblr.com/';
  }
  ?>';
  </script>
  <script src="tumblr-book.js"></script>
</body>
</html>
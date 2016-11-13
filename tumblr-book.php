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
  <?php
  if(isset($_GET['blog']) && $_GET['blog'] !== ''){
	  echo 'var siteURL = "https://' . $_GET['blog'] . '.tumblr.com/";';
	  echo 'var blogname = "' . $_GET['blog'] . '";';
  }else{
	  // temporary default
	  echo 'var siteURL = "https://solacingsavant.tumblr.com/";';
	  echo 'var blogname = "solacingsavant";';
  }
  ?>
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="tumblr-book.js"></script>
</body>
</html>
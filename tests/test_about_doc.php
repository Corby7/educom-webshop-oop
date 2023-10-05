<?php

  include_once "../views/about_doc.php";

  $data = array ( 'page' => 'about', /* other fields */ );

  $view = new AboutDoc($data);
  $view  -> show();

?>
<?php

  include_once "../views/home_doc.php";

  $data = array ( 'page' => 'home', /* other fields */ );

  $view = new HomeDoc($data);
  $view  -> show();

?>
<?php

  include_once "../views/webshop_doc.php";

  $data = array ( 'page' => 'webshop', /* other fields */ );

  $view = new WebshopDoc($data);
  $view  -> show();

?>
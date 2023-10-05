<?php

  include_once "../views/basic_doc.php";

  $data = array ( 'page' => 'basic', /* other fields */ );

  $view = new BasicDoc($data);
  $view  -> show();

?>
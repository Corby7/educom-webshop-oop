<?php

  include_once "../views/topfive_doc.php";

  $data = array ( 'page' => 'topfive', /* other fields */ );

  $view = new TopfiveDoc($data);
  $view  -> show();

?>
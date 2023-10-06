<?php

  include_once "../views/error_doc.php";

  $data = array ( 'page' => 'error', /* other fields */ );

  $view = new ErrorDoc($data);
  $view  -> show();

?>
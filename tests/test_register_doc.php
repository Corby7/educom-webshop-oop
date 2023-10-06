<?php

  include_once "../views/register_doc.php";

  $data = array ( 'page' => 'register', /* other fields */ );

  $view = new RegisterDoc($data);
  $view  -> show();

?>
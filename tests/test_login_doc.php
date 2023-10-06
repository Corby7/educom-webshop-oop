<?php

  include_once "../views/login_doc.php";

  $data = array ( 'page' => 'login', /* other fields */ );

  $view = new LoginDoc($data);
  $view  -> show();

?>
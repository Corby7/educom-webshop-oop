<?php

  include_once "../views/ordersucces_doc.php";

  $data = array ( 'page' => 'ordersucces', /* other fields */ );

  $view = new OrderSuccesDoc($data);
  $view  -> show();

?>
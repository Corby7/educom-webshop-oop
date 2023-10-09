<?php

  include_once "../views/shoppingcart_doc.php";

  $data = array ( 'page' => 'shoppingcart', /* other fields */ );

  $view = new ShoppingCartDoc($data);
  $view  -> show();

?>
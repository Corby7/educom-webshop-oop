<?php
include_once "product_doc.php";

class ProductPageDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Productpagina';
    }

    protected function showContent() {
        extract($this->model->product);

        echo '
        <ul class="product">
            <div class="productimage">
                <li><img src="images/' . $filenameimage . '"</li>
            </div>
            <div class="productinfo">
                <li class="productname">' . $name . '</li>
                <li class="price">€' . $price . '</li>
                <li class="description">' . $description . '</li>';
                if($this->model->isUserLoggedIn()) {
                    echo '<li>';
                        $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $id);
                    echo '</li>';
                }
            echo '
            </div>
        </ul>';
    }


}

?>
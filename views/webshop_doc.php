<?php
include_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Webshop';
    }

    protected function showContent() {
        echo '<ul class="products">';

    foreach ($this->model->products as $product) {
        extract($product);
        
        echo '
        <a href="index.php?page=productpage&productid=' . $id . '" class="productlink">
            <ul class="productcard">
                <li>' . $id . '</li>
                <li><img src="images/' . $filenameimage . '"></li>
                <div class="productcardbottom">
                    <div class="productcardleft">
                        <li class="productname">' . $name . '</li>
                        <li class="price">€' . $price . '</li>
                    </div>
                    <div class="productcardright">';
                    if($this->model->isUserLoggedIn()) {
                        echo '<li>';
                           $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $id);
                        echo '</li>';
                    }
                    echo '
                    </div>
                </div>
            </ul>
        </a>';
    }

        echo '</ul>';
    }

}

// <form method="post" action="index.php">
// <input type="hidden" name="id" value=' . $id . '>
// <input type="hidden" name="action" value="addtocart">
// <button type="submit" name="page" value="shoppingcart">Add to cart</button>
// </form>

?>
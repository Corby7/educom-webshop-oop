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
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <img src="images/' . $filenameimage . '" class="img-fluid" style="width: 350px" alt="Image of ' . $name . '">
            </div>
            <div class="col-md-8">
                <div class="product-card product-info">
                    <h2 class="card-title product-name">' . $name . '</h2>
                    <p class="card-text price h5">€' . $price . '</p>
                    <p class="card-text description">' . $description . '</p>';
                    if($this->model->isUserLoggedIn()) {
                            $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $id);
                    }
                echo '
                </div>
            </div>
        </div>';
    }


}

?>
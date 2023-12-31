<?php
include_once "product_doc.php";

class ProductPageDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Productpagina';
    }

    protected function showContent() {
        $product = $this->model->product;

        echo '
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <img src="images/' . $product->filenameimage . '" class="img-fluid" style="width: 350px" alt="Image of ' . $product->name . '">
            </div>
            <div class="col-md-8">
                <div class="d-flex flex-column product-card product-info gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column gap-2">
                            <h2 class="card-title product-name">' . $product->name . '</h2>
                            <p class="card-text price h4 fw-bold text-danger">€' . $product->price . '</p>
                        </div>
                        <div class="rating me-3 ';
                        if(!$this->model->isUserLoggedIn()) {
                            echo 'unclickablerating';
                        }
                        echo '" data-productid="' . $product->id . '">';
                            $this->ratingStars();
                        echo '
                        </div>
                    </div>
                    <p class="card-text description">' . $product->description . '</p>';
                    if($this->model->isUserLoggedIn()) {
                            $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $product->id);
                    }
                echo '
                </div>
            </div>
        </div>';
    }


}

?>
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
                <div class="product-card product-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="card-title product-name">' . $product->name . '</h2>
                            <p class="card-text price h5">€' . $product->price . '</p>
                        </div>
                        <div class="rating" data-productid="' . $product->id . '">
                            <span class="star" data-value="1"><i class="bi bi-star"></i></span>
                            <span class="star" data-value="2"><i class="bi bi-star"></i></span>
                            <span class="star" data-value="3"><i class="bi bi-star"></i></span>
                            <span class="star" data-value="4"><i class="bi bi-star"></i></span>
                            <span class="star" data-value="5"><i class="bi bi-star"></i></span>
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
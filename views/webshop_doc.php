<?php
include_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Webshop';
    }

    protected function showContent() {
        echo '<div class="row row-cols-md-2 row-cols-xl-3 g-3">';

        foreach ($this->model->products as $product) {
            
            echo '
            <div class="col">
                <div class="card">
                    <a href="index.php?page=productpage&productid=' . $product->id . '" class="productlink text-decoration-none">
                        <img src="images/' . $product->filenameimage . '" class="img-fluid" style="width: 400px" alt="Image of ' . $product->name . '">
                    </a>
                    <div class="card-body d-flex flex-wrap g-4 justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <span class="card-title h2">' . $product->name . '</span>
                            <div class="rating" data-productid="' . $product->id . '">
                                <span class="star" data-value="1">*</span>
                                <span class="star" data-value="2">*</span>
                                <span class="star" data-value="3">*</span>
                                <span class="star" data-value="4">*</span>
                                <span class="star" data-value="5">*</span>
                            </div>
                            <span class="card-subtitle">€' . $product->price . '</span>
                        </div>
                        <div>';
                        if($this->model->isUserLoggedIn()) {
                            $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $product->id);
                        }
                        echo '
                        </div>
                    </div>
                </div>
            </div>';
        }

    echo '</div>';
    }

}

?>
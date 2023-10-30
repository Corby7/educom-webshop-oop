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
                    <div class="card-body d-flex justify-content-between m-1">
                        <div class="d-flex flex-column justify-content-evenly">
                            <span class="card-title h2">' . $product->name . '</span>
                            <div class="rating unclickablerating" data-productid="' . $product->id . '">';
                                $this->ratingStars();
                            echo '</div>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center gap-2">
                            <span class="card-subtitle h4 fw-bold text-danger">€' . $product->price . '</span>';
                            if($this->model->isUserLoggedIn()) {
                                $this->showActionForm('shoppingcart', 'addtocart', '', $product->id);
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
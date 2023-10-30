<?php
include_once "product_doc.php";

class TopFiveDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Top 5 Producten';
    }

    protected function showContent() {
        $ranking = 0;
        echo '<div class="row">';
    
        foreach ($this->model->products as $product) {
            $ranking += 1;
            
            echo '
            <div class="col-12 mb-4">
                <a href="index.php?page=productpage&productid=' . $product->id . '" class="productlink text-decoration-none">
                    <div class="card flex-md-row h-60">
                        <img src="images/' . $product->filenameimage . '" class="img-fluid" style="width: 200px" alt="Image of ' . $product->name . '">
                        <div class="card-body col-md-6 d-flex gap-5">
                            <span class="card-title h2">' . $ranking . '.</span>
                            <div class="d-flex flex-column justify-content-evenly">
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="card-title h2">' . $product->name . '</span>
                                    <div class="rating" data-productid="' . $product->id . '">
                                        <span class="star" data-value="1"><i class="bi bi-star"></i></span>
                                        <span class="star" data-value="2"><i class="bi bi-star"></i></span>
                                        <span class="star" data-value="3"><i class="bi bi-star"></i></span>
                                        <span class="star" data-value="4"><i class="bi bi-star"></i></span>
                                        <span class="star" data-value="5"><i class="bi bi-star"></i></span>
                                    </div>
                                </div>    
                                <p class="card-text h4 fw-bold text-danger">€' . $product->price . '</p>';
                                if($this->model->isUserLoggedIn()) {
                                    $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $product->id);
                                }
                            echo '
                            </div>
                        </div>
                    </div>
                </a>
            </div>';
        }
    
        echo '</div>';
    }


}

?>
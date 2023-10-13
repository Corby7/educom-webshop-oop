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
            extract($product);
            
            echo '
            <div class="col-12 mb-4">
                <a href="index.php?page=productpage&productid=' . $id . '" class="productlink text-decoration-none">
                    <div class="card flex-md-row h-60">
                        <img src="images/' . $filenameimage . '" class="img-fluid" style="width: 200px" alt="Image of ' . $name . '">
                        <div class="card-body col-md-6 d-flex gap-5">
                            <span class="card-title h2">' . $ranking . '.</span>
                            <div class="d-flex flex-column justify-content-evenly">
                                <span class="card-title h2">' . $name . '</span>
                                <p class="card-text h4">€' . $price . '</p>';
                                if($this->model->isUserLoggedIn()) {
                                    $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $id);
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
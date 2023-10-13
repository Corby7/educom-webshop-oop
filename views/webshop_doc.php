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
            extract($product);
            
            echo '
            <div class="col">
                <a href="index.php?page=productpage&productid=' . $id . '" class="productlink text-decoration-none">
                    <div class="card">
                        <img src="images/' . $filenameimage . '" class="img-fluid" style="width: 400px" alt="Image of ' . $name . '">
                        <div class="card-body d-flex flex-wrap g-4 justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <span class="card-title h2">' . $name . '</span>
                                <span class="card-subtitle">€' . $price . '</span>
                            </div>
                            <div>';
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

// <form method="post" action="index.php">
// <input type="hidden" name="id" value=' . $id . '>
// <input type="hidden" name="action" value="addtocart">
// <button type="submit" name="page" value="shoppingcart">Add to cart</button>
// </form>

?>
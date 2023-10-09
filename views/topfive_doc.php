<?php
include_once "product_doc.php";

class TopFiveDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Top 5 Producten';
    }

    protected function showContent() {
        $ranking = 0;
        echo '<ul class="topfiveproducts">';
    
        foreach ($this->data['products'] as $product) {
            $ranking += 1;
            extract($product);
            
            echo '
            <li class="topfiveproductcard">
                <a href="index.php?page=productpage&productid=' . $id . '" class="productlink">
                    <ul>
                        <li><img src="images/' . $filenameimage . '"></li>
                        <div class="productcardbottom">
                            <div class="productcardleft">
                                <li class="ranking">' . $ranking . '.</li>
                                <li class="productname">' . $name . '</li>
                                <li class="price">€' . $price . '</li>
                            </div>
                            <div class="productcardright">';
                            if(isUserLoggedIn()) {
                                echo '<li>';
                                    $this->showActionForm('shoppingcart', 'addtocart', 'Add to cart', $id);
                                echo '</li>';
                            }
                            echo '
                            </div>
                        </div>
                    </ul>
                </a>
            </li>';
        }
    
        echo '</ul>';
    }


}

?>
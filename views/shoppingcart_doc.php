<?php
include_once "product_doc.php";

class ShoppingCartDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Shopping Cart';
    }

    protected function showContent() {
        if (empty($_SESSION['shoppingcart'])) {
            echo '<h3>Uw winkelmandje is leeg.</h3>';
            return;
        }
    
        echo '
        <div class="shoppingcart">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Artikel:</th>
                        <th>Prijs:</th>
                        <th>Aantal:</th>
                        <th>Subtotaal:</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">';
    
                foreach ($this->model->cartLines as $cartline) {
                    extract($cartline);
                    
                    echo '
                    <tr>
                        <td><a href="index.php?page=productpage&productid=' . $id . '" class="productlink"><img src="images/' . $filenameimage . '"class="img-fluid" style="width: 100px" alt="Image of ' . $name . '"></a></td>
                        <td><a href="index.php?page=productpage&productid=' . $id . '" class="productlink">' . $name . '</a></td>
                        <td>€' . number_format($price,2) . '</td>
                        <td>';
                            $this->showActionForm('shoppingcart', 'removefromcart', 'dash', $id, 'shoppingcart','addtocart', 'plus',  $quantity, );
                        echo '
                        </td>
                        <td>€' . number_format($subtotal, 2) . '</td>
                    </tr>';
                }
                
                echo '
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Totaalprijs: €' . number_format(($this->model->cartTotal), 2) . '</th>
                    </tr>
                </tfoot>
            </table>
            <div class= "d-flex justify-content-end me-5">';
                $this->showActionForm('shoppingcart', 'checkout', 'Afrekenen');
            echo '</div>';
        echo '</div>';
    }
     
}

?>
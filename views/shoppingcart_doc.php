<?php
include_once "product_doc.php";

class ShoppingCartDoc extends ProductDoc {

    protected function showHeader() {
        echo '
        Shopping Cart';
    }

    protected function showContent() {
        if (empty($_SESSION['shoppingcart'])) {
            echo '<h1>Uw winkelmandje is leeg.</h1>';
            return;
        }
    
        echo '
        <div class="shoppingcart">
            <table>
                <tr>
                    <th></th>
                    <th>Artikel</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                    <th>Subtotaal</th>
                </tr>';
    
                foreach ($this->model->cartLines as $cartline) {
                    extract($cartline);
                    
                    echo '
                    <tr>
                            <td><a href="index.php?page=productpage&productid=' . $id . '" class="productlink"><img src="images/' . $filenameimage . '"</a></td>
                            <td><a href="index.php?page=productpage&productid=' . $id . '" class="productlink">' . $name . '</a></td>
                        </a>
                        <td>€' . number_format($price,2) . '</td>
                        <td>';
                            $this->showActionForm('shoppingcart', 'removefromcart', '-', $id, $quantity, 'addtocart', '+');
                        echo '
                        </td>
                        <td>€' . number_format($subtotal, 2) . '</td>
                    </tr>';
                }
                
                echo '
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Totaalprijs: €' . number_format(($this->model->cartTotal), 2) . '</th>
                </tr>
            </table>';
            $this->showActionForm('shoppingcart', 'checkout', 'Afrekenen');
        echo '</div>';
    }
     
}

?>
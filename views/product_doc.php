<?php
include_once "basic_doc.php";

abstract class ProductDoc extends BasicDoc {

    protected function showActionForm(name, $text, action, optional id) {
        echo '
        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <input type="hidden" name="action" value="' . $value . '">
            <button type="submit" name="page" value="' . $value . '">' . $text . '</button>
        </form>
        ';


        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <input type="hidden" name="action" value="addtocart">
            <button type="submit" name="page" value="shoppingcart">Add to cart</button>
        </form>

        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <input type="hidden" name="action" value="addtocart">
            <button type="submit" name="page" value="shoppingcart">Add to cart</button>
        </form>

        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <input type="hidden" name="action" value="addtocart">
            <button type="submit" name="page" value="shoppingcart">Add to cart</button>
        </form>

        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <input type="hidden" name="page" value="shoppingcart">
            <button type="submit" name="action" value="removefromcart">-</button>
            ' . $quantity . '
            <button type="submit" name="action" value="addtocart">+</button>
        </form>

        <form method="post" action="index.php">
            <input type="hidden" name="id" value=' . $id . '>
            <button type="submit" name="page" value="checkout">Afrekenen</button>
        </form>
    }

}

?>
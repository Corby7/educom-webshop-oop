<?php
include_once "basic_doc.php";

abstract class ProductDoc extends BasicDoc {

    protected function showActionForm($pagevalue, $actionvalue, $text, $id = "", $quantity = NULL, $actionvalue2 = "", $text2 = "") {
        echo '
        <form method="post" action="index.php">';
            if (!empty($id)) {
                echo '<input type="hidden" name="id" value=' . $id . '>';
            }
            echo '
            <input type="hidden" name="page" value="' . $pagevalue . '">
            <button type="submit" name="action" value="' . $actionvalue . '">' . $text . '</button>';
            if ($quantity !== NULL) {
                echo $quantity;
                echo '<button type="submit" name="action" value="' . $actionvalue2 . '">' . $text2 . '</button>';
            }
        echo '
        </form>';
    }


    //     <form method="post" action="index.php">
    //         <input type="hidden" name="id" value=' . $id . '>
    //         <input type="hidden" name="page" value="shoppingcart">
    //         <button type="submit" name="action" value="addtocart">Add to cart</button>
    //     </form>

    //     <form method="post" action="index.php">
    //         <input type="hidden" name="id" value=' . $id . '>
    //         <input type="hidden" name="page" value="shoppingcart">
    //         <button type="submit" name="action" value="removefromcart">-</button>
    //         ' . $quantity . '
    //         <button type="submit" name="action" value="addtocart">+</button>
    //     </form>

    //     <form method="post" action="index.php">
    //         <input type="hidden" name="page" value="shoppingcart">
    //         <button type="submit" name="action" value="checkout">Afrekenen</button>
    //     </form>
    // }

}

?>
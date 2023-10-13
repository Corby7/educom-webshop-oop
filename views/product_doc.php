<?php
include_once "basic_doc.php";

abstract class ProductDoc extends BasicDoc {

    protected function showActionForm($pagevalue, $actionvalue, $text, $id = "", $type = "", $actionvalue2 = "", $text2 = "", $quantity = NULL, ) {
        echo '
        <div>
            <form method="post" action="index.php">';
                if (!empty($id)) {
                    echo '<input type="hidden" name="id" value=' . $id . '>';
                }
                echo '
                <input type="hidden" name="page" value="' . $pagevalue . '">';

                if (empty($type)) {
                    echo '
                    <button class="cartplus btn btn-primary d-flex gap-2 pxy-2 webshop-button" id="button-invert" 
                    type="submit" name="action" value="' . $actionvalue . '">
                        <i class="bi bi-bag-plus"></i>
                        <i class="bi bi-bag-plus-fill"></i>
                        <span class="btn-text">' . $text . '</span>
                    </button>';

                } else {

                    $buttons = [
                        ['text' => $text, 'actionvalue' => $actionvalue],
                        ['text' => $text2, 'actionvalue' => $actionvalue2],
                    ];
                    
                    echo '<div class="d-flex align-items-center">';
                    foreach($buttons as $index => $button) {
                        echo'
                        <button class="cart' . $button['text'] . ' btn>
                        type="submit" name="action" id="button-shoppingcart" value="' . $button['actionvalue'] . '">
                            <i class="bi bi-bag-' . $button['text'] . '"></i>
                            <i class="bi bi-bag-' . $button['text'] . '-fill"></i>
                        </button>'; 

                        if ($index === 0 && $quantity !== NULL) {
                            echo $quantity;
                        }
                    }
                    echo '</div>';
                }
            echo '
            </form>
        </div>';
    }

}

?>
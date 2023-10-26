$(document).ready(function() {

  productID = $(".rating").attr('data-productid');
  console.log(productID);


    $.ajax({
      type: 'GET',
      url: "index.php?action=ajax&function=getRating&id=4>",
      success: function($ratingValue) {
        console.log('succes', $ratingValue);
        fillStars(parseInt($ratingValue));
      }
    });

    function fillStars($value) {
      $('.star').each((index, elem) => {
        const itemValue = $(elem).attr('data-value')
        if(itemValue <= $value) {
          $(elem).addClass('red')
        }
      });
    }

   
    $(".star").click(function() {
        const value = $(this).attr('data-value')

        //clear all stars on click
        $(".star").removeClass('red')
        
        //paint all stars red
        fillStars(value);

        $.ajax({
          type: "POST",
          url: "index.php?action=ajax",
          data: { rating: value },
          success: function(result) {
            //code dat runned op succes
          }
        });
    })

 });




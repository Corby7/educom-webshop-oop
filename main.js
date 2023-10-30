$(document).ready(function() {

  showAllRatings();

  function showAllRatings() {
    $('.rating').each((index, elem) => {
      const productId = $(elem).attr('data-productid')
  
      $.ajax({
        type: 'GET',
        url: "index.php?action=ajax&function=getRating&id=" + productId,
        success: function (ratingValue) {
          //console.log('ratingvalue:', ratingValue);
          fillAllStars(productId, parseInt(ratingValue));
        }
      });
    });
  }
  
  function fillAllStars(productId, value) {
    $('.rating[data-productid="' + productId + '"] .star').each((index, elem) => {
      const itemValue = $(elem).attr('data-value');
      //console.log(index + ":" + itemValue);
      if (parseInt(itemValue) <= value) { 
        $(elem).addClass('red');
      }
    });
  }

  // function getRating() {
  //   productId = $(".rating").attr('data-productid');
  //   console.log(productId);
  //   fillStar(rating);
  // }


  function fillStar(value) {
    $('.star').each((index, elem) => {
      const itemValue = $(elem).attr('data-value')
      //console.log(index + ":" + itemValue);
      if(itemValue <= value) {
        $(elem).addClass('red')
      }
    });
  }

  updateRating();

  function updateRating() {
    const productId = $('.rating').attr('data-productid');
    console.log(productId);

    $(".star").click(function() {
        const value = $(this).attr('data-value')
        console.log(value);

        //clear all stars on click
        $(".star").removeClass('red')
        
        //paint all stars red
        fillStar(value);

        $.ajax({
          type: "POST",
          url: "index.php?action=ajax&function=updateRating&id=" + productId + "&rating=" + value,
          //data: { rating: value },
          success: function(result) {
            //code dat runned op succes
          }
        });
    })
  }

 });




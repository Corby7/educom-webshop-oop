$(document).ready(function() {

  showAllRatings();

  function showAllRatings() {
    var productsArray = [];

    //loop through all products and add them to array
    $('.rating').each((index, elem) => {
      const productId = $(elem).attr('data-productid');
      productsArray.push(productId);
    });

    //if array only has one product, get that rating
    if (productsArray.length === 1) {
      const productId = productsArray[0];
      getAjax("getRating&id=" + productId);
  
    //if array has more products, get all ratings
    } else {
      getAjax("getAllRatings");
    }
  }

  function getAjax(url) {
    $.ajax({
      type: 'GET',
      url: "index.php?action=ajax&function=" + url,
      success: function (data) {
        const productsArray = JSON.parse(data);
  
        $.each(productsArray, function(index, product) {
            fillAllStars(product.id, product.rating);
        });
      }
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




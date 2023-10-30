$(document).ready(function() {

  showAllRatings();

  function showAllRatings() {
    var productsArray = [];

    //loop through all products and add them to array
    $('.rating').each((index, elem) => {
      const productId = $(elem).data('productid');
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
            fillStars(product.rating, product.id);
        });
      }
    }); 
  }

  function fillStars(value, productId = null) {
    const selector = productId !== null ? `.rating[data-productid="${productId}"]` : '';
    $(`${selector} .star`).each((index, elem) => {
      const itemValue = $(elem).data('value');
      const star = $(elem).find('.bi-star');
      const starFill = $(elem).find('.bi-star-fill');
  
      if (itemValue <= value) {
        star.addClass('hide');
        starFill.removeClass('hide');
      } else {
        star.removeClass('hide');
        starFill.addClass('hide');
      }
    });
  }
  
  updateRating();

  function updateRating() {
    const productId = $('.rating').data('productid');

    $(".star").click(function() {
        const value = $(this).data('value')
        console.log(value);

        //paint all stars
        fillStars(value);

        $.ajax({
          type: "POST",
          url: "index.php?action=ajax&function=updateRating&id=" + productId + "&rating=" + value,
          success: function(data) {
            const productsArray = JSON.parse(data);
  
            $.each(productsArray, function(index, product) {
                fillStars(product.rating, product.id);
            }); 
          }
        });
    });
  }

 });




$(document).ready(function() {
   
    $(".star").click( function() {
        const value = $(this).attr('data-value')

        $(".star").removeClass('red')
        
        $('.star').each( (index, elem) => {
            const itemValue = $(elem).attr('data-value')
            if(itemValue <= value) {
              $(elem).addClass('red')
            }
          })
    })

 });


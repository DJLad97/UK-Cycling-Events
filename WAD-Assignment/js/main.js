var moveDown = false;

function moveDownCirle(){
  if(!moveDown) {
    $('#navButton').animate({
        'margin-top': "+=120px"
      }, 'slow');

      moveDown = true;
  }
  else if(moveDown) {

    $('#navButton').animate({
        'margin-top': "-=120px"
      }, 'slow');

      moveDown = false;
  }
}

// function fadeInElements(){
//   $(window).scroll(function(){
//     $('fade-in').each(function(i){
//       var bottomOfObject = $(this).position().top + $(this).outerHeight();
//       var bottomOfWindow = $(window).scrollTop() + $(window).height();
//
//       if(bottomOfWindow > bottomOfObject){
//         $(this).animate({'opacity' : '1'}, 1500);
//       }
//     });
//   });
// }

$(document).ready(function(){

  $('header nav').meanmenu();
  $('#myCarousel').carousel();
  $('#myCarousel').fadeIn('slow');

  $(window).scroll( function(){
      $('.fade-in').each( function(i){

          var bottomOfObject = $(this).position().top + $(this).outerHeight();
          var bottomOfWindow = $(window).scrollTop() + $(window).height();

          bottomOfWindow = bottomOfWindow + 200;

          if( bottomOfWindow > bottomOfObject ){
              $(this).animate({'opacity':'1'},500);
          }
      });
   });

   $(".moveDownBtn").click(function(){

       $('html, body').animate({
          scrollTop: $("#upcoming-races").offset().top - 500
       }, 1200, 'easeInOutSine');

   });

   $(window).resize(function()
   {
      var viewportWidth = $(window).width();
      if (viewportWidth <= 768) {
          $(".removeLeft").removeClass("navbar-left");
      }
      else {
          $(".removeLeft").addClass("navbar-left");
      }
    });


  $('#navButton').click(function(){
      $('#fullDropdown').slideToggle('slow');
      moveDownCirle();
  });

  $('li').click(function(){
      $('#fullDropdown').slideToggle('slow');
      moveDownCirle();

  });

  $('[name=isFree]').change(function(){
      if($(this).val() == 'no') {
          $('#priceTextBox').slideDown('slow');
      }
      else {
          $('#priceTextBox').slideUp('slow');
      }
  });

  // var replyForm = "<div id="reply-comment">" +
  //   "<form action="add-comment.php" method="post">" +
  //     "<input type="hidden" name="raceID" value="<?php echo $commentResult->CommentID; ?>">" +
  //     "<label>Reply to comment</label>" +
  //     "<textarea type="comments" class="form-control" name="replyCommet"></textarea>" +
  //     "<input type="submit" value="Reply" name="replyBtn" class="btn btn-primary"></input>" +
  //   "</form>" +
  // "</div>"
  //
  // $('.reply-text').click(function(){
  //     $('#reply-comment').slideToggle('slow');
  // });

});

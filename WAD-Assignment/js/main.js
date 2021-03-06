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

function deselect(e){
  $('.popup').slideToggle(function() {
    e.removeClass('selected');
  })
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

  var modal = document.getElementById('login-modal');


  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }

  var modal2 = document.getElementById('signup-modal');

  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  }
  $('#cart').on('click', function(){
    if($(this).hasClass('selected')){
      deselect($(this));
    }
    else{
      $(this).addClass('selected');
      $('.cart-window').slideToggle();
    }
    return false;
  });

  $('#add-to-cart').on('click', function(){
    if($(this).hasClass('selected')){
      deselect($(this));
    }
    else{
      $(this).addClass('selected');
      $('.cart-window').slideToggle();
    }
    return false;
  });

  $('.close').on('click', function(){
    deselect($('#cart'));
    return false;
  });

  $('header nav').meanmenu();
  $('#myCarousel').carousel();
  $('#myCarousel').fadeIn('slow');

  $(window).scroll( function(){
      $('.fade-in').each( function(i){
          var bottomOfObject = $(this).position().top + $(this).outerHeight();
          var bottomOfWindow = $(window).scrollTop() + $(window).height();

          bottomOfWindow = bottomOfWindow + 550;

          if(bottomOfWindow > bottomOfObject){
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

  $('.races').on('click', function(ev){
    ev.preventDefault();
    $('#user-races').slideToggle('slow', function(){
      if($(this).is(':hidden'))  {
          $('.races').html('Your upcoming races <i class="fa fa-angle-down" aria-hidden="true"></i>');
      }
      else{
          $('.races').html('Your upcoming races <i class="fa fa-angle-up" aria-hidden="true"></i>');
      }
    });
  });

  $('.profile').on('click', function(ev){
    ev.preventDefault();
    $('#profile-customize').slideToggle('slow', function(){
      if($(this).is(':hidden'))  {
          $('.profile').html('Profile Details <i class="fa fa-angle-down" aria-hidden="true"></i>');
      }
      else{
          $('.profile').html('Profile Details <i class="fa fa-angle-up" aria-hidden="true"></i>');
      }
    });
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

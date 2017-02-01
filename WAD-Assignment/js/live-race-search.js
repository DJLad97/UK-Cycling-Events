$(document).ready(function() {
    $('#searchTerm').on('input', function(){
      var searchKeyword = $(this).val();

      if(searchKeyword.length >= 3){
        $.post(
          'search-race.php',
          {searchTerm: searchKeyword},
          function(data){
            $('ul#content').empty();
            $.each(data, function(){
              $('ul#content').append('<li><a href="race-sign-up.php?RaceID=' +
                                    this.RaceID + '">' + this.RaceName + '</a></li>');
            })
          }, "json");
      }
    });
});

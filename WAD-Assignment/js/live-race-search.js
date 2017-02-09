$(document).ready(function() {
    var previewHTML = '';
    $('#searchTerm').on('input', function(){
      var searchKeyword = $(this).val();

      if(searchKeyword.length >= 1){
        $.post(
          'search-race.php',
          {searchTerm: searchKeyword},
          function(data){
            $('ul#content').empty();
            $.each(data, function(){
              previewHTML = '<div class="parent"><div class="preview"><a class="non-nav" href="#" data-id=' +
                                  this.RaceID + ' class="getPreview">Preview</a></div>' +
                                  '<div class="fullDetails"></div></div>';

              $('ul#content').append('<li><strong><a class="non-nav" href="race-sign-up.php?RaceID=' +
                                    this.RaceID + '">' + this.RaceName + '</a>' + previewHTML + '</strong></li>');

              // $('ul#content').append('<li><a href="race-sign-up.php?RaceID=' +
              //                       this.RaceID + '">' + this.RaceName + '</a>' +
              //                       '<div class="preview"><a href="#" data-id=' +
              //                       this.RaceID + ' class="getPreview">Preview</a></div></li>');
            })
          }, "json");
      }
      else if(searchKeyword.length <= 0){
        $('ul#content').empty();
      }
    });
    $(document).on('click', '.getPreview', function(ev){
      ev.preventDefault();
      var myVars = {'RaceID': $(this).attr('data-id')};
      var currentNode = $(this);
      var detailsNode = $(this).parents('.parent').find('.fullDetails')
      $.get('search-race.php', myVars, function(data){
        alert("In get");
        // $(detailsNode).html(data.RaceDate + ' - ' +
        // data.ClosingEntryDate + ' - ' +
        // data.RaceType).slideToggle(500);
        console.dir(data);
        $('.fullDetails').html(data.RaceDate + ' - ' +
        data.ClosingEntryDate + ' - ' +
        data.RaceType);
      }, 'json');
    });

});

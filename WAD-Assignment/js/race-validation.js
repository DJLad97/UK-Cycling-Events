$(document).ready(function(){

  $('#startDate').datepicker({
       changeMonth: true,
       changeYear: true,
       dateFormat: "yy-mm-dd"

  });

  $('#closingEntryDate').datepicker({
       changeMonth: true,
       changeYear: true,
       dateFormat: "yy-mm-dd"

  });

  $.validator.setDefaults({
      errorClass: 'help-block',
      highlight: function(element){
        $(element)
          .closest('.form-group')
          .addClass('has-error');
      },
      unhighlight: function(element){
        $(element)
          .closest('.form-group')
          .removeClass('has-error');
      }
    });

    $.validator.addMethod('validStartDate', function(value, element){
          var startDate = $('#startDate').datepicker('getDate');
          var closingEntryDate = $('#closingEntryDate').datepicker('getDate');

          return (Date.parse(startDate) > Date.parse(closingEntryDate))
    }, 'Please put your start date after your closing entry date')

    $.validator.addMethod('validCloseDate', function(value, element){
          var startDate = $('#startDate').datepicker('getDate');
          var closingEntryDate = $('#closingEntryDate').datepicker('getDate');

          return (Date.parse(closingEntryDate) < Date.parse(startDate))
    }, 'The closing entry date must be before the start of the race')

    $.validator.addMethod('validPostcode', function(value, element){
      return /^[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}$/i.test(value);
    }, 'Please enter a valid postcode!')

  $('#add-race-form').validate({
      rules: {
        raceType: {
          required: true
        },
        organiserName: "required",
        organiserEmail: {
            required: true,
            email: true
        },
        raceName: "required",
        raceAddress: "required",
        racePostcode: {
          required: true,
          validPostcode: true
        },
        raceLatLong: "required",
        raceType: "required",
        raceStartDate: {
          required: true,
          validStartDate: true
        },
        closingEntryDate: {
          required: true,
          validCloseDate: true
        },
        isFree: 'required'

      },
      messages: {
        raceType: {
          required: 'Please choose what type of race you have!'
        },
       organiserEmail: {
         required: 'Please enter your organisation email address!',
         email: 'Please enter a <em>valid</em> email address!'
       },
       organiserName: {
         required: 'Please enter your organisation name!'
       },
       raceName: {
         required: 'Please enter the name of your race!'
       },
       raceStartDate: {
         required: 'Please enter the date your race starts!'
       },
       closingEntryDate: {
         required: 'Please enter the date in which enteries are no longer allowed after!'
       },
       raceAddress: {
         required: 'Please enter the address of your race!'
       },
       racePostcode: {
         required: 'Please enter the race postcode!'
       },
       raceLatLong: {
         required: 'Please choose the latitude and longtitude on the map!'
       },
       isFree: {
         required: 'Please specifiy if your race is free to enter or not!'
       }

     }
  });
});

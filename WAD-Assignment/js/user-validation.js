$(document).ready(function(){


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

    $.get('get-uname-email.php', function(data){
      $.validator.addMethod('unameAvailability', function(value, element){
        var taken = [];
        // Loop through the data array that contains the usernames and emails
        for (var i = 0; i < data.length; i++){
          // If the username entered matches one in the database
          // add a true to the taken array else add a false
          value == data[i].Username ? taken.push(true) : taken.push(false);
        }
        for (var i = 0; i < taken.length; i++){
          // Loop through the taken array, if any of them is true
          // then we know that the username entered is taken
          if(taken[i] == true)
            return false;
        }
        return true;
      }, "That username is already taken!");

      $.validator.addMethod('emailAvailability', function(value, element){
        // Ditto the comments above just for email this time
        var taken = [];
        for (var i = 0; i < data.length; i++){
          value == data[i].Email ? taken.push(true) : taken.push(false);
        }
        for (var i = 0; i < taken.length; i++){
          if(taken[i] == true)
            return false;
        }
        return true;
      }, "That email is already in use!");
    }, 'json');

  $.validator.addMethod('strongPassword', function(value, element){
    return this.optional(element)
           || value.length >= 6
           && /\d/.test(value)
           && /[a-z]/i.test(value);
  }, 'Your password must be at least 6 characters long and contain at least one number and one character')

  $.validator.addMethod('validPostcode', function(value, element){
    return /^[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}$/i.test(value);
  }, 'Please enter a valid postcode!')

  $('#register-form').validate({
      rules: {
        fName: {
          required: true,
          nowhitespace: true,
          lettersonly: true
        },
        sName: {
          required: true,
          nowhitespace: true,
          lettersonly: true
        },
        uName: {
          required: true,
          nowhitespace: true,
          unameAvailability: true
        },
        email: {
          required: true,
          email: true,
          emailAvailability: true
        },
        pass: {
          required: true,
          strongPassword: true
        },
        passConf: {
          required: true,
          equalTo: '#pass'
        },
        add1: "required",
        townCity: "required",
        county: "required",
        country: {
          required: true
        },

        postCode: {
          required: true,
          validPostcode: true
        }

      },
      messages: {
        email: {
          required: 'Please enter an email address!',
          email: 'Please enter a <em>valid</em> email address'
        },
        fName: {
          required: 'Please enter your first name!'
        },
        sName: {
          required: 'Please enter your first name!'
        },
        uName: {
          required: 'Please enter a username!'
        },
        pass: {
          required: 'Please enter a password!'
        },
        passConf: {
          required: 'Please confirm your password!'
        },
        add1: {
          required: 'Please the first line of your address!'
        },
        townCity: {
          required: 'Please enter your town/city!'
        },
        county: {
          required: 'Please enter your county!'
        },
        postCode: {
          required: 'Please enter your postcode!'
        },
        country: {
          required: 'Please input your country!'
        }

      }
  });
});

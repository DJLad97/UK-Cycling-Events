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
          nowhitespace: true
        },
        email: {
          required: true,
          email: true
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

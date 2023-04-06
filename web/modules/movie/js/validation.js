/**
 * @file
 *
 * Movie Form Validation - This is a validation to the movie entity’s forms.
 */

(function ($, Drupal) {
  "use strict";

  Drupal.behaviors.validatorDate = {
    attach: function (context, settings) {
      $('#edit-release-date-wrapper', context)
        .once('validatorDate')
        .each(function (_, element) {
          $(element).change(function () {
            const inputValue = $(element).find('input').val();

            if (new Date(inputValue) > new Date()) {
              $(element).find('.form-item__label').addClass('has-error');
              $(element).find('input').addClass('error');
              
              $(element).find('.form-item__description').after(`
                <div id='input-error' class='form-item__label has-error'>
                  ${Drupal.t('The release date cannot be a future date.')}
                </div>
              `);
              $('#edit-submit').attr('disabled', true);
            } 
            else {
              $(element).find('.form-item__label').removeClass('has-error');
              $(element).find('input').removeClass('error');
              $(element).find('#input-error').remove();
              $('#edit-submit').attr('disabled', false);
            }
          });
      });
    }
  };
})(jQuery, Drupal);
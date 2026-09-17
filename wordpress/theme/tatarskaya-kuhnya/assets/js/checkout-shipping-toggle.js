(function ($) {
  function toggleAddressFields() {
    const chosen = $('input[name^="shipping_method"]:checked').val() || '';
    const isPickup = chosen.indexOf('local_pickup') !== -1;
    $('#billing_address_1_field').toggle(!isPickup);
  }

  $(document.body).on('updated_checkout', toggleAddressFields);
  $(document).ready(toggleAddressFields);
})(jQuery);

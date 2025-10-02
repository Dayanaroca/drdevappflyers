jQuery(document).ready(function($) {
  $('#upload_shipping_image').on('click', function(e) {
    e.preventDefault();

    const customUploader = wp.media({
      title: 'Seleccionar imagen',
      button: {
        text: 'Usar esta imagen'
      },
      multiple: false
    });

    customUploader.on('select', function() {
      const attachment = customUploader.state().get('selection').first().toJSON();
      $('#shipping_image_id').val(attachment.id);
      $('#shipping-image-preview').attr('src', attachment.url);
    });

    customUploader.open();
  });
});
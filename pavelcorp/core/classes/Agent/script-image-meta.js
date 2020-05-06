jQuery(document).ready(function ($) {
	function removeFromGallery(evt) {
		evt.preventDefault();
		var gallery, children, name;

		gallery = $(this).parent().parent();
		
		// Remove img
		$(this).parent().remove();

		children = gallery.children();

		// Rename all sibblings
		name = JSON.parse(gallery.attr('data-info')).name;

		children.each(function(index){
			var container = $(this);
			var input = container.children('input');

			input.attr('name', name)
		})
	}

	$('.single-preview > div > .remove').click(removeFromGallery)

  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;
  // Runs when the image button is clicked.
  $('.single-upload').click(function (e) {
		// Get preview pane
		var meta_image_preview = $(this).parent().children('.single-preview');
		var name;

		name = JSON.parse(meta_image_preview.attr('data-info')).name;
		
		// Prevents the default action from occuring.
		e.preventDefault();

		// Sets up the media library frame
		meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
		  title: '',
		  button: {
				stext: ''
		  }
		});


		// Runs when an image is selected.
		meta_image_frame.on('select', function () {
		  // Grabs the attachment selection and creates a JSON representation of the model.
		  var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
		  // Sends the attachment URL to our custom image input field.
		  var id, url;
		  id = media_attachment.id;
		  url = media_attachment.url;

		  var img = document.createElement('img');
		  img.src = url;

		  var input = document.createElement('input');
		  input.type = "hidden";
		  input.value = id;
		  input.name = name;

		  var container = document.createElement('div');
		  container.appendChild(input);
		  container.appendChild(img);

		  // Remove current img
		  meta_image_preview.children().remove();
		  meta_image_preview.append(container);
		});
		
		// Opens the media library frame.
		meta_image_frame.open();
  });
});
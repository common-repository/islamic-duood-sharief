/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var background_frame_cover;
 
    // Runs when the image button is clicked.
    //$('.song-button').click(function(e){
	$(document).on('click', '.background-image-button' , function(e){
		
        // Prevents the default action from occuring.
        e.preventDefault();
		target = e.target || e.srcElement;
		song_id = target.id;

        // If the frame already exists, re-open it.
        if ( background_frame_cover ) {
            background_frame_cover.open();
            return;
        }

        // Sets up the media library frame
        background_frame_cover = wp.media.frames.background_frame_cover = wp.media({
            title: duroodshariefdiv_media_cover_js.title,
            button: { text:  duroodshariefdiv_media_cover_js.button },
            library: { type: 'image' },
			multiple: false
        });

        // Runs when an image is selected.
        background_frame_cover.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = background_frame_cover.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom image input field.

			$('#duroodshariefdiv_media_background_image').val(media_attachment.url);
			delete target;
			delete song_id;
        });
 
        // Opens the media library frame.
        background_frame_cover.open();
    });

				$('.duroodshariefdiv_close').click(function(){
       
		$('.exp_floatdiv_content_pro').hide('slow');;
});
	
});


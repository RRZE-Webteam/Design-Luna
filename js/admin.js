/*
 * Image Upload for Widget
 */

jQuery(document).ready(function($){


		var custom_uploader;

		$('.upload_image_button').click(function(e) {

			e.preventDefault();
			var button = $(this);
			var id = button.attr('id').replace('_button', '');
			var idimgid = button.attr('id').replace('url_button', 'id');
			var idtitle = button.attr('id').replace('image_url_button', 'title');

			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: { text:'Choose Image' },
				library: { type: 'image' },
				multiple: false
			});

			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				$('#'+id).val(attachment.url);
				$('#'+idimgid).val(attachment.id);
				var pretitle = $('#'+idtitle).val();
				if (!pretitle)
					$('#'+idtitle).val(attachment.title);

			});

			//Open the uploader dialog
			custom_uploader.open();

		});


		var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;

		$('#upload_logo_button').click(function(e) {
			var send_attachment_bkp = wp.media.editor.send.attachment;
			var button = $(this);
			var id = button.attr('id').replace('_button', '');
			_custom_media = true;
			wp.media.editor.send.attachment = function(props, attachment){
				if ( _custom_media ) {
					$("#"+id).val(attachment.url);
				} else {
					return _orig_send_attachment.apply( this, [props, attachment] );
				};
			}

			wp.media.editor.open(button);
			return false;
		});

		$('.add_media').on('click', function(){
			_custom_media = false;
		});





$('body').on('click', '.link-btn', function(event) {
            wpActiveEditor = true; //we need to override this var as the link dialogue is expecting an actual wp_editor instance
            wpLink.open(); //open the link popup
            return false;
        });
$('body').on('click', '#wp-link-submit', function(event) {
            var linkAtts = wpLink.getAttrs();//the links attributes (href, target) are stored in an object, which can be access via  wpLink.getAttrs()
            $('#vortrag_referentlink').val(linkAtts.href);//get the href attribute and add to a textfield, or use as you see fit
            wpLink.textarea = $('body'); //to close the link dialogue, it is again expecting an wp_editor instance, so you need to give it something to set focus back to. In this case, I'm using body, but the textfield with the URL would be fine
            wpLink.close();//close the dialogue
//trap any events
            event.preventDefault ? event.preventDefault() : event.returnValue = false;
            event.stopPropagation();
            return false;
        });

 $('body').on('click', '#wp-link-cancel', function(event) {
        wpLink.textarea = $('body');
        wpLink.close();
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        event.stopPropagation();
        return false;
    });




});

jQuery(function() {
   jQuery(".datepicker").datepicker();
});
$(document).ready(function(){
	$(document).on('click', '.dropdown', function(e){
		$(this).toggleClass("active");
		$(this).next().slideToggle(150);
	});
	$('.ui.checkbox').checkbox();
	// $('.ui.dropdown').dropdown();

	if( $('textarea[name="tags"]').length > 0 ){
		$('textarea[name="tags"]').tagEditor({
			autocomplete : {
		        delay: 0, // show suggestions immediately
		        position: { collision: 'flip' }, // automatic menu position up/down
		        source: tags
		    },
		    forceLowercase : false,
		    placeholder : 'Enter tags here',
		    animateDelete : 0
		});
	}

	if( $('textarea[name="longdescription"]').length > 0 ){
		CKEDITOR.replace( 'longdescription' );
	}
	
    $('.sidebar').perfectScrollbar();

    if( $('#courses_list').length > 0 ){
	    $('#courses_list').DataTable({
	    	serverSide: true,
                processing: true,
                pageLength: 25,
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: dtUrl
	    });
    }

    if( $('#topics_list').length > 0 ){
	    $('#topics_list').DataTable({
	    	serverSide: true,
                processing: true,
                pageLength: 25,
                lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ],
                ajax: dtUrl
	    });
    }

    if( $('.openimagemodal').length > 0 ){
    	$(document).on('click', '.openimagemodal', function(){
    		$('.ui.modal.image-show')
    		.modal('setting', 'duration', 200)
    		.modal({inverted: true})
    		.modal('setting', 'transition', 'fade')
    		.modal('show');
    	});
    }

});
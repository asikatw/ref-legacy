/* Fix Bluestork and Bootstrap Conflict */
window.addEvent( 'domready', function(){
	var modal = $$('a.modal') ;
	setTimeout(function(){ modal.removeClass('modal'); }, 500 );
} );
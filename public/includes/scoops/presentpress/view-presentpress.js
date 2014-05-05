function next_slide() {
	console.log( Reveal.next,  typeof Reveal.next != 'undefined' );
	if( typeof Reveal.next != 'undefined' ) {
		Reveal.next();
	} else {
		setTimeout( next_slide, 100 );
	}
}
next_slide();
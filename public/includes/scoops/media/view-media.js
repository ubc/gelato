var Gelato_Media = {
	media: null,
	was_playing: null,
	duration: null,
	playing: false,
	
	onContentLoad: function() {
		Gelato_Media.media = Popcorn.smart( '#gelato-media', gelatoScoop.media.url );
		Gelato_Media.media.autoplay( false );
	}
}

document.addEventListener( "DOMContentLoaded", Gelato_Media.onContentLoad, false );

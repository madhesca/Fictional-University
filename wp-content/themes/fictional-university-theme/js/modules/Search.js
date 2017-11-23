import $ from 'jquery';

class Search {
	//1. describe and create our object
	constructor() {
		this.resultsDiv = $('#search-overlay__results');
		this.openButton	= $('.js-search-trigger');
		this.closeButton = $('.search-overlay__close');	
		this.searchOverlay = $('.search-overlay');	
		this.searchField = $('#search-term');
		this.events();
		this.isOverLayOpen = false;
		this.isSpinnerVisible = false;
		this.previousValue;
		this.typingTimer;

	}
//2. events
events() {
	this.openButton.on('click', this.openOverlay.bind(this));
	this.closeButton.on('click', this.closeOverlay.bind(this));
	$(document).on('keydown', this.keyPressDispacher.bind(this));
	this.searchField.on('keyup', this.typingLogic.bind(this));
}



//3.methods (functions, actions..)

//this method is for typing in search box and output results
typingLogic() {
	if(this.searchField.val() != this.previousValue) {
		clearTimeout(this.typingTimer);

	if (this.searchField.val()) {
		if (!this.isSpinnerVisible) {
		this.resultsDiv.html('<div class = "spinner-loader"></div>');
		this.isSpinnerVisible = true;
	}
	this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
	} else {
		this.resultsDiv.html('');
		this.isSpinnerVisible = false;
	}

	
	}

	
	this.previousValue = this.searchField.val();
}

getResults() {
	this.resultsDiv.html('imagine real search result here');
	this.isSpinnerVisible = false;
}


keyPressDispacher(e) {
	if(e.keyCode == 83 && !this.isOverLayOpen && !$('input, textarea').is(':focus')) {
		this.openOverlay();
	}

	if(e.keyCode == 27 && this.isOverLayOpen) {
		this.closeOverlay();
	}

}

openOverlay() {
	this.searchOverlay.addClass('search-overlay--active');
	$('body').addClass('body-no-scroll');
	this.isOverLayOpen = true;
}

closeOverlay() {
	this.searchOverlay.removeClass('search-overlay--active');
	$('body').removeClass('body-no-scroll');
	this.isOverLayOpen = false;
}

}


export default Search;
import $ from 'jquery';

class Search {
	//1. describe and create our object
	constructor() {
		this.addSearchHTML(); //this must be the 1st one here
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
	this.typingTimer = setTimeout(this.getResults.bind(this), 750);
	} else {
		this.resultsDiv.html('');
		this.isSpinnerVisible = false;
	}

	
	}

	
	this.previousValue = this.searchField.val();
}
//this gets results for the text fields from data

getResults() {
	$.when(
		$.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()), 
		$.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
		).then((posts, pages) => {
		var combineResults = posts[0].concat(pages[0]);
	  	this.resultsDiv.html(`
			<h2 class = "search-overlay__section-title">General Information</h2>
			${combineResults.length ? '<ul class = "link-list min-list">' : '<p>No general information matches that search.</p>'}
				${combineResults.map(item => `<li><a href = "${item.link}">${item.title.rendered}</a> ${item.type == 'post' ? `by ${item.authorName}` : ''}</li>`).join('')}
			
			${combineResults.length ? '</ul>' : ''}
		`);

		this.isSpinnerVisible = false;
		}, () => {
			this.resultsDiv.html('<p>Unexpected error. please try again</p>');
		});
	}





keyPressDispacher(e) {
	if(e.keyCode == 83 && !this.isOverLayOpen && !$('input, textarea').is(':focus')) {
		this.openOverlay();
	}

	if(e.keyCode == 27 && this.isOverLayOpen) {
		this.closeOverlay();
	}

}
//it add class to acticate the overlay and control not to scroll the body
//and in will automatically put the focus and can type immediately
openOverlay() {
	this.searchOverlay.addClass('search-overlay--active');
	$('body').addClass('body-no-scroll');
	this.searchField.val('');
	setTimeout(() => this.searchField.focus(), 301);
	this.isOverLayOpen = true;
}
//it delete the addtl class name to deactivate the search overlay
closeOverlay() {
	this.searchOverlay.removeClass('search-overlay--active');
	$('body').removeClass('body-no-scroll');
	this.isOverLayOpen = false;
}

//html for search overlay and div that holds the content of the search
//these were from footer.php initially
addSearchHTML() {
	$('body').append(`
		
<div class="search-overlay">
  <div class="search-overlay__top">
    <div class="container">
      <i class="fa fa-search search-overlay__icon" aria-hidden = "true"></i>
      <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
      <i class="fa fa-window-close search-overlay__close" aria-hidden = "true"></i>
    </div>
  </div>



<div class="container">
  <div id="search-overlay__results"></div>

</div>

</div>

	`);
}


}


export default Search;
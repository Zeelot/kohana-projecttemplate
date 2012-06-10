(function($, App, Lib, Templates) {
	// Initialize the app here
	$(function() {
		// Add all the templates to Templates
		$('script.template').each(function () {
			Templates[$(this).data('path')] = $(this).html();
		});

		// Initialize our Router and start the app
		window.App.Router = new window.App.Lib.AppRouter;
		Backbone.history.start({pushState: true, root: '/'});
	});
})(JQuery, window.App, window.App.Lib, window.App.Templates);
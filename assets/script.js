// https://getbootstrap.com/docs/5.3/forms/validation/#custom-styles
(() => {
	'use strict';

	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	const forms = document.querySelectorAll('.needs-validation');

	// Loop over them and prevent submission
	Array.from(forms).forEach(form => {
		form.addEventListener('submit', event => {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}

			form.classList.add('was-validated');

		}, false);
	});
})();




// Delete button
const deleteButtons = document.querySelectorAll('.delete-button');
deleteButtons.forEach(button => {
	button.addEventListener('click', function (event) {
		event.preventDefault();
		
		// show confirmation prompt
		const result = confirm('Are you sure you want to delete this car?');
		if (!result) {
			console.info('User cancelled the delete operation');
			return;
		} else {
			console.info('User confirmed the delete operation, deleting car with id ' + button.getAttribute('data-id') + '...');
		}

		const id = button.getAttribute('data-id');
		const response = fetch('handler.php?id=' + id, {
			method: 'DELETE',
		});
		if (response.status === 200) {
			window.location.reload();
		}
	});
});

// Privacy notice
document.addEventListener('DOMContentLoaded', function () {
	// Show the status of the Global Privacy Control flag and Do Not Track flag in the footer
	// https://globalprivacycontrol.org/ and https://developer.mozilla.org/en-US/docs/Web/API/Navigator/doNotTrack

	let dnt_status = document.getElementById('dnt_status');
	if (navigator.doNotTrack == 1) {
		dnt_status.innerText = '';
		console.info('Do Not Track is enabled');
	} else {
		dnt_status.innerText = 'do not';
		console.info('Do Not Track is disabled');
	}

	let gpc_status = document.getElementById('gpc_status');
	if (navigator.globalPrivacyControl == 1) {
		gpc_status.innerText = 'enabled';
		console.info('GPC flag is enabled');
	} else {
		gpc_status.innerText = 'disabled';
		console.info('GPC flag is disabled');
	}
});


// Active tab using the current URL
document.addEventListener('DOMContentLoaded', function () {
	// Get the current URL's name (e.g. index.php, about.php, contact.php)
	const url = window.location.pathname;
	const filename = url.substring(url.lastIndexOf('/') + 1);
	// console.info('Current URL: ' + filename);

	// Get the tab links
	const tabLinks = document.querySelectorAll('.nav-link');

	// foreach tab link, check if the href matches the current URL
	tabLinks.forEach(link => {
		// Remove the leading / from the filename
		linkurl = link.getAttribute('href').substring(1);
		// console.log(linkurl);
		if (linkurl === filename) {
			link.classList.add('active');
		}
	});
});
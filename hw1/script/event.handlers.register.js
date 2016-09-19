// -----------------------------------------------------------------------------
// register all event handlers right after the DOM content is fully loaded
// -----------------------------------------------------------------------------

// register form onsubmit event handler
document.addEventListener('DOMContentLoaded', function(e) {
    var form = element('simpleForm');
    // alert(form.id);
    form.addEventListener('submit', submit_click, false);
});

// register form submit button click event handler
document.addEventListener('DOMContentLoaded', function(e) {
    var submitButton = element('inputSubmit');
    // alert(form.id);
    submitButton.addEventListener('click', submit_button_click, false);
});


// register other event handlers

// --------------------------- DOMContentLoaded --------------------------------

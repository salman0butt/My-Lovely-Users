// Add this code to your plugin file or enqueue it as a separate JS file

jQuery(document).ready(function ($) {

    // Get the user details container element
    const userDetailsContainer = $('#user-details-container');

    // Attach a click event handler to all user details links
    $('.user-details-link').on('click', function (event) {
        event.preventDefault();

      // Get the user ID from the data-user-id attribute
        const userId = $(this).data('user-id');
      // Make an AJAX request to retrieve the user details
        $.ajax({
            url: myPlugin.ajaxUrl,
            type: 'POST',
            data: {
                action: 'fetch_user_details',
                my_plugin_nonce: myPlugin.nonce,
                user_id: userId
            },
            beforeSend: function () {
              // Show a loading message or spinner
                userDetailsContainer.html('<p style="text-align:center;">Loading user details...</p>');
            },
            success: function (response) {
                if (response.success) {
                  // Display the user details in the container
                    userDetailsContainer.html(response.data.html);
                  // get the position of the div you want to scroll to
                    const TOP_PADDING = 100;
                    const position = userDetailsContainer.offset().top - TOP_PADDING;

                  // animate the scroll to the div's position
                    $('html, body').animate({
                        scrollTop: position
                    }, 1000);
                } else {
                    userDetailsContainer.html('<p>Something went wrong.</p>');
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
              // Handle errors or display an error message
                userDetailsContainer.html('<p>Error retrieving user details: ' + errorThrown + '</p>');
            }
        });
    });

});


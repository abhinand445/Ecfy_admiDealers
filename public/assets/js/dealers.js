
// Password validation
$('#dealer_form').on('submit', function (e) {
    const password = $('#password').val();
    const confirmPassword = $('#confirm_password').val();
    if (password !== confirmPassword) {
        e.preventDefault();
        $('#passwordError').show();
    } else {
        $('#passwordError').hide();
    }
});

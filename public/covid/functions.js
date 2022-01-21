// $('input.form-control').keydown(function() {
//     $(this).addClass('key');
// });
// $('input.form-control').keyup(function() {
//     $(this).removeClass('key');
// });

function registerValide()
{
    if($('#password').val() != $('#confirm-password').val())
    {
        $('#no-match').show();
    }
    else
    {
        $('#register').submit();
    }
}
$(function () {
    // Show activity in process once form is submitted.
    $('form').submit(function () {
        $('button[type=submit]').attr('disabled', true).html('<i class="fas fa-fw fa-lg fa-spinner fa-spin"></i> Processing');
    });
});

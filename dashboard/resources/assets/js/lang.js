$(document).ready(function(){

    $('.languageSwitcher').click(function (e){
        e.preventDefault();

        var _locale = e.target.getAttribute('data-locale');
        var _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/language",
            type: 'post',
            data: {_locale: _locale, _token: _token},
            datatype: 'json',
            success: function (data) {
            },
            complete: function (data) {
                window.location.reload(true);
            }
        });
    });
});
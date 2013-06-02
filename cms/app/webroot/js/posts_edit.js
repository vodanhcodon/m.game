$(function() {

    var _loadingDiv = $("#loadingDiv");

    $('#PostAddForm, #PostEditForm').submit(function(){
        _loadingDiv.show();
        $.post('/posts/ajax_edit',
            $(this).serializeArray(),
            afterValidate,
            "json"
        );
        return false;
    });
 
    function afterValidate(data, status)  {
        $(".message").remove();
        $(".error-message").remove();

        if (data.errors) {
            onError(data.errors);
        } else if (data.success) {
            onSuccess(data.success);
        }
    }
 
    function onSuccess(data) {
        flashMessage(data.message);
        _loadingDiv.hide();
        window.setTimeout(function() {
            window.location.href = '/posts';
        }, 2000);
    };
 
    function onError(data) {
        flashMessage(data.message);
        $.each(data.data, function(model, errors) {
            for (fieldName in this) {
                var element = $("#" + camelize(model + '_' + fieldName));
                var _insert = $(document.createElement('div')).insertAfter(element);
                _insert.addClass('error-message').text(this[fieldName])
            }
            _loadingDiv.hide();
        });
    };
 
    function flashMessage(message) {
        var _insert = $(document.createElement('div')).css('display', 'none');
        _insert.attr('id', 'flashMessage').addClass('message').text(message);
        _insert.insertBefore($(".posts")).fadeIn();
    }

    function camelize(string) {
        var a = string.split('_'), i;
        s = [];
        for (i=0; i<a.length; i++){
            s.push(a[i].charAt(0).toUpperCase() + a[i].substring(1));
        }
        s = s.join('');
        return s;
    }

});
<?php
echo $this->element('jquery_file_upload');
?>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        // có sự sai lệch về đường dẫn link tới file ảnh
        // nên thêm vào đường dẫn tuyệt đối
        var webroot = '<?php echo $this->webroot; ?>';
        
        var url = '<?php echo $this->Html->url(array('action' => 'upload')) ?>',
                uploadButton = $('<button/>')
                .addClass('btn')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
            var $this = $(this),
                    data = $this.data();
            $this
                    .off('click')
                    .text('Abort')
                    .on('click', function() {
                $this.remove();
                data.abort();
            });
            data.submit().always(function() {
                $this.remove();
            });
        });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            loadImageMaxFileSize: 15000000, // 15MB
            disableImageResize: false,
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {
                node
                        .append('<br>')
                        .append(file.error);
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
            $.each(data.result.files, function(index, file) {
                var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', webroot+file.url);
                $(data.context.children()[index])
                        .wrap(link);
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.result.files, function(index, file) {
                var error = $('<span/>').text(file.error);
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        });
    });
</script>
<div class="container">
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="icon-plus icon-white"></i>
        <span>Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress progress-success progress-striped">
        <div class="bar"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files"></div>
    <br>
</div>

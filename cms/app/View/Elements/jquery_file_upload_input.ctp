<?php
// xử lý các tham số tùy chỉnh đầu vào
$singleFileUploads = isset($singleFileUploads) ? $singleFileUploads : 'true';
$limitMultiFileUploads = isset($limitMultiFileUploads) ? $limitMultiFileUploads : 1;
$acceptFileTypes = isset($acceptFileTypes) ? $acceptFileTypes : 'gif|jpe?g|png';
$maxFileSize = isset($maxFileSize) ? $maxFileSize : 5 * 1000 * 1000;
$maxNumberOfFiles = isset($maxNumberOfFiles) ? $maxNumberOfFiles : 1;
$selectorID = isset($selectorID) ? $selectorID : 'fileupload';
$imagePath = isset($imagePath) ? $imagePath : '';

$uploadTemplateId = 'template-upload-' . $selectorID;
$downloadTemplateId = 'template-download-' . $selectorID;

$webroot = $this->webroot;
?>
<style>
    .row{
        margin-left:  0px;
    }
</style>
<script>
    /*jslint nomen: true, unparam: true, regexp: true */
    /*global $, window, document */
    var webroot = '<?php echo $this->webroot; ?>';
    $(function() {
        'use strict';
        // Initialize the jQuery File Upload widget:
        $('#<?php echo $selectorID ?>').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '<?php echo $this->Html->url(array('action' => 'jqueryFileUpload')) ?>',
            acceptFileTypes: /(\.|\/)(<?php echo $acceptFileTypes ?>)$/i,
            singleFileUploads: <?php echo $singleFileUploads ?>,
            maxFileSize: <?php echo $maxFileSize ?>,
            maxNumberOfFiles: <?php echo $maxNumberOfFiles ?>,
            limitMultiFileUploads: <?php echo $limitMultiFileUploads ?>,
            uploadTemplateId: '<?php echo $uploadTemplateId ?>',
            downloadTemplateId: '<?php echo $downloadTemplateId ?>',
        });

        // Enable iframe cross-domain access via redirect option:
        $('#<?php echo $selectorID ?>').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                /\/[^\/]*$/,
                '/cors/result.html?%s'
                )
                );

        // Load existing files:
        /*
         $('#<?php echo $selectorID ?>').addClass('fileupload-processing');
         $.ajax({
         // Uncomment the following to send cross-domain cookies:
         //xhrFields: {withCredentials: true},
         url: $('#fileupload').fileupload('option', 'url'),
         dataType: 'json',
         context: $('#fileupload')[0]
         }).always(function(result) {
         $(this).removeClass('fileupload-processing');
         }).done(function(result) {
         $(this).fileupload('option', 'done')
         .call(this, null, {result: result});
         });
         */
    });

</script>
<!--<div class="container">-->
<!-- The file upload form used as target for the file upload widget -->
<!--<form id="fileupload" action="<?php echo $this->Html->url(array('action' => 'jqueryFileUpload')) ?>" method="POST" enctype="multipart/form-data">-->
<div id="<?php echo $selectorID ?>">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="<?php echo $this->Html->url(array('action' => 'index')) ?>"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <!--<div class="span10">-->
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <span>Thêm Files...</span>
            <input type="file" name="files[]" multiple>
        </span>
        <!--                <button type="submit" class="btn btn-primary start">
                            <i class="icon-upload icon-white"></i>
                            <span>Start upload</span>
                        </button>-->
        <!--                <button type="reset" class="btn btn-warning cancel">
                            <i class="icon-ban-circle icon-white"></i>
                            <span>Cancel upload</span>
                        </button>-->
        <button type="button" class="btn btn-danger delete">
            <i class="icon-trash icon-white"></i>
            <span>Xóa</span>
        </button>
        <input type="checkbox" class="toggle">
        <!-- The loading indicator is shown during file processing -->
<!--        <span class="fileupload-loading"></span>-->
        <!--</div>-->
        <!-- The global progress information -->
        <div class="span10 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="bar" style="width:0%;"></div>
            </div>
            <!-- The extended global progress information -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped">
        <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
            <?php if (!empty($imagePath) && !is_array($imagePath)): ?>
                <?php
                $relativePath = $imagePath;
                $imagePath = $webroot . $imagePath;
                $imageName = substr(strrchr($imagePath, '/'), 1);
                ?>
                <tr class="template-download fade in">
                    <td>
                        <span class="preview">
                            <a download="<?php echo $imageName ?>" data-gallery="gallery" title="<?php echo $imageName ?>" href="<?php echo $imagePath ?>">
                                <img src="<?php echo $imagePath ?>" style="max-width: 80px; max-height: 80px;">
                            </a>
                        </span>
                    </td>
                    <td>
                        <p class="name">
                            <a download="<?php echo $imageName ?>" data-gallery="gallery" title="<?php echo $imageName ?>" href="<?php echo $imagePath ?>">
                                <?php echo $imageName ?>
                            </a>
                            <input type="hidden" name="<?php echo $inputname ?>" value ="<?php echo $imageName ?>" class="<?php echo $formname; ?>" />
                        </p>
                    </td>
                    <td>
                        <!--<span class="size">334.94 KB</span>-->
                    </td>
                    <td>
                        <button data-url="<?php echo $this->Html->url(array('action' => 'jqueryFileUpload')) ?>?file=<?php echo $imageName ?>&detele_link=<?php echo $relativePath ?>" data-type="DELETE" class="btn btn-danger delete">
                            <i class="icon-trash icon-white"></i>
                            <span>Xóa</span>
                        </button>
                        <input type="checkbox" class="toggle" value="1" name="delete">
                    </td>
                </tr>
            <?php elseif (!empty($imagePath) && is_array($imagePath)): ?>
                <?php foreach ($imagePath as $item): ?>
                    <?php
                    $relativePath = $item;
                    $itemPath = $webroot . $item;
                    $itemName = substr(strrchr($itemPath, '/'), 1);
                    ?>
                    <tr class="template-download fade in">
                        <td>
                            <span class="preview">
                                <a download="<?php echo $itemName ?>" data-gallery="gallery" title="<?php echo $itemName ?>" href="<?php echo $itemPath ?>">
                                    <img src="<?php echo $itemPath ?>" style="max-width: 80px; max-height: 80px;">
                                </a>
                            </span>
                        </td>
                        <td>
                            <p class="name">
                                <a download="<?php echo $itemName ?>" data-gallery="gallery" title="<?php echo $itemName ?>" href="<?php echo $itemPath ?>">
                                    <?php echo $itemName ?>
                                </a>
                                <input type="hidden" name="<?php echo $inputname ?>" value ="<?php echo $itemName ?>" class="<?php echo $formname; ?>" />
                            </p>
                        </td>
                        <td>
                            <!--<span class="size">334.94 KB</span>-->
                        </td>
                        <td>
                            <button data-url="<?php echo $this->Html->url(array('action' => 'jqueryFileUpload')) ?>?file=<?php echo $itemName ?>&detele_link=<?php echo $relativePath ?>" data-type="DELETE" class="btn btn-danger delete">
                                <i class="icon-trash icon-white"></i>
                                <span>Xóa</span>
                            </button>
                            <input type="checkbox" class="toggle" value="1" name="delete">
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif;
            ?>

        </tbody>
    </table>
    <!--</form>-->
</div>
<!--</div>-->
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Tải về</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="<?php echo $uploadTemplateId ?>" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{%=file.name%}</p>
    {% if (file.error) { %}
    <div><span class="label label-important">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <p class="size">{%=o.formatFileSize(file.size)%}</p>
    {% if (!o.files.error) { %}
    <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>

    {% } %}
    </td>
    <td>
    {% if (!o.files.error && !i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start">
    <i class="icon-upload icon-white"></i>
    <span>Tải lên</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <i class="icon-ban-circle icon-white"></i>
    <span>Hủy Bỏ</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="<?php echo $downloadTemplateId ?>" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td>
    <span class="preview">
    {% if (file.thumbnail_url) { %}
    <a href="{%=webroot+file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=webroot+file.thumbnail_url%}"></a>
    {% } %}
    </span>
    </td>
    <td>
    <p class="name">
    <a href="{%=webroot+file.url%}" title="{%=file.name%}" data-gallery="{%=webroot+file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
    <input type="hidden" name="<?php echo $inputname ?>" value ="{%=file.name%}" class="<?php echo $formname; ?>" />
    </p>
    {% if (file.error) { %}
    <div><span class="label label-important">Lỗi</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td>
    <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="icon-trash icon-white"></i>
    <span>Xóa</span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle">
    </td>
    </tr>
    {% } %}
</script>
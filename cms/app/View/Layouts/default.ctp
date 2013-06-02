<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');

        // thêm vào Jquery UI
        echo $this->Html->script('jquery-1.9.1');
        echo $this->Html->script('jquery-ui-1.10.1.custom.min');
        echo $this->Html->css('smoothness/jquery-ui-1.10.1.custom');


        // thêm giao diện được tạo sẵn bởi bootstrap
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('bootstrap-responsive');
        echo $this->Html->script('bootstrap.min');
        echo $this->Html->script('bootstrap-multiselect');
        echo $this->Html->css('cake.generic');

        // submit form theo kiểu ajax
        echo $this->Html->script('jquery.form');

        // tạo select kiểu dropdown
        echo $this->Html->script('bootstrap-select.min');
        echo $this->Html->css('bootstrap-select.min');

        // mã JS thực hiện nestsortable cho Danh mục đa cấp
        echo $this->Html->script('jquery.mjs.nestedSortable');
        ?>
        <?php $pageinfo = $this->Paginator->params(); ?>
        <script type="text/javascript">
            $(document).ready(function(e) {
                $("table.sortable tbody").sortable({
                    update: function() {
                        if ($("table.sortable tbody tr").length > 0) {
                            writeoptions($("table.sortable tbody tr").length);
                            $("table.sortable tbody tr").each(function(index, value) {
                                var index = parseInt(index) + parseInt(<?php echo ($pageinfo['page'] - 1) * $pageinfo['limit']; ?>);
                                $(this).find('td.order select').val(index);

                            });
                        }
                    }
                });

                // thực hiện giả lập xóa dữ liệu theo phương thức POST
                // BEGIN
                $('a.remove').on('click', function(event) {

                    var warning = confirm('Bạn có chắc chắn muốn xóa hay không?');
                    var url = $(this).attr('href');

                    if (warning) {
                        $.post(url, function(data) {
                            if (data.error != null) {
                                flagMessage(data.error);
                            }
                            if (data.redirect != null) {
                                window.location.href = data.redirect;
                            }
                        }, 'json');
                    }
                    //                    event.preventDefault();
                    return false;
                });
            });
            // END

            function writeoptions(options) {
                var select = $("table.sortable tbody tr td.order select");
                select.html('');
                for (var i = 0; i < options; i++) {
                    var value = parseInt(i) + parseInt(<?php echo ($pageinfo['page'] - 1) * $pageinfo['limit']; ?>);
                    select.append('<option value="' + value + '">' + value + '</option>');
                }

            }
            function flagMessage(message) {
                var html = '<div class="message" id="flashMessage">' + message + '</div>';
                if ($('#content #flashMessage').length <= 0) {
                    $('#content').prepend(html);
                }
                else {
                    $('#content #flashMessage').text(message);
                }
            }
        </script>
        <style type="text/css">
            table.sortable {
                cursor: move;
            }
            table.sortable select {
                width: auto;
            }
            .btn a {
                color: white;
                text-decoration: none;
            }
            .label {
                white-space: normal;
            }
            .icon-trash{
                margin-left: 15px;
            }

            body {
                background: none;
            }
            legend {
                margin-bottom: 0px;
            }
            select.input-medium{
                max-width: 200px;
            }
        </style>
    </head>
    <body>
        <?php echo $this->element('navbar'); ?>
        <div id="container">
            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php
                // thêm vào thông báo hiện thị lỗi khi quá trình xác thực auth bị lỗi
                echo $this->Session->flash('auth');
                ?>

                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">

            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>

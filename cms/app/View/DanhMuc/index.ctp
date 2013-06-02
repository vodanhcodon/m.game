<script>
    $(document).ready(function() {
        // thiết lập kiểu type danh mục mặc định là danh mục Game
        var type = '<?php echo $type_danhmuc ?>';

        $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            //            helper: 'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 3,
            //            isTree: true,
            //            expandOnHover: 700,
            //            startCollapsed: true,
            //            protectRoot: true,
            //            rootID: 'game',
        });
        //        $('.disclose').on('click', function() {
        //            $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
        //        })
        $('#update').on('click', function() {

            type = $('.nav-tabs li.active a').data('type');
            $('.type_danhmuc').val(type);

            // xác định xem hiện tab danh mục nào đang được kích hoạt
            var target = $('.nav-tabs li.active a').attr('href');

            // thực hiện lấy về chuỗi json mô tả cấu trúc tree danh mục trong tab đó
            var trees = $(target + ' ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            console.log(trees);
            trees = JSON.stringify(trees);

            $('#trees').val(trees);
            $('#updateList').submit();
        });
        $('a[data-toggle="tab"]').on('shown', function(e) {
            e.target // activated tab

            // thực hiện set kiểu type của danh mục, để khi ấn search thì chỉ thực hiện tìm kiếm 
            // trong 1 kiểu type danh mục nhất định
            type = $(this).data('type');
            $('.type_danhmuc').val(type);

            // thực lấy các giá trị trong chuỗi JSON ẩn tương ứng với từng tab
            // để thực hiện lưu lại cấu trúc tree danh mục mà người dùng đã thiết lập
            var target = $(this).attr('href');
            var trees = $(target + ' ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            console.log(trees);
            trees = JSON.stringify(trees);

            $('#trees').val(trees);

        })
    });
</script>
<style type="text/css">
    .placeholder {
        outline: 1px dashed #4183C4;
        /*-webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        margin: -1px;*/
    }
    .mjs-nestedSortable-error {
        background: #fbe3e4;
        border-color: transparent;
    }
    .sortable ol, .sortable ol ol {
        margin: 0 0 0 25px;
        padding: 0;
        list-style-type: none;
    }
    ol.sortable {
        margin: 4em 0;
    }
    .sortable li {
        margin: 5px 0 0 0;
        padding: 0;
    }
    .sortable li div {
        border: 1px solid #d4d4d4;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        border-color: #D4D4D4 #D4D4D4 #BCBCBC;
        padding: 6px;
        margin: 0;
        cursor: move;
        background: #f6f6f6;
        background: -moz-linear-gradient(top, #ffffff 0%, #f6f6f6 47%, #ededed 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
        background: -webkit-linear-gradient(top, #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        background: -o-linear-gradient(top, #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        background: -ms-linear-gradient(top, #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        background: linear-gradient(to bottom, #ffffff 0%,#f6f6f6 47%,#ededed 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
    }
    .sortable li.mjs-nestedSortable-branch div {
        background: -moz-linear-gradient(top, #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
        background: -webkit-linear-gradient(top, #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);
    }
    .sortable li.mjs-nestedSortable-leaf div {
        background: -moz-linear-gradient(top, #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
        background: -webkit-linear-gradient(top, #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);
    }
    li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
        border-color: #999;
        background: #fafafa;
    }
    .disclose {
        cursor: pointer;
        width: 10px;
        display: none;
    }
    .sortable li.mjs-nestedSortable-collapsed > ol {
        display: none;
    }
    .sortable li.mjs-nestedSortable-branch > div > .disclose {
        display: inline-block;
    }
    .sortable li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
        content: '+ ';
    }
    .sortable li.mjs-nestedSortable-expanded > div > .disclose > span:before {
        content: '- ';
    }

</style>
<div class="row-fluid">
    <ul class="nav nav-tabs">
        <li <?php echo ($type_danhmuc == 1) ? 'class="active"' : '' ?>>
            <a href="#game" data-toggle="tab"  data-type ="1">Danh Mục Game</a>
        </li>
        <li <?php echo ($type_danhmuc == 3) ? 'class="active"' : '' ?>>
            <a href="#app" data-toggle="tab"  data-type ="3">Danh Mục App</a>
        </li>
        <li <?php echo ($type_danhmuc == 2) ? 'class="active"' : '' ?>>
            <a href="#news" data-toggle="tab"  data-type ="2">Danh Mục News</a>
        </li>
        <li <?php echo ($type_danhmuc == 6) ? 'class="active"' : '' ?>>
            <a href="#product" data-toggle="tab"  data-type ="6">Danh Mục Product Distribution</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class= "tab-pane <?php echo ($type_danhmuc == 1) ? 'active' : '' ?>" id="game">
            <?php
            echo $this->element('search_danhmuc', array(
                'type_danhmuc' => $type_danhmuc,
                'options' => $opts_game,
                'type' => 1,
            ));
            ?>
            <div class="row-fluid">
                <?php echo $danhmuc_game; ?>
            </div>
        </div>
        <div class="tab-pane <?php echo ($type_danhmuc == 3) ? 'active' : '' ?>" id="app">
            <?php
            echo $this->element('search_danhmuc', array(
                'type_danhmuc' => $type_danhmuc,
                'options' => $opts_app,
                'type' => 3,
            ));
            ?>
            <div class="row-fluid">
                <?php echo $danhmuc_app; ?>
            </div>
        </div>
        <div class="tab-pane <?php echo ($type_danhmuc == 2) ? 'active' : '' ?>" id="news">
            <?php
            echo $this->element('search_danhmuc', array(
                'type_danhmuc' => $type_danhmuc,
                'options' => $opts_news,
                'type' => 2,
            ));
            ?>
            <div class="row-fluid">
                <?php echo $danhmuc_news; ?>
            </div>

        </div>
        <div class="tab-pane <?php echo ($type_danhmuc == 6) ? 'active' : '' ?>" id="product">
            <?php
            echo $this->element('search_danhmuc', array(
                'type_danhmuc' => $type_danhmuc,
                'options' => $opts_product,
                'type' => 6,
            ));
            ?>
            <div class="row-fluid">
                <?php echo $danhmuc_product; ?>
            </div>
        </div>

    </div>
    <?php
    echo $this->Form->create('DanhMuc', array(
        'url' => array(
            'controller' => 'DanhMuc',
            'action' => 'updateList',
        ),
        'id' => 'updateList',
    ));
    ?>
    <?php
    echo $this->Form->hidden('DanhMuc.trees', array(
        'value' => '',
        'id' => 'trees',
    ));
    echo $this->Form->hidden('DanhMuc.type', array(
        'value' => $type_danhmuc,
        'class' => 'type_danhmuc',
    ));
    ?>
    <?php
    echo $this->Form->end();
    ?>
    <div class="form-actions">
        <?php echo $this->Form->button(__('Thay đổi'), array('class' => array('btn', 'btn-primary'), 'type' => 'submit', 'id' => 'update')); ?>
        <?php echo $this->element('add'); ?>
    </div>
</div>
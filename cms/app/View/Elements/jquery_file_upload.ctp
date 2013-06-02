<?php
echo $this->Html->script('jquery.ui.widget');
echo $this->Html->script('tmpl.min');
echo $this->Html->script('load-image.min');
echo $this->Html->script('canvas-to-blob.min');
echo $this->Html->script('bootstrap-image-gallery.min');
echo $this->Html->script('jquery.iframe-transport');
echo $this->Html->script('jquery.fileupload');
echo $this->Html->script('jquery.fileupload-process');
echo $this->Html->script('jquery.fileupload-resize');
echo $this->Html->script('jquery.fileupload-validate');
echo $this->Html->script('jquery.fileupload-ui');

echo $this->Html->css('jquery.fileupload-ui');
echo $this->Html->css('bootstrap-image-gallery.min');
?>
<noscript><?php echo $this->Html->css('jquery.fileupload-ui-noscript'); ?></noscript>
<!--The XDomainRequest Transport is included for cross-domain file deletion for IE8+-->
<!--[if gte IE 8]><?php echo $this->Html->script('jquery.xdr-transport'); ?></script><![endif]-->
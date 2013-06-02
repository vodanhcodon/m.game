<?php
/**
 * giá trị đường dẫn tham chiếu $referer được thực hiện xử lý trong beforeRender ở AppController
 */
?>
<input type="hidden" name="referer" value="<?php echo $referer == '' ? $this->Html->url(array('action' => 'index')) : $referer; ?>"/>
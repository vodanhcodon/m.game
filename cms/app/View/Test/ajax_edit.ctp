<?php
$output = array();
if($this->validationErrors) {
    $output = Set::insert($output, 'errors', array('message' => $errors['message']));
    $errorMessages = array(
        'Post' => array(
            'title' => array(
                'required' => __("This field cannot be left blank.", true),
                'maxlength' => sprintf(__("Maximum length of %d characters.", true), 30)
            ),
            'body' => array(
                'required' => __("This field cannot be left blank.", true),
                'maxlength' => sprintf(__("Maximum length of %d characters.", true), 200)
            )
        )
    );
    foreach ($errors['data'] as $model => $errs) {
        foreach ($errs as $field => $message) {
            $output['errors']['data'][$model][$field] = $errorMessages[$model][$field][$message];
        }
    }
} elseif ($success) {
    $output = Set::insert($output, 'success', array(
        'message' => $success['message'],
        'data' => $success['data']
    ));
}
echo $javascript->object($output);
?>
<?php
$languages = $db->select('course_languages', ['status' => 1]);
foreach ($languages as $language) {
    echo '<option value="' . $language->code . '" ' . (@$_SESSION['course_details']['general_details']['language'] == $language->code ? "selected" : "") . '>' . $language->name . '</option>';
}
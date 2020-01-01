<?php
    // ==[INPUT VALIDATION]==
        // Email.
        if (empty($_POST['email'])) {
            $errors['email'] = "An email is required.";
        } else {
            $inputs['email'] = $_POST['email'];
            if(!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Valid email address required.';
            }
        }
        // Activity.
        if (empty($_POST['activity'])) {
            $errors['activity'] = "The activity name is required.";
        } else {
            $inputs['activity'] = $_POST['activity'];
            if(!preg_match('/^([a-zA-Z\s])(\s*[a-zA-Z\s]*)+$/', $inputs['activity'])) {
                $errors['activity'] = 'Valid activity name is required.';
            }
        }
        // Tags.
        if (empty($_POST['tags'])) {
            $errors['tags'] = "At least one tag required.";
        } else {
            $inputs['tags'] = $_POST['tags'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $inputs['tags'])) {
                $errors['tags'] = 'Tags need to be comma separated.';
            }
        }
        // Details.
        if (empty($_POST['details'])) {
            $errors['details'] = "Activity details required.";
        } else {
            $inputs['details'] = $_POST['details'];
        }
?>
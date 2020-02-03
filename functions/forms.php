<?php
/**
 * Contact forms
 */
function form_result($error = 'success')
{
    switch ($error) {
        case 'send_fail':
            $result = [
                status => 'error',
                message => 'Message could not be sent. Security issues.',
            ];
            break;

        case 'send_fail-email':
            $result = [
                status => 'error',
                message => 'Message could not be sent. Please contact the site administrator.',
            ];
            break;

        case 'send_fail_key':
            $result = [
                status => 'error',
                message => 'Message could not be sent. Security problems.',
            ];
            break;

        case 'name_short':
            $result = [
                status => 'error',
                message => 'Name cannot be less than two characters',
            ];
            break;

        case 'name_empty':
            $result = [
                status => 'error',
                message => 'Name cannot be empty',
            ];
            break;

        case 'email_empty':
            $result = [
                status => 'error',
                message => 'Email cannot be empty',
            ];
            break;

        case 'phone_empty':
            $result = [
                status => 'error',
                message => 'Phone cannot be empty',
            ];
            break;

        case 'comment_empty':
            $result = [
                status => 'error',
                message => 'Message cannot be empty',
            ];
            break;

        default:
            $result = [
                status => 'success',
                message => 'Your message has been sent successfully!',
            ];
            break;
    }

    wp_send_json($result);
}

function send_email(
    $form,
    $email,
    $information
) {

    $headers = "Content-Type: text/html; charset=\"UTF-8\"\n";
    $email_title = get_bloginfo('name') . ' - ' . $form;

    $message = '<table>';
    foreach ($information as $key => $value) {
        switch ($key) {
            case 'name':
                $option = 'Name';
                break;

            case 'phone':
                $option = 'Phone';
                break;

            case 'email':
                $option = 'Email';
                break;

            case 'message':
                $option = 'Message';
                break;

            default:
                $option = '';
                break;
        }

        $message .= "<tr>
      <td>$option:</td>
      <td>$value</td>
    </tr>";
    }
    $message .= '</table>';

    return wp_mail($email, $email_title, $message, $headers);
}

function form_handler()
{
    if (empty($_POST) || !wp_verify_nonce($_POST['scdata'], 'form_handler')) {
        // if you are checking ajax nonce - use wp_verify_nonce($_POST['security'], 'login_nonce'
        form_result('send_fail_key');
    } else {
        $information = [
            name => sanitize_text_field($_POST['name']),
            email => sanitize_email($_POST['email']),
            message => sanitize_text_field($_POST['message']),
        ];

        if (empty($information['name'])) {
            form_result('name_empty');
        } else if (strlen($information['name']) <= 2) {
            form_result('name_short');
        }

        if (empty($information['email'])) {
            form_result('email_empty');
        }

        if (empty($information['comment'])) {
            form_result('comment_empty');
        }

        $email = get_field('form-email', 'options');
        $status = send_email('Contact form', $email, $information);

        if ($status) {
            form_result();
        } else {
            form_result('send_fail-email');
        }
    }
}

if (wp_doing_ajax()) {
    add_action('wp_ajax_form_handler', 'form_handler');
    add_action('wp_ajax_nopriv_form_handler', 'form_handler');
}

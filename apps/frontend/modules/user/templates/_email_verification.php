<?php echo __('EMAIL_VERIFICATION_BODY', array('%email%' => $email, '%token%' => $token)); ?>


<?php echo url_for('user/verify?e='. $email . '&v=' . $token, true); ?>


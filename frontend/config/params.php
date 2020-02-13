<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'cpk@mpgu.edu',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'staticHostInfo' => (isset($_SERVER["HTTPS"]) ? 'https' : 'http').'://'.'aa:8080',
    'staticPath' =>'@frontend/web',
    'operatorHostInfo' => (isset($_SERVER["HTTPS"]) ? 'https' : 'http').'://'.'operator.aa:8080',
    'operatorPath' =>'@operator/web',
    'teacherHostInfo' => (isset($_SERVER["HTTPS"]) ? 'https' : 'http').'://'.'teacher.aa:8080',
    'teacherPath' =>'@teacher/web',
];

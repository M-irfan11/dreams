<?php
/*
 * ONE-TIME USE ONLY.
 *
 * The 3 old users (id 1, 2, 7) still have SHA1-hashed passwords from before
 * login.php was fixed to use password_hash()/password_verify(). This script
 * gives them new passwords in the correct bcrypt format so they can log in
 * again.
 *
 * HOW TO USE:
 * 1. Edit the $new_passwords array below - set whatever temporary password
 *    you want for each email (tell each user their new password afterwards,
 *    or better, ask them to change it once they log in if you have a
 *    "change password" page).
 * 2. Upload this file next to your other root-level files (same folder as
 *    login.php) and visit it once in the browser.
 * 3. Confirm it printed "Done" below for each user.
 * 4. DELETE THIS FILE immediately after running it - it changes passwords
 *    and should not be left on a live server.
 */

require_once 'component/connection.php'; // gives $crud

$new_passwords = [
    'araf@yahoo.com'   => '123456',
    'pritam@gmail.com' => '123456',
    'surafa@gmail.com' => '123456',
];

foreach ($new_passwords as $email => $plain_password) {
    $hashed = password_hash($plain_password, PASSWORD_DEFAULT);

    $result = $crud->common_update('users', [
        'password' => $hashed
    ], ['email' => $email]);

    if ($result['status']) {
        echo "Done - $email password updated.<br>";
    } else {
        echo "FAILED - $email: " . htmlspecialchars($result['message']) . "<br>";
    }
}

echo "<br><strong>Now delete this file.</strong>";

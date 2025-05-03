<?php
include 'includes/header.php';
include 'includes/db_connect.php'; 

$message_saved = false;
$error_message = '';
$form_data = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_data['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $form_data['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $form_data['subject'] = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $form_data['message'] = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $honeypot = filter_input(INPUT_POST, 'website_url', FILTER_SANITIZE_STRING); // Piège à bots

    if (empty($form_data['name']) || empty($form_data['email']) || empty($form_data['subject']) || empty($form_data['message'])) {
        $error_message = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $error_message = "Veuillez entrer une adresse e-mail valide.";
    } elseif (!empty($honeypot)) {
         $error_message = "Une erreur est survenue. Veuillez réessayer.";
    } else {

        $sql_insert = "INSERT INTO contact_messages (sender_name, sender_email, subject, message_content)
                       VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql_insert);

        if ($stmt) {
            $stmt->bind_param("ssss",
                $form_data['name'],
                $form_data['email'],
                $form_data['subject'],
                $form_data['message']
            );

            if ($stmt->execute()) {
                $message_saved = true;
                $form_data = []; 
            } else {
                $error_message = "An error occurred. Please try again.";
            }
            $stmt->close();

        } else {
            $error_message =  "Sorry, there was an error sending your message. Please try again later or contact me directly at " ;
        }


    }
}

if (isset($conn) && $conn) {
}

?>
<div class="container page-container">
    <h1>Contact me</h1>
    <p class="page-description">Have a question, a project proposal, or just want to say hello? Feel free to reach out!</p>

    <?php if ($message_saved): ?>
        <div class="form-success">
            <p>Thank you! Your message has been sent successfully. I'll get back to you as soon as possible.</p>
        </div>
    <?php else: ?>

        <?php if (!empty($error_message)): ?>
            <div class="form-error">
                <p><?php echo htmlspecialchars($error_message); ?></p>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="contact-form" id="contactForm" novalidate>
            <div class="form-group">
                <label for="name">Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="subject">Subject <span class="required">*</span></label>
                <input type="text" id="subject" name="subject" required value="<?php echo htmlspecialchars($form_data['subject'] ?? ''); ?>">
            </div>
             <div class="form-group website-url-field">
                <label for="website_url">Website URL (Ne pas remplir)</label>
                <input type="text" id="website_url" name="website_url" tabindex="-1" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="message">Message <span class="required">*</span></label>
                <textarea id="message" name="message" rows="6" required><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Send message</button>
            </div>
        </form>

    <?php endif; ?>

    <div class="contact-alternatives">
        <h2>Other Ways to Connect</h2>
        <p>You can also find me on</p>
        <ul>
        <li><a href="https://www.linkedin.com/in/ilef-akremi-64029b296/?originalSubdomain=tn" target="_blank">LinkedIn</a></li>
            <li><a href="https://github.com/ilefz" target="_blank">GitHub</a></li>
            <li>Or email me directly at: <a href="mailto:akremiilef@gmail.com">akremiilef@gmail.com</a></li> 
        </ul>
        
    </div>

</div>

<?php include 'includes/footer.php'; ?>
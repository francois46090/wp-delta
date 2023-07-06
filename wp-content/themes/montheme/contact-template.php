<?php
/*    Template Name: Contact
*/
?>

<?php get_header()?>

<h1> Contact </h1>

<div class="container py-4">

<!-- Formulaire de contact -->
<form id="contact-form" class="mx-auto" style="max-width: 400px;">

    <!-- Name input -->
    <div class="mb-3">
      <label class="form-label" for="name">Nom<span class="required">*</span></label>
      <input class="form-control" id="name" type="text" required="required" placeholder="Votre nom" />
    </div>

    <!-- Email input -->
    <div class="mb-3">
      <label class="form-label" for="emailAddress">Adresse email<span class="required">*</span></label>
      <input class="form-control" id="emailAddress" type="email" required="required" placeholder="Votre adresse mail" />
    </div>

    <!-- Message input -->
    <div class="mb-3">
      <label class="form-label" for="message">Message<span class="required">*</span></label>
      <textarea class="form-control" id="message" type="text" required="required" placeholder="Votre message" style="height: 10rem;"></textarea>
    </div>

    <!-- Bouton envoyé -->
    <div class="text-end">
    <button class="btn btn-primary btn-sm" type="submit">
        <a href="http://localhost/abc_hypnose/confirmation-message-envoye" style="text-decoration:none; color: inherit;">Envoyer</a>
    </button>
    </div>

  </form>

</div>

<?php get_footer()?>
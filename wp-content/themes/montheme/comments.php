<!-- Section Commentaire(s) -->

<?php if (have_comments()) : ?>

    <h6 id="comment-count">
        <?php echo get_comments_number(); ?> commentaire(s)</p> <!-- si com. existe afficher ce titre -->
    </h6>

    <ol class="liste-comment">
        <?php wp_list_comments(); // Boucle commentaire ?> 
    </ol>

<?php else : ?>
    <h3 class="titre-comment">
        Soyez le premier à laisser un commentaire <!-- si pas de com. afficher ce titre -->
    </h3>
<?php endif; ?>

<!-- Afficher le formulaire de commentaire -->
<?php if (comments_open()) : ?>

    <div id="commentaires">

        <!-- Titre du formulaire de commentaire -->
        <h3 class="titre-comment">Laisser un commentaire</h3>

        <!-- Formulaire de commentaire -->
        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" 
              method="post" id="commentform" class="comment-form">

            <!-- Nom Auteur -->  
            <div class="comment-form-author">
                <label class="form-label"  for="author">Nom<span class="required">*</span></label>
                <input class="form-control mx-auto" type="text" name="author" id="author" required="required" placeholder="Votre nom" />
            </div>

            <!-- Email Auteur -->  
            <div class="comment-form-email">
                <label class="form-label" for="emailAddress">Adresse email<span class="required">*</span></label>
                <input class="form-control mx-auto" type="email" id="emailAddress"  required="required" placeholder="Votre adresse mail" />
            </div>

            <!-- Commentaire -->  
            <div class="comment-form-comment">
                <label class="form-label" for="comment">Commentaire<span class="required">*</span></label>
                <textarea  class="form-control mx-auto" id="comment" name="comment" maxlength="500" style="height: 10rem" required="required" aria-required="true" placeholder="Votre commentaire"></textarea>
            </div>

            <!-- Bouton soumettre -->  
            <div class="form-submit text-end">
                <button class="btn btn-primary btn-sm" type="submit">
                    Commenter
                </button>
                <input type='hidden' name='comment_post_ID' value='<?php echo get_the_ID(); ?>' id='comment_post_ID' />
                <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
            </div>

        </form> <!-- FIN formulaire de commentaire -->
    </div> <!-- FIN div #commentaire -->

<?php else : ?>
    <p>Les commentaires sont fermés pour cet article.</p>
<?php endif; ?>

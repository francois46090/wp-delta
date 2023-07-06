               
<section class="d-flex">

    <div>
        <h2 class="text-danger"><?php the_title();?></h2>
            <figure class="text-end">
                <blockquote class="blockquote">
                    <?php the_content();?>
                </blockquote>
                <figcaption class="blockquote-footer">
                    d'après <cite title="Source Title"><?php the_author(); ?></cite>
                </figcaption>
            </figure>
    </div>
        <?php if(has_post_thumbnail()){?>
    <figure class="mx-3"><?php the_post_thumbnail(); ?></figure>

    <?php }?>
</section>
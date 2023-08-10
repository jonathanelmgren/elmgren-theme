</main>
<footer class='elmgren-footer text-red-50'>
    <div class='elmgren-footer--content <?php elmgren_get_page_width() ?>'>
        <?php elmgren_the_footer_setting('company_name'); ?>
        <?php elmgren_the_footer_setting('contact_info'); ?>
        <?php if (elmgren_has_socials()) : ?>
            <div class='elmgren-footer--socials'>
                <?php if (elmgren_has_socials('facebook')) : ?>
                    <a aria-label="Facebook" href="<?php elmgren_the_footer_setting('facebook'); ?>">
                        <?php get_template_part('assets/images/icons/inline/inline', 'facebook.svg');  ?>
                    </a>
                <?php endif; ?>
                <?php if (elmgren_has_socials('instagram')) : ?>
                    <a aria-label="Instagram" href="<?php elmgren_the_footer_setting('instagram'); ?>">
                        <?php get_template_part('assets/images/icons/inline/inline', 'instagram.svg');  ?>
                    </a>
                <?php endif; ?>
                <?php if (elmgren_has_socials('youtube')) : ?>
                    <a aria-label="Youtube" href="<?php elmgren_the_footer_setting('youtube'); ?>">
                        <?php echo get_template_part('assets/images/icons/inline/inline', 'youtube.svg');  ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
<?php $this->view('templates/default/register/modal'); ?>
<?php if(config('ads-code')): ?>
    <?php echo config('ads-code'); ?>
    <script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>
<?php endif; ?>
<?php $pages = get_pages(); ?>
<footer class="text-center py-3 footer-wrapper border-top">
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php foreach($pages as $page): ?>
            <a href="<?php echo page_url($page) ?>" class="bottom-page-link"><?php echo strtoupper($page['title']); ?></a>
            <?php endforeach;; ?>
        </div>
    </div><br/>
    <div class="row">
        <div class="col-12"><?php echo lang('copyright'); ?> <?php echo date('Y'); ?> <?php echo config('website-title', 'FriendsQuizzy') ?>.<?php echo lang('all-rights-reserved') ?> </div>
    </div>
</div>
</footer>
</body>
<script>
    var base_url = '<?php echo site_url(); ?>'
</script>

<script rel="script" src="<?php echo asset_url().'default/js/jquery.js'; ?>"></script>
<script rel="script" src="<?php echo asset_url().'default/js/custom.min.js'; ?>"></script>
<script rel="script" src="<?php echo asset_url().'default/js/script.js'; ?>"></script>
</body>
</html>
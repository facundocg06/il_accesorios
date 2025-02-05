<?php
    $containerFooter =
        isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
            ? 'container-xxl'
            : 'container-fluid';
?>

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="<?php echo e($containerFooter); ?>">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>, hecho por el Grupo 19
            </div>
            <div class="d-none d-lg-inline-block">
                
                <?php
                    $pageUrl = Route::current()->uri();
                    $pageView = \App\Models\PageView::where('page_url', $pageUrl)->first();
                ?>

                <?php if($pageView): ?>
                    <p>Esta página ha sido visitada <?php echo e($pageView->visits); ?> veces.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer-->
<?php /**PATH /var/www/resources/views/layouts/sections/footer/footer.blade.php ENDPATH**/ ?>
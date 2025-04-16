<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="footer-info">
                        <h3>CV. Saksana Antakara</h3>
                        <p>
                            Jalan Pare 24 Metro Timur,<br>
                            Kota Metro Provinsi Lampung<br><br>
                            <strong>Phone:</strong> +62<br>
                            <strong>Email:</strong> saksana.antakara@mailnesia.com<br>
                        </p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Menu</h4>
                    <ul>
                        <?php foreach ($allowed_tabs as $tab) : ?>
                            <?php if (isset($page_titles[$tab])) : ?>
                                <li><i class="bx bx-chevron-right"></i> <a href="<?php echo $tab; ?>"><?php echo $page_titles[$tab]; ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Services</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="about.php">About</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="testimonials.php">Testimonials</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="portfolio.php">Galery</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="blog.php">Blog</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="contact.php" class="active">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Survey Kepuasan</h4>
                    <p>Bantu kami meningkatkan layanan kami dengan mengisi survey kepuasan.</p>
                    <a href="https://forms.gle/qRqwSL511cKfdhZ87" class="btn btn-primary" target="_blank">Isi Survey</a>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; <?php echo date("Y"); ?> <strong><span>Human Resource Management</span></strong>. CV. Saksana Antakara
        </div>
        <div class="credits">
            <a href="https://teer.id/hunty/">Bot Hunting Company Limited</a>
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>
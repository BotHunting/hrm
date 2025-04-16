<?php
session_start();
include 'header.php';

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Inisialisasi array tombol yang akan ditampilkan
$buttons = array();

// Tentukan tombol yang akan ditampilkan berdasarkan jabatan pengguna
switch ($_SESSION["jabatan"]) {
    case "karyawan":
        $buttons = array("absensi.php", "kinerja.php", "pelatihan.php");
        break;
    case "admin":
        $buttons = array("karyawan.php", "absensi.php", "kinerja.php", "pelatihan.php", "gaji.php", "pengguna.php", "laporan.php");
        break;
    case "ceo":
        $buttons = array("karyawan.php", "gaji.php", "laporan.php", "pengguna.php");
        break;
    default:
        break;
}
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Contact</h2>
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li>Contact</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

            <div>
                <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d835.3887100500247!2d105.31759708806062!3d-5.135754232467265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40beb3d1ad7797%3A0xd3bda4f04e59cf72!2sJl.%20Pare%20No.24%2C%20Tejoagung%2C%20Kec.%20Metro%20Tim.%2C%20Kota%20Metro%2C%20Lampung%2034123!5e0!3m2!1sid!2sid!4v1712603784788!5m2!1sid!2sid" frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="row mt-5">

                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>Jl. Pare No.24, Tejoagung, Kec. Metro Timur, Kota Metro, Lampung 34123</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>saksana.antakara@mailnesia.com</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>+62</p>
                        </div>

                    </div>

                </div>

                <div class="col-lg-8 mt-5 mt-lg-0">

                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<?php include 'footer.php' ?>
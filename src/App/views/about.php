<?php include $this->resolve("partials/_header.php"); ?>
<!-- Start Main Content Area -->
<section class="container mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <!-- Page Title -->
    <h3>About Page</h3>

    <hr />

    <!-- Escaping Data -->
    <p>Escaping Data: <?php echo e($dangerousData); ?></p>

    <!-- Escaping is the process of converting a character into a different character for security  -->
    <!-- Purpose of escaping is to prevent a compiler or interpreter from accidently processing the character as an instruction, using HTML Entities  -->
    <!-- Why is this important  -->
    <!-- to defend the xss attack -->
    <!-- What is xss -->
    <!-- XSS is the short for cross-site scripting. It's when malicious code is inserted into a template -->
</section>
<!-- End Main Content Area -->
<?php include $this->resolve("partials/_footer.php"); ?>
<?php include $this->resolve("partials/_header.php"); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        email.addEventListener('input', validateEmail);
        password.addEventListener('input', validatePassword);

        form.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });

        function validateEmail() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                emailError.textContent = 'Please enter a valid email address.';
                return false;
            } else {
                emailError.textContent = '';
                return true;
            }
        }

        function validatePassword() {
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!passwordPattern.test(password.value)) {
                passwordError.textContent = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
                return false;
            } else {
                passwordError.textContent = '';
                return true;
            }
        }

        function validateForm() {
            let isValid = true;
            isValid &= validateEmail();
            isValid &= validatePassword();
            return isValid;
        }
    });
</script>

<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <form id="registerForm" method="POST" class="grid grid-cols-1 gap-6">
        <?php include $this->resolve("partials/_csrf.php"); ?>
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input id="email" value="<?php echo e($oldFormData['email'] ?? "");  ?>" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com" />
            <div id="emailError" class=" mt-2 p-2 text-red-500">
            </div>
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <label class="block">
            <span class="text-gray-700">Password</span>
            <input id="password" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <div id="passwordError" class=" mt-2 p-2 text-red-500">
            </div>
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Submit
        </button>
    </form>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>
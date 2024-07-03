<?php include $this->resolve("partials/_header.php");
// dd($oldFormData);
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const email = document.getElementById('email');
        const age = document.getElementById('age');
        const country = document.getElementById('country');
        const url = document.getElementById('URL');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const tos = document.getElementById('tos');

        const emailError = document.getElementById('emailError');
        const ageError = document.getElementById('ageError');
        const countryError = document.getElementById('countryError');
        const urlError = document.getElementById('URLError');
        const passwordError = document.getElementById('passwordError');
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        const tosError = document.getElementById('tosError');

        email.addEventListener('input', validateEmail);
        age.addEventListener('input', validateAge);
        country.addEventListener('change', validateCountry);
        url.addEventListener('input', validateURL);
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validateConfirmPassword);
        tos.addEventListener('change', validateTOS);

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

        function validateAge() {
            if (age.value < 18 || age.value > 100) {
                ageError.textContent = 'Age must be between 18 and 100.';
                return false;
            } else {
                ageError.textContent = '';
                return true;
            }
        }

        function validateCountry() {
            if (country.value === 'Invalid Country') {
                countryError.textContent = 'Please select a valid country.';
                return false;
            } else {
                countryError.textContent = '';
                return true;
            }
        }

        function validateURL() {
            const urlPattern = /^(ftp|http|https):\/\/[^ "]+$/;
            if (url.value && !urlPattern.test(url.value)) {
                urlError.textContent = 'Please enter a valid URL.';
                return false;
            } else {
                urlError.textContent = '';
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

        function validateConfirmPassword() {
            if (confirmPassword.value !== password.value) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                return false;
            } else {
                confirmPasswordError.textContent = '';
                return true;
            }
        }

        function validateTOS() {
            if (!tos.checked) {
                tosError.textContent = 'You must accept the terms of service.';
                return false;
            } else {
                tosError.textContent = '';
                return true;
            }
        }

        function validateForm() {
            let isValid = true;
            isValid &= validateEmail();
            isValid &= validateAge();
            isValid &= validateCountry();
            isValid &= validateURL();
            isValid &= validatePassword();
            isValid &= validateConfirmPassword();
            isValid &= validateTOS();
            return isValid;
        }
    });
</script>

<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">


    <form id="registerForm" action="/register" method="POST" class="grid grid-cols-1 gap-6">
        <?php include $this->resolve("partials/_csrf.php"); ?>

        <!-- Email -->
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input id="email" value="<?php echo e($oldFormData['email'] ?? "");  ?>" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com" required />
            <div id="emailError" class=" mt-2 p-2 text-red-500">
            </div>
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); ?>

                <?php endif; ?>
        </label>
        <!-- Age -->
        <label class="block">
            <span class="text-gray-700">Age</span>
            <input id="age" value="<?php echo e($oldFormData['age'] ?? "");  ?>" name=" age" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" required />
            <div id="ageError" class=" mt-2 p-2 text-red-500">
            </div>
            <?php if (array_key_exists('age', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['age'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <!-- Country -->
        <label class="block">
            <span class="text-gray-700">Country</span>
            <select id="country" name="country" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="USA">USA</option>
                <option value="Canada" <?php echo $oldFormData['country'] ?? '' === 'Canada' ? 'selected' : '' ?>>Canada</option>
                <option value="Mexico" <?php echo $oldFormData['country'] ?? '' === 'Mexico' ? 'selected' : '' ?>>Mexico</option>
                <option value="Invalid Country" <?php echo $oldFormData['country'] ?? '' === 'Invalid Country' ? 'selected' : '' ?>>Invalid Country</option>
            </select>
            <div id="countryError" class=" mt-2 p-2 text-red-500">
            </div>
            <?php if (array_key_exists('country', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['country'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <!-- Social Media URL -->
        <label class="block">
            <span class="text-gray-700">Social Media URL</span>
            <input id="URL" value="<?php echo e($oldFormData['socialMediaURL'] ?? '');  ?> " name=" socialMediaURL" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <div id="URLError" class=" mt-2 p-2 text-red-500">
            </div>
            <?php if (array_key_exists('socialMediaURL', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['socialMediaURL'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <!-- Password -->
        <label class="block">
            <span class="text-gray-700">Password</span>
            <input id="password" name=" password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" required />
            <?php if (array_key_exists('password', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php print_r(e($errors['password'][0])); ?>
                </div>
            <?php endif; ?>
            <div id="passwordError" class=" mt-2 p-2 text-red-500">
            </div>
        </label>
        <!-- Confirm Password -->
        <label class="block">
            <span class="text-gray-700">Confirm Password</span>
            <input id="confirmPassword" name=" confirmPassowrd" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" required />
            <?php if (array_key_exists('confirmPassowrd', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['confirmPassowrd'][0]); ?>
                </div>
            <?php endif; ?>
            <div id="confirmPasswordError" class=" mt-2 p-2 text-red-500">
            </div>
        </label>
        <!-- Terms of Service -->
        <div class="block">
            <div class="mt-2">
                <div>
                    <label class="inline-flex items-center">
                        <input id="tos" <?php echo e($oldFormData['tos'] ?? false ? 'checked' : '') ?> name="tos" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox" required />
                        <span class="ml-2">I accept the terms of service.</span>
                        <div id="tosError" class=" mt-2 p-2 text-red-500">
                        </div>
                        <?php if (array_key_exists('tos', $errors)) : ?>
                            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                                <?php echo e($errors['tos'][0]); ?>
                            </div>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
        </div>
        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Submit
        </button>
    </form>
    <?php echo dd($oldFormData); ?>
</section>


<?php



include $this->resolve("partials/_footer.php") ?>
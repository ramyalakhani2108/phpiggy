<?php include $this->resolve("partials/_header.php");
// dd($oldFormData);
?><script>
    document.addEventListener('DOMContentLoaded', function() {
        const FormFields = ['email', 'age', 'country', 'URL', 'password', 'confirmPassword', 'tos'];
        const ErrorFields = ['emailError', 'ageError', 'countryError', 'URLError', 'passwordError', 'confirmPassword', 'tos'];

        FormFields.forEach(Element => {
            FormFields[Element] = document.getElementById(Element);
        });





    })
</script>

<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">

    <div id="loop">

    </div>
    <form id="registrationForm" action="/register" method="POST" class="grid grid-cols-1 gap-6">
        <!-- Email -->
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input id="email" value="<?php echo e($oldFormData['email'] ?? "");  ?>" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com" required />

            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); ?>
                </div>
            <?php endif; ?>
        </label>
        <!-- Age -->
        <label class="block">
            <span class="text-gray-700">Age</span>
            <input id="age" value="<?php echo e($oldFormData['age'] ?? "");  ?>" name=" age" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" required />
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
                    <?php echo e($errors['password'][0]); ?>
                </div>
            <?php endif; ?>
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
        </label>
        <!-- Terms of Service -->
        <div class="block">
            <div class="mt-2">
                <div>
                    <label class="inline-flex items-center">
                        <input id="tos" <?php echo e($oldFormData['tos'] ?? false ? 'checked' : '') ?> name="tos" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox" required />
                        <span class="ml-2">I accept the terms of service.</span>
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
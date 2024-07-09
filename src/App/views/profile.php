<?php include $this->resolve("partials/_header.php");

?>

<section class="container mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <h2 class="text-2xl font-semibold mb-4 p-4">Account Settings</h2>

    <!-- Account Settings Form -->
    <form method="POST" enctype="multipart/form-data" class=" p-4  space-y-8">
        <?php include $this->resolve("partials/_csrf.php"); ?>

        <!-- Username -->
        <div class="mt-6">
            <label for="username" class=" mb-4 block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" value="<?php echo e($profile['username']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2 px-3">
        </div>
        <?php if (array_key_exists('username', $errors)) : ?>
            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                <?php echo e($errors['username'][0]); ?>
            </div>
        <?php endif; ?>
        <!-- Email -->
        <div class="mt-6">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="<?php echo e($profile['user_email']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2 px-3">
        </div>
        <?php if (array_key_exists('email', $errors)) : ?>
            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                <?php echo e($errors['email'][0]); ?>
            </div>
        <?php endif; ?>

        <div class="mt-6">
            <label for="email" class="block text-sm font-medium text-gray-700">Age</label>

            <input id="age" value="<?php echo e($profile['user_age'] ?? "");  ?>" name=" age" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" required />

            <?php if (array_key_exists('age', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['age'][0]); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Password -->
        <div class="mt-6">
            <label for="sociaMediaUrl" class="block text-sm font-medium text-gray-700">Social Media Url</label>
            <input type="text" value="<?php echo e($profile['user_social_media_url']) ?>" name="socialMediaURL" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2 px-3">
        </div>
        <?php if (array_key_exists('socialMediaURL', $errors)) : ?>
            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                <?php echo e($errors['socialMediaURL'][0]); ?>
            </div>
        <?php endif; ?>
        <div class="mt-6">
            <label class="block ">
                <span class="text-gray-700">Country</span>
                <select id="country" name="country" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="USA" <?php echo $profile['user_country']  === 'USA' ? 'selected' : '' ?>>USA</option>
                    <option value="Canada" <?php echo $profile['user_country']  === 'Canada' ? 'selected' : '' ?>>Canada</option>
                    <option value="Mexico" <?php echo $profile['user_country']  === 'Mexico' ? 'selected' : '' ?>>Mexico</option>
                    <option value="Invalid Country" <?php echo $profile['user_country']  === 'Invalid Country' ? 'selected' : '' ?>>Invalid Country</option>
                </select>
                <div id="countryError" class=" mt-2 p-2 text-red-500">
                </div>
                <?php if (array_key_exists('country', $errors)) : ?>
                    <div class="bg-gray-100 mt-2 p-2 text-red-500">
                        <?php echo e($errors['country'][0]); ?>
                    </div>
                <?php endif; ?>
            </label>
        </div>
        <!-- Confirm Password -->
        <div class="mt-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Enter Your Income </label>
            <input type="text" value="<?php echo e($profile['income']); ?>" id="income" name="income" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2 px-3">
        </div>
        <?php if (array_key_exists('income', $errors)) : ?>
            <div class="bg-gray-100 mt-2 p-2 text-red-500">
                <?php echo e($errors['income'][0]); ?>
            </div>
        <?php endif; ?>
        <!-- Update Button -->
        <div class="mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Account</button>
        </div>
        <!-- Update Button -->
        <div class="mt-4">
            <a href="/profile/updatePassword" class="hover:bg-indigo-500">Update Passowrd [click] </a>
        </div>
        <input type="hidden" name="balance" value="<?php echo e(((float) $profile['income'] - (float) $total_amt['total_transaction']) + $profile['balance']); ?>">
    </form>

    <!-- Horizontal Line with Squares -->
    <hr class="my-8 border-gray-300">

    <!-- Financial Summary -->
    <div class="flex justify-between">
        <!-- Income -->
        <div class="text-center">
            <div class="text-sm font-medium text-gray-700 mb-1">Income</div>
            <div class="text-lg font-semibold text-green-500"><?php echo e($profile['income']); ?></div>
        </div>

        <!-- Spend -->
        <div class="text-center">
            <div class="text-sm font-medium text-gray-700 mb-1">Spend</div>
            <div class="text-lg font-semibold text-red-500"><?php print_r($total_amt['total_transaction']); ?></div>
        </div>

        <!-- Profit or Loss -->
        <div class="text-center">
            <div class="text-sm font-medium text-gray-700 mb-1">Profit or Loss</div>
            <?php if ((float) $total_amt['total_transaction'] < (float) $profile['income']) : ?>
                <div class="text-lg font-semibold " style="color:green">
                    <?php echo e((float) $profile['income'] - (float) $total_amt['total_transaction']); ?>
                </div>
            <?php else : ?>
                <div class="text-lg font-semibold text-red-500">
                    <?php echo e((float) $profile['income'] - (float) $total_amt['total_transaction']); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Balance -->
        <div class="text-center">
            <div class="text-sm font-medium text-gray-700 mb-1">Balance</div>
            <div class="text-lg font-semibold text-gray-900">
                <?php
                echo e(((float) $profile['income'] - (float) $total_amt['total_transaction']) + $profile['balance']);
                ?>

            </div>
        </div>
    </div>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>




<!-- Profile Picture Upload
<div class="mt-6">
    <label for="profile_pic" class="block text-sm font-medium text-gray-700">Profile Picture</label>
    <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2 px-3">
</div>

<!-- Current Profile Picture -->
<!-- <div class="mt-6">
    <label class="block text-sm font-medium text-gray-700">Current Profile Picture</label>
    <?php //if (!empty($user['profile_pic'])) : 
    ?>
        <img src="<?php // echo e($user['profile_pic']); 
                    ?>" alt="Current Profile Picture" class="mt-2 rounded-md border border-gray-300">
    <?php //else : 
    ?>
        <p class="mt-2 text-sm text-gray-500">No profile picture uploaded.</p>
    <?php // endif; 
    ?>
</div> -->
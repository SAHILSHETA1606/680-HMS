<div class="wrapper flex flex-col h-screen justify-between">
    <div class="wrapper">
        <header class="w-screen py-4 bg-green-700 overflow-x-hidden">
            <h1 class="text-2xl text-white text-center font-semibold">Healthcare Dashboard</h1>
        </header>
        <nav class="bg-green-700/90 pl-2 pr-3 text-white py-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="#" class="text-2xl font-semibold">
                    <span>Welcome <?php echo $_SESSION['username'] ?></span>
                </a>
                <ul class="flex space-x-4">
                    <?php  ?>
                    <li><a href="profile.php" class="hover:text-gray-300">Profile</a></li>
                    <li><a href="messages.php" class="hover:text-gray-300">Chats</a></li>
                    <li><a href="change-password.php?id=<?php echo $_SESSION['docId'] ?>" class="hover:text-gray-300 underline">Change Password</a></li>
                    <li><a href="logout.php" class="hover:text-gray-300">Logout</a></li>
                </ul>
            </div>
        </nav>

<!DOCTYPE html>
<html lang="en" dir="rtl"> <!-- RTL for Kurdish -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Kurdish Marketplace' ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/custom.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white shadow-lg p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="../index.php" class="text-3xl font-extrabold tracking-wide flex items-center space-x-3 hover:text-gray-200 transition-all duration-300">
                <img src="../assets/images/logo.png" alt="Logo" class="h-12">
                <span class="text-lg">Kurdish Market</span>
            </a>

            <div class="flex items-center space-x-8 space-x-reverse">
                <a href="../index.php" class="hover:text-blue-200 transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="search.php" class="hover:text-blue-200 transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-search mr-2"></i> Search
                </a>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="user-dashboard.php" class="hover:text-blue-200 transition duration-300 ease-in-out transform hover:scale-105">
                        <i class="fas fa-user mr-2"></i> Dashboard
                    </a>
                    <a href="../backend/auth/logout.php" class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="hover:text-blue-200 transition duration-300 ease-in-out transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                    <a href="register.php" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container mx-auto px-4 py-8 min-h-screen"></main>
</body>
</html>

</main> <!-- Close main tag from header -->

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">About Us</h3>
                <p>Connecting Kurdish sellers with buyers worldwide since 2023.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="../index.php" class="hover:text-blue-300">Home</a></li>
                    <li><a href="search.php" class="hover:text-blue-300">Products</a></li>
                    <li><a href="contact.php" class="hover:text-blue-300">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Contact</h3>
                <p><i class="fas fa-envelope mr-2"></i> contact@kurdishmarket.com</p>
                <p class="mt-2"><i class="fas fa-phone mr-2"></i> +964 750 123 4567</p>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center">
            <p>&copy; <?= date('Y') ?> Kurdish Marketplace. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- JavaScript Files -->
<script src="../assets/js/main.js"></script>
<?php if(basename($_SERVER['PHP_SELF']) == 'search.php'): ?>
    <script src="../assets/js/search.js"></script>
<?php endif; ?>
</body>
</html>
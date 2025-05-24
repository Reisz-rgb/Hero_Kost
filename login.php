<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Kost Hero</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #120707;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden">

  <!-- Background Bubbles -->
  <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
    <div class="absolute w-32 h-32 bg-teal-400 opacity-30 rounded-full -top-10 -left-10"></div>
    <div class="absolute w-32 h-32 bg-teal-400 opacity-30 rounded-full -bottom-10 -right-10"></div>
    <div class="absolute w-32 h-32 bg-teal-400 opacity-20 rounded-full top-1/2 left-0 -translate-y-1/2 -translate-x-1/2"></div>
  </div>

  <!-- Login Card -->
  <div class="z-10 bg-rose-300 rounded-3xl p-8 shadow-xl text-center w-80">
    <div class="w-16 h-16 mx-auto mb-4 bg-white rounded-full flex items-center justify-center shadow">
      <img src="assets/img/logo.png" alt="Logo" class="w-8 h-8">
    </div>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">KOST HERO</h1>

    <!-- Tombol Login Role -->
    <a href="login_pencari.php" class="block bg-teal-400 hover:bg-teal-500 text-white font-medium py-2 rounded-full mb-3 transition duration-200">
      Login sebagai Pencari
    </a>
    <a href="login_pemilik.php" class="block bg-teal-400 hover:bg-teal-500 text-white font-medium py-2 rounded-full mb-3 transition duration-200">
      Login sebagai Pemilik
    </a>

    <!-- Tombol Register -->
    <a href="register.php" class="block text-sm text-white mt-4 hover:underline">Belum punya akun? Register</a>
  </div>
</body>
</html>

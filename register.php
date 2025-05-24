<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Kost Hero</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #3d2d2c;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden">

  <!-- Background Orbs -->
  <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
    <div class="absolute w-32 h-32 bg-teal-300 opacity-30 rounded-full -top-10 -left-10"></div>
    <div class="absolute w-32 h-32 bg-teal-300 opacity-30 rounded-full -bottom-10 -right-10"></div>
  </div>

  <!-- Register Card -->
  <div class="z-10 bg-rose-300 rounded-3xl p-8 w-80 text-center shadow-xl">
    <h2 class="text-sm font-semibold text-gray-700 mb-3">Buat Akun Baru</h2>
    <div class="w-16 h-16 mx-auto bg-white rounded-full mb-4 flex items-center justify-center">
      <img src="assets/img/logo.png" class="w-8 h-8" alt="logo" />
    </div>

    <form method="POST" action="auth_register.php" class="space-y-3">
      <input name="username" type="text" placeholder="Username" class="w-full px-4 py-2 rounded-full outline-none text-sm" required>
      <input name="email" type="email" placeholder="Email" class="w-full px-4 py-2 rounded-full outline-none text-sm" required>
      <input name="password" type="password" placeholder="Password" class="w-full px-4 py-2 rounded-full outline-none text-sm" required>
      <input name="confirm" type="password" placeholder="Confirm Password" class="w-full px-4 py-2 rounded-full outline-none text-sm" required>

      <select name="role" class="w-full px-4 py-2 rounded-full text-sm outline-none">
        <option value="pencari">Saya Pencari</option>
        <option value="pemilik">Saya Pemilik Kos</option>
      </select>

      <button type="submit" class="w-full bg-teal-400 hover:bg-teal-500 text-white font-semibold py-2 rounded-full mt-2">
        Register
      </button>
    </form>

    <p class="text-xs text-gray-700 mt-4">Sudah punya akun? 
      <a href="login_pencari.php" class="text-blue-900 hover:underline">Login</a>
    </p>
  </div>
</body>
</html>

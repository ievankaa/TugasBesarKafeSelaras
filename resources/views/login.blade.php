<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kafe Selaras Web</title>
  <link rel="stylesheet" href="{{ asset('css/pemilik/style_login_pegawai.css') }}">

  <style>
    .image-section {
      position: absolute; /* Atau relative, fixed, dll, sesuai kebutuhan */
      bottom: 0; /* Menempatkan gambar di bagian bawah */
      right: 0; /* Bisa menambahkan untuk menempatkan gambar di kiri */
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login-section">
      <div class="login-frame">
        <div class="welcome-back">Welcome Back!</div>
        <div class="description">
          Masukkan nomor handphone dan password untuk akses halaman
        </div>

        <!-- Tampilkan Pesan Kesalahan -->
        @if ($errors->any())
          <div class="error">
            {{ $errors->first('login') }}
          </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('auth.login') }}" method="POST">
          @csrf
          <!-- Input Nomor Handphone -->
          <input type="text" name="phone" class="input-field" placeholder="Nomor Handphone" required />

          <!-- Input Password -->
          <div class="input-container">
            <input type="password" name="password" class="input-field" placeholder="Password" required />
            <span class="eye-icon" onclick="togglePassword()">👁️</span>
          </div>

          <!-- Tombol Sign In -->
          <button type="submit" id="signInButton" class="sign-in">Sign In</button>
        </form>
      </div>
    </div>
    <img class="image-section" src="{{ asset('img/v5568_308.png') }}" alt="Example Image" width=700 height=500>
  </div>

  <!-- Pindahkan script ke file eksternal -->
  <script>
    function togglePassword() {
      const passwordField = document.querySelector('input[name="password"]');
      const passwordFieldType = passwordField.getAttribute('type');
      passwordField.setAttribute(
        'type',
        passwordFieldType === 'password' ? 'text' : 'password'
      );
    }
  </script>
</body>

</html>

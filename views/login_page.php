<?php include "../views/base/header.php"; ?>
<main class="login form-signin w-50 m-auto">
  <form class="">
    <h1 class="h3 mb-3 fw-normal">FAÇA LOGIN</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" minlength="6" required>
      <label for="floatingPassword">Senha</label>
      <button type="button" id="togglePassword" class="btn btn-link">Ver</button>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">LOGAR</button>
  </form>
  <a href="chose_profile.php" class="register-link"><p>Não possuo uma conta</p></a>
</main>

<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('floatingPassword');

  togglePassword.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    togglePassword.textContent = type === 'password' ? 'Ver' : 'Ocultar';
  });
</script>
<?php include "../views/base/footer.php"; ?>
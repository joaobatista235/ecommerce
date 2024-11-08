<?php include "../views/base/header.php"; ?>
<main class="login form-signin w-50 m-auto">
  <form class="" method="POST" action=" ../controllers/receber_login.php">
    <h1 class="h3 mb-3 fw-normal">FAÇA LOGIN</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" minlength="6" required name="passwd">
      <label for="floatingPassword">Senha</label>
      <button type="button" id="togglePassword" class="btn btn-link">Ver</button>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">LOGAR</button>
  </form>
  <a id="choseProfile" href="#" class="register-link"><p>Não possuo uma conta</p></a>
</main>

<script>
  // Wrap the togglePassword functionality in a function to avoid declaring multiple times
  (function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('floatingPassword');

    // Check if the togglePassword element exists before adding the event listener
    if (togglePassword) {
      togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.textContent = type === 'password' ? 'Ver' : 'Ocultar';
      });
    }
  })();

  $(document).ready(function() {
    $('#choseProfile').click(function() {
      loadContent('views\\chose_profile.php', '#loginContainer');
    });
  });
</script>

<?php include "../views/base/footer.php"; ?>

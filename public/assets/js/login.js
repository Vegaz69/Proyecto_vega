document.querySelector('#loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('/auth/dologin', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'ok') {
      let route = (data.role === 'admin') ? '/admin/dashboard' : '/cliente/home';
      window.location.href = route;
    } else {
      document.getElementById('alert').innerHTML =
        '<div class="alert alert-danger">Credenciales inválidas</div>';
    }
  });
});

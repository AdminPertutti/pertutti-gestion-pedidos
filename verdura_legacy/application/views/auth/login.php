<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestor de Pedidos Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .demo-accounts {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <h2>Gestor de Pedidos Pro</h2>
                        <p class="mb-0">Accede a tu cuenta para continuar</p>
                    </div>
                    <div class="p-4">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div id="error-message" class="alert alert-danger d-none"></div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                        </form>
                        
                        <div class="demo-accounts">
                            <h6><i class="fas fa-info-circle me-2"></i>Cuentas de prueba:</h6>
                            <small class="d-block"><strong>Admin:</strong> admin@empresa.com / admin123</small>
                            <small class="d-block"><strong>Usuario:</strong> usuario@empresa.com / user123</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const errorDiv = document.getElementById('error-message');
            
            fetch('<?= base_url('auth/login') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '<?= base_url('dashboard') ?>';
                } else {
                    errorDiv.textContent = data.message || 'Error al iniciar sesión';
                    errorDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                errorDiv.textContent = 'Error de conexión';
                errorDiv.classList.remove('d-none');
            });
        });
    </script>
</body>
</html>

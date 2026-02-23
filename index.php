<?php
session_start();
require_once 'config/database.php';

$errors = [];
$success = '';

// --------------------- РЕГИСТРАЦИЯ ---------------------
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$name || !$email || !$password) {
        $errors[] = "Заполните все поля";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Неверный email";
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $errors[] = "Пароль должен быть 8-20 символов";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) $errors[] = "Такой email уже есть";
    }

    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $passwordHash])) {
            $success = "Регистрация прошла успешно";
        } else {
            $errors[] = "Ошибка, попробуйте позже";
        }
    }
}

// --------------------- ВХОД ---------------------
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        $errors[] = "Заполните все поля";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $errors[] = "Пользователь не найден";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Неверный пароль";
        } else {
            // Устанавливаем сессию
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // При успешном входе делаем редирект на home.php
            header('Location: public/home.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Авторизация</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI', Roboto, Helvetica, sans-serif;}
body{display:flex;justify-content:center;align-items:center;height:100vh;background:#f4f7f6;}
.container{background:#fff;border-radius:20px;box-shadow:0 20px 40px rgba(0,0,0,0.12);position:relative;overflow:hidden;width:850px;max-width:90vw;height:450px;max-height:80vh;}
.form-container{position:absolute;top:0;height:100%;transition:all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);}
.login-container{left:0;width:50%;z-index:2;}
.register-container{left:0;width:50%;opacity:0;z-index:1;}
.container.right-panel-active .login-container{transform:translateX(100%);opacity:0;}
.container.right-panel-active .register-container{transform:translateX(100%);opacity:1;z-index:5;}
form{background:#fff;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:0 50px;padding-bottom:40px;height:100%;text-align:center;position:relative;}
h1{font-weight:700;margin-bottom:20px;color:#2c3e50;font-size:28px;}
input{background:#f1f3f6;border:none;padding:14px 18px;margin:8px 0;width:100%;border-radius:12px;outline:none;font-size:15px;color:#333;transition:0.3s;}
input:focus{background:#e8ecef;box-shadow:inset 0 0 0 2px #3498db;}
button{border-radius:30px;border:1px solid #3498db;background:#3498db;color:#fff;font-size:14px;font-weight:600;width:190px;height:50px;text-transform:uppercase;letter-spacing:1px;cursor:pointer;transition:all 0.3s ease;position:absolute;bottom:40px;left:50%;transform:translateX(-50%);}
button:hover{background:#2980b9;transform:translateX(-50%) translateY(-2px);box-shadow:0 5px 15px rgba(52,152,219,0.3);}
button:active{transform:translateX(-50%) translateY(0);}
button.ghost{background:transparent;border-color:#fff;}
button.ghost:hover{background:#fff;color:#3498db;}
.overlay-container{position:absolute;top:0;left:50%;width:50%;height:100%;overflow:hidden;transition:transform 0.6s ease-in-out;z-index:100;}
.container.right-panel-active .overlay-container{transform:translateX(-100%);}
.overlay{background:linear-gradient(135deg,#2980b9 0%,#3498db 100%);color:#fff;position:relative;left:-100%;height:100%;width:200%;transform:translateX(0);transition:transform 0.6s ease-in-out;}
.container.right-panel-active .overlay{transform:translateX(50%);}
.overlay-panel{position:absolute;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:0 40px;text-align:center;top:0;height:100%;width:50%;transition:transform 0.6s ease-in-out;}
.overlay-panel h1{color:#fff;}
.overlay-left{transform:translateX(-20%);}
.container.right-panel-active .overlay-left{transform:translateX(0);}
.overlay-right{right:0;transform:translateX(0);}
.container.right-panel-active .overlay-right{transform:translateX(20%);}
p{font-size:15px;line-height:1.6;margin:15px 0 80px;opacity:0.9;}
a{color:#7f8c8d;font-size:14px;text-decoration:none;margin-top:15px;border-bottom:1px solid transparent;transition:0.3s;margin-bottom:60px;}
a:hover{border-color:#3498db;color:#3498db;}
.message{position:absolute;top:10px;width:80%;text-align:center;padding:8px;border-radius:8px;z-index:10;}
.error{background:#ffe6e6;color:#d8000c;}
.success{background:#e6ffe6;color:#006600;}
</style>
</head>
<body>

<div class="container" id="container">

  <div class="form-container register-container">
    <form method="POST">
      <h1>Создать аккаунт</h1>

      <?php if(!empty($errors) && isset($_POST['action']) && $_POST['action']==='register'): ?>
        <div class="message error" id="msg"><?php echo htmlspecialchars($errors[0]); ?></div>
      <?php endif; ?>
      <?php if(!empty($success) && isset($_POST['action']) && $_POST['action']==='register'): ?>
        <div class="message success" id="msg"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <input type="text" name="name" placeholder="Имя и Фамилия" required />
      <input type="email" name="email" placeholder="Электронная почта" required />
      <input type="password" name="password" placeholder="Придумайте пароль" required />
      <button type="submit">Регистрация</button>
      <input type="hidden" name="action" value="register">
    </form>
  </div>

  <div class="form-container login-container">
    <form method="POST">
      <h1>Личный кабинет</h1>

      <?php if(!empty($errors) && isset($_POST['action']) && $_POST['action']==='login'): ?>
        <div class="message error" id="msg"><?php echo htmlspecialchars($errors[0]); ?></div>
      <?php endif; ?>

      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Пароль" required />
      <a href="#">Забыли пароль?</a>
      <button type="submit">Войти</button>
      <input type="hidden" name="action" value="login">
    </form>
  </div>

  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h1>Уже с нами?</h1>
        <p>Войдите в личный кабинет, чтобы управлять бронированием и гаражом.</p>
        <button class="ghost" id="signIn">Войти</button>
      </div>

      <div class="overlay-panel overlay-right">
        <h1>Впервые у нас?</h1>
        <p>Зарегистрируйтесь, чтобы забронировать тест-драйв и собрать авто мечты.</p>
        <button class="ghost" id="signUp">Регистрация</button>
      </div>
    </div>
  </div>

</div>

<script>
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click',()=>{container.classList.add("right-panel-active");});
signInButton.addEventListener('click',()=>{container.classList.remove("right-panel-active");});

// Авто-переключение на регистрацию если была регистрация с ошибкой
<?php if(isset($_POST['action']) && $_POST['action']==='register'): ?>
container.classList.add("right-panel-active");
<?php endif; ?>

// Авто-скрытие сообщений через 3 секунды
const msg = document.getElementById('msg');
if(msg){
    setTimeout(()=>{ msg.style.display='none'; }, 3000);
}
</script>

</body>
</html>
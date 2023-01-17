<?php
require "core/database.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Відновлення логіну</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="website icon" type="png" href="img/web-icon.png">
</head>

<body>
    <div class="main-wrapper">

        <div class="preload">
            <div class="preload-carcass">
                <img src="img/preload.svg" class="icon-preload">
            </div>
        </div>

        <div class="popup__navbar">
            <div class="navbar__navbar">
                <div class="headline-wrap__navbar">
                    <img src="img/logo.svg" class="logo__navbar">
                    <img src="img/close.svg" class="close__navbar">
                </div>

                <div class="wrap-content__navbar">
                    <div class="content__navbar">
                        <a href="index.php" class="link__navbar">Головна</a>
                        <a href="cargo-add.php" class="link__navbar">Додати вантаж</a>
                        <a href="car-add.php" class="link__navbar">Додати транспорт</a>
                        <a href="cargos.php" class="link__navbar">Біржа вантажів</a>
                        <a href="cars.php" class="link__navbar">Біржа транспорту</a>
                    </div>
                    <?php if(!empty($_SESSION['auth'])){ ?>
                    <a href="profile.php" class="button__navbar">Особистий кабінет</a>
                    <?php } else { ?>
                    <p class="button__navbar start-popup__login">Увійти</p>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="popup__login">
            <div class="popup-carcass__login">
                <img src="img/close-popup.svg" class="close__login">
                <div class="wrap-content__login">
                    <form action="core/login.php" method="post" class="form__login">
                        <p class="headline__login">Авторизація</p>
                        <input type="text" class="input__login" name="user_login" id="login-error_login"
                            placeholder="Введіть ваш логін">
                        <div class="user-login_login__error"></div>
                        <input type="password" class="input__login" name="user_pass" id="pass-error_login"
                            placeholder="Введіть ваш логін">
                        <div class="user-pass_login__error"></div>
                        <div class="wrap-checkbox__login">
                            <input type="checkbox" name="remember" value="1">
                            <p>Запам'ятати мене</p>
                        </div>
                        <div class="nav-unit__login">
                            <button type="submit" name="login_submit" class="submit-btn__login">Увійти</button>
                            <a href="restore.php" class="data-info__login">Забули пароль ?</a>
                        </div>
                        <p class="new_profile-btn__login"><a href="reg-type.php">Створити</a> новий профіль</p>
                    </form>
                    <img src="img/login.jpg" class="bg__login">
                </div>
            </div>
        </div>

        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="wrap-header">
                        <img src="img/logo.svg" class="logo">
                        <img src="img/menu-icon.svg" class="menu-icon" id="popup__navbar-start">
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="container">

                <?php  if(isset($_SESSION['success_restore_pass'])){
                            echo $_SESSION['success_restore_pass'];
                            unset($_SESSION['success_restore_pass']);
                    } ?>

                <div class="wrap-content__restore">
                    <div class="wrap-forms__restore">
                        <h2 class="headline__restore">Скидання паролю</h2>
                        <p class="descript__restore">Не повідомляйте нікому свої особисті дані, це може бути небезпечно
                            для
                            вашого профілю</p>
                        <form action="core/restore-pass.php" method="post" class="form__restore">
                            <div class="wrap-input__restore">
                                <p>Ваш логін</p>
                                <input type="text" class="input__restore" name="restore_login" id="restore_login"
                                    placeholder="Введіть ваш пароль" required>
                                <div class="restore-login_error"></div>
                            </div>
                            <div class="wrap-input__restore">
                                <p>Ваш номер телефону</p>
                                <input type="tel" class="input__restore" name="phone" id="restore_phone"
                                    placeholder="Введіть ваш номер телефону" required>
                                <div class="restore-phone_error"></div>
                            </div>

                            <button class="submit__restore" name="submit__restore">Скинути пароль</button>

                        </form>
                    </div>
                    <img src="img/restore-bg.svg" class="bg__restore">
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="wrap__footer">
                    <img src="img/logo.svg" class="logo__footer">

                    <div class="nav-bar__footer">
                        <a href="index.php">Головна</a>
                        <a href="cargo-add.php">Додавання вантажу</a>
                        <a href="car-add.php">Додавання транспорту</a>
                        <a href="cargos.php">Біржа вантажів</a>
                        <a href="cars.php">Біржа транспорту</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script>
    window.onload = function() {
        let preloader = $(".preload");
        $(".preload").addClass('hide-preload')
    }
    $("#popup__navbar-start").click(function() {
        $(".popup__navbar").addClass("active__navbar");
    });

    $(".close__navbar").click(function() {
        $(".popup__navbar").removeClass("active__navbar");
    });

    $(".start-popup__login").click(function() {
        setTimeout(function() {
            $(".popup__login").addClass('active__login')
        }, 300);
        $(".popup__navbar").removeClass("active__navbar");
    });

    $(".close__login").click(function() {
        $(".popup__login").removeClass("active__login");
    });

    $("input[name~='user_login']").on("input", function() {
        $.ajax({
            url: "core/login.php",
            method: "POST",
            data: {
                user_login: $(this).val()
            },
            success: function(data) {
                $(".user-login_login__error").html(data);
            }
        });
    });

    $("input[name~='user_pass']").on("input", function() {
        $.ajax({
            url: "core/login.php",
            method: "POST",
            data: {
                user_pass: $(this).val(),
                user_login: $("input[name~='user_login']").val()
            },
            success: function(data) {
                $(".user-pass_login__error").html(data);
            }
        });
    });

    $("input[name~='phone']").on("click", function() {
        $(this).val("+380");
    });

    $("input[name~='restore_login']").on("input", function() {
        $.ajax({
            url: "core/restore-pass.php",
            method: "POST",
            data: {
                restore_login: $(this).val()
            },
            success: function(data) {
                $(".restore-login_error").html(data);
            }
        });
    });

    $("input[name~='phone']").on("input", function() {
        $.ajax({
            url: "core/restore-pass.php",
            method: "POST",
            data: {
                restore_phone: $(this).val(),
                check_login: $("input[name~='restore_login']").val()
            },
            success: function(data) {
                $(".restore-phone_error").html(data);
            }
        });
    });
    </script>
</body>

</html>
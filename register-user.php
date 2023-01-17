<?php
require "core/database.php";
$link = openConnection();
$query = "SELECT * FROM regions";
$regions = executeQuery($link,$query);
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Реєстрація користувача</title>
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
                        <input type="text" class="input__login" name="user_login__log" id="login-error_login"
                            placeholder="Введіть ваш логін">
                        <div class="user-login_login__error"></div>
                        <input type="password" class="input__login" name="user_pass__log" id="pass-error_login"
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
            <section class="register">
                <div class="container">
                    <h2>Реєстрація користувача</h2>
                    <p class="description__register">Не повідомляйте нікому свої особисті дані, це може бути небезпечно
                        для вашого профілю</p>

                    <?php 
                    if(isset($_SESSION['error-reg'])){
                        echo $_SESSION['error-reg'];
                        unset($_SESSION['error-reg']);
                    }
                    ?>

                    <p class="form-name__register">Дані користувача</p>
                    <form action="core/register.php" method="post" class="form__register">
                        <div class="wrap-form__register">
                            <div class="wrap-input__register">
                                <p>Ваш логін</p>
                                <input type="text" name="user_login" id="user-login__error" class="input__register"
                                    placeholder="Введіть бажаний логін" required>
                                <div class="user-login__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ваш пароль</p>
                                <input type="password" name="user_pass" id="user-pass__error" class="input__register"
                                    placeholder="Введіть бажаний пароль" required>
                                <div class="user-pass__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Повторіть пароль</p>
                                <input type="password" name="user_confirm" id="user-confirm__error"
                                    class="input__register" placeholder="Повторіть пароль" required>
                                <div class="user-confirm__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ваше ім’я</p>
                                <input type="text" name="user_name" id="user-name__error" class="input__register"
                                    placeholder="Введіть ваше ім’я" required>
                                <div class="user-name__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>По-батькові</p>
                                <input type="text" name="user_middle_name" id="user-middle_name__error"
                                    class="input__register" placeholder="По-батькові" required>
                                <div class="user-middle_name__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ваше прізвище</p>
                                <input type="text" name="user_surname" id="user-surname__error" class="input__register"
                                    placeholder="Введіть ваше прізвище" required>
                                <div class="user-surname__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ваша область</p>
                                <select class="select__register" name="region" id="regions" required>
                                    <option value="" disabled selected hidden>Оберіть вашу область</option>
                                    <?php
                                        while($region = mysqli_fetch_assoc($regions)){
                                            echo '<option value="'.$region['region_id'].'">'.$region['region_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ваше місто</p>
                                <select class="select__register" id="cities" name="city" required>
                                    <option disabled selected hidden>Оберіть ваше місто</option>
                                    <option disabled>Спочатку оберіть область</option>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ваш номер телефону</p>
                                <input type="tel" name="phone" class="input__register"
                                    placeholder="Введіть ваш номер телефону" id="user_phone" required>
                                <div class="user-phone__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Фото профілю</p>
                                <input type="file" name="user_image" multiple id="image-file__reg-user">
                                <label for="image-file__reg-user" class="input-file__register">Оберіть фото
                                    профілю</label>
                            </div>
                        </div>

                        <div class="wrap-images__car-add" id="preview-user-image">
                        </div>

                        <button type="submit" name="user_submit" class="button__register">Зареєструватись</button>
                    </form>
                </div>
            </section>
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

    $("input[name~='user_login__log']").on("input", function() {
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

    $("input[name~='user_pass__log']").on("input", function() {
        $.ajax({
            url: "core/login.php",
            method: "POST",
            data: {
                user_pass: $(this).val(),
                user_login: $("input[name~='user_login__log']").val()
            },
            success: function(data) {
                $(".user-pass_login__error").html(data);
            }
        });
    });

    $("input[name~='user_login']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_login: $(this).val()
            },
            success: function(data) {
                $(".user-login__error").html(data);
            }
        });
    });

    $("input[name~='user_pass']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_pass: $(this).val()
            },
            success: function(data) {
                $(".user-pass__error").html(data);
            }
        });
    });

    $("input[name~='user_confirm']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_confirm: $(this).val(),
                user_pass: $("input[name~='user_pass']").val()
            },
            success: function(data) {
                $(".user-confirm__error").html(data);
            }
        });
    });

    $("input[name~='user_name']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_name: $(this).val()
            },
            success: function(data) {
                $(".user-name__error").html(data);
            }
        });
    });

    $("input[name~='user_middle_name']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_middle_name: $(this).val()
            },
            success: function(data) {
                $(".user-middle_name__error").html(data);
            }
        });
    });

    $("input[name~='user_surname']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_surname: $(this).val()
            },
            success: function(data) {
                $(".user-surname__error").html(data);
            }
        });
    });

    $("#regions").on("change", function() {
        $.ajax({
            url: "core/cities-script.php",
            method: "POST",
            data: {
                region: $(this).val()
            },
            success: function(data) {
                $("#cities").html(data);
            }
        });
    });

    $("input[name~='phone']").on("click", function() {
        $(this).val("+380");
    });

    $("input[name~='phone']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                user_phone: $(this).val()
            },
            success: function(data) {
                $(".user-phone__error").html(data);
            }
        });
    });

    $("#image-file__reg-user").change(function() {
        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            var formData = new FormData();
            $.each($("#image-file__reg-user")[0].files, function(key, input) {
                formData.append('file[]', input);
            });

            var ajax_img = 0;
            $.ajax({
                type: "POST",
                url: 'core/upload-user-image.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    data.forEach(function(msg) {
                        $('#preview-user-image').append(msg);
                    });

                    $('.delete-image__car-add').each(function(index, elems) {
                        $(this).attr('data-index', index);

                        String.prototype.filename = function(extension) {
                            var s = this.replace(/\\/g, '/');
                            s = s.substring(s.lastIndexOf('/') + 1);
                            return s;
                        }

                        $(this).on("click", function() {
                            $('.image-car__car-add').each(function(index, img) {
                                $(this).attr('data-index', index);
                            });

                            $.ajax({
                                url: "core/delete-user-image.php",
                                method: "POST",
                                data: {
                                    image_name: $('.image-car__car-add')[
                                        index].src.filename()
                                },
                                success: function(data) {
                                    $('.wrap-image__car-add').each(
                                        function(index, img) {
                                            $(this).attr(
                                                'data-index',
                                                index);
                                        });
                                    $('.wrap-image__car-add')[index]
                                        .classList.add("hide-preview");
                                }
                            });
                        })
                    });

                }
            });
        }
    });
    </script>
</body>

</html>
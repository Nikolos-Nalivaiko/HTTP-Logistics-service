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
    <title>HTTP - Реєстрація профілю підприємства</title>
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
            <section class="register">
                <div class="container">
                    <h2>Реєстрація профілю підприємства</h2>
                    <p class="description__register">Не повідомляйте нікому свої особисті дані, це може бути небезпечно
                        для вашого профілю</p>

                    <p class="form-name__register">Дані підприємства</p>
                    <form action="core/register.php" method="post" class="form__register">
                        <div class="wrap-form__reg-company">
                            <div class="wrap-input__reg-company">
                                <p>Ваш логін</p>
                                <input type="text" name="company_login" id="company-login__error"
                                    class="input__register" placeholder="Введіть бажаний логін" required>
                                <div class="company-login__error"></div>
                            </div>

                            <div class="wrap-input__reg-company">
                                <p>Ваш пароль</p>
                                <input type="password" name="company_pass" id="company-pass__error"
                                    class="input__register" placeholder="Введіть бажаний пароль" required>
                                <div class="company-pass__error"></div>
                            </div>

                            <div class="wrap-input__reg-company">
                                <p>Повторіть пароль</p>
                                <input type="password" name="company_confirm" id="company-confirm__error"
                                    class="input__register" placeholder="Повторіть пароль" required>
                                <div class="company-confirm__error"></div>
                            </div>

                            <div class="wrap-input__reg-company">
                                <p>Назва організації</p>
                                <input type="text" name="company_name" id="company-name__error" class="input__register"
                                    placeholder="ТОВ «НАЗВА»" required>
                                <div class="company-name__error"></div>
                            </div>

                            <div class="wrap-input__reg-company">
                                <p>Ваша область</p>
                                <select class="select__register" id="regions" name="company_region" required>
                                    <option value="" disabled selected hidden>Оберіть вашу область</option>
                                    <?php
                                        while($region = mysqli_fetch_assoc($regions)){
                                            echo '<option value="'.$region['region_id'].'">'.$region['region_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__reg-company">
                                <p>Ваше місто</p>
                                <select class="select__register" name="company_city" id="cities" required>
                                    <option disabled selected hidden>Оберіть ваше місто</option>
                                    <option disabled>Спочатку оберіть область</option>
                                </select>
                            </div>

                            <div class="wrap-input__reg-company">
                                <p>Ваш номер телефону</p>
                                <input type="text" class="input__register" name="company_phone"
                                    placeholder="Введіть ваш номер телефону" id="company_phone" required>
                                <div class="company-phone__error"></div>
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

                        <button type="submit" name="company_submit" class="button__register">Зареєструватись</button>
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

    $("input[name~='company_login']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                company_login: $(this).val()
            },
            success: function(data) {
                $(".company-login__error").html(data);
            }
        });
    });

    $("input[name~='company_pass']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                company_pass: $(this).val()
            },
            success: function(data) {
                $(".company-pass__error").html(data);
            }
        });
    });

    $("input[name~='company_confirm']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                company_confirm: $(this).val(),
                company_pass: $("input[name~='company_pass']").val()
            },
            success: function(data) {
                $(".company-confirm__error").html(data);
            }
        });
    });

    $("input[name~='company_name']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                company_name: $(this).val()
            },
            success: function(data) {
                $(".company-name__error").html(data);
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

    $("input[name~='company_phone']").on("click", function() {
        $(this).val("+380");
    });

    $("input[name~='company_phone']").on("input", function() {
        $.ajax({
            url: "core/register.php",
            method: "POST",
            data: {
                company_phone: $(this).val()
            },
            success: function(data) {
                $(".company-phone__error").html(data);
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
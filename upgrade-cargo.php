<?php
require "core/database.php";
session_start();
if(!empty($_SESSION['auth'])) { 

$cargo_id = $_POST['cargoID'];
$query = "SELECT * FROM cargos JOIN body_types ON body_types.body_id = cargos.body_type WHERE cargo_id='$cargo_id'";
$cargo = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT * FROM cargos 
            JOIN regions ON regions.region_id = cargos.loading_region
            JOIN cities ON cities.city_id = cargos.loading_city WHERE cargo_id='$cargo_id'";
$load = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT * FROM cargos 
            JOIN regions ON regions.region_id = cargos.unloading_region
            JOIN cities ON cities.city_id = cargos.unloading_city WHERE cargo_id='$cargo_id'";
$unload = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT * FROM body_types";
$bodys = executeQuery(openConnection(),$query);

$query = "SELECT * FROM regions";
$load_regions = executeQuery(openConnection(), $query);
$unload_regions = executeQuery(openConnection(), $query);

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
                        <a href="cars.php" class="link__navbar">Відновити дані аккаунту</a>
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
                <h2>Вхід</h2>
                <form action="core/login.php" method="post" class="form__login">
                    <div class="wrap-input__login">
                        <p>Ваш логін</p>
                        <input type="text" name="user_login" id="login-error_login" class="input__login"
                            placeholder="Введіть логін">
                        <div class="user-login_login__error"></div>
                    </div>
                    <div class="wrap-input__login">
                        <p>Ваш пароль</p>
                        <input type="password" name="user_pass" id="pass-error_login" class="input__login"
                            placeholder="Введіть пароль">
                        <div class="user-pass_login__error"></div>
                    </div>
                    <div class="wrap-checkbox__login">
                        <input type="checkbox" name="remember" value="1">
                        <p>Запам'ятати мене</p>
                    </div>
                    <div class="wrap-btn-unit__login">
                        <button type="submit" name="login_submit" class="login-btn__login">Увійти</button>
                        <a href="reg-type.php" class="reg-btn__login">Зареєструватися<img
                                src="img/reg-btn__login.svg"></a>
                    </div>
                </form>
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
            <section class="cargo-add">
                <div class="container">
                    <h2>Редагування вантажу</h2>
                    <p class="description__register">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>

                    <?php 
                    if(!empty($_SESSION['auth'])) {
                    ?>

                    <form action="core/upgrade-cargo.php" method="post" class="form__cargo-add">
                        <input type="text" hidden value="<?=$cargo['cargo_id']?>" name="cargoID">
                        <div class="wrap-form__register">
                            <div class="wrap-input__register">
                                <p>Назва товару</p>
                                <input type="text" name="cargo_name" id="cargo_name__error" class="input__register"
                                    placeholder="Введіть назву товару" value="<?=$cargo['cargo_name']?>">
                                <div class="cargo_name__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Опис товару</p>
                                <input type="text" name="cargo_descript" id="cargo_descript__error"
                                    class="input__register" placeholder="Введіть бажаний пароль"
                                    value="<?=$cargo['description_cargo']?>">
                                <div class="cargo_descript__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Область завантаження</p>
                                <select class="select__register" name="load_region" id="load_region">
                                    <option value="<?=$load['region_id']?>"><?=$load['region_name']?></option>
                                    <?php
                                        while($load_region = mysqli_fetch_assoc($load_regions)){
                                            echo '<option value="'.$load_region['region_id'].'">'.$load_region['region_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Місто завантаження</p>
                                <select class="select__register" name="load_city" id="load_city">
                                    <option value="<?=$load['city_id']?>"><?=$load['city_name']?></option>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Дата завантаження</p>
                                <input type="date" class="input__register" name="load_date"
                                    value="<?=$cargo['loading_date']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Вага</p>
                                <input type="number" name="cargo_weight" step="any" class="input__register"
                                    placeholder="Вводити у тонах" value="<?=$cargo['weight']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Тип кузова</p>
                                <select class="select__register" name="body_type">
                                    <option value="<?=$cargo['body_id']?>"><?=$cargo['body_name']?></option>
                                    <?php
                                        while($body = mysqli_fetch_assoc($bodys)){
                                            echo '<option value="'.$body['body_id'].'">'.$body['body_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Відстань</p>
                                <input type="number" name="distance" class="input__register" placeholder="Вводити у км."
                                    value="<?=$cargo['distance']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Область вивантаження</p>
                                <select class="select__register" name="unload_region" id="unload_region">
                                    <option value="<?=$unload['region_id']?>"><?=$unload['region_name']?></option>
                                    <?php
                                        while($unload_region = mysqli_fetch_assoc($unload_regions)){
                                            echo '<option value="'.$unload_region['region_id'].'">'.$unload_region['region_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Місто вивантаження</p>
                                <select class="select__register" name="unload_city" id="unload_city">
                                    <option value="<?=$unload['city_id']?>"><?=$unload['city_name']?></option>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Дата вивантаження</p>
                                <input type="date" class="input__register" name="unload_date"
                                    value="<?=$cargo['unloading_date']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Ціна</p>
                                <input type="number" class="input__register" placeholder="Введіть ціну"
                                    name="cargo_price" value="<?=$cargo['price']?>">
                            </div>

                        </div>

                        <div class="bottom-form__cargo-add">
                            <button type="submit" name="upgrade-cargo_submit" class="button__register">Редагувати
                                вантаж</button>

                            <div class="status-cargo__add"><input type="checkbox" name="cargo_urgent" value="1">
                                <p>Терміновий заказ</p>
                            </div>
                        </div>
                    </form>

                    <?php } else { ?>

                    <div class="info__no-auth">
                        <div class="wrap-info__no-auth">
                            <img src="img/warning.svg" class="icon-info__no-auth">
                            <div class="wrap-text-info__no-auth">
                                <p class="headline-info__no-auth">Увага</p>
                                <p class="text__no-auth">Щоб мати доступ до цього розділу, пройдіть авторизауію на
                                    нашому сайті</p>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
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

    $("#unload_region").on("change", function() {
        $.ajax({
            url: "core/cities-script.php",
            method: "POST",
            data: {
                unload_region: $(this).val()
            },
            success: function(data) {
                $("#unload_city").html(data);
            }
        });
    });

    $("#load_region").on("change", function() {
        $.ajax({
            url: "core/cities-script.php",
            method: "POST",
            data: {
                load_region: $(this).val()
            },
            success: function(data) {
                $("#load_city").html(data);
            }
        });
    });

    $("input[name~='cargo_name']").on("input", function() {
        $.ajax({
            url: "core/cargo-add.php",
            method: "POST",
            data: {
                cargo_name: $(this).val()
            },
            success: function(data) {
                $(".cargo_name__error").html(data);
            }
        });
    });

    $("input[name~='cargo_descript']").on("input", function() {
        $.ajax({
            url: "core/cargo-add.php",
            method: "POST",
            data: {
                cargo_descript: $(this).val()
            },
            success: function(data) {
                $(".cargo_descript__error").html(data);
            }
        });
    });
    </script>
</body>

</html>
<?php } ?>
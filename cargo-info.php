<?php
require "core/database.php";
session_start();
$cargo_id = $_GET['cargo_id'];
$query = "SELECT * FROM cargos JOIN body_types ON body_types.body_id = cargos.body_type WHERE cargo_id='$cargo_id'";
$cargo = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

$query = "SELECT city_name,region_name FROM cargos 
            JOIN regions ON regions.region_id = cargos.loading_region
            JOIN cities ON cities.city_id = cargos.loading_city WHERE cargo_id='$cargo_id'";
$load = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT city_name,region_name FROM cargos 
            JOIN regions ON regions.region_id = cargos.unloading_region
            JOIN cities ON cities.city_id = cargos.unloading_city WHERE cargo_id='$cargo_id'";
$unload = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT * FROM users JOIN cargos ON cargos.id_user = users.user_id
                            JOIN regions ON regions.region_id = users.id_region
                            JOIN cities ON cities.city_id = users.id_city WHERE cargo_id='$cargo_id'";
$user = mysqli_fetch_assoc(executeQuery(openConnection(), $query));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Інформація про вантаж</title>
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
            <section class="cargo-info">
                <div class="container">
                    <h2>Інформація про вантаж</h2>
                    <div class="header__cargo-info">
                        <div class="wrap-name__cargo-info">
                            <p class="name__cargo-info"><?= $cargo['cargo_name'] ?></p>
                            <p class="price__cargo-info"><?= $cargo['price'] ?><img src="img/price-cargo-info.svg"
                                    class="icon-price__cargo-info"></p>
                        </div>

                        <div class="wrap-points__cargo-info">
                            <div class="wrap-point__cargo-info">
                                <img src="img/point.svg" class="icon-point__cargo-info">
                                <div class="wrap-name-point__cargo-info">
                                    <p class="type-of-name__cargo-info">Пункт завантаження</p>
                                    <p class="point__cargo-info"><?= $load['city_name'] ?>,
                                        <?= $load['region_name'] ?></p>
                                </div>
                            </div>
                            <img src="img/arrow-cargos.svg" class="arrow-point__cargo-info">
                            <div class="wrap-point__cargo-info">
                                <img src="img/point.svg" class="icon-point__cargo-info">
                                <div class="wrap-name-point__cargo-info">
                                    <p class="type-of-name__cargo-info">Пункт розвантаження</p>
                                    <p class="point__cargo-info"><?= $unload['city_name'] ?>,
                                        <?= $unload['region_name'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="middle-part__cargo-info">
                        <div class="wrap-infos__cargo-info">
                            <div class="wrap-info__cargo-info">
                                <p class="type-of-info__cargo-info">Дата завантаження</p>
                                <hr class="line-of-info__cargo-info">
                                <p class="name-info__cargo-info"><?= date("d.m.Y", strtotime($cargo['loading_date'])) ?>
                                </p>
                            </div>

                            <div class="wrap-info__cargo-info">
                                <p class="type-of-info__cargo-info">Дата розвантаження</p>
                                <hr class="line-of-info__cargo-info">
                                <p class="name-info__cargo-info">
                                    <?= date("d.m.Y", strtotime($cargo['unloading_date'])) ?></p>
                            </div>

                            <div class="wrap-info__cargo-info">
                                <p class="type-of-info__cargo-info">Тип кузова</p>
                                <hr class="line-of-info__cargo-info">
                                <p class="name-info__cargo-info"><?= $cargo['body_name'] ?></p>
                            </div>

                            <div class="wrap-info__cargo-info">
                                <p class="type-of-info__cargo-info">Відстань</p>
                                <hr class="line-of-info__cargo-info">
                                <p class="name-info__cargo-info"><?= $cargo['distance'] ?> км.</p>
                            </div>

                            <div class="wrap-info__cargo-info">
                                <p class="type-of-info__cargo-info">Вага</p>
                                <hr class="line-of-info__cargo-info">
                                <p class="name-info__cargo-info"><?= $cargo['weight'] ?> т.</p>
                            </div>
                        </div>

                        <div class="user__cargo-info">
                            <div class="wrap-user-content__cargo-info">
                                <div class="header-user__cargo-info">
                                    <img src="user_images/<?= $user['user_image']?>" class="icon-user__cargo-info">
                                    <div class="wrap-name-user__cargo-info">
                                        <a href="user-info.php?user_id=<?=$user['user_id']?>"
                                            class="name-user__cargo-info"><?= $user['user_name']?>
                                            <?= $user['middle_name']?>
                                            <?= $user['surname']?></a>
                                        <?php if($user['user_type'] == 0) {
                                            echo '<p class="user-account__cargo-info">Фізична особа</p>';
                                        } else { 
                                            echo '<p class="user-account__cargo-info">Підприємство</p>';
                                        }?>
                                    </div>
                                </div>

                                <div class="info-user-block__cargo-info">
                                    <div class="wrap-info-user__cargo-info">
                                        <p class="type-of-info-user__cargo-info">Контактний номер</p>
                                        <p class="info-user__cargo-info">+<?= $user['phone'] ?></p>
                                    </div>
                                    <div class="wrap-info-user__cargo-info">
                                        <p class="type-of-info-user__cargo-info">Місцезнаходження</p>
                                        <p class="info-user__cargo-info"><?= $user['city_name']?>,
                                            <?= $user['region_name']?></p>
                                    </div>
                                </div>
                            </div>
                            <a href="user-info.php?user_id=<?=$user['user_id']?>"
                                class="user-btn__cargo-info">Детальніше</a>
                        </div>
                    </div>

                    <div class="wrap-descript__cargo-info">
                        <p class="type-descript__cargo-info">Опис</p>
                        <?php if(empty($cargo['description_cargo'])) {
                            echo "<p>Автор не додав опис</p>";
                        } else {?>
                        <p><?= $cargo['description_cargo'] ?></p>
                        <?php } ?>
                    </div>

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
    </script>
</body>

</html>
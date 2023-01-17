<?php
require "core/database.php";
session_start();

if(isset($_SESSION['cargo-filter'])) {
    $query = $_SESSION['cargo-filter'];
} else {
    $query = "SELECT * FROM cargos JOIN body_types ON body_types.body_id = cargos.body_type ORDER BY cargo_id DESC";
}

$cargos = executeQuery(openConnection(), $query);
$cargo_empty = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

if(isset($_SESSION['cargo-filter-loads'])){
    $query = $_SESSION['cargo-filter-loads'];
} else {
    $query = "SELECT city_name,region_name FROM cargos 
            JOIN regions ON regions.region_id = cargos.loading_region
            JOIN cities ON cities.city_id = cargos.loading_city ORDER BY cargo_id DESC";
}
$loads = executeQuery(openConnection(), $query);

if(isset($_SESSION['cargo-filter-loads'])){
    $query = $_SESSION['cargo-filter-unloads'];
} else {
    $query = "SELECT city_name,region_name FROM cargos 
            JOIN regions ON regions.region_id = cargos.unloading_region
            JOIN cities ON cities.city_id = cargos.unloading_city ORDER BY cargo_id DESC";
}
$unloads = executeQuery(openConnection(), $query);

$query = "SELECT * FROM regions";
$load_regions = executeQuery(openConnection(), $query);
$unload_regions = executeQuery(openConnection(), $query);

$query = "SELECT * FROM body_types";
$bodys = executeQuery(openConnection(),$query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Біржа вантажів</title>
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
                        <a href="cargos.php" class="active-link__navbar">Біржа вантажів</a>
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
            <section class="cargos">
                <div class="container">
                    <div class="top-part__cargos">
                        <div class="wrap-headline__cargos">
                            <p class="headline__cargos">Біржа вантажів</p>
                            <p class="descript__cargos">Тут зібрані усі активні вантажі користувачів платформи</p>
                        </div>
                        <div class="filter__cargos">
                            <p>Фільтри</p><img src="img/filter.svg">
                        </div>
                    </div>

                    <form action="core/filter.php" method="post" class="form__filter">
                        <div class="wrap-inputs__filter">

                            <select name="load_region" id="load_region" class="select__filter">
                                <option disabled selected hidden>Оберіть область завантаження</option>
                                <?php
                                    while($load_region = mysqli_fetch_assoc($load_regions)){
                                        echo '<option class="option__filter" value="loading_region = '.$load_region['region_id'].'">'.$load_region['region_name'].'</option>';
                                    } 
                                    ?>
                            </select>

                            <select name="load_city" id="load_city" class="select__filter">
                                <option disabled selected hidden>Оберіть місто завантаження</option>
                                <option class="option__filter" disabled>Спочатку оберіть область</option>
                            </select>

                            <input type="text" name="load_date" onfocus="(this.type='date')" class="input__filter"
                                placeholder="Дата завантаження">

                            <input type="number" step="any" name="weight" class="input__filter" placeholder="Вага, т.">

                            <select name="body" id="body" class="select__filter">
                                <option disabled selected hidden>Оберіть тип кузову</option>
                                <?php
                                    while($body = mysqli_fetch_assoc($bodys)){
                                        echo '<option class="option__filter" value="body_type = '.$body['body_id'].'">'.$body['body_name'].'</option>';
                                    } 
                                    ?>
                            </select>

                            <input type="number" name="distance" step="any" class="input__filter"
                                placeholder="Відстань">

                            <select name="unload_region" id="unload_region" class="select__filter">
                                <option disabled selected hidden>Оберіть область вивантаження</option>
                                <?php
                                    while($unload_region = mysqli_fetch_assoc($unload_regions)){
                                        echo '<option class="option__filter" value="unloading_region = '.$unload_region['region_id'].'">'.$unload_region['region_name'].'</option>';
                                    } 
                                ?>
                            </select>

                            <select name="unload_city" id="unload_city" class="select__filter">
                                <option disabled selected hidden>Оберіть місто вивантаження</option>
                                <option class="option__filter" disabled>Спочатку оберіть область</option>
                            </select>

                            <input type="text" onfocus="(this.type='date')" class="input__filter"
                                placeholder="Дата вивантаження" name="unload_date">

                        </div>
                        <div class="unit-btn__filter">
                            <button type="submit" name="filter_submit" class="btn-form__filter">Знайти вантаж</button>
                            <button type="submit" name="filter_reset" class="btn-form__filter">Скинути</button>
                        </div>
                    </form>

                    <?php if($cargo_empty == null){ ?>
                    <div class="info__no-auth">
                        <div class="wrap-info__no-auth">
                            <img src="img/warning.svg" class="icon-info__no-auth">
                            <div class="wrap-text-info__no-auth">
                                <p class="headline-info__no-auth">Увага</p>
                                <p class="text__no-auth">Вантажі не знайдено</p>
                            </div>
                        </div>
                    </div>
                    <?php } else { while ($cargo = mysqli_fetch_assoc($cargos) and $load = mysqli_fetch_assoc($loads) and $unload = mysqli_fetch_assoc($unloads)){ ?>
                    <div class="card__cargos">
                        <div class="header-card__cargos">
                            <a href="cargo-info.php?cargo_id=<?=$cargo['cargo_id']?>"
                                class="name-cargo__cargos"><?= $cargo['cargo_name'] ?></a>
                            <div class="right-part_header__cargos">

                                <?php if($cargo['urgent'] == 1) {
                                echo '<div class="urgently-cargo__cargos">
                                        <p>Терміновий вантаж</p>
                                         <img src="img/urgently.svg" class="urgently-icon__cargos">
                                    </div>';
                            }?>

                                <p class="price__cargos"><?= $cargo['price'] ?> UAH</p>
                            </div>
                        </div>

                        <div class="content-card__cargos">

                            <div class="point__cargos">
                                <div class="wrap-name-point__cargos">
                                    <img src="img/point.svg" class="icon-point__cargos">
                                    <div class="point-name__cargos">
                                        <p class="type-of-point-name__cargos">Пункт завантаження</p>
                                        <p class="name-point__cargos"><?= $load['city_name'] ?>,
                                            <?= $load['region_name'] ?></p>
                                    </div>
                                </div>

                                <img src="img/arrow-cargos.svg" class="arrow__cargos">

                                <div class="wrap-name-point__cargos">
                                    <img src="img/point.svg" class="icon-point__cargos">
                                    <div class="point-name__cargos">
                                        <p class="type-of-point-name__cargos">Пункт завантаження</p>
                                        <p class="name-point__cargos"><?= $unload['city_name'] ?>,
                                            <?= $unload['region_name'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="info-blocks__cargos">
                                <div class="wrap-info-block__cargos">
                                    <img src="img/distance-cargo.svg" class="icon-info__cargos">
                                    <div class="info__cargos">
                                        <p class="type-of-info__cargos">Відстань</p>
                                        <p><?= $cargo['distance'] ?> км.</p>
                                    </div>
                                </div>

                                <div class="wrap-info-block__cargos">
                                    <img src="img/weight-cargo.svg" class="icon-info__cargos">
                                    <div class="info__cargos">
                                        <p class="type-of-info__cargos">Вага</p>
                                        <p><?= $cargo['weight'] ?> т.</p>
                                    </div>
                                </div>

                                <div class="wrap-info-block__cargos">
                                    <img src="img/body-cargo.svg" class="icon-info__cargos">
                                    <div class="info__cargos">
                                        <p class="type-of-info__cargos">Тип кузова</p>
                                        <p><?= $cargo['body_name'] ?></p>
                                    </div>
                                </div>

                                <div class="wrap-info-block__cargos">
                                    <img src="img/date-cargo.svg" class="icon-info__cargos">
                                    <div class="info__cargos">
                                        <p class="type-of-info__cargos">Дата завантаження</p>
                                        <p><?= date("d.m.Y", strtotime($cargo['loading_date'])) ?></p>
                                    </div>
                                </div>

                                <div class="wrap-info-block__cargos">
                                    <img src="img/date-cargo.svg" class="icon-info__cargos">
                                    <div class="info__cargos">
                                        <p class="type-of-info__cargos">Дата розвантаження</p>
                                        <p><?= date("d.m.Y", strtotime($cargo['unloading_date'])) ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="respons-card__cargos">
                        <div class="header_resp-car__cargos">
                            <div class="wrap-name-header__cargos">
                                <a href="cargo-info.php" class="name-resp-car__cargos"><?= $cargo['cargo_name'] ?></a>

                                <?php if($cargo['urgent'] == 1) {
                                echo '<div class="urgently-cargo__cargos">
                                        <p>Терміновий вантаж</p>
                                         <img src="img/urgently.svg" class="urgently-icon__cargos">
                                    </div>';
                            }?>

                            </div>
                            <p class="price-resp__cargos"><?= $cargo['price'] ?> UAH</p>
                        </div>
                        <div class="content-resp__cargos">

                            <div class="wrap-point-resp__cargos">
                                <div class="wrap-name-point__cargos">
                                    <img src="img/point.svg" class="icon-point__cargos">
                                    <div class="point-name__cargos">
                                        <p class="type-of-point-name__cargos">Пункт завантаження</p>
                                        <p class="name-point__cargos"><?= $load['city_name'] ?>,
                                            <?= $load['region_name'] ?></p>
                                    </div>
                                </div>

                                <div class="wrap-name-point__cargos">
                                    <img src="img/point.svg" class="icon-point__cargos">
                                    <div class="point-name__cargos">
                                        <p class="type-of-point-name__cargos">Пункт завантаження</p>
                                        <p class="name-point__cargos"><?= $unload['city_name'] ?>,
                                            <?= $unload['region_name'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap-info_resp__cargos">
                                <p class="type-of-info-resp__cargos">Відстань</p>
                                <hr class="info-line-resp__cargos">
                                <p class="descript-info-resp__cargos"><?= $cargo['distance'] ?> км.</p>
                            </div>

                            <div class="wrap-info_resp__cargos">
                                <p class="type-of-info-resp__cargos">Вага</p>
                                <hr class="info-line-resp__cargos">
                                <p class="descript-info-resp__cargos"><?= $cargo['weight'] ?> т.</p>
                            </div>

                            <div class="wrap-info_resp__cargos">
                                <p class="type-of-info-resp__cargos">Тип кузова</p>
                                <hr class="info-line-resp__cargos">
                                <p class="descript-info-resp__cargos"><?= $cargo['body_name'] ?></p>
                            </div>

                            <div class="wrap-info_resp__cargos">
                                <p class="type-of-info-resp__cargos">Дата розвантаження</p>
                                <hr class="info-line-resp__cargos">
                                <p class="descript-info-resp__cargos">
                                    <?= date("d.m.Y", strtotime($cargo['unloading_date'])) ?></p>
                            </div>

                            <div class="wrap-info_resp__cargos">
                                <p class="type-of-info-resp__cargos">Дата завантаження</p>
                                <hr class="info-line-resp__cargos">
                                <p class="descript-info-resp__cargos">
                                    <?= date("d.m.Y", strtotime($cargo['loading_date'])) ?></p>
                            </div>

                        </div>
                    </div>
                    <?php } } ?>


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
                        <a href="cargos.php" class="active-link__footer">Біржа вантажів</a>
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
    $(".filter__cargos").click(function() {
        $('.form__filter').css('display', 'block');
    });

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

    $("#load_region").on("change", function() {
        $.ajax({
            url: "core/filter.php",
            method: "POST",
            data: {
                load_region: $(this).val()
            },
            success: function(data) {
                $("#load_city").html(data);
                $("#load_city").addClass('select-checked__filter');
                $("#load_region").addClass('select-checked__filter');
            }
        });
    });

    $("#unload_region").on("change", function() {
        $.ajax({
            url: "core/filter.php",
            method: "POST",
            data: {
                unload_region: $(this).val()
            },
            success: function(data) {
                $("#unload_city").html(data);
                $("#unload_city").addClass('select-checked__filter');
                $("#unload_region").addClass('select-checked__filter');
            }
        });
    });

    $("#body").on("change", function() {
        $("#body").addClass('select-checked__filter');
    });
    </script>
</body>

</html>
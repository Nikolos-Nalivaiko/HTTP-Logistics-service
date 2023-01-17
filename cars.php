<?php
require "core/database.php";
session_start();

if (isset($_SESSION['filter-car'])) {
    $query = $_SESSION['filter-car'];
} else {
    $query = "SELECT * FROM cars 
            JOIN brands ON brands.brand_id=cars.brand
            JOIN models ON models.model_id=cars.model
            JOIN regions ON regions.region_id=cars.location_region
            JOIN cities ON cities.city_id=cars.location_city
            JOIN body_types ON body_types.body_id=cars.body_type 
            JOIN car_images ON car_images.id_car=cars.car_id WHERE preview_image = '1' ORDER BY car_id DESC";
}
$cars = executeQuery(openConnection(), $query);
$car_empty = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT * FROM body_types";
$bodys = executeQuery(openConnection(),$query);

$query = "SELECT * FROM brands";
$brands = executeQuery(openConnection(),$query);

$query = "SELECT * FROM gearboxes";
$gearboxes = executeQuery(openConnection(),$query);

$query = "SELECT * FROM wheel_drives";
$wheels = executeQuery(openConnection(),$query);

$query = "SELECT * FROM engine_types";
$engines = executeQuery(openConnection(),$query);

$query = "SELECT * FROM regions";
$regions = executeQuery(openConnection(),$query);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Біржа транспорту</title>
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
                        <a href="cars.php" class="active-link__navbar">Біржа транспорту</a>
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
            <section class="cars">
                <div class="container">
                    <div class="top-part__cargos">
                        <div class="wrap-headline__cargos">
                            <p class="headline__cargos">Біржа транспорту</p>
                            <p class="descript__cargos">Тут зібран весь активний транспорт користувачів платформи</p>
                        </div>
                        <div class="filter__cars">
                            <p>Фільтри</p><img src="img/filter.svg">
                        </div>
                    </div>

                    <form action="core/filter.php" method="post" class="form__filter">
                        <div class="wrap-inputs__filter">

                            <select name="brand" id="brand" class="select__filter">
                                <option disabled selected hidden>Оберіть марку авто</option>
                                <?php
                                    while($brand = mysqli_fetch_assoc($brands)){
                                        echo '<option class="option__filter" value="brand = '.$brand['brand_id'].'">'.$brand['brand_name'].'</option>';
                                    } 
                                    ?>
                            </select>

                            <select name="model" id="model" class="select__filter">
                                <option disabled selected hidden>Оберіть модель авто</option>
                                <option class="option__filter" disabled>Спочатку оберіть марку</option>
                            </select>

                            <input type="number" name="engine_capacity" step="any" class="input__filter"
                                placeholder="Введіть об'єм двигуна">

                            <select name="wheel" id="wheel" class="select__filter">
                                <option disabled selected hidden>Оберіть привід авто</option>
                                <?php
                                    while($wheel = mysqli_fetch_assoc($wheels)){
                                        echo '<option class="option__filter" value="wheel_drive = '.$wheel['wheel_drive_id'].'">'.$wheel['wheel_drive_name'].'</option>';
                                    } 
                                ?>
                            </select>

                            <select name="gearbox" id="gearbox" class="select__filter">
                                <option disabled selected hidden>Оберіть тип КПП</option>
                                <?php
                                    while($gearbox = mysqli_fetch_assoc($gearboxes)){
                                        echo '<option class="option__filter" value="gearbox = '.$gearbox['gearbox_id'].'">'.$gearbox['gearbox_name'].'</option>';
                                    } 
                                ?>
                            </select>

                            <select name="engine" id="engine" class="select__filter">
                                <option disabled selected hidden>Оберіть тип двигуна</option>
                                <?php
                                    while($engine = mysqli_fetch_assoc($engines)){
                                        echo '<option class="option__filter" value="engine_type = '.$engine['engine_id'].'">'.$engine['engine_name'].'</option>';
                                    } 
                                ?>
                            </select>

                            <select name="body" id="body" class="select__filter">
                                <option disabled selected hidden>Оберіть тип кузова</option>
                                <?php
                                    while($body = mysqli_fetch_assoc($bodys)){
                                        echo '<option class="option__filter" value="body_type = '.$body['body_id'].'">'.$body['body_name'].'</option>';
                                    } 
                                ?>
                            </select>

                            <input type="number" name="load_capacity" step="any" class="input__filter"
                                placeholder="Введіть вантажопідйомність">

                            <select name="region" id="region" class="select__filter">
                                <option disabled selected hidden>Оберіть область знаходження</option>
                                <?php
                                    while($region = mysqli_fetch_assoc($regions)){
                                        echo '<option class="option__filter" value="location_city = '.$region['region_id'].'">'.$region['region_name'].'</option>';
                                    } 
                                ?>
                            </select>

                            <select name="city" id="city" class="select__filter">
                                <option disabled selected hidden>Оберіть місто знаходження</option>
                                <option class="option__filter" disabled>Спочатку оберіть марку</option>
                            </select>

                        </div>

                        <div class="unit-btn__filter">
                            <button type="submit" name="filter_submit_car" class="btn-form__filter">Знайти
                                транспорт</button>
                            <button type="submit" name="filter_reset_car" class="btn-form__filter">Скинути</button>
                        </div>
                    </form>


                    <?php if($car_empty == null){ ?>
                    <div class="info__no-auth">
                        <div class="wrap-info__no-auth">
                            <img src="img/warning.svg" class="icon-info__no-auth">
                            <div class="wrap-text-info__no-auth">
                                <p class="headline-info__no-auth">Увага</p>
                                <p class="text__no-auth">Транспорт не знайдено</p>
                            </div>
                        </div>
                    </div>
                    <?php } else { while($car = mysqli_fetch_assoc($cars)) { ?>
                    <div class="wrap-cars__car">
                        <div class="card__car">
                            <img src="car_images/<?= $car['image_name'] ?>" class="image-car__car">
                            <div class="spec__car">
                                <div class="top-info__car">
                                    <a href="car-info.php?car_id=<?=$car['car_id']?>"
                                        class="name__car"><?= $car['brand_name'] ?> <?= $car['model_name'] ?>
                                        <?= $car['year'] ?></a>
                                    <div class="wrap-price">
                                        <p class="price-text__car">Ціна за сутки</p>
                                        <p class="price__car"><?= $car['price'] ?> UAH</p>
                                    </div>
                                </div>

                                <div class="point__car">
                                    <img src="img/point.svg" class="icon-point__car">
                                    <div class="content-point__car">
                                        <p class="type-point__car">Пункт завантаження</p>
                                        <p><?= $car['city_name'] ?>, <?= $car['region_name'] ?></p>
                                    </div>
                                </div>

                                <div class="wrap-spec-info__car">
                                    <div class="spec-info__car">
                                        <p class="type-spec__car">Вантажопідйомність</p>
                                        <hr class="line__car">
                                        <p class="info-spec__car"><?= $car['load_capacity'] ?> т.</p>
                                    </div>
                                    <div class="spec-info__car">
                                        <p class="type-spec__car">Тип кузова</p>
                                        <hr class="line__car">
                                        <p class="info-spec__car"><?= $car['body_name'] ?></p>
                                    </div>
                                    <div class="spec-info__car">
                                        <p class="type-spec__car">Об'єм двигуна</p>
                                        <hr class="line__car">
                                        <p class="info-spec__car"><?= $car['engine_capacity'] ?> л.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php } }?>
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
                        <a href="cars.php" class="active-link__footer">Біржа транспорту</a>
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

    $(".filter__cars").click(function() {
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

    $("#brand").on("change", function() {
        $.ajax({
            url: "core/filter.php",
            method: "POST",
            data: {
                brand: $(this).val()
            },
            success: function(data) {
                $("#model").html(data);
                $("#model").addClass('select-checked__filter');
                $("#brand").addClass('select-checked__filter');
            }
        });
    });

    $("#region").on("change", function() {
        $.ajax({
            url: "core/filter.php",
            method: "POST",
            data: {
                region: $(this).val()
            },
            success: function(data) {
                $("#city").html(data);
                $("#city").addClass('select-checked__filter');
                $("#region").addClass('select-checked__filter');
            }
        });
    });

    $("#wheel").on("change", function() {
        $("#wheel").addClass('select-checked__filter');
    });

    $("#gearbox").on("change", function() {
        $("#gearbox").addClass('select-checked__filter');
    });

    $("#engine").on("change", function() {
        $("#engine").addClass('select-checked__filter');
    });

    $("#body").on("change", function() {
        $("#body").addClass('select-checked__filter');
    });
    </script>
</body>

</html>
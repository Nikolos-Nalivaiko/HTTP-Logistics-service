<?php
require "core/database.php";
session_start();
if(!empty($_SESSION['auth'])) {

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

$carID = $_POST['carID'];

$query = "SELECT * FROM cars
            JOIN brands ON brands.brand_id=cars.brand
            JOIN models ON models.model_id=cars.model
            JOIN regions ON regions.region_id=cars.location_region
            JOIN cities ON cities.city_id=cars.location_city
            JOIN body_types ON body_types.body_id=cars.body_type
            JOIN wheel_drives ON wheel_drives.wheel_drive_id=cars.wheel_drive
            JOIN gearboxes ON gearboxes.gearbox_id=cars.gearbox 
            JOIN engine_types ON engine_types.engine_id=cars.engine_type WHERE car_id='$carID'";
$car = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

$query = "SELECT * FROM car_images WHERE id_car='$carID'";
$images = executeQuery(openConnection(),$query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Редагування транспорту</title>
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
                        <a href="cargo-add.php" class="active-link__navbar">Додати вантаж</a>
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
                    <h2>Редагування транспорту</h2>
                    <p class="description__register">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>

                    <?php 
                    if(!empty($_SESSION['auth'])) {
                    if(isset($_SESSION['success-add-car'])){
                        echo $_SESSION['success-add-car'];
                        unset($_SESSION['success-add-car']);
                    }
                    ?>

                    <form action="core/upgrade-car.php" method="post" class="form__cargo-add">
                        <div class="wrap-form__register">
                            <div class="wrap-input__register">
                                <p>Марка</p>
                                <select class="select__register" id="brands" name="brand">
                                    <option value="<?=$car['brand_id']?>"><?=$car['brand_name']?></option>
                                    <?php
                                        while($brand = mysqli_fetch_assoc($brands)){
                                            echo '<option value="'.$brand['brand_id'].'">'.$brand['brand_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Модель</p>
                                <select class="select__register" name="model" id="models">
                                    <option value="<?=$car['model_id']?>"><?=$car['model_name']?></option>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Об'єм двигуна</p>
                                <input type="number" step="any" name="capacity_engine" class="input__register"
                                    placeholder="Введіть об'єм двигуна" value="<?=$car['engine_capacity']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Привід</p>
                                <select class="select__register" name="wheel">
                                    <option value="<?=$car['wheel_drive_id']?>"><?=$car['wheel_drive_name']?></option>
                                    <?php
                                        while($wheel = mysqli_fetch_assoc($wheels)){
                                            echo '<option value="'.$wheel['wheel_drive_id'].'">'.$wheel['wheel_drive_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Тип КПП</p>
                                <select class="select__register" name="gearbox">
                                    <option value="<?=$car['gearbox_id']?>"><?=$car['gearbox_name']?></option>
                                    <?php
                                        while($gearbox = mysqli_fetch_assoc($gearboxes)){
                                            echo '<option value="'.$gearbox['gearbox_id'].'">'.$gearbox['gearbox_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Потужність</p>
                                <input type="number" name="power" class="input__register"
                                    placeholder="Введіть потужність" value="<?=$car['power']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Пробіг</p>
                                <input type="number" name="mileage" class="input__register" placeholder="Введіть пробіг"
                                    value="<?=$car['mileage']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Тип двигуна</p>
                                <select class="select__register" name="engine">
                                    <option value="<?=$car['engine_id']?>"><?=$car['engine_name']?></option>
                                    <?php
                                        while($engine = mysqli_fetch_assoc($engines)){
                                            echo '<option value="'.$engine['engine_id'].'">'.$engine['engine_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Тип кузова</p>
                                <select class="select__register" name="body">
                                    <option value="<?=$car['body_id']?>"><?=$car['body_name']?></option>
                                    <?php
                                        while($body = mysqli_fetch_assoc($bodys)){
                                            echo '<option value="'.$body['body_id'].'">'.$body['body_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Вантажопідйомність</p>
                                <input type="number" step="any" name="load_capacity" class="input__register"
                                    placeholder="Введіть вантажопідйомність" value="<?=$car['load_capacity']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Область знаходження</p>
                                <select class="select__register" name="region" id="regions">
                                    <option value="<?=$car['region_id']?>"><?=$car['region_name']?></option>
                                    <?php
                                        while($region = mysqli_fetch_assoc($regions)){
                                            echo '<option value="'.$region['region_id'].'">'.$region['region_name'].'</option>';
                                        } 
                                    ?>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Місто знаходження</p>
                                <select class="select__register" name="city" id="cities">
                                    <option value="<?=$car['city_id']?>"><?=$car['city_name']?></option>
                                </select>
                            </div>

                            <div class="wrap-input__register">
                                <p>Опис</p>
                                <input type="text" name="description" id="car_descript" class="input__register"
                                    placeholder="Введіть опис авто" value="<?=$car['description_car']?>">
                                <div class="car_descript__error"></div>
                            </div>

                            <div class="wrap-input__register">
                                <p>Ціна</p>
                                <input type="text" name="price" class="input__register" placeholder="Введіть ціну"
                                    value="<?=$car['price']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Рік випуску</p>
                                <input type="text" name="year" class="input__register" placeholder="Введіть ціну"
                                    value="<?=$car['year']?>">
                            </div>

                            <div class="wrap-input__register">
                                <p>Фото авто</p>
                                <input type="file" name="image[]" multiple id="image-file__car-add">
                                <label for="image-file__car-add" class="input-file__register">Оберіть фото авто</label>
                            </div>

                            <input type="text" name="preview_image" value="" hidden>
                            <input type="text" name="carID" value="<?=$car['car_id']?>" hidden>

                        </div>

                        <div class="wrap-images__car-add" id="preview-car-image">
                            <?php while($image = mysqli_fetch_assoc($images)){
                                if($image['image_name'] != 'no-image.jpg') {?>
                            <div class="wrap-image__car-add">
                                <img src="car_images/<?=$image['image_name']?>" class="image-car__car-add">
                                <img src="img/close-car-add.svg" class="delete-image__car-add">
                            </div>
                            <?php } } ?>
                        </div>

                        <button type="submit" name="car_upgrade_submit" class="button__register">Редагувати
                            транспорт</button>
                    </form>
                    <?php } else { ?>

                    <div class="info__no-auth">
                        <div class="wrap-info__no-auth">
                            <img src="img/warning.svg" class="icon-info__no-auth">
                            <div class="wrap-text-info__no-auth">
                                <p class="headline-info__no-auth">Увага</p>
                                <p class="text__no-auth">Щоб мати доступ до цього розділу, пройдіть авторизацію на
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
    $(".delete-image__car-add").click(function() {
        console.log($(".image-car__car-add").attr('src'));
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

    $("#brands").on("change", function() {
        $.ajax({
            url: "core/models-script.php",
            method: "POST",
            data: {
                brand: $(this).val()
            },
            success: function(data) {
                $("#models").html(data);
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

    $("#image-file__car-add").change(function() {
        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            var formData = new FormData();
            $.each($("#image-file__car-add")[0].files, function(key, input) {
                formData.append('file[]', input);
            });

            var ajax_img = 0;
            $.ajax({
                type: "POST",
                url: 'core/upload-car-image.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    data.forEach(function(msg) {
                        $('#preview-car-image').append(msg);
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
                                url: "core/delete-car-image.php",
                                method: "POST",
                                data: {
                                    image_name: $(
                                        '.image-car__car-add')[
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

                    // $('.wrap-image__car-add').each(function(index, img) {
                    //     if ($(this).hasClass("hide-preview")) {
                    //         console.log('yes');
                    //     } else {
                    //         $('.image-car__car-add').each(function(index, img) {
                    //             $('.image-car__car-add')[0].classList.add("bord");
                    //             $("input[name~='preview_image']").val($(
                    //                     '.image-car__car-add')[
                    //                     0]
                    //                 .src.filename());
                    //             $(this).on("click", function() {
                    //                 $("input[name~='preview_image']").val($(
                    //                         '.image-car__car-add')[
                    //                         index].src
                    //                     .filename());
                    //                 $('.image-car__car-add').removeClass(
                    //                     "bord");
                    //                 $('.image-car__car-add')[index]
                    //                     .classList.add(
                    //                         "bord");
                    //             });
                    //         });
                    //     }
                    // });

                    $('.image-car__car-add').each(function(index, img) {
                        $('.image-car__car-add')[0].classList.add("bord");
                        $("input[name~='preview_image']").val($('.image-car__car-add')[
                                0]
                            .src.filename());
                        $(this).on("click", function() {
                            $("input[name~='preview_image']").val($(
                                    '.image-car__car-add')[index].src
                                .filename());
                            $('.image-car__car-add').removeClass("bord");
                            $('.image-car__car-add')[index].classList.add(
                                "bord");
                        });
                    });

                }
            });
        }
    });

    $("input[name~='description']").on("input", function() {
        $.ajax({
            url: "core/car-add.php",
            method: "POST",
            data: {
                descript: $(this).val()
            },
            success: function(data) {
                $(".car_descript__error").html(data);
            }
        });
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
                url: "core/delete-car-image.php",
                method: "POST",
                data: {
                    image_upgrade_name: $('.image-car__car-add')[
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

    $('.image-car__car-add').each(function(index, img) {
        $('.image-car__car-add')[0].classList.add("bord");
        $("input[name~='preview_image']").val($('.image-car__car-add')[0].src.filename());
        $(this).on("click", function() {
            $("input[name~='preview_image']").val($(
                    '.image-car__car-add')[index].src
                .filename());
            $('.image-car__car-add').removeClass("bord");
            $('.image-car__car-add')[index].classList.add("bord");
        });
    });
    </script>
</body>

</html>
<?php } ?>
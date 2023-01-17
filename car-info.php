<?php
require "core/database.php";
session_start();

$car_id = $_GET['car_id'];
$query = "SELECT * FROM cars
            JOIN brands ON brands.brand_id=cars.brand
            JOIN models ON models.model_id=cars.model
            JOIN regions ON regions.region_id=cars.location_region
            JOIN cities ON cities.city_id=cars.location_city
            JOIN body_types ON body_types.body_id=cars.body_type
            JOIN wheel_drives ON wheel_drives.wheel_drive_id=cars.wheel_drive
            JOIN gearboxes ON gearboxes.gearbox_id=cars.gearbox 
            JOIN engine_types ON engine_types.engine_id=cars.engine_type WHERE car_id='$car_id'";
$car = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

$query = "SELECT * FROM users JOIN cars ON cars.id_user = users.user_id
                            JOIN regions ON regions.region_id = users.id_region
                            JOIN cities ON cities.city_id = users.id_city WHERE car_id='$car_id'";
$user = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

$query = "SELECT * FROM car_images WHERE id_car='$car_id'";
$images = executeQuery(openConnection(),$query);
$images_popup = executeQuery(openConnection(),$query);
$images_mobile = executeQuery(openConnection(),$query);

$query = "SELECT * FROM car_images WHERE preview_image = '1' AND id_car='$car_id'";
$preview = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Інформація про транспорт</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="website icon" type="png" href="img/web-icon.png">
</head>

<body>
    <div class="preload">
        <div class="preload-carcass">
            <img src="img/preload.svg" class="icon-preload">
        </div>
    </div>
    <div class="image-popup__car-info">
        <div class="wrap-image-popup__car-info">
            <div class="header-image-popup__car-info">
                <div class="left-header-image-popup__car-info">
                    <p class="name_image-popup__car-info"><?= $car['brand_name'] ?> <?= $car['model_name'] ?>
                        <?= $car['year'] ?></p>
                    <div class="wrap-price_image-popup__car-info">
                        <p class="type-of-price_image-popup__car-info">Ціна за сутки</p>
                        <p class="price_image-popup__car-info"><?= $car['price'] ?> UAH</p>
                    </div>
                </div>
                <img src="img/close-image-popup.svg" class="close_image-popup__car-info">
            </div>
            <div class="content_image-popup__car-info">

                <div class="slider-horizontal_image-popup__car-info">
                    <div class="arrow-unit-slider-horizontal_image-popup__car-info">
                        <img src="img/arrow-left.svg" id="btn-prev-horizont">
                        <img src="img/arrow-right.svg" id="btn-next-horizont">
                    </div>
                    <div class="slider-horizontal-container_image-popup__car-info">
                        <div class="slider-horizontal-track__image-popup__car-info">
                            <?php while($image_mobile = mysqli_fetch_assoc($images_mobile)) { ?>
                            <div class="slider-horizontal-item_image-popup__car-info">
                                <img src="car_images/<?= $image_mobile['image_name'] ?>"
                                    class="smallImg-horizont-slider">
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="slider-vertical_image-popup__car-info">
                    <img src="img/arrow-up.svg" id="btn-prev"
                        class="arrow-prev_image-popup__car-info btn-unit__car-info">

                    <div class="slider-container_image-popup__car-info">
                        <div class="slider-track_image-popup__car-info">
                            <?php while($image_popup = mysqli_fetch_assoc($images_popup)) { ?>
                            <img src="car_images/<?= $image_popup['image_name'] ?>"
                                class="slider-item_image-popup__car-info">
                            <?php } ?>
                        </div>
                    </div>

                    <img src="img/arrow-down.svg" id="btn-next"
                        class="arrow-next_image-popup__car-info btn-unit__car-info">
                </div>
                <img src="car_images/<?= $preview['image_name'] ?>" class="main-img_image-popup__car-info"
                    id="mainImg_slider">
            </div>
        </div>
    </div>


    <div class="main-wrapper">

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
            <section class="car-info">
                <div class="container">
                    <h2>Інформація про транспорт</h2>

                    <div class="top-info__car-info">
                        <div class="top-wrap-info__car-info">
                            <p class="car-name__car-info"><?= $car['brand_name'] ?>
                                <?= $car['model_name'] ?> <?= $car['year'] ?></p>
                            <div class="wrap-price__car-info">
                                <p class="type-of-price__car-info">Ціна за сутки</p>
                                <p class="price__car-info"><?= $car['price'] ?> UAH</p>
                            </div>
                        </div>
                        <div class="wrap-point__car-info">
                            <img src="img/point.svg" class="icon-point__car-info">
                            <div class="text-wrap-point__car-info">
                                <p class="type-of-point__car-info">Місцезнаходження</p>
                                <p><?= $car['city_name'] ?>, <?= $car['region_name'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="main__car-info">
                        <img src="car_images/<?= $preview['image_name'] ?>"
                            class="main-img__car-info start_image-popup__car-info" id="mainImg__car-info">

                        <div class="specs__car-info">
                            <p class="headline_specs__car-info">Технічні характеристики</p>
                            <div class="wrap-spec__car-info">
                                <p>Привід</p>
                                <p class="content-spec__car-info"><?=$car['wheel_drive_name']?></p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Потужність</p>
                                <p class="content-spec__car-info"><?=$car['power']?> к.с</p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Тип кузова</p>
                                <p class="content-spec__car-info"><?=$car['body_name']?></p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Тип КПП</p>
                                <p class="content-spec__car-info"><?=$car['gearbox_name']?></p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Рік випуску</p>
                                <p class="content-spec__car-info"><?=$car['year']?></p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Об'єм двигуна</p>
                                <p class="content-spec__car-info"><?=$car['engine_capacity']?> л.</p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Тип двигуна</p>
                                <p class="content-spec__car-info"><?=$car['engine_name']?></p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Пробіг</p>
                                <p class="content-spec__car-info"><?=$car['mileage']?> км.</p>
                            </div>
                            <div class="wrap-spec__car-info">
                                <p>Вантажопідйомність</p>
                                <p class="content-spec__car-info"><?=$car['load_capacity']?> км.</p>
                            </div>
                        </div>
                    </div>

                    <div class="wrap-images__car-info">
                        <?php while($image = mysqli_fetch_assoc($images)) { ?>
                        <img src="car_images/<?= $image['image_name'] ?>" class="image__car-info">
                        <?php } ?>
                        <div class="more-images__car-info">
                            <img src="img/gallery.svg" class="more-img-icon__car-info">
                            <p>Завантажити більше</p>
                        </div>
                    </div>

                    <div class="specs-respons__car-info">
                        <p class="headline__specs-respons__car-info">Технічні характеристики</p>

                        <div class="wrap-spec__car-info">
                            <p>Привід</p>
                            <p class="content-spec__car-info"><?=$car['wheel_drive_name']?></p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Потужність</p>
                            <p class="content-spec__car-info"><?=$car['power']?> к.с</p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Тип кузова</p>
                            <p class="content-spec__car-info"><?=$car['body_name']?></p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Тип КПП</p>
                            <p class="content-spec__car-info"><?=$car['gearbox_name']?></p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Рік випуску</p>
                            <p class="content-spec__car-info"><?=$car['year']?></p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Об'єм двигуна</p>
                            <p class="content-spec__car-info"><?=$car['engine_capacity']?> л.</p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Тип двигуна</p>
                            <p class="content-spec__car-info"><?=$car['engine_name']?></p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Пробіг</p>
                            <p class="content-spec__car-info"><?=$car['mileage']?> км.</p>
                        </div>
                        <div class="wrap-spec__car-info">
                            <p>Вантажопідйомність</p>
                            <p class="content-spec__car-info"><?=$car['load_capacity']?> км.</p>
                        </div>

                    </div>

                    <div class="descript__car-info">
                        <p class="type-of-descript__car-info">Опис</p>
                        <?php if(empty($car['description_car'])) {
                            echo "<p>Автор не додав опис</p>";
                        } else {?>
                        <p><?= $car['description_car'] ?></p>
                        <?php } ?>
                    </div>

                    <div class="user__cargo-info user__car-info">
                        <div class="wrap-user-content__cargo-info">
                            <div class="header-user__cargo-info">
                                <img src="user_images/<?= $user['user_image']?>" class="icon-user__cargo-info">
                                <div class="wrap-name-user__cargo-info">
                                    <a href="user-info.php?user_id=<?=$user['user_id']?>"
                                        class="name-user__cargo-info"><?= $user['user_name'] ?>
                                        <?= $user['middle_name'] ?>
                                        <?= $user['surname'] ?></a>
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
                                    <p class="info-user__cargo-info"><?= $user['city_name'] ?>,
                                        <?= $user['region_name'] ?></p>
                                </div>
                            </div>
                        </div>
                        <a href="user-info.php?user_id=<?=$user['user_id']?>" class="user-btn__car-info">Детальніше</a>
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
    var mainImg = document.getElementById('mainImg__car-info');
    var smallImg = document.querySelectorAll('.image__car-info');
    var moreImg = document.querySelector('.more-images__car-info');
    var maxItem = 8;

    if ($(window).width() <= 1200) {
        var maxItem = 6;
    }
    if ($(window).width() <= 992) {
        var maxItem = 5;
    }
    if ($(window).width() <= 768) {
        var maxItem = 4;
    }
    if ($(window).width() <= 425) {
        var maxItem = 3;
    }
    if ($(window).width() <= 375) {
        var maxItem = 3;
    }
    if ($(window).width() <= 320) {
        var maxItem = 2;
    }

    smallImg.forEach((el, index) => {
        el.setAttribute('data-index', index);

        el.addEventListener('click', (e) => {
            mainImg.src = smallImg[index].src;
        });

        if (index + 1 > maxItem) {
            document.querySelectorAll(`.image__car-info:nth-child(n+${maxItem + 1})`).forEach(el => {
                el.style.display = 'none';
                moreImg.style.display = 'flex';
            });
        }
    });


    var mainImg_slider = document.getElementById('mainImg_slider');
    var smallImg_slider = document.querySelectorAll('.slider-item_image-popup__car-info');
    smallImg_slider.forEach((el, index) => {
        el.setAttribute('data-index', index);

        el.addEventListener('click', (e) => {
            mainImg_slider.src = smallImg_slider[index].src;
        });
    });

    if ($(window).width() <= 768) {
        var smallImg_slider_horizont = document.querySelectorAll('.smallImg-horizont-slider');
        smallImg_slider_horizont.forEach((el, index) => {
            el.setAttribute('data-index', index);

            el.addEventListener('click', (e) => {
                mainImg_slider.src = smallImg_slider_horizont[index].src;
            });
        });
    }

    // slider-start

    let position = 0;
    let slideToShow = 3;
    let slideToScroll = 1;
    let margin = 12;

    const container = $('.slider-horizontal-container_image-popup__car-info');
    const track = $('.slider-track_image-popup__car-info');
    const item = $('.slider-item_image-popup__car-info');

    marginItem = margin * slideToShow;

    let itemPos = 0; // Позиция наших видимых блоков 
    let itemCount = item.length - slideToShow;


    let itemHeight = item.height() + margin; // Высота видимых блоков

    if (item.length <= 3) {
        $(".btn-unit__car-info").addClass("btn-unit__car-info__none");
    }

    $("#btn-next").on("click", function() {
        ++itemPos;
        console.log(itemPos)
        if (itemPos <= itemCount) {
            position = (slideToScroll * itemHeight) * itemPos; // Умножаем высоту на к-ство нажатий 
            track.css({
                transform: `translateY(-${position}px)`
            });
        }
        if (itemPos == itemCount) {
            $("#btn-next").addClass("arrow-disable_image-popup__car-info");
        }
        if (itemPos <= itemCount) {
            $("#btn-prev").removeClass("arrow-disable_image-popup__car-info");
        }
    })

    if (itemPos == 0) {
        $("#btn-prev").addClass("arrow-disable_image-popup__car-info");
    }

    $("#btn-prev").on("click", function() {
        --itemPos;
        console.log(itemPos)
        position = position - itemHeight; // Умножаем длинну на к-ство нажатий 
        track.css({
            transform: `translateY(-${position}px)`
        });
        if (itemPos == 0) {
            $("#btn-prev").addClass("arrow-disable_image-popup__car-info");
        }
        if (itemPos >= 0) {
            $("#btn-next").removeClass("arrow-disable_image-popup__car-info");
        }
    })

    // 
    if ($(window).width() <= 768) {
        let position = 0;
        let slideToShow = 3;
        let slideToScroll = 1;

        const track = $('.slider-horizontal-track__image-popup__car-info');
        const item = $('.slider-horizontal-item_image-popup__car-info');


        let itemPos = 0; // Позиция наших видимых блоков 
        let itemCount = item.length - slideToShow;
        let margin = 10;

        let itemWidth = (item.width() * slideToScroll) + (margin * slideToScroll); // Длинна видимых блоков

        if (item.length <= 3) {
            $('.arrow-unit-slider-horizontal_image-popup__car-info').css('display', 'none');
        }

        $("#btn-next-horizont").on("click", function() {
            ++itemPos;
            console.log(itemPos)
            if (itemPos <= itemCount) {
                position = (slideToScroll * itemWidth) * itemPos; // Умножаем высоту на к-ство нажатий 
                console.log(position)
                track.css({
                    transform: `translateX(-${position}px)`
                });
            }
            if (itemPos == itemCount) {
                $("#btn-next-horizont").addClass("arrow-disable_image-popup__car-info");
            }
            if (itemPos >= 0) {
                $("#btn-prev-horizont").removeClass("arrow-disable_image-popup__car-info");
            }
        })

        $("#btn-prev-horizont").on("click", function() {
            --itemPos;
            console.log(itemPos)
            position = position - itemWidth; // Умножаем длинну на к-ство нажатий 
            track.css({
                transform: `translateX(-${position}px)`
            });
            if (itemPos < itemCount) {
                $("#btn-next-horizont").removeClass("arrow-disable_image-popup__car-info");
            }
            if (itemPos <= 0) {
                $("#btn-prev-horizont").addClass("arrow-disable_image-popup__car-info");
            }
        })

        if (itemPos >= 0) {
            $("#btn-prev-horizont").addClass("arrow-disable_image-popup__car-info");
        }

    }
    // 


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

    $(".more-images__car-info").click(function() {
        $(".image-popup__car-info").addClass("active_image-popup__car-info");
    });

    $(".start_image-popup__car-info").click(function() {
        $(".image-popup__car-info").addClass("active_image-popup__car-info");
    });

    $(".close_image-popup__car-info").click(function() {
        $(".image-popup__car-info").removeClass("active_image-popup__car-info");
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
<?php
require "core/database.php";
session_start(); 

$query = "SELECT * FROM reviews 
            JOIN users ON users.user_id=reviews .id_user";
$reviews = executeQuery(openConnection(),$query);
$empty_reviews = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

if (empty($_SESSION['auth']) or $_SESSION['auth'] == false) {

    if (!empty($_COOKIE['login']) and !empty($_COOKIE['key'])) {

        $login = $_COOKIE['login'];
        $key = $_COOKIE['key'];

        $query = "SELECT * FROM `users` WHERE `login` = '$login'";
        $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

        $query = 'SELECT * FROM users WHERE login="'.$login.'" AND cookie="'.$key.'"';
        $result = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

        if (!empty($result)) {

            $_SESSION['auth'] = true;
            $_SESSION['id'] = $user['user_id'];

        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Головна сторінка</title>
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
                        <a href="index.php" class="active-link__navbar">Головна</a>
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

        <header>
            <div class="header-top">
                <div class="container">
                    <div class="wrap-header">
                        <img src="img/logo.svg" class="logo">
                        <img src="img/menu-icon.svg" class="menu-icon" id="popup__navbar-start">
                    </div>
                </div>
            </div>

            <div class="offer-block">
                <div class="container">
                    <div class="content__offer">
                        <h1>HTTP - Крізь час та відстань</h1>
                        <p class="descript__offer">Грамотний підхід до логістики дозволить вам оптимізувати процес
                            управління обіговими коштами та запасами, підвищити здатність реагувати на запити, що
                            висуваються ринком, і, в підсумку, зробити ваш бізнес більш ефективним.</p>
                        <a href="#anchor" class="button__offer" id="scroll">Детальніше <img
                                src="img/btn-arrow-offer.svg"></a>
                    </div>
                </div>
            </div>
        </header>

        <section class="services">
            <div class="container">

                <div class="wrap-blocks__service">
                    <div class="block__service">
                        <div class="wrap-icon-cargo__service">
                            <img src="img/service-icon-cargo.svg" class="icon__service">
                        </div>
                        <div class="wrap-content__service">
                            <h3 class="headline__service">Додати вантаж</h3>
                            <p class="description__service">Маєте власний вантаж але не знаете чим його перевезти ?
                                Просто додайте вантаж та очікуйте на відповід.</p>
                            <a href="cargo-add.php" class="button__service">Додати вантаж</a>
                        </div>
                    </div>
                    <div class="block__service">
                        <div class="wrap-icon-car__service"><img src="img/service-icon-car.svg" class="icon__service">
                        </div>
                        <div class="wrap-content__service">
                            <h3 class="headline__service">Додати транспорт</h3>
                            <p class="description__service">Хочете здавати транспорт в аренду ? Просто додайте його на
                                нашу платформу та очікуйте клієнтів.</p>
                            <a href="car-add.php" class="button__service">Додати транспорт</a>
                        </div>
                    </div>
                    <div class="block__service">
                        <div class="wrap-icon-cargo__service"><img src="img/service-icon-cargo.svg"
                                class="icon__service">
                        </div>
                        <div class="wrap-content__service">
                            <h3 class="headline__service">Біржа вантажів</h3>
                            <p class="description__service">Маєте власний транспорт але не знаете де знайти вантаж ?
                                Наша біржа допоможе вам з цим питанням.</p>
                            <a href="cargos.php" class="button__service">Біржа вантажів</a>
                        </div>
                    </div>
                    <div class="block__service">
                        <div class="wrap-icon-car__service"><img src="img/service-icon-car.svg" class="icon__service">
                        </div>
                        <div class="wrap-content__service">
                            <h3 class="headline__service">Біржа транспорту</h3>
                            <p class="description__service">Хочете знайти транспорт в аренду ? Наша транспортна біржа
                                допоможе з цим питанням.</p>
                            <a href="cars.php" class="button__service">Біржа транспорту</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="about">
            <div class="container">
                <div class="wrapper__about">
                    <div class="text-content__about">
                        <h2 id="anchor">Кому буде цікава наша платформа ? </h2>

                        <div class="block-info__about">
                            <div class="header_block-info__about">
                                <hr class="line__about">
                                <h3>Компаніям</h3>
                            </div>
                            <p class="description__about">Логістичні компанії з легкістю можуть використовувати
                                платформу
                                HTTP – Logistics service для надання свої послуг клієнтам.</p>
                        </div>

                        <div class="block-info__about">
                            <div class="header_block-info__about">
                                <hr class="line__about">
                                <h3>Вантажовідправникам</h3>
                            </div>
                            <p class="description__about">Платформа HTTP – Logistics service підходить підприємствам та
                                фізичним особам, які мають вантаж, для пошуку транспорту або перевізників.</p>
                        </div>

                        <div class="block-info__about">
                            <div class="header_block-info__about">
                                <hr class="line__about">
                                <h3>Водіям</h3>
                            </div>
                            <p class="description__about">Платформа HTTP – Logistics service буде досить корисною для
                                перевізників, які шукають роботу або здають свій транспорт в оренду.</p>
                        </div>
                    </div>
                    <div class="image-content__about">
                        <img src="img/about1.jpg" class="image-first__about">
                        <div class="bottom-part_image-content__about">
                            <img src="img/about2.jpg" class="image-second__about">
                            <img src="img/about3.jpg" class="image-three__about">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="reviews">
            <div class="container">

                <div class="wrap-headline__reviews">
                    <img src="img/arrow-left.svg" id="prev" class="slider-arrow__reviews">
                    <p class="headline__review">Відгуки про платформу</p>
                    <img src="img/arrow-right.svg" id="next" class="slider-arrow__reviews">
                </div>

                <div class="slider-arrow-unit__comment-add">
                    <img src="img/arrow-left.svg" id="prev_resp" class="slider-arrow-resp__reviews">
                    <img src="img/arrow-right.svg" id="next_resp" class="slider-arrow-resp__reviews">
                </div>

                <?php if(empty($empty_reviews)){ ?>
                <div class="info__no-auth info__no-auth__comments">
                    <div class="wrap-info__no-auth">
                        <img src="img/warning.svg" class="icon-info__no-auth">
                        <div class="wrap-text-info__no-auth">
                            <p class="headline-info__no-auth">Увага</p>
                            <p class="text__no-auth">Платформа не має відгуків</p>
                        </div>
                    </div>
                </div>
                <?php  } ?>

                <div class="slider-container__reviews">
                    <div class="slider-track__reviews">
                        <?php while($review = mysqli_fetch_assoc($reviews)) { ?>
                        <div class="slider-item__reviews">
                            <div class="wrap-slider-block__reviews">
                                <div class="header-review__reviews">
                                    <img src="user_images/<?=$review['user_image']?>" class="icon__reviews">
                                    <div class="user-info__reviews">
                                        <p class="name-user__reviews"><?=$review['surname']?>
                                            <?=$review['user_name']?> <?=$review['middle_name']?></p>

                                        <?php if($review['user_type'] == 0) {
                                            echo '<p class="type-of-acc_profile">Фізична особа</p>';
                                        } else { 
                                         echo '<p class="type-of-acc_profile">Підприємство</p>';
                                        }?>
                                    </div>
                                </div>

                                <div class="grade__reviews">
                                    <?php for($i = 1; $i <= $review['review_grade'];$i++){ ?>
                                    <img src="img/star.svg" class="star-icon__reviews">
                                    <?php } ?>
                                </div>

                                <p class="descript-comment__comment-add"><?=$review['review_description']?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>

            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="wrap__footer">
                    <img src="img/logo.svg" class="logo__footer">

                    <div class="nav-bar__footer">
                        <a href="index.php" class="active-link__footer">Головна</a>
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

    let position = 0;
    let slideToShow = 2;
    let slideToScroll = 1;

    var next = $("#next");
    var prev = $("#prev");

    if ($(window).width() <= 992) {
        slideToShow = 1;
        var next = $("#next_resp");
        var prev = $("#prev_resp");
    }

    const track = $('.slider-track__reviews');
    const item = $('.slider-item__reviews');


    let itemPos = 0; // Позиция наших видимых блоков 
    let itemCount = item.length - slideToShow;
    let margin = 20;

    let itemWidth = ((item.width() - margin) * slideToScroll) + (margin *
        slideToScroll); // Длинна видимых блоков

    // console.log(item.width()- margin);

    next.on("click", function() {
        ++itemPos;
        if (itemPos <= itemCount) {
            position = (slideToScroll * itemWidth) *
                itemPos; // Умножаем высоту на к-ство нажатий 
            console.log(position)
            track.css({
                transform: `translateX(-${position}px)`
            });
        }
        if (itemPos == itemCount) {
            next.addClass("arrow-disable_image-popup__car-info");
        }
        if (itemPos >= 0) {
            prev.removeClass("arrow-disable_image-popup__car-info");
        }
    })

    prev.on("click", function() {
        --itemPos;
        position = position - itemWidth; // Умножаем длинну на к-ство нажатий 
        track.css({
            transform: `translateX(-${position}px)`
        });
        if (itemPos < itemCount) {
            next.removeClass("arrow-disable_image-popup__car-info");
        }
        if (itemPos <= 0) {
            prev.addClass("arrow-disable_image-popup__car-info");
        }
    })

    if (itemPos >= 0) {
        prev.addClass("arrow-disable_image-popup__car-info");
    }
    if (itemCount <= 0) {
        next.addClass("arrow-disable_image-popup__car-info");
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

    let anchor = document.getElementById('scroll');

        anchor.addEventListener('click', function(e) {
            e.preventDefault()

            const blockID = anchor.getAttribute('href')

            document.querySelector(blockID).scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            })
        })
    </script>
</body>

</html>
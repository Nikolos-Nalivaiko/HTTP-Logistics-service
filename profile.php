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
    <title>HTTP - Особистий кабінет</title>
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

        <div class="popup__delete-cargo">
            <div class="carcass__delete">
                <div class="wrap-text__delete">
                    <p class="headline__delete">Ви дійсно бажаєте видалити вантаж ? </p>
                    <p class="descript__delete">Після видалення вантажу, його вже не можна буде відновити та проводити
                        будь-які дії з ним</p>
                </div>
                <div class="wrap-btn__delete">
                    <p class="close-btn__delete">Закрити</p>
                    <p class="delete-btn__delete">Видалити</p>
                </div>
            </div>
        </div>

        <div class="popup__delete-car">
            <div class="carcass__delete">
                <div class="wrap-text__delete">
                    <p class="headline__delete">Ви дійсно бажаєте видалити транспорт ? </p>
                    <p class="descript__delete">Після видалення транспорту, його вже не можна буде відновити та
                        проводити
                        будь-які дії з ним</p>
                </div>
                <div class="wrap-btn__delete">
                    <p class="close-btn__delete-car">Закрити</p>
                    <p class="delete-btn__delete-car">Видалити</p>
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

        <?php if(!empty($_SESSION['auth'])) { 
            $user_id = $_SESSION['id'];
            $query = "SELECT * FROM users 
                        JOIN regions ON regions.region_id = users.id_region
                        JOIN cities ON cities.city_id = users.id_city  WHERE user_id='$user_id'";
            $user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

            $query = "SELECT * FROM cargos JOIN body_types ON body_types.body_id = cargos.body_type WHERE id_user='$user_id' ORDER BY cargo_id DESC";
            $cargos = executeQuery(openConnection(), $query);
            $cargo_empty = mysqli_fetch_assoc(executeQuery(openConnection(), $query)); 

            $query = "SELECT city_name,region_name FROM cargos 
                        JOIN regions ON regions.region_id = cargos.loading_region
                        JOIN cities ON cities.city_id = cargos.loading_city WHERE id_user='$user_id' ORDER BY cargo_id DESC";
            $loads = executeQuery(openConnection(), $query);

            $query = "SELECT city_name,region_name FROM cargos 
                        JOIN regions ON regions.region_id = cargos.unloading_region
                        JOIN cities ON cities.city_id = cargos.unloading_city WHERE id_user='$user_id' ORDER BY cargo_id DESC";
            $unloads = executeQuery(openConnection(), $query);

            $query = "SELECT * FROM cars 
                        JOIN brands ON brands.brand_id=cars.brand
                        JOIN models ON models.model_id=cars.model
                        JOIN regions ON regions.region_id=cars.location_region
                        JOIN cities ON cities.city_id=cars.location_city
                        JOIN body_types ON body_types.body_id=cars.body_type
                        JOIN car_images ON car_images.id_car=cars.car_id WHERE id_user='$user_id' AND preview_image = '1' ORDER BY car_id DESC";
            $cars = executeQuery(openConnection(), $query);
            $car_empty = mysqli_fetch_assoc(executeQuery(openConnection(), $query));

            $query = "SELECT * FROM comments 
                        JOIN users ON users.user_id=comments.sender_id WHERE recipient_id='$user_id'";
            $comments = executeQuery(openConnection(),$query);
            $empty_comments = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

            $query = "SELECT * FROM reviews WHERE id_user='$user_id'";
            $review = mysqli_fetch_assoc(executeQuery(openConnection(),$query));
            ?>
        <main>
            <section class="profile">
                <div class="container">
                    <div class="wrap-headline__profile">
                        <h2>Особистий кабінет</h2>
                        <div class="wrap-button__profile">
                            <a href="core/logout.php" class="exit__profile"><img src="img/exit.svg"
                                    class="exit-icon__profile">Вийти</a>
                            <a href="profile-setting.php" class="setting__profile"><img
                                    src="img/setting.svg">Налаштування</a>
                        </div>
                    </div>

                    <div class="info__profile">
                        <div class="left-info__profile">
                            <img src="user_images/<?=$user['user_image']?>" class="ava__profile">
                            <div class="wrap-name__profile">
                                <p class="name__profile"><?=$user['surname']?> <?=$user['user_name']?>
                                    <?=$user['middle_name']?></p>
                                <?php if($user['user_type'] == 0) {
                                            echo '<p class="type-of-acc_profile">Фізична особа</p>';
                                        } else { 
                                         echo '<p class="type-of-acc_profile">Підприємство</p>';
                                        }?>
                            </div>
                        </div>
                        <div class="right-info__profile">
                            <div class="wrap-user-info__profile">
                                <p class="type-of-user-info__profile">Контактний номер</p>
                                <p>+<?=$user['phone']?></p>
                            </div>
                            <div class="wrap-user-info__profile">
                                <p class="type-of-user-info__profile">Місцезнаходження</p>
                                <p><?=$user['city_name']?>, <?=$user['region_name']?></p>
                            </div>
                        </div>
                    </div>

                    <?php  if(isset($_SESSION['success-review-add'])){
                            echo $_SESSION['success-review-add'];
                            unset($_SESSION['success-review-add']);
                    }  
                    if(isset($_SESSION['success-upgrade-cargo'])){
                        echo $_SESSION['success-upgrade-cargo'];
                        unset($_SESSION['success-upgrade-cargo']);
                    }
                    if(isset($_SESSION['success-upgrade-car'])){
                        echo $_SESSION['success-upgrade-car'];
                        unset($_SESSION['success-upgrade-car']);
                    }
                    if(isset($_SESSION['success-delete-cargo'])){
                        echo $_SESSION['success-delete-cargo'];
                        unset($_SESSION['success-delete-cargo']);
                    }
                    if(isset($_SESSION['success-delete-car'])){
                        echo $_SESSION['success-delete-car'];
                        unset($_SESSION['success-delete-car']);
                    }
                    if(isset($_SESSION['error-reg'])){
                        echo $_SESSION['error-reg'];
                        unset($_SESSION['error-reg']);
                    }
                    ?>

                    <div class="nav-bar__profile">
                        <p class="link-nav__profile" id="default_link">Ваші вантажі</p>
                        <p class="link-nav__profile">Ваш транспорт</p>
                        <p class="link-nav__profile">Відгуки про вас</p>
                        <p class="link-nav__profile">Ваш відгук про платформу</p>
                    </div>

                    <div class="cargos__profile nav-content__profile" id="default_content">
                        <?php if(!empty($cargo_empty)){ while($cargo = mysqli_fetch_assoc($cargos) and $load = mysqli_fetch_assoc($loads) and $unload = mysqli_fetch_assoc($unloads)){ ?>
                        <div class="card__cargos">
                            <div class="header-card__cargos">
                                <a href="cargo-info.php?cargo_id=<?=$cargo['cargo_id']?>"
                                    class="name-cargo__cargos"><?=$cargo['cargo_name']?></a>
                                <div class="right-part_header__cargos">

                                    <?php if($cargo['urgent'] == 1) {
                                echo '<div class="urgently-cargo__cargos">
                                        <p>Терміновий вантаж</p>
                                         <img src="img/urgently.svg" class="urgently-icon__cargos">
                                    </div>';
                            }?>

                                    <p class="price__cargos"><?=$cargo['price']?> UAH</p>
                                </div>
                            </div>

                            <div class="content-card__cargos">

                                <div class="point__cargos">
                                    <div class="wrap-name-point__cargos">
                                        <img src="img/point.svg" class="icon-point__cargos">
                                        <div class="point-name__cargos">
                                            <p class="type-of-point-name__cargos">Пункт завантаження</p>
                                            <p class="name-point__cargos"><?=$load['city_name']?>,
                                                <?=$load['region_name']?></p>
                                        </div>
                                    </div>

                                    <img src="img/arrow-cargos.svg" class="arrow__cargos">

                                    <div class="wrap-name-point__cargos">
                                        <img src="img/point.svg" class="icon-point__cargos">
                                        <div class="point-name__cargos">
                                            <p class="type-of-point-name__cargos">Пункт розвантаження</p>
                                            <p class="name-point__cargos"><?=$unload['city_name']?>,
                                                <?=$unload['region_name']?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-blocks__cargos">
                                    <div class="wrap-info-block__cargos">
                                        <img src="img/distance-cargo.svg" class="icon-info__cargos">
                                        <div class="info__cargos">
                                            <p class="type-of-info__cargos">Відстань</p>
                                            <p><?=$cargo['distance']?> км.</p>
                                        </div>
                                    </div>

                                    <div class="wrap-info-block__cargos">
                                        <img src="img/weight-cargo.svg" class="icon-info__cargos">
                                        <div class="info__cargos">
                                            <p class="type-of-info__cargos">Вага</p>
                                            <p><?=$cargo['weight']?> т.</p>
                                        </div>
                                    </div>

                                    <div class="wrap-info-block__cargos">
                                        <img src="img/body-cargo.svg" class="icon-info__cargos">
                                        <div class="info__cargos">
                                            <p class="type-of-info__cargos">Тип кузова</p>
                                            <p><?=$cargo['body_name']?></p>
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
                            <form action="upgrade-cargo.php" method="post" class="wrap-btn-nav-cargo__profile">
                                <button class="update-btn-cargo__profile" type="submit">Редагувати</button>
                                <input type="text" name="cargoID" hidden value="<?=$cargo['cargo_id']?>">
                                <p class="delete-btn-cargo__profile start_popup__delete"
                                    data-index="<?=$cargo['cargo_id']?>">Видалити</p>
                            </form>
                        </div>

                        <div class="respons-card__cargos">
                            <div class="header_resp-car__cargos">
                                <div class="wrap-name-header__cargos">
                                    <a href="cargo-info.php?cargo_id=<?=$cargo['cargo_id']?>"
                                        class="name-resp-car__cargos"><?=$cargo['cargo_name']?></a>

                                    <?php if($cargo['urgent'] == 1) {
                                echo '<div class="urgently-cargo__cargos">
                                        <p>Терміновий вантаж</p>
                                         <img src="img/urgently.svg" class="urgently-icon__cargos">
                                    </div>';
                            }?>

                                </div>
                                <p class="price-resp__cargos"><?=$cargo['price']?> UAH</p>
                            </div>
                            <div class="content-resp__cargos">

                                <div class="wrap-point-resp__cargos">
                                    <div class="wrap-name-point__cargos">
                                        <img src="img/point.svg" class="icon-point__cargos">
                                        <div class="point-name__cargos">
                                            <p class="type-of-point-name__cargos">Пункт завантаження</p>
                                            <p class="name-point__cargos"><?=$load['city_name']?>,
                                                <?=$load['region_name']?></p>
                                        </div>
                                    </div>

                                    <div class="wrap-name-point__cargos">
                                        <img src="img/point.svg" class="icon-point__cargos">
                                        <div class="point-name__cargos">
                                            <p class="type-of-point-name__cargos">Пункт розвантаження</p>
                                            <p class="name-point__cargos"><?=$unload['city_name']?>,
                                                <?=$unload['region_name']?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="wrap-info_resp__cargos">
                                    <p class="type-of-info-resp__cargos">Відстань</p>
                                    <hr class="info-line-resp__cargos">
                                    <p class="descript-info-resp__cargos"><?=$cargo['distance']?> км.</p>
                                </div>

                                <div class="wrap-info_resp__cargos">
                                    <p class="type-of-info-resp__cargos">Вага</p>
                                    <hr class="info-line-resp__cargos">
                                    <p class="descript-info-resp__cargos"><?=$cargo['weight']?> т.</p>
                                </div>

                                <div class="wrap-info_resp__cargos">
                                    <p class="type-of-info-resp__cargos">Тип кузова</p>
                                    <hr class="info-line-resp__cargos">
                                    <p class="descript-info-resp__cargos"><?=$cargo['body_name']?></p>
                                </div>

                                <div class="wrap-info_resp__cargos">
                                    <p class="type-of-info-resp__cargos">Дата завантаження</p>
                                    <hr class="info-line-resp__cargos">
                                    <p class="descript-info-resp__cargos">
                                        <?= date("d.m.Y", strtotime($cargo['loading_date'])) ?></p>
                                </div>

                                <div class="wrap-info_resp__cargos">
                                    <p class="type-of-info-resp__cargos">Дата розвантаження</p>
                                    <hr class="info-line-resp__cargos">
                                    <p class="descript-info-resp__cargos">
                                        <?= date("d.m.Y", strtotime($cargo['unloading_date'])) ?></p>
                                </div>
                            </div>
                            <form action="upgrade-cargo.php" method="post" class="wrap-btn-nav-cargo__profile">
                                <button class="update-btn-cargo__profile" type="submit">Редагувати</button>
                                <input type="text" name="cargoID" hidden value="<?=$cargo['cargo_id']?>">
                                <p class="delete-btn-cargo__profile start_popup__delete"
                                    data-index="<?=$cargo['cargo_id']?>">Видалити</p>
                            </form>
                        </div>

                        <?php } } else { ?>
                        <div class="info__no-auth">
                            <div class="wrap-info__no-auth">
                                <img src="img/warning.svg" class="icon-info__no-auth">
                                <div class="wrap-text-info__no-auth">
                                    <p class="headline-info__no-auth">Увага</p>
                                    <p class="text__no-auth">Ви ще не додали вантаж</p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <div class="cars__profile nav-content__profile">

                        <?php if(!empty($car_empty)) { while($car = mysqli_fetch_assoc($cars)) { ?>
                        <div class="card-car__profile">
                            <div class="wrap-car__profile">
                                <img src="car_images/<?=$car['image_name']?>" class="image-car__car">
                                <div class="spec__car">
                                    <div class="top-info__car">
                                        <a href="car-info.php?car_id=<?=$car['car_id']?>"
                                            class="name__car"><?=$car['brand_name']?>
                                            <?=$car['model_name']?> <?=$car['year']?></a>
                                        <div class="wrap-price">
                                            <p class="price-text__car">Ціна за сутки</p>
                                            <p class="price__car"><?=$car['price']?> UAH</p>
                                        </div>
                                    </div>

                                    <div class="point__car">
                                        <img src="img/point.svg" class="icon-point__car">
                                        <div class="content-point__car">
                                            <p class="type-point__car">Місцезнаходження</p>
                                            <p><?=$car['city_name']?>, <?=$car['region_name']?></p>
                                        </div>
                                    </div>

                                    <div class="wrap-spec-info__car">
                                        <div class="spec-info__car">
                                            <p class="type-spec__car">Вантажопідйомність</p>
                                            <hr class="line__car">
                                            <p class="info-spec__car"><?=$car['load_capacity']?> т.</p>
                                        </div>
                                        <div class="spec-info__car">
                                            <p class="type-spec__car">Тип кузова</p>
                                            <hr class="line__car">
                                            <p class="info-spec__car"><?=$car['body_name']?></p>
                                        </div>
                                        <div class="spec-info__car">
                                            <p class="type-spec__car">Об'єм двигуна</p>
                                            <hr class="line__car">
                                            <p class="info-spec__car"><?=$car['engine_capacity']?> л.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <form action="upgrade-car.php" method="post" class="wrap-btn-nav-car__profile">
                                <input type="text" hidden name="carID" value="<?=$car['car_id']?>">
                                <button class="update-btn-car__profile">Редагувати</button>
                                <p class="delete-btn-car__profile start_popup__delete-car"
                                    data-index="<?=$car['car_id']?>">Видалити</p>
                            </form>
                        </div>
                        <?php } } else { ?>
                        <div class="info__no-auth">
                            <div class="wrap-info__no-auth">
                                <img src="img/warning.svg" class="icon-info__no-auth">
                                <div class="wrap-text-info__no-auth">
                                    <p class="headline-info__no-auth">Увага</p>
                                    <p class="text__no-auth">Ви ще не додали транспорт</p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="comments__profile nav-content__profile" id="comment_block">

                        <div class="wrap-headline__reviews">
                            <img src="img/arrow-left.svg" id="prev" class="slider-arrow__reviews">
                            <p class="headline__review">Відгуки про вас</p>
                            <img src="img/arrow-right.svg" id="next" class="slider-arrow__reviews">
                        </div>

                        <div class="slider-arrow-unit__comment-add">
                            <img src="img/arrow-left.svg" id="prev_resp" class="slider-arrow-resp__reviews">
                            <img src="img/arrow-right.svg" id="next_resp" class="slider-arrow-resp__reviews">
                        </div>

                        <?php if(empty($empty_comments)){ ?>
                        <div class="info__no-auth info__no-auth__comments">
                            <div class="wrap-info__no-auth">
                                <img src="img/warning.svg" class="icon-info__no-auth">
                                <div class="wrap-text-info__no-auth">
                                    <p class="headline-info__no-auth">Увага</p>
                                    <p class="text__no-auth">Ви не маєте відгуків</p>
                                </div>
                            </div>
                        </div>
                        <?php  } ?>

                        <div class="slider-container__reviews">
                            <div class="slider-track__reviews">
                                <?php while($comment = mysqli_fetch_assoc($comments)) { ?>
                                <div class="slider-item__reviews">
                                    <div class="wrap-slider-block__reviews">
                                        <div class="header-review__reviews">
                                            <img src="user_images/<?=$comment['user_image']?>" class="icon__reviews">
                                            <div class="user-info__reviews">
                                                <p class="name-user__reviews"><?=$comment['surname']?>
                                                    <?=$comment['user_name']?> <?=$comment['middle_name']?></p>

                                                <?php if($comment['user_type'] == 0) {
                                            echo '<p class="type-of-acc_profile">Фізична особа</p>';
                                        } else { 
                                         echo '<p class="type-of-acc_profile">Підприємство</p>';
                                        }?>
                                            </div>
                                        </div>

                                        <div class="grade__reviews">
                                            <?php for($i = 1; $i <= $comment['comment_grade'];$i++){ ?>
                                            <img src="img/star.svg" class="star-icon__reviews">
                                            <?php } ?>
                                        </div>

                                        <p class="descript-comment__comment-add"><?=$comment['comment_description']?>
                                        </p>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                        </div>

                    </div>

                    <div class="review__profile nav-content__profile">
                        <p class="headline-review-block__profile">Оцінка платформи HTTP</p>
                        <p class="descript-review-block__profile">Ви можете залишити свій коментарій та оцінку про
                            платформу HTTP, команда HTTP буде дуже вдячна за ваш відгук</p>

                        <?php if(empty($review)){ ?>
                        <form action="core/review-add.php" method="post" class="form-comment-add__user-info">
                            <div class="wrap-add__comment-add">
                                <p class="headline-form__comment-add">Додати відгук про платформу</p>
                                <div class="wrap-input__comment-add">
                                    <p>Ваш відгук</p>
                                    <input type="text" class="input__comment-add" id="review__error"
                                        name="review_descript" placeholder="Введіть ваш відгук" required>
                                    <div class="review_descript__error"></div>
                                </div>
                                <p class="headline-radio__comment-add">Наскільки вам сподобався користувач ?</p>
                                <div class="grade-block__comment-add">
                                    <div class="wrap-radio__comment-add">
                                        <input type="radio" name="grade_review" value="1" required>
                                        <p>1</p>
                                    </div>
                                    <div class="wrap-radio__comment-add">
                                        <input type="radio" name="grade_review" value="2" required>
                                        <p>2</p>
                                    </div>
                                    <div class="wrap-radio__comment-add">
                                        <input type="radio" name="grade_review" value="3" required>
                                        <p>3</p>
                                    </div>
                                    <div class="wrap-radio__comment-add">
                                        <input type="radio" name="grade_review" value="4" required>
                                        <p>4</p>
                                    </div>
                                    <div class="wrap-radio__comment-add">
                                        <input type="radio" name="grade_review" value="5" required>
                                        <p>5</p>
                                    </div>
                                </div>

                                <button class="button__comment-add" name="review_submit">Додати відгук</button>
                            </div>
                            <img src="img/comment.svg" class="icon__comment-add">
                        </form>
                        <?php } else { ?>
                        <p class="headline-comment__comment-add">Ваш відгук про платформу</p>
                        <div class="comment__comment-add">
                            <p class="headline_comment-descript__comment-add">Ваш відгук про платформу</p>
                            <p class="descript_comment__comment-add"><?=$review['review_description']?></p>
                            <div class="grade__reviews">
                                <?php for($i = 1; $i <= $review['review_grade'];$i++){ ?>
                                <img src="img/star.svg" class="star-icon__reviews">
                                <?php } ?>
                            </div>
                            <div class="btn-unit__comment-add">
                                <p class="btn__comment-add update-btn__comment-add">Редагувати</p>
                                <p class="btn__comment-add">Видалити</p>
                            </div>
                        </div>

                        <div class="update-comment__comment-add">
                            <form action="core/review-add.php" method="post" class="form-comment-add__user-info">
                                <div class="wrap-add__comment-add">
                                    <p class="headline-form__comment-add">Редагувати відгук про платформу</p>
                                    <div class="wrap-input__comment-add">
                                        <p>Ваш відгук</p>
                                        <input type="text" class="input__comment-add" id="update_review"
                                            name="update_review" value="<?=$review['review_description']?>" required>
                                        <div class="update_review__error"></div>
                                    </div>
                                    <p class="headline-radio__comment-add">Наскільки вам сподобалася платформа ?</p>
                                    <div class="grade-block__comment-add">
                                        <div class="wrap-radio__comment-add">
                                            <input type="radio" name="grade_review" value="1" required>
                                            <p>1</p>
                                        </div>
                                        <div class="wrap-radio__comment-add">
                                            <input type="radio" name="grade_review" value="2" required>
                                            <p>2</p>
                                        </div>
                                        <div class="wrap-radio__comment-add">
                                            <input type="radio" name="grade_review" value="3" required>
                                            <p>3</p>
                                        </div>
                                        <div class="wrap-radio__comment-add">
                                            <input type="radio" name="grade_review" value="4" required>
                                            <p>4</p>
                                        </div>
                                        <div class="wrap-radio__comment-add">
                                            <input type="radio" name="grade_review" value="5" required>
                                            <p>5</p>
                                        </div>
                                    </div>

                                    <button class="button__comment-add" name="review_update_submit">Редагувати
                                        відгук</button>
                                </div>
                                <img src="img/comment.svg" class="icon__comment-add">
                            </form>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </section>
        </main>
        <?php } ?>

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
    var links = document.querySelectorAll('.link-nav__profile');
    var contents = document.querySelectorAll('.nav-content__profile');
    let default_content = document.getElementById('default_content');
    let default_link = document.getElementById('default_link');
    var commentBlock = document.getElementById('comment_block');
    default_link.classList.add('link-nav_active__profile');


    links.forEach((el, index) => {
        el.setAttribute('data-index', index);

        contents.forEach((cont, index) => {
            cont.setAttribute('data-index', index);
            cont.style.display = "none";
            default_content.style.display = "block";
        });

        el.addEventListener('click', (e) => {
            for (content of contents) {
                if (content.style.display = "block") {
                    content.style.display = "none";
                }
                contents[index].style.display = "block";
            }

            for (link of links) {
                if (link.classList.contains('link-nav_active__profile')) {
                    link.classList.remove('link-nav_active__profile');
                }
            }
            // slider-start
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
            // slider-finish

            $('.update-btn__comment-add').click(function() {
                $('.update-comment__comment-add').css('display', 'block');
            });

            links[index].classList.add('link-nav_active__profile');

        });

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

    $("input[name~='review_descript']").on("input", function() {
        $.ajax({
            url: "core/review-add.php",
            method: "POST",
            data: {
                review_descript: $(this).val()
            },
            success: function(data) {
                $(".review_descript__error").html(data);
            }
        });
    });

    $("input[name~='update_review']").on("input", function() {
        $.ajax({
            url: "core/review-add.php",
            method: "POST",
            data: {
                update_review: $(this).val()
            },
            success: function(data) {
                $(".update_review__error").html(data);
            }
        });
    });

    $(".start_popup__delete").click(function() {
        $(".popup__delete-cargo").addClass("active__delete");
    });

    $(".close-btn__delete").click(function() {
        $(".popup__delete-cargo").removeClass("active__delete");
    });

    $(".delete-btn-cargo__profile").click(function() {
        let id = $(this).attr('data-index');
        $(".delete-btn__delete").click(function() {
            // console.log(id);
            $.ajax({
                url: "core/delete-cargo.php",
                method: "POST",
                data: {
                    delete_id: id
                },
                success: function(data) {
                    // $(".del").html(data);
                    location.reload()
                }
            });
        });
    });

    $(".start_popup__delete-car").click(function() {
        $(".popup__delete-car").addClass("active__delete");
    });

    $(".close-btn__delete-car").click(function() {
        $(".popup__delete-car").removeClass("active__delete");
    });

    $(".delete-btn-car__profile").click(function() {
        let id_car = $(this).attr('data-index');
        $(".delete-btn__delete-car").click(function() {
            $.ajax({
                url: "core/delete-car.php",
                method: "POST",
                data: {
                    delete_id: id_car
                },
                success: function(data) {
                    location.reload()
                }
            });
        });
    });
    </script>
</body>

</html>
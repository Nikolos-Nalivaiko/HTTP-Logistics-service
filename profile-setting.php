<?php
require "core/database.php";
session_start();
if(!empty($_SESSION['auth'])) { 

$user_id = $_SESSION['id'];

$query = "SELECT * FROM users 
JOIN regions ON regions.region_id = users.id_region
JOIN cities ON cities.city_id = users.id_city  WHERE user_id='$user_id'";
$user = mysqli_fetch_assoc(executeQuery(openConnection(),$query));

$query = "SELECT * FROM regions";
$regions = executeQuery(openConnection(),$query);
$user_name = $user['user_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP - Налаштування профілю</title>
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

    <div class="popup__change-log">
        <div class="carcass-popup__change">
            <img src="img/close__change.svg" class="close__change-log">
            <p class="headline____change">Зміна логіну</p>
            <p class="descript__change">Щоб змінити логін, заповніть форму нижче</p>

            <form action="core/change-log.php" method="post" class="form__change">
                <div class="section-form__change">

                    <div class="wrap-input__change">
                        <p>Ваш логін</p>
                        <input type="text" class="input__change" id="login" name="login"
                            placeholder="Введіть ваш логін">
                        <div class="login__error"></div>
                    </div>
                    <div class="wrap-input__change">
                        <p>Ваш пароль</p>
                        <input type="password" class="input__change" name="pass" id="pass"
                            placeholder="Введіть ваш пароль">
                        <div class="pass__error"></div>
                    </div>

                </div>
                <div class="section-form__change">

                    <div class="wrap-input__change">
                        <p>Новий логін</p>
                        <input type="text" class="input__change" name="new_login" id="new_login"
                            placeholder="Введіть новий логін">
                        <div class="new_login__error"></div>
                    </div>
                    <div class="wrap-input__change">
                        <p>Повторіть логін</p>
                        <input type="text" class="input__change" id="confirm_login" name="confirm_login"
                            placeholder="Повторіть новий логін">
                        <div class="confirm_login__error"></div>
                    </div>

                </div>

                <button type="submit" class="btn__change" name="log_change">Редагувати</button>
            </form>

        </div>
    </div>

    <div class="popup__change-pass">
        <div class="carcass-popup__change">
            <img src="img/close__change.svg" class="close__change-pass">
            <p class="headline____change">Зміна паролю</p>
            <p class="descript__change">Щоб змінити пароль, заповніть форму нижче</p>

            <form action="core/change-pass.php" method="post" class="form__change">
                <div class="section-form__change">

                    <div class="wrap-input__change">
                        <p>Ваш логін</p>
                        <input type="text" class="input__change" id="login_pass" name="login"
                            placeholder="Введіть ваш логін">
                        <div class="login__error"></div>
                    </div>
                    <div class="wrap-input__change">
                        <p>Ваш пароль</p>
                        <input type="password" class="input__change" name="pass" id="old_pass"
                            placeholder="Введіть ваш пароль">
                        <div class="pass__error"></div>
                    </div>

                </div>
                <div class="section-form__change">

                    <div class="wrap-input__change">
                        <p>Новий пароль</p>
                        <input type="password" class="input__change" name="new_pass" id="new_pass"
                            placeholder="Введіть новий логін">
                        <div class="new_pass__error"></div>
                    </div>
                    <div class="wrap-input__change">
                        <p>Повторіть пароль</p>
                        <input type="password" class="input__change" id="confirm_pass" name="confirm_pass"
                            placeholder="Повторіть новий логін">
                        <div class="confirm_pass__error"></div>
                    </div>

                </div>

                <button type="submit" class="btn__change" name="pass_change">Редагувати</button>
            </form>

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
            <div class="header-bg__setting">
                <div class="container">
                    <div class="wrap-header__setting">
                        <h2 class="headline__setting">Налаштування профілю</h2>

                        <div class="btn-unit__setting">
                            <p class="btn-pass__setting"><img src="img/pass-btn.svg">Зміна паролю</p>
                            <p class="btn-log__setting"><img src="img/log-btn.svg">Зміна логіну</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="info__profile info__setting">
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

                <?php 
                    if(isset($_SESSION['success-upgrade-user'])){
                        echo $_SESSION['success-upgrade-user'];
                        unset($_SESSION['success-upgrade-user']);
                    }          
                    if(isset($_SESSION['success-log-change'])){
                        echo $_SESSION['success-log-change'];
                        unset($_SESSION['success-log-change']);
                    } 
                    if(isset($_SESSION['success-pass-change'])){
                        echo $_SESSION['success-pass-change'];
                        unset($_SESSION['success-pass-change']);
                    }    
                    if(isset($_SESSION['error-reg'])){
                        echo $_SESSION['error-reg'];
                        unset($_SESSION['error-reg']);
                    }       
                ?>

                <form action="core/upgrade-user.php" method="post" class="form__cargo-add form__setting">
                    <p class="headline-form__setting">Особисті дані</p>
                    <div class="wrap-form__register wrap-form__setting">
                        <?php if($user['user_type'] == 0) { ?>
                        <div class="wrap-input__register wrap-input__setting">
                            <p>Ваше імя</p>
                            <input type="text" value='<?=$user_name?>' name="name_user" id="name_user"
                                class="input__register" placeholder="Введіть назву товару">
                            <div class="name_user__error"></div>
                        </div>

                        <div class="wrap-input__register wrap-input__setting">
                            <p>По-батькові</p>
                            <input type="text" name="middle_name" id="middle_name" class="input__register"
                                placeholder="Введіть назву товару" value="<?=$user['middle_name']?>">
                            <div class="middle_name__error"></div>
                        </div>

                        <div class="wrap-input__register wrap-input__setting">
                            <p>Призвіще</p>
                            <input type="text" name="surname" id="surname" class="input__register"
                                placeholder="Введіть назву товару" value="<?=$user['surname']?>">
                            <div class="surname__error"></div>
                        </div>
                        <?php } else { ?>
                        <div class="wrap-input__register wrap-input__setting">
                            <p>Назва організації</p>
                            <input type="text" value='<?=$user_name?>' name="name_company" id="name_company"
                                class="input__register" placeholder='ТОВ "НАЗВА"'>
                            <div class="company-name__error"></div>
                        </div>
                        <?php } ?>

                        <div class="wrap-input__register wrap-input__setting">
                            <p>Ваша область</p>
                            <select class="select__register" name="region" id="regions">
                                <option value="<?=$user['region_id']?>"><?=$user['region_name']?></option>
                                <?php
                                        while($region = mysqli_fetch_assoc($regions)){
                                            echo '<option value="'.$region['region_id'].'">'.$region['region_name'].'</option>';
                                        } 
                                    ?>
                            </select>
                        </div>

                        <div class="wrap-input__register wrap-input__setting">
                            <p>Ваше місто</p>
                            <select class="select__register" name="city" id="cities">
                                <option value="<?=$user['city_id']?>"><?=$user['city_name']?></option>
                            </select>
                        </div>

                        <div class="wrap-input__register wrap-input__setting">
                            <p>Ваш номер телефону</p>
                            <input type="text" name="phone" id="phone" class="input__register"
                                placeholder="Ваш номер телефону" value="+<?=$user['phone']?>">
                            <div class="user-phone__error"></div>
                        </div>

                        <div class="wrap-input__register wrap-input__setting">
                            <p>Фото профілю</p>
                            <input type="file" name="user_image" multiple id="image-file__reg-user">
                            <label for="image-file__reg-user" class="input-file__register">Оберіть фото
                                профілю</label>
                        </div>

                    </div>

                    <div class="wrap-images__car-add" id="preview-user-image">
                        <?php if($user['user_image'] != 'no-image.jpg') {?>
                        <div class="wrap-image__car-add">
                            <img src="user_images/<?=$user['user_image']?>" class="image-car__car-add">
                            <img src="img/close-car-add.svg" class="delete-image__car-add">
                        </div>
                        <?php } ?>
                    </div>

                    <input type="text" hidden value="<?=$user['user_type']?>" name="user_type">

                    <button type="submit" name="user_upgrade_submit" class="button__register">Редагувати
                        профіль</button>
                </form>
            </div>
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

    $("#login").on("input", function() {
        $.ajax({
            url: "core/change-log.php",
            method: "POST",
            data: {
                login_check: $(this).val()
            },
            success: function(data) {
                $(".login__error").html(data);
            }
        });
    });

    $("#pass").on("input", function() {
        $.ajax({
            url: "core/change-log.php",
            method: "POST",
            data: {
                pass_check: $(this).val(),
                login_check: $("input[name~='login']").val()
            },
            success: function(data) {
                $(".pass__error").html(data);
            }
        });
    });

    $("#old_pass").on("input", function() {
        $.ajax({
            url: "core/change-pass.php",
            method: "POST",
            data: {
                pass_check: $(this).val(),
                login_check: $("#login_pass").val()
            },
            success: function(data) {
                $(".pass__error").html(data);
            }
        });
    });

    $("#login_pass").on("input", function() {
        $.ajax({
            url: "core/change-pass.php",
            method: "POST",
            data: {
                login_check: $(this).val()
            },
            success: function(data) {
                $(".login__error").html(data);
            }
        });
    });

    $("input[name~='new_login']").on("input", function() {
        $.ajax({
            url: "core/change-log.php",
            method: "POST",
            data: {
                new_login: $(this).val()
            },
            success: function(data) {
                $(".new_login__error").html(data);
            }
        });
    });

    $("input[name~='new_pass']").on("input", function() {
        $.ajax({
            url: "core/change-pass.php",
            method: "POST",
            data: {
                new_pass: $(this).val()
            },
            success: function(data) {
                $(".new_pass__error").html(data);
            }
        });
    });

    $("input[name~='confirm_pass']").on("input", function() {
        $.ajax({
            url: "core/change-pass.php",
            method: "POST",
            data: {
                confirm_pass: $(this).val(),
                new_pass: $("input[name~='new_pass']").val()
            },
            success: function(data) {
                $(".confirm_pass__error").html(data);
            }
        });
    });

    $("input[name~='confirm_login']").on("input", function() {
        $.ajax({
            url: "core/change-log.php",
            method: "POST",
            data: {
                confirm_login: $(this).val(),
                new_login: $("input[name~='new_login']").val()
            },
            success: function(data) {
                $(".confirm_login__error").html(data);
            }
        });
    });

    $("input[name~='name_company']").on("input", function() {
        $.ajax({
            url: "core/upgrade-user.php",
            method: "POST",
            data: {
                name_company: $(this).val()
            },
            success: function(data) {
                $(".company-name__error").html(data);
            }
        });
    });

    $("input[name~='name_user']").on("input", function() {
        $.ajax({
            url: "core/upgrade-user.php",
            method: "POST",
            data: {
                name_user: $(this).val()
            },
            success: function(data) {
                $(".name_user__error").html(data);
            }
        });
    });

    $("input[name~='middle_name']").on("input", function() {
        $.ajax({
            url: "core/upgrade-user.php",
            method: "POST",
            data: {
                middle_name: $(this).val()
            },
            success: function(data) {
                $(".middle_name__error").html(data);
            }
        });
    });

    $("input[name~='surname']").on("input", function() {
        $.ajax({
            url: "core/upgrade-user.php",
            method: "POST",
            data: {
                surname: $(this).val()
            },
            success: function(data) {
                $(".surname__error").html(data);
            }
        });
    });

    $("#popup__navbar-start").click(function() {
        $(".popup__navbar").addClass("active__navbar");
    });

    $(".close__navbar").click(function() {
        $(".popup__navbar").removeClass("active__navbar");
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

    $("input[name~='phone']").on("click", function() {
        $(this).val("+380");
    });

    $("input[name~='phone']").on("input", function() {
        $.ajax({
            url: "core/upgrade-user.php",
            method: "POST",
            data: {
                user_phone: $(this).val()
            },
            success: function(data) {
                $(".user-phone__error").html(data);
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
                url: "core/delete-user-image.php",
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

    $(".btn-log__setting").click(function() {
        $(".popup__change-log").addClass("active__change");
    });

    $(".close__change-log").click(function() {
        $(".popup__change-log").removeClass("active__change");
    });

    $(".btn-pass__setting").click(function() {
        $(".popup__change-pass").addClass("active__change-pass");
    });

    $(".close__change-pass").click(function() {
        $(".popup__change-pass").removeClass("active__change-pass");
    });
    </script>
</body>

</html>

<?php } ?>
<style media="screen" class="wp-adminify-style-wp">
    body.wp-adminify-login-customizer .login-background {
        background-color: #0347FF;
    }

    body.wp-adminify-login-customizer #login h1 a:focus {
        border: 0;
        box-shadow: none;
        outline: 0;
    }

    body.wp-adminify-login-customizer #login {
        background-color: #fff;
        border: 0;
        border-radius: 8px;
        box-shadow: 0px 2px 54px rgba(20, 20, 42, 0.1);
        position: relative;
    }

    body.wp-adminify-login-customizer #login h1 a {
        margin-bottom: 0;
    }

    body.wp-adminify-login-customizer #loginform,
    body.wp-adminify-login-customizer #registerform,
    body.wp-adminify-login-customizer #lostpasswordform {
        background-color: transparent !important;
        border: 0;
        box-shadow: none;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        margin-top: 0;
        padding-bottom: 35px;
    }

    body.wp-adminify-login-customizer #loginform label,
    body.wp-adminify-login-customizer #registerform label,
    body.wp-adminify-login-customizer #lostpasswordform label {
        color: #4E4B66;
    }

    body.wp-adminify-login-customizer #loginform input,
    body.wp-adminify-login-customizer #registerform input,
    body.wp-adminify-login-customizer #lostpasswordform input,
    body.wp-adminify-login-customizer #loginform textarea,
    body.wp-adminify-login-customizer #registerform textarea,
    body.wp-adminify-login-customizer #lostpasswordform textarea,
    body.wp-adminify-login-customizer #loginform select,
    body.wp-adminify-login-customizer #registerform select,
    body.wp-adminify-login-customizer #lostpasswordform select {
        background: #F1F1F3;
        border: 0;
        border-radius: 6px;
        box-shadow: none;
        color: #4E4B66;
        font-size: 14px;
        line-height: 16px;
        height: 36px;
    }

    body.wp-adminify-login-customizer #loginform textarea,
    body.wp-adminify-login-customizer #registerform textarea,
    body.wp-adminify-login-customizer #lostpasswordform textarea {
        height: auto;
    }

    body.wp-adminify-login-customizer #loginform input[type="submit"],
    body.wp-adminify-login-customizer #registerform input[type="submit"],
    body.wp-adminify-login-customizer #lostpasswordform input[type="submit"] {
        background-color: #0347FF;
        color: #fff;
        float: none;
        margin-top: 15px;
        padding: 0 15px;
        width: 100%;
    }

    body.wp-adminify-login-customizer #loginform input[type="checkbox"],
    body.wp-adminify-login-customizer #registerform input[type="checkbox"],
    body.wp-adminify-login-customizer #lostpasswordform input[type="checkbox"],
    body.wp-adminify-login-customizer #loginform input[type="radio"],
    body.wp-adminify-login-customizer #registerform input[type="radio"],
    body.wp-adminify-login-customizer #lostpasswordform input[type="radio"] {
        height: 14px;
        width: 14px;
        border-radius: 4px;
        min-width: inherit;
    }

    body.wp-adminify-login-customizer #loginform .button.wp-hide-pw {
        background-color: transparent;
        border: 0;
        box-shadow: none;
        color: #4E4B66;
        font-size: 16px;
        height: 36px;
        margin-top: 0;
    }

    body.wp-adminify-login-customizer #login #nav {
        bottom: -40px;
        position: absolute;
        text-align: center;
        padding: 0;
        width: 100%;
    }

    body.wp-adminify-login-customizer #login #nav a {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }

    body.wp-adminify-login-customizer #login #backtoblog a {
        background: #FFF;
        box-shadow: 0px 2px 35px rgba(78, 75, 102, 0.05);
        border-radius: 6px;
        color: #4E4B66;
        display: inline-block;
        font-size: 13px;
        line-height: 20px;
        left: 30px;
        top: 30px;
        padding: 8px 10px;
        position: fixed;
    }

    @media only screen and (max-width: 600px) {
        body.wp-adminify-login-customizer .wp-adminify-container {
            height: auto;
        }
        body.wp-adminify-login-customizer:not(.wp-adminify-half-screen):not(.wp-adminify-fullwidth) .wp-adminify-container .wp-adminify-form-container {
            width: 100%;
            padding: 20px;
        }
        #login {
            max-width: 100%;
            margin-top: 70px;
        }
        .login h1 {
            /* margin-top: 40px; */
        }
        .wp-adminify-form-container .columns.all-centered {
            width: 100%;
            padding-bottom: 30px;
        }
    }
</style>

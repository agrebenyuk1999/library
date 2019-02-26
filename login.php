<?php
require 'header.php';
require'loginFormValidate.php';
?>

<section class="registration" id="registration">
    <div class="container" id="app">
        <div class="reg__form" id="reg__form">
            <div class="head__form__title">Авторизация</div>
            <span v-if="errors.length != 0">Ошибки в заполнении формы</span>
            <div class="error__form">{{ errors['form'] ? errors['form'] : '' }}</div>
<!--            <ul>-->
<!--                <li v-for="error in errors" class="errors__reg__form"> {{ error }}</li>-->
<!--            </ul>-->
            <form method="post" onsubmit="return false;">
                <div><input type="text" name="login" placeholder="Логин или E-mail" v-model="login" value=""></div>
                <span>{{ errors['login'] ? errors['login'][0] : '' }}</span>
                <div><input type="password" name="password1" placeholder="Пароль" v-model="password1" value=""></div>
                <span>{{ errors['password1'] ? errors['password1'][0] : '' }}</span>
                <div><button type="submit" @click="send()">Войти</button></div>
            </form>
        </div>
    </div>
</section>

<script>
    axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    axios.defaults.transformRequest = [function (data, headers) {
        var str = [];
        for(var p in data)
            if (data.hasOwnProperty(p) && data[p]) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(data[p]));
            }
        return str.join("&");
    }];
    var app = new Vue({
        el: '#app',
        data: {
            login: null,
            password1: null,
            errors: []
        },
        methods: {
            send() {
                axios.post('loginFormValidate.php', this.getFormFields).then(response => {
                    if (response.data.status) {
                        this.errors = [];
                        window.location.href = "profile.php";
                    }else {
                        this.errors = response.data.errors;
                    }
                });
            }
        },
        computed: {
            getFormFields() {
                return {
                    login: this.login,
                    password1: this.password1,
                }
            }
        }
    })
</script>

<?php require ('footer.php')?>

var app = new Vue({
    el: '#reg__form',
    data: {
        login: '',
        email: '',
        password1: '',
        password2: '',
        errors: []
    },
    methods: {
        checkRegForm: function(e){
            this.errors.splice(0, this.errors.length);
            if (this.login != '' && this.email != '' && this.password1 != '' && this.password1 == this.password2) {
                return true;
            }
            if (this.login == '') {
                this.errors.push('Логин не может быть пустым')
            }
            if (this.email == '') {
                this.errors.push('E-mail не может быть пустым')
            }
            if (this.password1 == '') {
                this.errors.push('Пароль не может быть пустым')
            }
            if (this.password1 !== this.password2) {
                this.errors.push('Пароли не совпадают')
            }
            e.preventDefault();
        },
        checkLoginForm: function (e) {
            this.errors.splice(0, this.errors.length);
            if (this.login != '' && this.password1 != '' ) {
                return true;
            }
            if (this.login == '') {
                this.errors.push('Логин не может быть пустым')
            }
            if (this.password1 == '') {
                this.errors.push('Пароль не может быть пустым')
            }
            e.preventDefault();
        }
    }
})

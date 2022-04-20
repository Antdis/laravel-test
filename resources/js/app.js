require('./bootstrap');

const STATUS_SUCCESS = 'success';
const STATUS_ERROR = 'error';

import Vue from 'vue/dist/vue.js';

var app = new Vue({
    el: '#app',
    data: {
        login: '',
        pass: '',
        post: false,
        invalidLogin: false,
        invalidPass: false,
        invalidSum: false,
        posts: [],
        addSum: 0,
        amount: 0,
        likes: 0,
        commentText: '',
        boosterpacks: [],
    },
    computed: {
        test: function () {
            var data = [];
            return data;
        }
    },
    created() {
        axios.get('/posts')
            .then(response => {
                this.posts = response.data.posts;
            })

        axios
            .get('/boosterPacks')
            .then(response => {
                this.boosterpacks = response.data.boosterPacks;
            })
    },
    methods: {
        logout: function () {
            console.log('logout');
        },
        logIn: function () {
            if (this.login === '') {
                this.invalidLogin = true
            } else if (this.pass === '') {
                this.invalidLogin = false
                this.invalidPass = true
            } else {
                this.invalidLogin = false
                this.invalidPass = false

                let form = new FormData();
                form.append("login", this.login);
                form.append("password", this.pass);

                axios.post('/login', form)
                    .then(() => location.reload())
                    .catch((error) => {
                        let {data, status} = error.response

                        // Validation Exception
                        if (status === 422) {
                            this.invalidLogin = data && data.errors.login
                            this.invalidPass = data && data.errors.password
                        } else {
                            this.invalidLogin = true
                            this.invalidPass = true
                        }
                    })
            }
        },
        addComment: function (id) {
            var self = this;
            if (self.commentText) {

                var comment = new FormData();
                comment.append('postId', id);
                comment.append('commentText', self.commentText);

                axios.post(
                    '/main_page/comment',
                    comment
                ).then(function () {

                });
            }

        },
        refill: function () {
            var self = this;
            if (self.addSum === 0) {
                self.invalidSum = true
            } else {
                self.invalidSum = false
                sum = new FormData();
                sum.append('sum', self.addSum);
                axios.post('/main_page/add_money', sum)
                    .then(function (response) {
                        setTimeout(function () {
                            $('#addModal').modal('hide');
                        }, 500);
                    })
            }
        },
        openPost: function (id) {
            var self = this;
            axios
                .get('/main_page/get_post/' + id)
                .then(function (response) {
                    self.post = response.data.post;
                    if (self.post) {
                        setTimeout(function () {
                            $('#postModal').modal('show');
                        }, 500);
                    }
                })
        },
        addLike: function (type, id) {
            var self = this;
            const url = '/main_page/like_' + type + '/' + id;
            axios
                .get(url)
                .then(function (response) {
                    self.likes = response.data.likes;
                })

        },
        buyPack: function (id) {
            var self = this;
            var pack = new FormData();
            pack.append('id', id);
            axios.post('/main_page/buy_boosterpack', pack)
                .then(function (response) {
                    self.amount = response.data.amount
                    if (self.amount !== 0) {
                        setTimeout(function () {
                            $('#amountModal').modal('show');
                        }, 500);
                    }
                })
        }
    }
});


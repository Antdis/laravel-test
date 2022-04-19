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
    created(){
        this.posts = [{"id":1,"img":"\/images\/posts\/1.png","text":"Post 1","user":{"id":1,"personaname":"Admin User","avatarfull":"https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/96\/967871835afdb29f131325125d4395d55386c07a_full.jpg","time_created":"2022-04-19 16:43:44","time_updated":"2022-04-19 16:43:44"},"time_created":"2022-04-19 16:43:44","time_updated":"2022-04-19 16:43:44"},{"id":2,"img":"\/images\/posts\/2.png","text":"Post 2","user":{"id":1,"personaname":"Admin User","avatarfull":"https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/96\/967871835afdb29f131325125d4395d55386c07a_full.jpg","time_created":"2022-04-19 16:43:44","time_updated":"2022-04-19 16:43:44"},"time_created":"2022-04-19 16:43:44","time_updated":"2022-04-19 16:43:44"}];
        this.boosterpacks = [{"id":1,"price":5},{"id":2,"price":20},{"id":3,"price":50}];
    //     var self = this
    //     axios
    //         .get('/main_page/get_all_posts')
    //         .then(function (response) {
    //             self.posts = response.data.posts;
    //         })
    //
    //     axios
    //         .get('/main_page/get_boosterpacks')
    //         .then(function (response) {
    //             self.boosterpacks = response.data.boosterpacks;
    //         })
    },
    methods: {
        logout: function () {
            console.log('logout');
        },
        logIn: function () {
            var self = this;
            if (self.login === '') {
                self.invalidLogin = true
            } else if (self.pass === '') {
                self.invalidLogin = false
                self.invalidPass = true
            } else {
                self.invalidLogin = false
                self.invalidPass = false

                form = new FormData();
                form.append("login", self.login);
                form.append("password", self.pass);

                axios.post('/main_page/login', form)
                    .then(function (response) {
                        if (response.data.user) {
                            location.reload();
                        }
                        setTimeout(function () {
                            $('#loginModal').modal('hide');
                        }, 500);
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


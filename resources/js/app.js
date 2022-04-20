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
        openPost: function (id) {
            axios
                .get(`/posts/${id}`)
                .then(response => {
                    this.post = response.data.post;

                    if (this.post) {
                        setTimeout(() => $('#postModal').modal('show'), 500);
                    }
                })
        },
        addComment: function (id) {
            if (this.commentText) {
                let comment = new FormData();
                comment.append('commentText', this.commentText);

                axios.post(`/posts/${id}/comment`, {commentText: this.commentText})
                    .then(response => {
                        this.post = response.data.post;
                    });
            }
        },
        addLike: function (type, id) {
            axios.post('/like', {type, id})
                .then(response => {
                    let {post} = response.data;
                    console.log(post);
                    let postIndex = this.posts.findIndex(post => post.id === id);
                    console.log(postIndex);
                    this.post = post
                    this.posts[postIndex] = this.post
                })

        },
        refill: function () {
            if (this.addSum === 0) {
                this.invalidSum = true
            } else {
                this.invalidSum = false

                axios.post('/addMoney', {sum: this.addSum})
                    .then(() => setTimeout(() => $('#addModal').modal('hide'), 500))
            }
        },
        buyPack: function (id) {
            axios.post(`/buyBooster/${id}`)
                .then(response => {
                    let {amount} = response.data
                    if (amount !== 0) {
                        alert(`You won ${amount} likes`);
                    }
                }).catch(error => this.showError(error.response.data));
        },

        showError(response) {
            let message = '';

            Object.values(response.errors).forEach(element => message += element.join(' '))
            alert(message);
        }
    }
});


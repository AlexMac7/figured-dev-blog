import Vue from "vue";
import Router from "vue-router";
import PostList from './views/PostList';
import CreatePost from './views/CreatePost';
import EditPost from './views/EditPost';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'postList',
            component: PostList,
        },
        {
            path: '/post',
            name: 'createPost',
            component: CreatePost,
        },
        {
            path: '/post/:id',
            name: 'editPost',
            component: EditPost,
            props: true
        }
    ]
});

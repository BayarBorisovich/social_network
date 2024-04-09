
import './bootstrap';
import { createApp } from 'vue';


const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import Posts from "./components/Posts.vue";
import Main from "./components/Main.vue";
import CreatePost from "./components/CreatePost.vue";
import Friend from "./components/Friend.vue";
import Users from "./components/Users.vue";
import UsersHomePage from "./components/UsersHomePage.vue";
import Messages from "./components/Messages.vue";
import Weather from "./components/weather.vue";


app.component('example-component', ExampleComponent);
app.component('component-posts', Posts);
app.component('component-main', Main);
app.component('create-component', CreatePost);
app.component('friend-component', Friend);
app.component('users-component', Users);
app.component('users-home-page-component', UsersHomePage);
app.component('messages-component', Messages);
app.component('weather-component', Weather);



// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.mount('#app');

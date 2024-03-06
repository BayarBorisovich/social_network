
import './bootstrap';
import { createApp } from 'vue';


const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import Posts from "./components/Posts.vue";



app.component('example-component', ExampleComponent);
app.component('component-posts', Posts);


// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.mount('#app');

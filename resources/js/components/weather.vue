<template>
    <article class="widget">
        <div class="weatherIcon">
            <img class="image" :src="weather ? weather.icon : '-'"  alt=""/>
        </div>
        <div class="weatherInfo">
            <div class="temperature"><span>{{ weather ? weather.temp : '-' }}&deg;</span></div>
            <div class="description">
                <div class="weatherCondition">{{ weather ? weather.weather : '-' }}</div>
                <div class="place">wind: {{ weather ? weather.wind : '-' }} m/s</div>
            </div>
        </div>
        <div class="date">{{ weather ? weather.name : '-' }}</div>
    </article>
</template>

<script>
import axios from "axios";

export default {
    name: "Weather",

    data() {
        return {
            posts: null,
            content: null,
            post_id: null,
            weather: null,
        }
    },

    mounted() {
        this.getMyPosts()
    },

    methods: {
        getMyPosts() {
            axios.get('/main/json')
                .then(result => {
                    console.log(result.data)
                    this.posts = result.data.posts
                    this.weather = result.data.weather
                })
        },

        deletePosts(id) {
            axios.post(`/post/delete/${id}`)
                .then(result => {
                    this.getMyPosts()
                })
        },

        updatePosts(id) {
            this.post_id = null
            axios.post(`/post/update/${id}`, {content: this.content})
                .then(result => {
                    this.getMyPosts()
                })
        },

        changePostId(id, content) {
            this.post_id = id
            this.content = content
        },

        isId(id) {
            return this.post_id === id
        },
    }
}
</script>
<style scoped>
@import url(https://fonts.googleapis.com/css?family=Poiret+One);
@import url(https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.9/css/weather-icons.min.css);

$border-radius: 20px;

body {
    background-color: #A64253;
    font-family: Poiret One;
}

.widget {
    position: absolute;
    top: 50%;
    left: 50%;
    display: flex;
    height: 300px;
    width: 600px;
    transform: translate(-50%, -50%);
    flex-wrap: wrap;
    cursor: pointer;
    border-radius: $border-radius;
    box-shadow: 0 27px 55px 0 rgba(0, 0, 0, 0.3), 0 17px 17px 0 rgba(0, 0, 0, 0.15);

    .weatherIcon {
        flex: 1 100%;
        height: 60%;
        border-top-left-radius: $border-radius;
        border-top-right-radius: $border-radius;
        background: #c4c6c9;
        font-family: weathericons,serif;
        display: flex;
        align-items: center;
        justify-content: space-around;
        font-size: 100px;

        i {
            padding-top: 30px;
        }
    }

    .weatherInfo {
        flex: 0 0 70%;
        height: 40%;
        background: #080705;
        border-bottom-left-radius: $border-radius;
        display: flex;
        align-items: center;
        color: white;

        .temperature {
            flex: 0 0 40%;
            width: 100%;
            font-size: 65px;
            display: flex;
            justify-content: space-around;
        }

        .description {
            flex: 0 60%;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            justify-content: center;

            .weatherCondition {
                text-transform: uppercase;
                font-size: 35px;
                font-weight: 100;
            }

            .place {
                font-size: 30px;
            }
        }
    }

    .date {
        flex: 0 0 30%;
        height: 40%;
        background: #70C1B3;
        border-bottom-right-radius: $border-radius;
        display: flex;
        justify-content: space-around;
        align-items: center;
        color: white;
        font-size: 30px;
        font-weight: 800;
    }
}

p {
    position: fixed;
    bottom: 0%;
    right: 2%;

    a {
        text-decoration: none;
        color: #E4D6A7;
        font-size: 10px;
    }
.image {
    height: 300%;
}

}
</style>

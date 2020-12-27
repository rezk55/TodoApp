<template>
    <div id="app" class="app row p-2">
        <div class="side-bar shadow-lg col-lg-2 col-md-12 pt-4">
            <side-bar class="" />
        </div>
        <div class="todos text-center col-lg-7 col-md-12 mt-2">
            <h1>My List</h1>
            <todo-comp class="shadow-lg" />
        </div>
    </div>
</template>
<script>
import SideBar from "./components/global/SideBar.vue";
import TodoComp from "./components/Todo/TodoComp";

export default {
    name: "Main",
    components: {
        // AppHeader,
        TodoComp,
        SideBar
    }
};
</script>
<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Langar&family=Luckiest+Guy&family=Roboto:wght@100&display=swap");

.app {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    .side-bar {
        height: 500px;
        background-color: #c7eed8;
        border: 1px solid #38c172;
        .btn-sidebar {
            width: 50px;
            height: 50px;
            border: 1px solid #38c172;
            padding: 0;
            color: #38c172;
            span {
                width: 150%;
                height: 20%;
                margin: -15px 0 0 -10px;
                display: block;
                font-size: 40px;
            }
            &:hover {
                color: #fff;
            }
            &:focus {
                color: #fff;
            }
        }
    }
    .todos {
        width: 100%;
        margin-left: 12%;
        h1 {
            color: #e3352f80;
            font-family: "Langar", cursive;
            font-size: 70px;
        }
    }
    @media (max-width: 991px) {
        .side-bar {
            height: 30%;
            p {
                width: 70%;
            }
        }
        .todos {
            margin-left: 0%;
        }
    }
    @media (max-width:575px) {
        .todos {
            margin-left: 0%;
        }
    }
}
</style>

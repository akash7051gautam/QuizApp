<template>
    <div id="app">
        <v-app id="inspire">
            <v-navigation-drawer clipped fixed v-model="drawer" app>
                <sidebar></sidebar>
            </v-navigation-drawer>

            <navbar :user="user" @toggleSideBar="ToggleSide($event)"></navbar>
            <v-content>
                <v-container fluid fill-height>
                    <v-layout justify-center>
                        <v-flex shrink>
                            <router-view></router-view>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
            <v-footer app fixed>
                <span>&copy; {{ new Date().getFullYear() }}</span>
            </v-footer>
        </v-app>
    </div>
</template>

<script>
import Sidebar from "./_sidebar";
import Navbar from "./_navbar";

export default {
    components: { Sidebar, Navbar },
    data: () => ({
        drawer: true
    }),
    props: ["user"],
    methods: {
        ToggleSide(title) {
            this.drawer = !this.drawer;
        }
    }
};
</script>

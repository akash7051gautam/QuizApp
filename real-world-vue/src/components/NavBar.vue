<template>
    <div>
        <header id="header" class="fixed-top">
            <div class="container d-flex align-items-center">
                <h1 class="logo me-auto">
                    <router-link to="/"><span>QUIZ</span>APP</router-link>
                </h1>
                
                <nav id="navbar" class="navbar order-last order-lg-0 ">
                    <ul>
                        <li>
                            <router-link to="/">
                                <i
                                    class="bi bi-house-door-fill"
                                    style="font-size:16px; margin-right:5px;"
                                ></i>Home</router-link>
                        </li>
                        <li>
                            <router-link to="/login">
                                <i
                                    class="bi bi-person-check"
                                    style="font-size:16px; margin-right:5px;"
                                ></i>STUDENT LOGIN</router-link>
                        </li>
                        <li>
                            <a href="#"
                                ><i
                                    class="bi bi-person-check-fill"
                                    style="font-size:16px; margin-right:5px;"
                                ></i>
                                ADMIN LOGIN</a
                            >
                        </li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>
    </div>
</template>

<template>
    <div>
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5"></div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-5">
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                            </div>
                            <form action="#" class="login-form">
                                <div class="form-group">
                                    <div
                                        class="icon d-flex align-items-center justify-content-center"
                                    >
                                        <span class="fa fa-user"></span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control rounded-left"
                                        placeholder="Username"
                                        required
                                    />
                                </div>
                                <div class="form-group">
                                    <div
                                        class="icon d-flex align-items-center justify-content-center"
                                    >
                                        <span class="fa fa-lock"></span>
                                    </div>
                                    <input
                                        type="password"
                                        class="form-control rounded-left"
                                        placeholder="Password"
                                        required
                                    />
                                </div>
                                <div
                                    class="form-group d-flex align-items-center"
                                >
                                    <div class="w-100">
                                        <label
                                            class="checkbox-wrap checkbox-primary mb-0"
                                            >Save Password
                                            <input type="checkbox" />
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div
                                        class="w-100 d-flex justify-content-end"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-primary rounded submit"
                                        >
                                            Login
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <div class="w-100 text-center">
                                        <p><a href="#">Forgot Password</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<style scoped src="../../public/css/login.css"></style>

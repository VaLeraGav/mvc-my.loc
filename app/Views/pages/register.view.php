<!--<main>-->
<!--    <form action="/registration" method="post">-->
        <?php
dpre($data ?? '');  ?>
<!---->
<!--        <p>Name: <input type="text" name="name" placeholder="" value="--><?//
//= $users['name'] ?? "" ?><!--"/></p>-->
<!--        <p>Phone: <input type="text" name="number" placeholder="123456789" value="--><?//
//= $users['number'] ?? "" ?><!--"/></p>-->
<!--        <p>Email: <input type="text" name="email" placeholder="@email.ru" value="--><?//
//= $users['email'] ?? "" ?><!--"/></p>-->
<!--        <p>Password: <input type="password" name="password" placeholder="********"/></p>-->
<!--        <p>Password: <input type="password" name="password_confirmation" placeholder="********"/></p>-->
<!--        <p><input type="submit" value="Registration" name="register"/></p>-->
<!--    </form>-->
<!--</main>-->

<section class="vh-100 bg-image"
         style="background-color: #CCCCCC;">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-1">Create an account</h2>
                            <?php
                            dpre($errors ?? '');  ?>
                            <form action="/registration" method="post">
                                <div class="form-outline mb-2">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Your Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Repeat your password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control form-control-lg"/>
                                </div>

                                <div class="d-flex justify-content-center text-light">
                                    <button type="submit" class="btn btn-dark btn-block btn-lg ">Register</button>
                                </div>
                                <p class="text-center text-muted mb-0">Have already an account?
                                    <a href="#!" class="fw-bold text-body">
                                        <u>Login here</u>
                                    </a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
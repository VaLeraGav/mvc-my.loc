<main>
    <?php
    if (!empty($message)) : ?>
        <p>
            <?php
            print_r($message); ?>
            <?php
            dpre($email); ?>
        </p>
    <?php
    endif; ?>
</main>

<section class="vh-100 bg-image"
         style="background-color: #CCCCCC;">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-5">Sign In</h2>

                            <form action="/login" method="post">

                                <div class="form-outline mb-4">
                                    <label class="form-label">Your Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg" value="<?=
                                    $email ?? '' ?>"/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg"/>
                                </div>

                                <div class="d-flex justify-content-center text-light">
                                    <button type="submit" class="btn btn-dark btn-block btn-lg ">Sibmit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- хлебные крошки -->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li class="active">Register</li>
            </ol>
        </div>
    </div>
</div>


<div class="register">
    <div class="container">
        <div class="register-top heading">
            <h2>REGISTER</h2>
        </div>
        <div class="register-main">
            <form action="/registration" method="post">
                <div class="col-md-6 account-left">
                    <input placeholder="First name" type="text" tabindex="1"  value="<?= $users['name'] ?? '' ?>" required>
                    <input placeholder="Last name" type="text" tabindex="2" required>
                    <input placeholder="Email address" type="text" tabindex="3" required>
                    <input placeholder="Mobile" type="text" tabindex="3" required>
                    <ul>
                        <li><label class="radio left"><input type="radio" name="radio" checked=""><i></i>Male</label>
                        </li>
                        <li><label class="radio"><input type="radio" name="radio"><i></i>Female</label></li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div class="col-md-6 account-left">
                    <input placeholder="Password" type="password" tabindex="4" required>
                    <input placeholder="Retype password" type="password" tabindex="4" required>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
        <div class="address submit">
            <input type="submit" value="Submit">
        </div>
    </div>
</div>
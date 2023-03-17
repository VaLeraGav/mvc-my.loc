<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5 ">
    <a class="navbar-brand" href="/">Web</a>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/close">Сlose</a>
            </li>
        </ul>
    </div>

    <?php if (!empty(\App\Models\UserModel::isAuth())) : ?>
        <a class="text-uppercase nav-link" href="/logout">logout</a>
    <?php else : ?>
        <a class="text-uppercase nav-link" href="/login">login</a>
        <a class="text-uppercase nav-link" href="/registration">Register</a>
    <?php endif; ?>
</nav>
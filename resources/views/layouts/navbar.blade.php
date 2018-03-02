<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="/">{{ config('app.name', 'Vehikl') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <router-link tag="li" to="/" class="nav-item" exact>
                <a class="nav-link">Home</a>
            </router-link>
            <router-link tag='li' to="/ticket" class="nav-item">
                <a class="nav-link">Enter</a>
            </router-link>
            <router-link tag='li' to="/ticket/pay" class="nav-item">
                <a class="nav-link">Pay Ticket</a>
            </router-link>
            <router-link tag='li' to="/exit" class="nav-item">
                <a class="nav-link">Exit</a>
            </router-link>
        </ul>
    </div>
</nav>
<div class="Body" ng-controller="RegisterForm">
    <div class="message">
        <h3>Welcoom <span>@{{message}}</span></h3>
    </div>
    <div class="form">
        <div class="inputGroupe">
            <label for="username">US</label>
            <input type="text" name="username" id="username" placeholder="User Name">
        </div>

        <div class="inputGroupe">
            <label for="password">PW</label>
            <input type="text" name="password" id="password" placeholder="Pass Word">
        </div>

        <div class="Button">
            <button class="btn LoginBTN" type="button" name="Login">Login</button>
        </div>

    </div>
</div>